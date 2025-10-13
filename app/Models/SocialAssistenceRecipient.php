<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class SocialAssistenceRecipient extends Model
{
    use SoftDeletes,UUID;
    protected $fillable =[
        'social_assistence_id',
        'head_of_family_id',
        'amount',
        'reason',
        'bank',
        'account_number',
        'proof',
        'status'
    ];

    public function socialAssistence()
    {
        return $this->belongsTo(SocialAssistence::class);
    }
    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }   

}
