<?php
namespace App\Repository\Staticpage;

use App\Models\Staticpage;
use App\Models\Product;


class Repository {
	
	public function getPaginated(Array $params= [])
	{
		$perPage = $params["per_page"] ?? 16;
		$sortBy = $params["sort_by"] ?? 'updated_at';
		$order = $params["order"] ?? 'DESC';
		$query = Staticpage::orderBy($sortBy, $order);
		$collection = $query->paginate($perPage);
		
		return $collection;
	}	

	public function getRelativesPaginated(Array $params= [])
	{
		$perPage = $params["per_page"] ?? 16;
		
		$sortBy = $params["sort_by"] ?? 'products.updated_at';
		$order = $params["order"] ?? 'DESC';
		$select = ['products.*'];
		$query = Product::select($select);		
		
		
			$query->leftJoin('categories'
			, 'categories.id'
			,'products.category_id' );	
		if ($sortBy == "category") {
			$sortBy='categories.name';
		
		}
		
		if (!empty($params["name"])) {
			$query->where("products.name", "~*", $params["name"]);
		}
			
		$query->orderBy($sortBy, $order);
		
		if (!empty($params["owned"])) { 
		
				$relatedId = $params["owned"];
				$query->join('relative_staticpage', function($join) use ($relatedId)
                         {
                           $join->on('relative_staticpage.relative_id','products.id')->where('relative_staticpage.staticpage_id', $relatedId);
                         });
		}
		
		if (!empty($params["exclude"])) { 
			$query->whereNotIn('products.id', $params["exclude"]);
		}
		
		if (!empty($params["parent_id"])) {
			$query->where("category_id", $params["parent_id"]);		
		}		

		if (!empty($params["parent_ids"])) {
			$query->whereIn("category_id", $params["parent_ids"]);
		}				
		
		$collection = $query->paginate($perPage);
		
		return $collection;
	}		
	
    public function getOne(int $id)
	{
		return Staticpage::findOrFail($id);
	}
	
	

     public function create(CreateDto $dto) : Staticpage
	{
		\DB::beginTransaction();
        try {
		$model = $dto->toModel(); 
		
			if ($this->save($model)) {
				if (!empty($dto->session_main_form)) {
					if(!$model->saveNewSessionPic($dto->session_main_form)) {
						\DB::rollBack();
						throw new \Exception('Не удалось сохранить картинку');
					}
				}
				
				\DB::commit();
				return $model;
			}
		} catch (QueryException $e) {
            \DB::rollBack();
            throw $e;
        }

        return false;			   
		
	}

    public function update(Staticpage $model, UpdateDto $dto): bool
    {
		 

		\DB::beginTransaction();
        try {
		$dto->toModel($model);
		
			if ($this->save($model)) {
				\DB::commit();
				return true;
			}
		} catch (QueryException $e) {
            \DB::rollBack();
            throw $e;
        }

        return false;			
		

    }	
	
    private function save(Staticpage $model): bool
    {
		
        
            if ($model->save()) {
                \DB::commit();
                return true;
            }
        return false;
    }	
}