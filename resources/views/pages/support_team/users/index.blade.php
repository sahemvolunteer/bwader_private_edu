@extends('layouts.master')
@section('page_title', 'إدارة المستخدمين')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">إدارة المستخدمين</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item"><a href="#new-user" class="nav-link active" data-toggle="tab">إضافة مستخدم جديد</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">إدارة المستخدمين</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($user_types as $ut)
                            <a href="#ut-{{ Qs::hash($ut->id) }}" class="dropdown-item" data-toggle="tab">{{ $ut->name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="new-user">
                    <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-store" action="{{ route('users.store') }}" data-fouc>
                        @csrf
                    <h6>البيانات الشخصية</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group text-right">
                                        <label for="user_type"> اختر نوع المستخدم: <span class="text-danger">*</span></label>
                                       <select required data-placeholder=" اختر" class="form-control select" name="user_type" id="user_type_select" onchange="showfields()">
    @foreach($user_types as $ut)
        <option value="{{ Qs::hash($ut->id) }}" data-type="{{ $ut->title }}"  {{ (old('user_type') == Qs::hash($ut->id)) ? 'selected' : '' }}>
            {{ $ut->name }}
        </option>
    @endforeach
</select>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group text-right">
                                        <label>الاسم الكامل: <span class="text-danger">*</span></label>
                                        <input value="{{ old('name') }}" required type="text" name="name" placeholder="الاسم الكامل" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-right ">
                                        <label>العنوان: <span class="text-danger">*</span></label>
                                        <input value="{{ old('address') }}" class="form-control" placeholder="العنوان" name="address" type="text" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group text-right ">
                                        <label>البريد الإلكتروني:</label>
                                        <input value="{{ old('email') }}" type="email" name="email" class="form-control" placeholder="example@email.com">
                                    </div>
                                </div>
                  
                                <div class="col-md-3">
                                    <div class="form-group text-right">
                                        <label>الهاتف:</label>
                                        <input value="{{ old('phone') }}"  required type="text" name="phone" class="form-control" placeholder="+966123456789">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group text-right">
                                        <label>هاتف إضافي:</label>
                                        <input value="{{ old('phone2') }}" type="text" name="phone2" class="form-control" placeholder="+966123456789">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
    


        <div class="col-md-3">
                                    <div class="form-group text-right">
                                        <label>اسم المستخدم:</label>
                                        <input value="{{ old('username') }}" type="text" name="username" class="form-control" placeholder="اسم المستخدم">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group text-right">
                                        <label for="password">كلمة المرور:</label>
                                        <input id="password" type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group text-right">
                                        <label for="gender">الجنس: <span class="text-danger">*</span></label>
                                        <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="اختر...">
                                            <option value=""></option>
                                            <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">ذكر</option>
                                            <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">أنثى</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group text-right">
                                        <label for="nal_id">الجنسية: <span class="text-danger">*</span></label>
                                        <select data-placeholder="اختر..." required name="nal_id" id="nal_id" class="select-search form-control">
                                            <option value=""></option>
                                            @foreach($nationals as $nal)
                                                <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group text-right">
                                        <label for="bg_id">فصيلة الدم:</label>
                                        <select class="select form-control" id="bg_id" name="bg_id" data-fouc data-placeholder="اختر...">
                                            <option value=""></option>
                                            @foreach($blood_groups as $bg)
                                                <option {{ (old('bg_id') == $bg->id ? 'selected' : '') }} value="{{ $bg->id }}">{{ $bg->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row">
                                {{--صورة شخصية--}}
                                <div class="col-md-6">
                                    <div class="form-group text-right">
                                        <label class="d-block">تحميل صورة:</label>
                                        <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                        <span class="form-text text-muted">الصور المقبولة: jpeg, png. الحجم الأقصى: 2MB</span>
                                    </div>
                                </div>
                                                       <div class="col-md-3" >
    <div class="form-group text-right text-right" style="display: block;"id="emp_date_field"> 
        <label>تاريخ التوظيف :</label>
        <input autocomplete="off" name="emp_date" value="{{ old('emp_date') }}" type="text" class="form-control date-pick" placeholder="Select Date...">
    </div>
</div>
<script>
    function showfields() {
        let selectedValue = document.getElementById("user_type_select").value;
        let empdatefield = document.getElementById("emp_date_field");
        let selectedOption = document.querySelector("#user_type_select option:checked");
        let originalType = selectedOption.getAttribute("data-type");
    console.log("نوع المستخدم المحدد:", originalType); // هذا سيساعدنا في التأكد

        if (originalType === "parent") {
            empdatefield.style.display = "none";
// إظهار حقل الإدخال
        } else {
            empdatefield.style.display = "block";
 // إخفاؤه إذا تم اختيار الأم أو الأب

        }
    }
      document.addEventListener("DOMContentLoaded", function() {
        showfields();
    });
</script>
        
                            </div>

                        </fieldset>

                    </form>
                </div>

                @foreach($user_types as $ut)
                    <div class="tab-pane fade" id="ut-{{Qs::hash($ut->id)}}">
                        <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>الرقم التسلسلي</th>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>اسم المستخدم</th>
                                <th>رقم الهاتف</th>
                                <th>البريد الإلكتروني</th>
                                <th>الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users->where('user_type', $ut->title) as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $u->photo }}" alt="الصورة"></td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->username }}</td>
                                    <td>{{ $u->phone }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-left">
                                                    <a href="{{ route('users.show', Qs::hash($u->id)) }}" class="dropdown-item"><i class="icon-eye"></i> عرض الملف الشخصي</a>
                                                    <a href="{{ route('users.edit', Qs::hash($u->id)) }}" class="dropdown-item"><i class="icon-pencil"></i> تعديل</a>
                                                @if(Qs::userIsSuperAdmin())
                                                    <a href="{{ route('users.reset_pass', Qs::hash($u->id)) }}" class="dropdown-item"><i class="icon-lock"></i> إعادة تعيين كلمة المرور</a>
                                                    <a id="{{ Qs::hash($u->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> حذف</a>
                                                    <form method="post" id="item-delete-{{ Qs::hash($u->id) }}" action="{{ route('users.destroy', Qs::hash($u->id)) }}" class="hidden">@csrf @method('delete')</form>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
        
    </div>

@endsection
