<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shoppings extends Model
{
    use SoftDeletes;
    protected $table = 'shoppings';
    protected $primaryKey = 'endroits_reference';
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = ['endroits_reference','type'];
    protected $hidden = ['endroits_reference','created_at','updated_at'];

    public function endroit()
    {
        return $this->belongsTo('App\Endroits', 'reference', 'endroits_reference');
    }
}
