<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Job extends Model
{
	public function form()
	{
	    return Form::of('jobs');
	}

    public function job_expenses()
    {
        return $this->hasMany(JobExpense::class);
    }

    public function job_profits()
    {
        return $this->hasMany(JobProfit::class);
    }

}
