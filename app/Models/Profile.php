<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Profile extends Model
{
    use SoftDeletes,UUID;
    protected $filelable = [
        'thumbnail',
        'name',
        'about',
        'headman',
        'people',
        'agriculture_area',
        'total_area',
    ];

    public function profileImages()
    {
        return $this->hasMany(ProfileImage::class);
    }
}
