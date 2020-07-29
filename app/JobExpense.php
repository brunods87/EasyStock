<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobExpense extends Model
{
	public function linkMaterial($item, $job_id, $quantity, $total)
	{
		$this->job_id = $job_id;
		$this->quantity = $quantity;
		$this->total = $total;
		$this->save();
		$item->job_expense()->save($this);
	}

	public function linkEmployee($employee, $job_id, $quantity, $quantity_extra, $total)
	{
		$this->job_id = $job_id;
		$this->quantity = $quantity;
		$this->quantity_extra = $quantity_extra;
		$this->total = $total;
		$this->save();
		$employee->job_expense()->save($this);
	}

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function expense_jobable()
    {
        return $this->morphTo(null, 'expense_type', 'expense_id');
    }
}
