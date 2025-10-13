<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Development extends Model
{
    use SoftDeletes,UUID;
    protected $filelable = [
        'thumbnail',
        'name',
        'description',
        'person_in_charge',
        'start_date',
        'end_date',
        'status',
    ];

    public function developmentApplicants()
    {
        return $this->hasMany(DevelopmentApplicant::class);
    }
    
}
