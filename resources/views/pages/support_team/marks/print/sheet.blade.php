{{--<!-- الاسم، الصف، والمعلومات الأخرى -->--}}
<table style="width:100%; border-collapse:collapse; direction: rtl; text-align: right;">
    <tbody>
    <tr>
        <td><strong>الاسم:</strong> {{ strtoupper($sr->user->name) }}</td>
        {{-- <td><strong>رقم القيد:</strong> {{ $sr->adm_no }}</td> --}}
        {{-- <td><strong>المنزل:</strong> {{ strtoupper($sr->house) }}</td> --}}
        <td><strong>الصف:</strong> {{ strtoupper($my_class->name) }}</td>
    </tr>
    <tr>
        <td><strong>كشف الدرجات لـ</strong> {!! strtoupper(Mk::getSuffix($ex->term)) !!} الفصل</td>
        <td><strong>العام الدراسي:</strong> {{ $ex->year }}</td>
        <td><strong>العمر:</strong> {{ $sr->age ?: ($sr->user->dob ? date_diff(date_create($sr->user->dob), date_create('now'))->y : '-') }}</td>
    </tr>
    </tbody>
</table>

{{-- جدول الدرجات --}}
<table style="width:100%; border-collapse:collapse; border: 1px solid #000; margin: 10px auto; direction: rtl; text-align: right;" border="1">
    <thead>
    <tr>
        <th rowspan="2">المواد</th>
        <th colspan="3">التقويم المستمر</th>
        <th rowspan="2">الامتحان<br>(60)</th>
        <th rowspan="2">المجموع النهائي<br>(100%)</th>
        <th rowspan="2">التقدير</th>
        <th rowspan="2">ترتيب المادة</th>
        <th rowspan="2">الملاحظات</th>
    </tr>
    <tr>
        <th>الاختبار 1 (20)</th>
        <th>الاختبار 2 (20)</th>
        <th>المجموع (40)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subjects as $sub)
        <tr>
            <td style="font-weight: bold">{{ $sub->name }}</td>
            @foreach($marks->where('subject_id', $sub->id)->where('exam_id', $ex->id) as $mk)
                <td>{{ $mk->t1 ?: '-' }}</td>
                <td>{{ $mk->t2 ?: '-' }}</td>
                <td>{{ $mk->tca ?: '-' }}</td>
                <td>{{ $mk->exm ?: '-' }}</td>
                <td>{{ $mk->$tex ?: '-'}}</td>
                <td>{{ $mk->grade ? $mk->grade->name : '-' }}</td>
                <td>{!! ($mk->grade) ? Mk::getSuffix($mk->sub_pos) : '-' !!}</td>
                <td>{{ $mk->grade ? $mk->grade->remark : '-' }}</td>
            @endforeach
        </tr>
    @endforeach
    <tr>
        <td colspan="3"><strong>إجمالي الدرجات المحصّلة:</strong> {{ $exr->total }}</td>
        <td colspan="3"><strong>المتوسط النهائي:</strong> {{ $exr->ave }}</td>
        <td colspan="3"><strong>متوسط الصف:</strong> {{ $exr->class_ave }}</td>
    </tr>
    </tbody>
</table>
