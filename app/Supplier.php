<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Supplier extends Model
{
	protected $guarded = [];

	public function form()
	{
	    return Form::of('suppliers', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'supplier-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label('Nome')
                    ->value($this->name ?? '');
                $fieldset->control('input:number', 'discount')
                    ->label('Desconto')
                    ->value($this->discount ?? '');
                $fieldset->control('input:number', 'nif')
                    ->label('NIF')
                    ->value($this->nif ?? '');
            });

        });
	}

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
