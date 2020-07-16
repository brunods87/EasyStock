<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
	public function total()
	{
	    $price = $this->material->price;
        $discount = $this->material->getDiscount();
        if ($discount > 0){
            $price -= $discount;
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
