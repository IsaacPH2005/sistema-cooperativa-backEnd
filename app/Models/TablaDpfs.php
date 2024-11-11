<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaDpfs extends Model
{
    use HasFactory;
    protected $fillable = ['plazo', 'interes_bs', 'interes_usd'];
}
