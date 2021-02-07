<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceData extends Model
{
    use HasFactory;

    protected $table = 'province_datas';
    protected $timestamp = false;
}
