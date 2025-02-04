<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\FakturModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailFakturModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'detail';

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function faktur()
    {
        return $this->belongsTo(FakturModel::class, 'id');
    }
}
