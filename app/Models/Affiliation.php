<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['institution', 'department', 'country', 'professional_title'])]
class Affiliation extends Model
{
    public function researcherProfile() : BelongsTo
    {
        return $this->belongsTo(ResearcherProfile::class);
    }
}
