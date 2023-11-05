<?php

namespace WPFP\App\Models;
use WPFP\Boot\System\Model as WPFPModel;
use Illuminate\Database\Eloquent\Model;

class M_test_eloquent extends Model
{
    public $timestamps = false;
    
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = "wp_users";
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'user_login', 'user_pass', 'user_nicename', 'user_email', 'user_registered'
    ];
}