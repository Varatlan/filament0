<?php

namespace App\Models;

use App\Models\FakturModel;
use App\Models\CustomerModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'penjualan';

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }

    public function faktur()
    {
        return $this->belongsTo(FakturModel::class, 'id');
    }
}
