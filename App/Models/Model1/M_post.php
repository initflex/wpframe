<?php

namespace WPFP\App\Models;
use WPFP\Boot\System\Model as WPFPModel;
use Illuminate\Database\Eloquent\Model;

class M_post extends Model
{
    public $timestamps = false;
    
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = "wp_posts";
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'ID', 'post_author', 'post_date', 'post_title'
    ];
}