<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // the table associated with the model
    protected $table = 'members';
    // the attributes that are mass assignable
    protected $fillable = ['name', 'email'];
    // hidden fields
    protected $hidden = ['updated_at'];

}
