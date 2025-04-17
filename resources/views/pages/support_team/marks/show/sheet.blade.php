<table class="table table-bordered table-responsive text-center" style="direction: rtl;">
    <thead>
    <tr>
        <th rowspan="2">الرقم التسلسلي</th>
        <th rowspan="2">المادة</th>
        <th rowspan="2">المذاكرة الأولى <br>(20)</th>
        <th rowspan="2">المذاكرة الثانية<br>(20)</th>
        <th rowspan="2">الامتحان<br>(60)</th>
        <th rowspan="2">المجموع<br>(100)</th>
        <th rowspan="2">التقدير</th>
        <th rowspan="2">ترتيب المادة</th>
        <th rowspan="2">الملاحظات</th>
    </tr>
    </thead>

    <tbody>
    @foreach($subjects as $sub)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sub->name }}</td>
            @foreach($marks->where('subject_id', $sub->id)->where('exam_id', $ex->id) as $mk)
                <td>{{ ($mk->t1) ?: '-' }}</td>
                <td>{{ ($mk->t2) ?: '-' }}</td>
                <td>{{ ($mk->exm) ?: '-' }}</td>
                <td>
                    @if($ex->term === 1) {{ ($mk->tex1) }}
                    @elseif ($ex->term === 2) {{ ($mk->tex2) }}
                    @elseif ($ex->term === 3) {{ ($mk->tex3) }}
                    @else {{ '-' }}
                    @endif
                </td>
                <td>{{ ($mk->grade) ? $mk->grade->name : '-' }}</td>
                <td>{!! ($mk->grade) ? Mk::getSuffix($mk->sub_pos) : '-' !!}</td>
                <td>{{ ($mk->grade) ? $mk->grade->remark : '-' }}</td>
            @endforeach
        </tr>
    @endforeach
    <tr>
        <td colspan="4"><strong>إجمالي الدرجات:</strong> {{ $exr->total }}</td>
        <td colspan="5"><strong>المتوسط النهائي:</strong> {{ $exr->ave }}</td>
        {{-- <td colspan="2"><strong>متوسط الصف:</strong> {{ $exr->class_ave }}</td> --}}
    </tr>
    </tbody>
</table>
