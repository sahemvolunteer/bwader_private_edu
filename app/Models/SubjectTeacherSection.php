<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacherSection extends Model
{
    use HasFactory;

    protected $table = 'subject_teacher_sections'; // تأكيد اسم الجدول

    protected $fillable = ['subject_id', 'teacher_id', 'section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
