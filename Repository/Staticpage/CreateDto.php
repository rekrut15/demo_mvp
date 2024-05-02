<?php
declare(strict_types=1);

namespace App\Repository\Staticpage;

use App\Models\Staticpage;
use Illuminate\Support\Facades\Auth;


class CreateDto extends AbstractDto
{
	
	
    public function toModel(): Staticpage
    {
		$model = new Staticpage; 
        foreach ($this->attributes as $attribute) {
            if (property_exists($this, $attribute)) {
                 $model->$attribute = $this->$attribute;
            }
        }
        return $model;
    }
}
