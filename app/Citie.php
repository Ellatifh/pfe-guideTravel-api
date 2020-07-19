<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citie extends Model
{
    use SoftDeletes;
    protected $table = 'cities';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function endroits(){
        return $this->hasMany('App\Endroits');
    }
}
