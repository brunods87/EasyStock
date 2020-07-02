<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Client extends Model
{
    protected $guarded = [];

	public function form()
	{
	    return Form::of('clients', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'client-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label('Nome')
                    ->value($this->name ?? '');
            
	            $fieldset->control('input:number', 'nif')
	                    ->label('NIF')
	                    ->value($this->nif ?? '');
	            $fieldset->control('textarea', 'address')
	                ->label('Morada')
	                ->value($this->address ?? '');
	        });
        });
	}

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
