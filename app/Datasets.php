<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datasets extends Model
{
    protected $table = 'datasets';
    protected $fillable = [
        'tanggal', 'tbs_olah', 'tbs_olah_normalisasi',
    ];
}
