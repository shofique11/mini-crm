<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /** @use HasFactory<\Database\Factories\LeadFactory> */
    use HasFactory;
    protected $fillable = ['name','email','phone','status','counselor_id'];

    public static function statuses()
    {
        return ['In Progress', 'Bad Timing', 'Not Interested', 'Not Qualified'];
    }

    /**
     * Relationship: A lead belongs to a counselor
     */
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
    /**
     * Relationship: A lead can have one application
     */
    public function application()
    {
        return $this->hasOne(Application::class);
    }
}
