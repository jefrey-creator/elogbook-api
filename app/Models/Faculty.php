<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    //
    use HasFactory;

    protected $table = 'tbl_faculty';
    protected $primaryKey = 'faculty_id';
    protected $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'sex',
        'user_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
