<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Session;
abstract class BaseModel extends Model {

    use SoftDeletes;

    public static function boot(){
        parent::boot();

    }
}