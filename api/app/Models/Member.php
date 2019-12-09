<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use Searchable;

    // the table associated with the model
    protected $table = 'members';
    // the attributes that are mass assignable
    protected $fillable = ['name', 'email'];
    // hidden fields
    protected $hidden = ['updated_at'];

}
