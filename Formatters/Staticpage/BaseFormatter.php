<?php  
namespace App\Http\Formatters\Staticpage;



use App\Models\Staticpage;
use App\Models\Product;

use Illuminate\Pagination\LengthAwarePaginator;

class BaseFormatter
{
	private $intlFormatter;
	public function __construct(
    ) {
		$this->intlFormatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
		$this->intlFormatter->setPattern('d MMMM');
    }
	
	public function getModel(Staticpage $model, $i) : array
	{
		$cnc = $model->cnc;
		$tmp = explode("/", $model->cnc);
		$cnc = rawurldecode(end($tmp));
		
		$result = [
			"id" => $model->id,
			"number" => $i, 
			"name" => $model->name,
			"cnc" => $model->cnc,
			"url" => $model->url,
			"link_meta" => route('admin.meta.view',
			['id' => $model->id,'type' => 'staticpage']),
			"link_meta" => route('admin.meta.view',['id' => $model->id,'type' => 'staticpage']),
			"link_related" => route('admin.staticpages.relatives', ['id' => $model->id]),
			"link_edit" => route('admin.staticpages.edit', ['id' => $model->id]),
			"link_delete" => route('admin.staticpages.delete', ['id' => $model->id]),
			"created_at" => $this->intlFormatter->format($model->created_at),
			"updated_at" => $this->intlFormatter->format($model->updated_at),
			"link_show" => route('catalog.view', ['slug' => $cnc]),  			
		];
	
		return $result;
	}
	
	public function getList(LengthAwarePaginator $collection) : array
	{
		$result = [];
		$i = ($collection->currentPage()-1)*$collection->perPage() + 1;
		foreach ($collection as $model) {
			$result[] = $this->getModel($model, $i++);	
		}
			//die();
		return $result;
			 
	}	
	
	public function getRelativeModel(Product $product,int $related) : array
	{

		$result = [
			"id" => $product->id,
			"name" => $product->name,
			"category" => $product->category ?  $product->category->name : '',
			"price" => $product->getPrice(''),
			"date" => $product->updated_at ? $product->updated_at->format('m.mY H:i') : $product->created_at->format('m.mY H:i'),
			"checked" => $product->staticpage->where('id',$related)->count() ? true : false,
		];
		
		return $result;
	}
	
	public function getListRelative(LengthAwarePaginator $collection, int $related) : array
	{
		$result = [];
		
		foreach ($collection as $model) {
			$result[] = $this->getRelativeModel($model, $related);	
		}
		
		return $result;
			 
	}	
}