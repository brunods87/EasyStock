<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobExpense extends Model
{
	public function linkMaterial($model)
	{
		$this->job_id = $model->job_id;
		$this->quantity = $model->quantity;
		$this->save();
		$model->material->job_expense()->save($this);
	}

	public function linkEmployee($model)
	{
		$this->job_id = $model->job_id;
		$this->expense_type = lcfirst(class_basename($model));
		$this->quantity = $model->quantity;
		$this->quantity_extra = $model->quantity_extra;
		$this->save();
		$model->job_expense()->save($this);
	}

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function expense_jobable()
    {
        return $this->morphTo(null, 'expense_type', 'expense_id')->orderBy('order');
    }
}
