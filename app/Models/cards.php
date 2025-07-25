<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cards extends Model
{
    protected $table="cards";
    protected$fillable=['user_id','card_number','expiry_month','expiry_year','cvv'];

  public function user()
    {
        return  $this->belongsTo(User::class);
    }

}
