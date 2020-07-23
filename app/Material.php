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
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'name')
                    ->label('Nome')
                    ->value($this->name ?? '');
                $fieldset->control('input:text', 'reference')
                    ->label('Referência')
                    ->value($this->reference ?? '');
                $fieldset->control('select', 'supplier_id')
                    ->options(['0' => ''] + Supplier::pluck('name', 'id')->toArray())
                    ->label('Fornecedor')
                    ->value($this->supplier_id ?? '');
                $fieldset->control('select', 'category_id')
                    ->options(['0' => ''] + Category::pluck('name', 'id')->toArray())
                    ->label('Categoria')
                    ->value($this->category_id ?? '');
                $fieldset->control('select', 'type_id')
                    ->options(['0' => ''] + Type::pluck('name', 'id')->toArray())
                    ->label('Tipo')
                    ->value($this->type_id ?? '');
                $attributes = [
                    'step' => 0.01,
                ];
                $fieldset->control('input:number', 'price')
                    ->label('Preço')
                    ->value($this->price ?? 0.00)
                    ->attributes($attributes);
                $fieldset->control('select', 'unity_id')
                    ->options(['0' => ''] + Unity::pluck('name', 'id')->toArray())
                    ->label('Unidade')
                    ->value($this->unity_id ?? '');
                $fieldset->control('input:number', 'discount')
                    ->label('Desconto')
                    ->value($this->discount ?? 0)
                    ->attributes($attributes);
                $fieldset->control('input:number', 'stock')
                    ->label('Stock')
                    ->value($this->stock ?? 0)
                    ->attributes($attributes);
                $fieldset->control('select', 'tax')
                    ->options(['0' => '0%', Setting::first()->tax_value_normal => Setting::first()->tax_value_normal.'%', Setting::first()->tax_value_intermediary => Setting::first()->tax_value_intermediary.'%', Setting::first()->tax_value_reduced => Setting::first()->tax_value_reduced.'%'])
                    ->label('IVA')
                    ->value($this->tax ?? 0);
            });

        });
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function job_expense()
    {
        return $this->morphOne(JobExpense::class, 'expense_jobable', 'expense_type', 'expense_id');
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

    public function getDiscount()
    {
        $discount = 0;
        if ($this->discount > 0){
            $discount += $this->price * ($this->discount / 100);
        }
        return $discount;
    }

}
