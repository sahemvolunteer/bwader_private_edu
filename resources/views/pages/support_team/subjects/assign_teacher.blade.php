@extends('layouts.master')
@section('page_title', 'assign Teacher - '.$s->name. ' ('.$s->my_class->name.')')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">assign Teacher - {{$s->my_class->name }}</h6>
        {!! Qs::getPanelOptions() !!}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('subjects.assign_teacher.save', $s->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="subject_id" value="{{ $s->id }}">

                    <div>
                        <label for="subject_id">المادة:</label>
                        <label>{{ $s->name }}</label>
                    </div>

                    <div>
                        <label for="teacher_id">المدرس:</label>
                        <select name="teacher_id" id="teacher_id" required>
                            <option value="" disabled selected>اختر مدرسًا</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="section_ids">الشعب:</label>
                        <select name="section_ids[]" id="section_ids" multiple required>
                            <option value="all">اختيار الكل</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript الخاص بـ select2 -->
<script>
    $(document).ready(function() {
        $('#section_ids').select2({
            placeholder: "اختر الشعب...",
            allowClear: true
        });

        $('#section_ids').on('change', function() {
            var selectedValues = $(this).val();

            if (selectedValues.includes("all")) {
                $(this).val($('#section_ids option[value!="all"]').map(function() {
                    return this.value;
                }).get());
            }

            $(this).trigger('change.select2');
        });
    });
</script>

@endsection
