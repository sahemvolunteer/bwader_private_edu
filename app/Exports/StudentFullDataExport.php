<?php
namespace App\Exports;

use App\Models\StudentRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentFullDataExport implements FromCollection, WithHeadings
{
    protected $student_id;

    public function __construct($student_id)
    {
        $this->student_id = $student_id;
    }

    public function collection()
    {
        $student = StudentRecord::with(['personalInfo', 'parentInfo', 'classInfo'])  // العلاقات حسب جدولك
->where('id', $this->student_id)
            ->get();

        return $student->map(function ($s) {
            return [
                'ID' => $s->id,
                'الاسم' => $s->personalInfo->first_name . ' ' . $s->personalInfo->last_name,
                'العمر' => $s->personalInfo->age,
                'الجنس' => $s->personalInfo->gender,
                'الأب' => $s->parentInfo->name ?? 'غير محدد',
                'الشعبة' => $s->classInfo->name ?? 'غير محدد',
                'رقم وطني' => $s->personalInfo->national_id,
                'سنة القبول' => $s->year_admitted,
                'نشط' => $s->active ? 'نعم' : 'لا',
            ];
        });
    }

    public function headings() : array
    {
        return [
            'ID',
            'الاسم',
            'العمر',
            'الجنس',
            'الأب',
            'الشعبة',
            'رقم وطني',
            'سنة القبول',
            'نشط',
        ];
    }
}
