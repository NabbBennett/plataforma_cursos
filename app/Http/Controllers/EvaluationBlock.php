<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationBlock extends Model
{
    protected $fillable = [
        'course_id',
        'after_week_id',
        'live_meet_link',
        'recording_link',
    ];

    public function weekAfter()
    {
        return $this->belongsTo(Week::class, 'after_week_id');
    }
}
