<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoryView extends Model
{
    use HasFactory;

    protected $fillable = [
    'story_id',
    'viewer_id',
    'viewed_at',
];

    public function story() {
        return $this->belongsTo(Story::class);
    }

    public function viewer() {
        return $this->belongsTo(User::class, 'viewer_id');
    }
}
