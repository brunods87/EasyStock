<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Setting extends Model
{
	protected $guarded = [];

	public function form()
	{
	    return Form::of('settings', function ($form) {

	        $attributes = [
	            'method' => 'POST',
	            'id'     => 'setting-login-form',
	            'class'  => 'form-horizontal',
	        ];

	        $form->attributes($attributes);
	        // The form submit button label
	        $form->submit = $this->exists ? 'Guardar' : 'Criar';

	        $form->fieldset(function ($fieldset) {
	            $fieldset->control('input:number', 'tax_value')
	                ->label('Valor IVA')
	                ->value($this->tax_value ?? '');
	        });

	    });
	}
    
}
