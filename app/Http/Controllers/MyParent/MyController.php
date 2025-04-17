<?php
namespace App\Http\Controllers\MyParent;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyController extends Controller
{
    protected $student;
    public function __construct(StudentRepo $student)
    {
        $this->student = $student;
    }

    public function children()
    {
        $data['students'] = $this->student->getRecord(['my_parent_id' => Auth::user()->id])->with(['my_class', 'section'])->get();

        return view('pages.parent.children', $data);
    }
    public function apiChildren(Request $request)
    {
        $parentId = $request->input('parent_id');

        $students = $this->student->getRecord(['my_parent_id' => $parentId])
            ->with(['my_class', 'section'])
            ->get();

        return response()->json([
            'status' => true,
            'data' => $students
        ]);
    }


}