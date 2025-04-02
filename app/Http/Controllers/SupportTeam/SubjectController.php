<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Requests\Subject\SubjectCreate;
use App\Http\Requests\Subject\SubjectUpdate;
use App\Repositories\MyClassRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  
use App\Models\Subject; // استيراد كلاس Subject
use App\Models\Section; 

use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    //protected 


    public $my_class, $user;

   



    public function __construct(MyClassRepo $my_class, UserRepo $user)
    {
        $this->middleware('teamSA', ['except' => ['destroy',] ]);
        $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->my_class = $my_class;
        $this->user = $user;
    }
     public function saveassignTeacher(Request $request)
{
  $sectionIds = $request->section_ids;

    if (in_array('all', $sectionIds)) {
        $sectionIds = Section::pluck('id')->toArray();
    }
    
 //
  // dd($request->all());
    $request->validate([
        'subject_id' => 'required|exists:subjects,id',
        'teacher_id' => 'required',
        'section_ids' => 'required|array', // ستحتوي على مجموعة من معرفات الشعب
        'section_ids.*' => 'exists:sections,id', // تأكد من أن كل معرّف شعبة موجود
    ]);

    // الحفظ في جدول subject_teacher_sections
    foreach ($request->section_ids as $sectionId) {
         

        DB::table('subject_teacher_sections')->updateOrInsert([
            'subject_id' => $request->subject_id,
             'section_id' => $sectionId,],
             [
            'teacher_id' => $request->teacher_id,

            'updated_at' => now(),

        ]);
    }

    return redirect()->route('subjects.index')->with('success', 'تم تعيين المدرس بنجاح');
}
public function assignTeacher($subjectId)
{
    // احصل على المادة باستخدام المعرف
    $s = Subject::findOrFail($subjectId);
    //    $s = Subject::all();
   $classId= $s->my_class_id;
    $sections = Section::where('my_class_id', $classId)->get();

//dd($sections);
    // احصل على قائمة المدرسين والشعب (أو أي بيانات تحتاجها)
    $teachers =$this->user->getUserByType('teacher');
//dd($teachers);

    //$sections = Section::all();
    // عرض الصفحة الخاصة بتعيين المدرس
    return view('pages.support_team.subjects.assign_teacher', compact('s', 'sections','teachers'));
}

    public function index()
    {
        $d['my_classes'] = $this->my_class->all();
       $d['teachers'] = $this->user->getUserByType('teacher');
        $d['subjects'] = $this->my_class->getAllSubjects();

        return view('pages.support_team.subjects.index', $d);
    }

    public function store(SubjectCreate $req)
    {
        $data = $req->all();

        $this->my_class->createSubject($data);

        return Qs::jsonStoreOk();
    }

    public function edit($id)
    {
        $d['s'] = $sub = $this->my_class->findSubject($id);
        $d['my_classes'] = $this->my_class->all();
    //    $d['teachers'] = $this->user->getUserByType('teacher');

        return is_null($sub) ? Qs::goWithDanger('subjects.index') : view('pages.support_team.subjects.edit', $d);
    }

    public function update(SubjectUpdate $req, $id)
    {
        $data = $req->all();
        $this->my_class->updateSubject($id, $data);

        return Qs::jsonUpdateOk();
    }

    public function destroy($id)
    {
        $this->my_class->deleteSubject($id);
        return back()->with('flash_success', __('msg.del_ok'));
    }
}
