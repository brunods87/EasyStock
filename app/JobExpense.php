<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobExpense extends Model
{
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function expense_jobable()
    {
        return $this->morphTo(null, 'expense_type', 'expense_id')->orderBy('order');
    }
}
