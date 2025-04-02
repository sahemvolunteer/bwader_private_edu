<?php

namespace App\Models;

use App\User;
use Eloquent;

class Subject extends Eloquent
{
    protected $fillable = ['name', 'my_class_id', 'slug'];
// i remove 
    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


public function sections()
{
    return $this->belongsToMany(Section::class, 'subject_teacher_sections', 'subject_id', 'section_id');
}


}
