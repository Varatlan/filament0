<?php

namespace App\Models;

use App\Models\FakturModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerModel extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $guarded = [];

    public function faktur()
    {
        return $this->hasMany(FakturModel::class);
    }
}
