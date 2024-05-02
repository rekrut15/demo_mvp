<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Staticpage\Repository;
use App\Services\StaticpageService;
use App\Models\Staticpage;

use App\Http\Formatters\Staticpage\BaseFormatter;
use App\Http\Requests\Admin\Staticpage\CreateRequest;
use App\Http\Requests\Admin\Staticpage\UpdateRequest;


class StaticpageController extends Controller
{
	private StaticpageService $service;
	private Repository $repo;
	private BaseFormatter $formatter;
	
	
	
	public function __construct(
        StaticpageService $service,
		Repository $repo,
		BaseFormatter $formatter

    ) {
        $this->service = $service;
		$this->repo = $repo;
		$this->formatter = $formatter;
    
    }
	
    public function index(Request $request)
	{
		
		$data = $request->all();
		
		if (request()->ajax) {
			
			$staticpages = $this->repo->getPaginated($data);	

			$result = [
				"data" => $this->formatter->getList($staticpages),
				"meta" => [
					"currentPage" => $staticpages->currentPage(),
					"total" => $staticpages->total(),
					"perPage" => $staticpages->perPage(),
					"lastPage" => $staticpages->lastPage(),
				]
			];
			return response()->json($result);	
		}
		
		
		
		$staticpages = $this->repo->getPaginated($data);		
		
		return view('admin.staticpage.index');
	}
	
	public function create()
	{
		$session_main_form = request()->old('session_main_form');
		if(!$session_main_form){
			$session_main_form = uniqid("staticpage_main_image_");
		}

		$session_mob_form = request()->old('session_mob_form');
		if(!$session_mob_form){
			$session_mob_form = uniqid("staticpage_mob_image_");
		}
		return view('admin.staticpage.create', compact('session_main_form', 'session_mob_form'));
	}	
	
	public function store(CreateRequest $request)
	{

		$dto = $request->getDto();
		
		$staticpage =  $this->service->create($dto); 
		
		return redirect()->route('admin.staticpages.home')
		->with('status', 'Посадочная страница ('.$staticpage->name.') добавлена');
;
	}	
	
	public function edit($id)
	{

		$staticpage = Staticpage::findOrFail($id);
		$session_main_form = request()->old('session_main_form');
		if(!$session_main_form){
			$session_main_form = uniqid("staticpage_main_image_");
		}
		$session_mob_form = request()->old('session_mob_form');
		if(!$session_mob_form){
			$session_mob_form = uniqid("staticpage_mob_image_");
		}
		
		return view('admin.staticpage.edit', compact('staticpage', 'session_main_form', 'session_mob_form'));

	}	
	
	public function update($id, UpdateRequest $request)
	{
		
		$staticpage = Staticpage::findOrFail($id);
				
        $dto = $request->getDto();
		
		$this->service->update($staticpage, $dto);
		
		return redirect()->route('admin.staticpages.home')->with('status', 'Посадочная страница ('.$staticpage->name.') отредактирована');

	}

	public function delete($id)
	{
		$staticpage = Staticpage::findOrFail($id);
		$name = $staticpage->name;
		$staticpage->delete();
		return redirect()->route('admin.staticpages.home')->with('status', 'Посадочная страница ('.$name.') удалена');

	}	

		public function relatives($id)
	{

		$staticpage = Staticpage::findOrFail($id);
		
			if (request()->ajax) {
			$data = request()->all();
			$data['exclude'] = [$id];
			$products = $this->repo->getRelativesPaginated($data);
			$result = [
				"data" => $this->formatter->getListRelative($products, $id),
				"meta" => [
					"currentPage" => $products->currentPage(),
					"total" => $products->total(),
					"perPage" => $products->perPage(),
					"lastPage" => $products->lastPage(),
				]
			];
			return response()->json($result);
		}
		
		return view('admin.staticpage.relatives',compact('staticpage'));

	}	

	public function setRelatives($id)
	{
		$staticpage = Staticpage::findOrFail($id);
		$data = request()->all();
		$rid = request()->rid;
		if ($rid == $id) {
			return response()->json(['status' => 0]);
		}
		$action = request()->action;
		if ($action == 'add') {
			$staticpage->relatives()->syncWithoutDetaching([$rid]);
		} else {
			\DB::table('relative_staticpage')->where('relative_id', $rid)
			->where('staticpage_id', $id)
			->delete();

		}
		return response()->json(['status' => 1]);

	}		

	
}
