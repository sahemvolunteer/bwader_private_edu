<form class="ajax-update" action="{{ route('marks.update', [$exam_id, $my_class_id, $section_id, $subject_id]) }}" method="post">
    @csrf @method('put')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>الرقم</th>
            <th>اسم الطالب</th>
            <th>رقم التسجيل</th>
            <th>الاختبار الأول (20)</th>
            <th>الاختبار الثاني (20)</th>
            <th>الامتحان (60)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($marks->sortBy('user.name') as $mk)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mk->user->name }}</td>
                <td>{{ $mk->user->student_record->adm_no }}</td>

                {{-- الاختبارات والامتحان --}}
                <td><input title="الاختبار الأول" min="0" max="20" class="text-center" name="t1_{{ $mk->id }}" value="{{ $mk->t1 }}" type="number"></td>
                <td><input title="الاختبار الثاني" min="0" max="20" class="text-center" name="t2_{{ $mk->id }}" value="{{ $mk->t2 }}" type="number"></td>
                <td><input title="الامتحان" min="0" max="60" class="text-center" name="exm_{{ $mk->id }}" value="{{ $mk->exm }}" type="number"></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center mt-2">
        <button type="submit" class="btn btn-primary">تحديث الدرجات <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
