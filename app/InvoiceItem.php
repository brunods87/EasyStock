<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
	public function total()
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
	    $quantity = $this->quantity;
	    return number_format($price * $quantity,2);
	}

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
