<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'tbl_logs';
    protected $primaryKey = 'logs_id';
    
    protected $fillable = [
        'full_name',
        'date_visited',
        'time_in',
        'time_out',
        'person_to_visit',
        'purpose',
        'action_taken',
        'is_accepted',
        'is_completed',
        'req_category',
    ];
}
