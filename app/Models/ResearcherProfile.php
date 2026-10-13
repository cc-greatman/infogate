<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['full_name', 'website_url', 'biography'])]
class ResearcherProfile extends Model
{

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function affiliations() : HasMany
    {
        return $this->hasMany(Affiliation::class);
    }

    public function researchInterests() : HasMany
    {
        return $this->hasMany(ResearchInterest::class);
    }
}
