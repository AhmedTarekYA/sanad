<?php

namespace App\Models\Sanad;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = 'backups';
    protected $fillable = ['backup_date'];
}
