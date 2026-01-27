<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status', 'web_link', 'github_link'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class)->withTimestamps();
    }
}
