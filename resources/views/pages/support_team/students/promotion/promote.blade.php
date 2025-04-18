<form method="post" action="{{ route('students.promote', [$fc, $fs, $tc, $ts]) }}">
    @csrf
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>الصورة</th>
            <th>الاسم</th>
            <th>{{ __('msg.csession') }} </th>
            <th>الأمر</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students->sortBy('user.name') as $sr)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><img class="rounded-circle" style="height: 30px; width: 30px;" src="{{ $sr->user->photo }}" alt="img"></td>
                <td>{{ $sr->user->name }}</td>
                <td>{{ $sr->session }}</td>
                <td>
                    <select class="form-control select" name="p-{{$sr->id}}" id="p-{{$sr->id}}">
                        <option value="P">نجاح </option>
                        <option value="D">رسوب</option>
                        <option value="G">تخرج</option>
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-center mt-3">
        <button class="btn btn-success"><i class="icon-stairs-up mr-2"></i> Promote Students</button>
    </div>
</form>