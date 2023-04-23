<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(Voucher::class, 'promos', 'voucher_id', 'user_id')->withTimestamps()->withPivot(['qty'])->as('promo');
    }
}
