<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $guarded = [];
    public function bagian(){
		return $this->hasOne('App\Bagian', 'id', 'bagian_id');
	}
}
