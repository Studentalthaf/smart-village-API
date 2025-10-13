<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Event extends Model
{
    use SoftDeletes,UUID;

    protected $filelable = [
        'name',
        'thumbnail',
        'description',
        'price',
        'date',
        'time',
        'is_active',
    ];
    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
