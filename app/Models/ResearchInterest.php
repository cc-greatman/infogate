<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['interest'])]
class ResearchInterest extends Model
{
    public function researcherProfile() : BelongsTo
    {
        return $this->belongsTo(ResearcherProfile::class);
    }
}
