<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Material extends Model
{
    protected $guarded = [];

    public function form()
    {
        return Form::of('materials', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'material-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = 'Guardar';

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label('Nome');
                $fieldset->control('input:text', 'reference')
                    ->label('Referência');
                $fieldset->control('select', 'supplier_id')
                    ->options(Supplier::all())
                    ->label('Fornecedor');
                $fieldset->control('select', 'category_id')
                    ->options(Category::all())
                    ->label('Categoria');
                $fieldset->control('select', 'type_id')
                    ->options(Type::all())
                    ->label('Tipo');
                $fieldset->control('input:number', 'price')
                    ->label('Preço');
                $fieldset->control('select', 'unity_id')
                    ->options(Unity::all())
                    ->label('Unidade');
                $fieldset->control('input:number', 'discount')
                    ->label('Desconto');
                $fieldset->control('input:number', 'stock')
                    ->label('Stock');
            });

        });
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function job_expense()
    {
        return $this->belongsTo(JobExpense::class);
    }

    public function job()
    {
    	return $this->job_expense->job;    
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function tax()
    {
    	if ($this->taxable){
	        $settings = Setting::first();
	        return $settings->tax_value;
	    }
	    return 0;
    }
}
