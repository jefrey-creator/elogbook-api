<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailer extends Model
{
    protected $table = 'tbl_mailer';
    protected $primaryKey = 'mail_id';
    protected $fillable = [
        'mail_body',
        'mail_subject',
        'mail_tag'
    ];
}
