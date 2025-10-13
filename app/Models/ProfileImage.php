<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class ProfileImage extends Model
{
    use SoftDeletes,UUID;
    protected $filelable = [
        'profile_id',
        'image',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
