<?php
namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentRecord extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'session', 'user_id', 'my_class_id', 'section_id', 'my_parent_id', 'dorm_id', 'dorm_room_no', 'adm_no', 'year_admitted', 'wd', 'wd_date', 'grad', 'grad_date', 'house', 'age', 'first_name', 'last_name', 'active', 'pob', 'first_class_id', 'file', 'rtype',
        'lastschool',
        'rdocument',
        'ndocument',
        'ddocument',
        'note_register',
        'certificate_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function my_parent()
    {
        return $this->belongsTo(User::class);
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
//     public function findStudentsBySection($class_id, $section_id)
// {
//     return StudentRecord::where('class_id', $class_id)->where('section_id', $section_id)->get();
// }








}
