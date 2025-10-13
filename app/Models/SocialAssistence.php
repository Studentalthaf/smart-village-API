<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class SocialAssistence extends Model
{
    use SoftDeletes,UUID;
    protected $fillable =[
        'id',
        'thumbnail',
        'name',
        'category',
        'amount',
        'provider',
        'description',
        'is_available',
    ];

    public function socialAssistenceRecipients()
    {
        return $this->hasMany(SocialAssistenceRecipient::class);
    }
}
