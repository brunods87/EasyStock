<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Employee extends Model
{
	protected $guarded = [];

	public function form()
	{
	    return Form::of('employees', function ($form) {

            $attributes = [
                'method' => 'POST',
                'id'     => 'employee-login-form',
                'class'  => 'form-horizontal',
            ];

            $form->attributes($attributes);
            // The form submit button label
            $form->submit = $this->exists ? 'Guardar' : 'Criar';

            $form->fieldset(function ($fieldset) {
                
            	$fieldset->control('input:number', 'number')
	                    ->label('Número')
	                    ->value($this->number ?? '');

                $fieldset->control('input:text', 'name')
                    ->label('Nome')
                    ->value($this->name ?? '');
            
	            $fieldset->control('input:date', 'admission_date')
	                ->label('Data de admissão')
                    ->value($this->admission_date ?? '');
                $attributes = [
				    'step' => 0.01,
				];
                $fieldset->control('input:number', 'salary')
                	->label('Salário')
                	->value($this->salary ?? '')
                	->attributes($attributes);

                $fieldset->control('input:number', 'value_hour')
                	->label('Valor hora')
                	->value($this->value_hour ?? '')
                	->attributes($attributes);

                $fieldset->control('input:number', 'value_extra_hour')
                    ->label('Valor hora extra')
                    ->value($this->value_extra_hour ?? '')
                    ->attributes($attributes);

	            $fieldset->control('textarea', 'observations')
	                ->label('Observações')
	                ->value($this->observations ?? '');
	        });
        });
	}

	public function job_expenses()
    {
        return $this->morphMany(JobExpense::class, 'expense_jobable', 'expense_type', 'expense_id');
    }
	
    public function worked_hours()
    {
        $job_expenses = $this->job_expenses;
    }
}
