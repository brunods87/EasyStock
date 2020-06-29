<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class Material extends Model
{
    protected $guarded = [];

    public function form()
    {
        return Form::of('materials');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function job_expense()
    {
        return $this->belongsTo(JobExpense::class);
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

    public function tax()
    {
    	if ($this->taxable){
	        $settings = Setting::first();
	        return $settings->tax_value;
	    }
	    return 0;
    }
}
