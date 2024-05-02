<?php
namespace App\Repository\Staticpage;

class AbstractDto{
	
    protected array $attributes = [
	  'name',
	  'cnc',
	  'url',
    ];	
    public $session_main_form;
    
    public function __construct(array $params = [])
    {
        
        foreach ($this->attributes as $attribute) {
            $keys = array_keys($params);
            if (in_array($attribute, $keys)) {
                $this->{$attribute} = $params[$attribute];
            }
        }
        
        $this->session_main_form = $params["session_main_form"] ?? null;
    }
}