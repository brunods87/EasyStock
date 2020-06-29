<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
	public function form()
	{
	    return Form::of('suppliers');
	}

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
