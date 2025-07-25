<?php

namespace App\Models;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{


protected $table="transactions";
protected $fillable=['user_id','transaction_number','amount','type','status','payment_method_id'];
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
        public function PaymentMethod()
    {
        return  $this->belongsTo(PaymentMethod::class);
    }
}
