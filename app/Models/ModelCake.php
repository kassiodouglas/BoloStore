<?php

namespace App\Models;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PDOException;

class ModelCake extends Model
{
    use HasFactory;

    protected $table = 'tb_cakes';

}
