<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyChange extends Model
{
    protected $guarded = [''];

    public function tocurrency()
    {
    	return $this->belongsTo('App\Currency', 'to_currency');
    }

    public function fromcurrency()
    {
    	return $this->belongsTo('App\Currency', 'from_currency');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
