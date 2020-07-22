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
                $fieldset->control('textarea', 'observations')
                    ->label('Observações')
                    ->value($this->observations ?? '');
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

    public function dropdownCustom()
    {
        $jobs = Job::all()->map(function($item, $key){
            return [$item->id => 'Ref: '.$item->reference.' | Nome: '.$item->name];
        });
    }

    public static function dropdownSelect($id = null)
    {
        $jobs = Job::where('active', true)->get();
        $options = "<option value=''></option>";
        foreach ($jobs as $job) {
            $selected = "";
            if (!is_null($id) && $id == $job->id) $selected = "selected";
            $options .= "<option value='".$job->id."' ".$selected.">REF: ".$job->reference." | NOME: ".$job->name."</option>";
        }
        return $options;
    }

}
