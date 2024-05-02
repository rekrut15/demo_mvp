<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin\Staticpage;

use Illuminate\Validation\Rule;
use App\Repository\Staticpage\UpdateDto; 

class UpdateRequest extends AbstractRequest
{

	public function rules(): array
    {

		$id = request()->route('id');
		$rules = [
			'cnc' => [
            'required',
            'string',
            Rule::unique('staticpages')->ignore($id, 'id')
            ]
		];
			
		return array_merge(parent::rules(), $rules);

    }

    public function getDto(): UpdateDto
    {
        $validated = $this->validated();
		
		$dto = new UpdateDto($validated);

        return $dto;
    }	
	
}