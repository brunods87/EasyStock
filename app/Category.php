<?php

namespace App;
use Form;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $guarded = [];

	public function form()
	{
	    return Form::of('categories', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'category-login-form',
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
