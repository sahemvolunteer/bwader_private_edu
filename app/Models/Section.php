<?php

namespace App\Models;

use App\User;
use Eloquent;

class Section extends Eloquent
{
    protected $fillable = ['name', 'my_class_id', 'active', 'teacher_id'];

    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }

public function subjectTeacherSections()
{
    return $this->hasMany(SubjectTeacherSection::class, 'section_id');
}
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    
public function teachers()
{
    return $this->belongsToMany(User::class, 'subject_teacher_sections', 'section_id', 'teacher_id');
}
    

    public function student_record()
    {
        return $this->hasMany(StudentRecord::class);
    }
}
