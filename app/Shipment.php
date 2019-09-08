<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable =[

        'payment_id', 'user_id','order_id','status',
        'shipment_date',
    ];

    public function customer(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
