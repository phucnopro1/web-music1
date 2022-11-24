<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';
    protected $primaryKey = 'id';
    protected $fillable = ['title','content','image','artist','song','year','album_id','slug','view','streams','featured'];
    //
    public function album()
    {
        return $this->belongsTo('App\Album');
    }
}
