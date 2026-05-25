<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['court_id', 'image_path', 'alt_text', 'is_primary'])]
class CourtImage extends Model
{
    protected function casts(): array
    {
        return ['is_primary' => 'boolean'];
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
