<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['reported_by', 'court_id', 'category', 'description', 'status'])]
class Report extends Model
{
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
