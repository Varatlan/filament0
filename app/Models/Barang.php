<?php

namespace App\Models;

use App\Models\DetailFakturModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany(DetailFakturModel::class);
    }
}
