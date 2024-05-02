<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin\Staticpage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
#use Illuminate\Support\Facades\Request;


class AbstractRequest extends FormRequest
{
	public function rules(): array
    {
		
        return [
			'name' => ['required','string'],
            'session_main_form' => ['nullable','string'],
            'session_mob_form' => ['nullable','string']
        ];
    }

    public function messages(): array
    {
        return [
        ];
    }

}
