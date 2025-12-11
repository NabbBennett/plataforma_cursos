<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'capacity',
        'price_per_week',
        'number_of_weeks',
        'image',
        'enrolled_count',
        'course_group',
        'schedule'
    ];

    public function weeks(){
        return $this->hasMany(Week::class);
    }

    public function hasAvailableSpots(){
        if (is_null($this->capacity)) {
            return true; 
        }
        
        return $this->enrolled_count < $this->capacity;
    }

    public function getAvailableCapacityAttribute()
    {
        if (is_null($this->capacity)) return null;
        return max(0, (int)$this->capacity - (int)$this->enrolled_count);
    }

    // Verificar si está lleno
    public function isFullAttribute(){
        if (is_null($this->capacity)) {
            return false;
        }
        
        return $this->enrolled_count >= $this->capacity;
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function days(){
        return $this->hasMany(WeekDay::class);
    }

    public function evaluationBlocks(){
        return $this->hasMany(EvaluationBlock::class)->orderBy('after_week_id');
    }

    public function exams(){
        return $this->hasMany(\App\Models\Exam::class);
    }

    public function reviews(){
        return $this->hasMany(CourseReview::class);
    }

     public function averageRating(){
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function percentageForRating($rating){
        $totalReviews = $this->reviews()->count();
        if ($totalReviews === 0) return 0;

        $ratingCount = $this->reviews()->where('rating', $rating)->count();
        return ($ratingCount / $totalReviews) * 100;
    }

    public function countForRating($rating){
        return $this->reviews()->where('rating', $rating)->count();
    }
}
