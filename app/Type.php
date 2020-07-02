<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Type extends Model
{
    protected $guarded = [];

	public function form()
	{
	    return Form::of('types', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'type-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label('Nome')
                    ->value($this->name ?? '');
            });

        });
	}

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
