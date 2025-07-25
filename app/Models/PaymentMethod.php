<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = "payment_methods";
    protected $fillable = ['name','logo','code','active','description','config'];
}
