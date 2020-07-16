<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Invoice extends Model
{

	protected $guarded = [];

    public function form()
    {
        return Form::of('invoices', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'invoice-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                $fieldset->control('input:text', 'number')
                    ->label('Número')
                    ->value($this->number ?? '');
                $fieldset->control('select', 'supplier_id')
                    ->options(['0' => ''] + Supplier::pluck('name', 'id')->toArray())
                    ->label('Fornecedor')
                    ->value($this->supplier_id ?? '');
                $fieldset->control('input:date', 'date')
                    ->label('Data')
                    ->value($this->date ?? '');
                
            });

        });
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->invoice_items as $item) {
            $total += $item->total();
        }
        $this->total = $total;
        $this->save();
        return $total;
    }

    public function materialsIds()
    {
        $arrayIds = $this->invoice_items->pluck('material_id')->toArray();
        return $arrayIds;
    }
}
