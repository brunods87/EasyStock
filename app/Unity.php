<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Unity extends Model
{
    protected $guarded = [];

	public function form()
	{
	    return Form::of('unities', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'unity-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label('Nome')
                    ->value($this->name ?? '');
                $fieldset->control('input:text', 'slug')
                    ->label('Abreviatura')
                    ->value($this->slug ?? '');
            });

        });
	}

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
