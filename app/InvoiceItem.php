<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
	public function total($tax = false)
	{
	    $price = $this->material->price;
        $discount_1 = $this->discount_1;
        if ($discount_1 > 0){
            $price -= $price * ($discount_1/100);
        }
        $discount_2 = $this->discount_2;
        if ($discount_2 > 0){
            $price -= $price * ($discount_2/100);
        }
        if ($tax){
            $price += $price * ($this->material->tax/100);
        }
	    $quantity = $this->quantity;
	    return $price * $quantity;
	}

    public function priceWithDiscount()
    {
        $price = $this->material->price;
        $discount_1 = $this->discount_1;
        if ($discount_1 > 0){
            $price -= $price * ($discount_1/100);
        }
        $discount_2 = $this->discount_2;
        if ($discount_2 > 0){
            $price -= $price * ($discount_2/100);
        }
        return $price;
    }

    public function getDiscount()
    {
        $discount = 0;
        $price = $this->material->price;
        $discount_1 = $this->discount_1;
        if ($discount_1 > 0){
            $discount += $price * ($discount_1/100);
            $price -= $price * ($discount_1/100);
        }
        $discount_2 = $this->discount_2;
        if ($discount_2 > 0){
            $discount += $price * ($discount_2/100);
        }
        return $discount;
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function job_expense()
    {
        return $this->morphOne(JobExpense::class, 'expense_jobable', 'expense_type', 'expense_id');
    }

    public function discountInvoiceJob()
    {
        return $this->getDiscount() * $this->quantity;
    }

    public function linkJob()
    {
        $expense = JobExpense::where('job_id', $this->job_id)->where('expense_id', $this->id)->first();
        if (is_null($expense)){
            $newExpense = new JobExpense();
            $newExpense->linkMaterial($this, $this->job_id, $this->quantity, $this->total());
        }else{
            $expense->quantity = $this->quantity;
            $expense->total = $this->total();
            $expense->save();
        }
    }
}
