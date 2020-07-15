<?php

namespace App;

use Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Job extends Model
{
    protected $guarded = [];

	public function form()
	{
	    return Form::of('jobs', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'job-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                $today = Carbon::today()->format('Y-m-d');
                $fieldset->control('input:date', 'date')
                    ->label('Data')
                    ->value($this->date ?? $today);
                $fieldset->control('input:text', 'reference')
                    ->label('Referência')
                    ->value($this->reference ?? '');
                $fieldset->control('input:text', 'name')
                    ->label('Nome')
                    ->value($this->name ?? '');
                $fieldset->control('select', 'client_id')
                    ->options(['0' => ''] + Client::pluck('name', 'id')->toArray())
                    ->label('Cliente')
                    ->value($this->client_id ?? '');
                $fieldset->control('textarea', 'address')
                    ->label('Morada')
                    ->value($this->address ?? '');
                $attributes = [
                    'step' => 0.01,
                ];
                $fieldset->control('input:number', 'quote_value')
                    ->label('Valor Orçamentado')
                    ->value($this->quote_value ?? 0.00)
                    ->attributes($attributes);
                $fieldset->control('select', 'type')
                    ->options(['faturado' => 'faturado', 'simplificado' => 'simplificado'])
                    ->label('Tipo')
                    ->value($this->type ?? 'faturado');
            });

        });
	}

    public function job_expenses()
    {
        return $this->hasMany(JobExpense::class);
    }

    public function job_profits()
    {
        return $this->hasMany(JobProfit::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
