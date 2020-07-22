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
	            $fieldset->control('input:number', 'tax_value_normal')
	                ->label('IVA Taxa normal')
	                ->value($this->tax_value_normal ?? '');
	        });

	        $form->fieldset(function ($fieldset) {
	            $fieldset->control('input:number', 'tax_value_reduced')
	                ->label('IVA Taxa reduzida')
	                ->value($this->tax_value_reduced ?? '');
	        });

	        $form->fieldset(function ($fieldset) {
	            $fieldset->control('input:number', 'tax_value_intermediary')
	                ->label('IVA Taxa intermédia')
	                ->value($this->tax_value_intermediary ?? '');
	        });

	    });
	}
    
}
