<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin\Staticpage;

use Illuminate\Validation\Rule;
use App\Repository\Staticpage\CreateDto;
use Illuminate\Validation\Rules\File;

class CreateRequest extends AbstractRequest
{
	
	public function rules(): array
    {

		$rules = [
			'cnc' => ['required', 'string', 'unique:staticpages'],
		];
		
		return array_merge(parent::rules(), $rules);

    }

    public function getDto(): CreateDto
    {
        $validated = $this->validated();
		$dto = new CreateDto($validated);

        return $dto;
    }	
	
}
