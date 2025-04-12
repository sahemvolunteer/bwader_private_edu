@extends('layouts.master')
@section('page_title', 'Student Information - '.$my_class->name)
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">قائمة الطلاب</h6>
        {!! Qs::getPanelOptions() !!}
    </div>
<div class="card-body">
    <ul class="nav nav-tabs nav-tabs-highlight">
        @if(Qs::userIsTeamSA())
        <li class="nav-item"><a href="{{ route('students.list', ['class_id' => $my_class->id]) }}" 
            class="nav-link {{ !isset($selected_section) ? 'active' : '' }}" data-toggle="tab">
            جميع طلاب  {{ $my_class->name }} 
        </a></li>
        @endif     

        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">الشعب</a>
            <div class="dropdown-menu dropdown-menu-right">
                @foreach($sections as $s)
                    <a href="{{ route('students.list.section', ['class_id' => $my_class->id, 'section_id' => $s->id]) }}" 
                        class="dropdown-item {{ isset($selected_section) && $selected_section == $s->id ? 'active' : '' }}">
                        {{ $my_class->name . ' ' . $s->name }}
                    </a>
                @endforeach
            </div>
        </li>
    </ul>
    
</div>

    {{-- <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
               @if(Qs::userIsTeamSA())
            <li class="nav-item"><a href="#all-students" class="nav-link active" data-toggle="tab">All {{ $my_class->name }} Students</a></li>
                   @endif     

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Sections</a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach($sections as $s)
                        <a href="{{ route('students.list', ['class_id' => $my_class->id, 'section_id' => $s->id]) }}" class="dropdown-item">{{ $my_class->name.' '.$s->name }}</a>
                    @endforeach
                </div>
            </li>
         
        </ul> --}}

       <div class="tab-content">
    @if(Qs::userIsTeamSA() || isset($selected_section)) 
        <div class="tab-pane fade show active" id="all-students">
            <table class="table datatable-button-html5-columns">

                    <thead>
                    <tr>
                        <th>رقم تسلسل</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>رقم القبول</th>
                        <th>الشعبة</th>
                        <th>رقم الاتصال</th>
                        <th>الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $s->user->photo }}" alt="photo"></td>
                            <td>{{ $s->user->name }}</td>
                            <td>{{ $s->adm_no }}</td>
                            <td>{{ $my_class->name.' '.$s->section->name }}</td>
                            <td>{{ $s->user->phone }}</td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a href="{{ route('students.show', Qs::hash($s->id)) }}" class="dropdown-item"><i class="icon-eye"></i> عرض الملف</a>
                                            @if(Qs::userIsTeamSA())
                                                <a href="{{ route('students.edit', Qs::hash($s->id)) }}" class="dropdown-item"><i class="icon-pencil"></i> تعديل</a>
                                                <a href="{{ route('st.reset_pass', Qs::hash($s->user->id)) }}" class="dropdown-item"><i class="icon-lock"></i> إعادة تعيين كلمة السر</a>
                                            @endif
                                            <a target="_blank" href="{{ route('marks.year_selector', Qs::hash($s->user->id)) }}" class="dropdown-item"><i class="icon-check"></i> جدول العلامات</a>

                                            {{--Delete--}}
                                            @if(Qs::userIsSuperAdmin())
                                                <a id="{{ Qs::hash($s->user->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> حذف</a>
                                                <form method="post" id="item-delete-{{ Qs::hash($s->user->id) }}" action="{{ route('students.destroy', Qs::hash($s->user->id)) }}" class="hidden">@csrf @method('delete')</form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

{{--Student List Ends--}}

@endsection
