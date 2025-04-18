<?php
namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Helpers\Mk;
use App\Http\Requests\Student\StudentRecordCreate;
use App\Http\Requests\Student\StudentRecordUpdate;
use App\Repositories\LocationRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\StudentRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentFullDataExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentRecordController extends Controller
{


    protected $loc, $my_class, $user, $student;




    public function __construct(LocationRepo $loc, MyClassRepo $my_class, UserRepo $user, StudentRepo $student)
    {
        $this->middleware('teamSA', ['only' => ['edit', 'update', 'reset_pass', 'create', 'store', 'graduated']]);
        $this->middleware('super_admin', ['only' => ['destroy', ]]);

        $this->loc = $loc;
        $this->my_class = $my_class;
        $this->user = $user;
        $this->student = $student;
    }


    public function exportStudent($id)
    {
        return Excel::download(new StudentFullDataExport($id), 'student_data.xlsx');
    }
    public function getTeacherClassesAndSections($teacherId)
    {
        return DB::table('subject_teacher_sections')
            ->join('sections', 'subject_teacher_sections.section_id', '=', 'sections.id')
            ->join('subjects', 'subject_teacher_sections.subject_id', '=', 'subjects.id')
            ->join('my_classes', 'subjects.my_class_id', '=', 'my_classes.id')
            ->where('subject_teacher_sections.teacher_id', $teacherId)
            ->select('my_classes.id as class_id', 'my_classes.name as class_name', 'sections.id as section_id', 'sections.name as section_name')
            ->distinct() // تجنب تكرار نفس الصف والشعبة إذا كان يدرّس أكثر من مادة لنفس الشعبة
->get();
    }

    public function reset_pass($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        $data['password'] = Hash::make('student');
        $this->user->update($st_id, $data);
        return back()->with('flash_success', __('msg.p_reset'));
    }

    public function create()
    {
        $data['my_classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['dorms'] = $this->student->getAllDorms();
        $data['students'] = $this->user->getUserByType('student');
        $data['states'] = $this->loc->getStates();
        $data['nationals'] = $this->loc->getAllNationals();
        return view('pages.support_team.students.add', $data);
    }

    public function store(StudentRecordCreate $req)
    { 
    // dd("error");
        $data = $req->only(Qs::getUserRecord());
        $sr = $req->only(Qs::getStudentData());

        $sp = $req->only([
            'national_id', 'form_date', 'confirmation_date', 'identified_by', 'exception_reason',
            'withdrawal', 'transfer_school', 'withdrawal_date', 'approved_mobile', 'custom_mobile',
            'kinship', 'region', 'transport_service', 'subscription_type', 'transport_group',
            'registration_place', 'registration_number', 'civil_registry_office',
            'governorate', 'housing_sector', 'commitment_behavior_year', 'commitment_academic_year', 'commitment_delay_year', 'commitment_fees_year', 'school_notes', 'admin_notes', 'health_notes', 'parent_recommendations'
        ]);
        $parent_info = $req->only([
            'father_name', 'grandfather_name', 'father_job', 'father_education', 'father_workplace', 'father_phone',
            'mother_firstname', 'mother_lastname', 'grandmother_name', 'mother_job', 'mother_education', 'mother_workplace',
            'mother_phone', 'father_birth_date', 'father_nationality', 'mother_birth_date', 'mother_nationality	',
            'separated', 'f_deceased', 'm_deceased'
        ]);

        $ct = $this->my_class->findTypeByClass($req->my_class_id)->code;
       /* $ct = ($ct == 'J') ? 'JSS' : $ct;
        $ct = ($ct == 'S') ? 'SS' : $ct;*/

        $data['user_type'] = 'student';
        $data['name'] = ucwords($req->name);
        $data['code'] = strtoupper(Str::random(10));
        $data['password'] = Hash::make('student');
        $data['photo'] = Qs::getDefaultUserImage();
        $adm_no = $req->adm_no;
        $data['username'] = strtoupper(Qs::getAppCode() . '/' . $ct . '/' . $sr['year_admitted'] . '/' . ($adm_no ? : mt_rand(1000, 99999)));

        if ($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student') . $data['code'], $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }


        $user = $this->user->create($data); // Create User

        $sr['adm_no'] = $adm_no;
      
        //$data['username'];
        $sr['user_id'] = $user->id;
        $sr['session'] = Qs::getSetting('current_session');
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('files', $filename, 'public');
            $sr['file'] = $path;
        }
        $this->student->createRecord($sr); // Create Student
        $sp['student_id'] = $user->id;
        DB::table('student_personal_info')->insert($sp);

    // 7️⃣ حفظ معلومات الوالدين في جدول parent_info
        $parent_info['student_id'] = $user->id;
        DB::table('parent_info')->insert($parent_info);
     // 8️⃣ حفظ الإخوة في جدول siblings
        if ($req->has('siblings')) {
            foreach ($req->siblings as $sibling_id) {
            // تأكد من أن العلاقة بين الطالب والأخ ليست موجودة مسبقًا
                if ($user->id != $sibling_id) {  // لا نريد أن يكون الطالب أخًا لنفسه
                    DB::table('siblings')->insert([
                        'student_id' => $user->id,
                        'sibling_id' => $sibling_id,
                        'relation_type' => $req->input('relation_type', null) // إذا كنت تستخدم نوع العلاقة
                    ]);
                    DB::table('siblings')->insert([
                        'student_id' => $sibling_id,
                        'sibling_id' => $user->id,

                    ]);
                }
            }
        }

        return Qs::jsonStoreOk();
    }

    public function listByClass($class_id)
    {
        $data['my_class'] = $mc = $this->my_class->getMC(['id' => $class_id])->first();

        $data['students'] = $this->student->findStudentsByClass($class_id);
        $data['sections'] = $this->my_class->getClassSections($class_id);
        $all_classes = $data['my_class'];
        $all_sections = $data['sections'];

        $teacherSections = [];
        if (Qs::userIsTeacher()) {
            $teacher_id = auth()->user()->id; // Get logged-in teacher's ID
            $data['sections'] = $all_sections->where('teacher_id', $teacher_id);
        // $all_sections= $data['sections'];
        // استدعاء الدالة وتمرير معرف المدرس
            $teacherClassesAndSections = $this->getTeacherClassesAndSections($teacher_id);
//dd($teacherClassesAndSections);
            foreach ($teacherClassesAndSections as $item)
                {
                if ($item->class_id == $class_id)
                    {
                    $teacherSections[] = $item->section_id;
                }

            }


            $data['sections'] = $all_sections->whereIn('id', $teacherSections)
                ->merge($all_sections->where('teacher_id', $teacher_id));
 

//dd($data);

















        }

        return is_null($mc) ? Qs::goWithDanger() : view('pages.support_team.students.list', $data);
    }

    public function getTeacherClasses()
    {
        $teacher_id = auth()->user()->id;

    // جلب الصفوف التي يكون فيها المدرس مسؤولاً عن القسم
        $class_ids_by_section = Section::where('teacher_id', $teacher_id)
            ->pluck('class_id')
            ->toArray();

    // جلب الصفوف التي يكون فيها المدرس مسؤولاً عن مادة
        $class_ids_by_subject = Subject::where('teacher_id', $teacher_id)
            ->pluck('class_id')
            ->toArray();

    // دمج جميع الصفوف وإزالة التكرار
        $class_ids = array_unique(array_merge($class_ids_by_section, $class_ids_by_subject));

    // جلب بيانات الصفوف
        $classes = MyClass::whereIn('id', $class_ids)->get();


        return view('teacher.classes', compact('classes'));
    }
    public function listBySection($class_id, $section_id)
    {
        $data['my_class'] = $mc = $this->my_class->getMC(['id' => $class_id])->first();
        $data['students'] = $this->student->findStudentsBySection($section_id);
        $data['sections'] = $this->my_class->getClassSections($class_id);
        $data['selected_section'] = $section_id;
    // if ($data['students']->isEmpty()) {
    //     dd('No students found', $data);
    // }
        return is_null($mc) ? Qs::goWithDanger() : view('pages.support_team.students.list', $data);
    }
    public function graduated()
    {
        $data['my_classes'] = $this->my_class->all();
        $data['students'] = $this->student->allGradStudents();

        return view('pages.support_team.students.graduated', $data);
    }

    public function not_graduated($sr_id)
    {
        $d['grad'] = 0;
        $d['grad_date'] = NULL;
        $d['session'] = Qs::getSetting('current_session');
        $this->student->updateRecord($sr_id, $d);

        return back()->with('flash_success', __('msg.update_ok'));
    }

    public function show($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if (!$sr_id) {
            return Qs::goWithDanger();
        }

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();

        /* Prevent Other Students/Parents from viewing Profile of others */
        if (Auth::user()->id != $data['sr']->user_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild($data['sr']->user_id, Auth::user()->id)) {
            return redirect(route('dashboard'))->with('pop_error', __('msg.denied'));
        }

        return view('pages.support_team.students.show', $data);
    }

    public function edit($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if (!$sr_id) {
            return Qs::goWithDanger();
        }

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        $student_id = $data['sr']->user_id;

        $data['personal_info'] = DB::table('student_personal_info')->where('student_id', $student_id)->first();
        $data['parent_info'] = DB::table('parent_info')->where('student_id', $student_id)->first();
//$data['siblings'] = DB::table('siblings')->where('student_id', $student_id)->pluck('sibling_id')->toArray();
        $data['siblings_ids'] = DB::table('siblings')->where('student_id', $student_id)->pluck('sibling_id')->toArray();

        $data['my_classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['dorms'] = $this->student->getAllDorms();
        $data['states'] = $this->loc->getStates();
        $data['students'] = $this->user->getUserByType('student');

        $data['nationals'] = $this->loc->getAllNationals();
        return view('pages.support_team.students.edit', $data);
    }

    // public function update(StudentRecordUpdate $req, $sr_id)
    // {
    //     $sr_id = Qs::decodeHash($sr_id);
    //     if(!$sr_id){return Qs::goWithDanger();}

    //     $sr = $this->student->getRecord(['id' => $sr_id])->first();
    //     $d =  $req->only(Qs::getUserRecord());
    //     $d['name'] = ucwords($req->name);

    //     if($req->hasFile('photo')) {
    //         $photo = $req->file('photo');
    //         $f = Qs::getFileMetaData($photo);
    //         $f['name'] = 'photo.' . $f['ext'];
    //         $f['path'] = $photo->storeAs(Qs::getUploadPath('student').$sr->user->code, $f['name']);
    //         $d['photo'] = asset('storage/' . $f['path']);
    //     }

    //     $this->user->update($sr->user->id, $d); // Update User Details

    //     $srec = $req->only(Qs::getStudentData());

    //     $this->student->updateRecord($sr_id, $srec); // Update St Rec

    //     /*** If Class/Section is Changed in Same Year, Delete Marks/ExamRecord of Previous Class/Section ****/
    //     Mk::deleteOldRecord($sr->user->id, $srec['my_class_id']);

    //     return Qs::jsonUpdateOk();
    // }
    public function update(StudentRecordUpdate $req, $sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if (!$sr_id) {
            return Qs::goWithDanger();
        }

        $sr = $this->student->getRecord(['id' => $sr_id])->first();
        if (!$sr) {
            return Qs::goWithDanger();
        }

        $data = $req->only(Qs::getUserRecord());
        $data['name'] = ucwords($req->name);

        if ($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student') . $sr->user->code, $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }



        $this->user->update($sr->user->id, $data); // تحديث بيانات المستخدم

        $srec = $req->only(Qs::getStudentData());
        if ($req->hasFile('file')) {


            $file = $req->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('files', $filename, 'public');
            $srec['file'] = $path;
        }
        $this->student->updateRecord($sr_id, $srec); // تحديث سجل الطالب

        Mk::deleteOldRecord($sr->user->id, $srec['my_class_id']); // حذف سجلات الدرجات إذا تغير الصف

    // ✅ تحديث معلومات الطالب الشخصية
        $sp = $req->only([
            'national_number', 'form_date', 'confirmation_date', 'identified_by', 'exception_reason',
            'withdrawal', 'transfer_school', 'withdrawal_date', 'approved_mobile', 'custom_mobile',
            'kinship', 'region', 'transport_service', 'subscription_type', 'transport_group',
            'registration_place', 'registration_number', 'civil_registry_office',
            'governorate', 'housing_sector', 'commitment_behavior_year', 'commitment_academic_year', 'commitment_delay_year', 'commitment_fees_year', 'school_notes', 'admin_notes', 'health_notes', 'parent_recommendations'
        ]);

        DB::table('student_personal_info')->updateOrInsert(
            ['student_id' => $sr->user->id],
            $sp
        );

    // ✅ تحديث معلومات الوالدين
        $parent_info = $req->only([
            'father_name', 'grandfather_name', 'father_job', 'father_education', 'father_workplace', 'father_phone',
            'mother_firstname', 'mother_lastname', 'grandmother_name', 'mother_job', 'mother_education', 'mother_workplace',
            'mother_phone', 'father_birth_date', 'father_nationalit', 'mother_birth_date', 'mother_nationality',
            'separated', 'f_deceased', 'm_deceased'
        ]);

        DB::table('parent_info')->updateOrInsert(
            ['student_id' => $sr->user->id],
            $parent_info
        );

    // ✅ تحديث الإخوة (بحذف الموجودين أولاً ثم إعادة الإدخال)
        DB::table('siblings')->where('student_id', $sr->user->id)->orWhere('sibling_id', $sr->user->id)->delete();

        if ($req->has('siblings')) {
            foreach ($req->siblings as $sibling_id) {
                if ($sr->user->id != $sibling_id) {
                    DB::table('siblings')->insert([
                        'student_id' => $sr->user->id,
                        'sibling_id' => $sibling_id,
                        'relation_type' => $req->input('relation_type', null)
                    ]);
                    DB::table('siblings')->insert([
                        'student_id' => $sibling_id,
                        'sibling_id' => $sr->user->id,
                    ]);
                }
            }
        }

        return Qs::jsonUpdateOk();
    }

    public function destroy($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        if (!$st_id) {
            return Qs::goWithDanger();
        }

        $sr = $this->student->getRecord(['user_id' => $st_id])->first();
        $path = Qs::getUploadPath('student') . $sr->user->code;
        Storage::exists($path) ? Storage::deleteDirectory($path) : false;
        $this->user->delete($sr->user->id);

        return back()->with('flash_success', __('msg.del_ok'));
    }

}
