<?php

// app/Models/WeekDay.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekDay extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'week_id', 'day_number', 'title', 'recording_link'];

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
