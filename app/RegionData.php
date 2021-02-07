<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionData extends Model
{
    use HasFactory;

    protected $table = 'region_datas';
    protected $timestamp = false;
}
