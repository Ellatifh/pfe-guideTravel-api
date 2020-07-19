<?php

namespace App;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;

class Endroits extends Model
{
    use SoftDeletes;
    protected $table = 'endroits';
    protected $primaryKey = 'reference';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['reference','name','description','adresse1','adresse2','email','telephone','website','startTime','endTime','zipcode','longitude','latitude','categorie_id','city_id','user_id'];
    protected $with = ['medias'];

    public function categories(){
        return $this->belongsTo(Categorie::class,'categorie_id','id');
    }

    public function cities(){
        return $this->belongsTo(Citie::class,'city_id','id');
    }

    public function medias(){
        return $this->hasMany(Media::class,'endroits_reference','reference');
    }

    public function hebergements(){
        return $this->hasOne(Hebergements::class,'endroits_reference','reference');
    }

    public function shoppings(){
        return $this->hasOne(Shoppings::class,'endroits_reference','reference');
    }

    public function restaurants(){
        return $this->hasOne(Restaurants::class,'endroits_reference','reference');
    }

    public function cultures(){
        return $this->hasOne(Cultures::class,'endroits_reference','reference');
    }

    public function events(){
        return $this->hasOne(Events::class,'endroits_reference','reference');
    }

    public function loisir(){
        return $this->hasOne(Loisir::class,'endroits_reference','reference');
    }

    public function infos(){
        return $this->hasOne(Infos::class,'endroits_reference','reference');
    }
}
