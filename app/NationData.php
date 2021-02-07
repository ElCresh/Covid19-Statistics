<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationData extends Model
{
    use HasFactory;

    protected $table = 'nation_datas';
    protected $timestamp = false;
}
