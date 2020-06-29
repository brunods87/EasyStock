<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

	public function job_expenses()
    {
        return $this->morphMany(JobExpense::class, 'expense_jobable', 'expense_type', 'expense_id');
    }
	
    public function worked_hours()
    {
        $job_expenses = $this->job_expenses;
    }
}
