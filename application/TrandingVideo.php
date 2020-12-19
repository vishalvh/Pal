<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TrandingVideo extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_tranding_video';
    protected $fillable = ['id', 'video_id', 'hotel_id','view_count', 'like_count', 'delete_flag', 'created_date_time', 'created_by'];
}