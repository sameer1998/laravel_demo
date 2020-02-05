<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Content extends Model
{
     use Notifiable;

    public $timestamps = true;
    public $table = 'contents';

    public function get_content($flag=""){
    	return Content::find()->where('flag',$flag)->first();
    }
}
