<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'id';
    protected $fillable = ['endroits_reference','path','type'];
    protected $hidden = ['id','endroits_reference','created_at','updated_at'];

    public function endroit()
    {
        return $this->belongsTo('App\Endroits', 'reference', 'endroits_reference');
    }
}
