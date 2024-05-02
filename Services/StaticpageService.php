<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\Staticpage\Repository;
use App\Repository\Staticpage\CreateDto;
use App\Repository\Staticpage\UpdateDto;
use App\Models\Staticpage;

class StaticpageService {
	
	private Repository $repo;
	
	public function __construct(
        Repository $repo
		
    ) {
        $this->repo = $repo;
    }
	
    public function create(CreateDto $dto): Staticpage
    {	
		
        $model = $this->repo->create($dto);
        return $model;
    }
	
    public function update(Staticpage $model, UpdateDto $dto): bool
    {
		
       $updateResult = $this->repo->update($model, $dto);
       return $updateResult;
    }
	
}	
