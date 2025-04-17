@extends('layouts.master')
@section('page_title', '  تعديل بيانات طالب')
@section('content')
<div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 id="ajax-title" class="card-title">تعديل بينات الطالب {{ $sr->user->name }}</h6>

                {!! Qs::getPanelOptions() !!}
            </div> 
              <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-update" data-reload="#ajax-title" action="{{ route('students.update', Qs::hash($sr->id)) }}" data-fouc>
                @csrf @method('PUT')

        <!-- بطاقة الطالب -->
        <h6>بطاقة الطالب</h6>
        <fieldset>
          <div class="row">
    <div class="col-md-6">
     <div class="form-group text-right">
      <label>
       الاسم  :
       <span class="text-danger">
        *
       </span>
      </label>
      <input class="form-control" id="first_name" name="first_name" oninput="updateModifiedLastName()" placeholder="" required="" type="text" value="{{ old('first_name', $sr->first_name) }}" >
     </div>
    </div>
    <div class="col-md-3">
     <div class="form-group">
  <label for="my_parent_id">
   الأب:
</label>
<select class="select-search form-control" data-placeholder="اختر..." id="my_parent_id" name="my_parent_id" onchange="updateModifiedLastName()">
    <option value="" {{ old('my_parent_id') == '' ? 'selected' : '' }}>
        اختر الأب
    </option>
    @foreach($parents as $p)
        <option value="{{ Qs::hash($p->id) }}" 
            {{ old('my_parent_id', Qs::hash($sr->my_parent_id)) == Qs::hash($p->id) ? 'selected' : '' }}>
            {{ $p->name }}
        </option>
    @endforeach
</select>



     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label>
       الكنية:
       <span class="text-danger">
        *
       </span>
      </label>
      <input class="form-control" id="last_name" name="last_name" oninput="updateModifiedLastName()" placeholder="أدخل الكنية" required="" type="text"             value="{{ old('lastname', $sr->last_name) }}">
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label>
       الكنية بلا التعريف:
       <span class="text-danger">
        *
       </span>
      </label>
      <input class="form-control" id="modifiedLastname" placeholder="سيتم تعبئته تلقائيًا" readonly="" type="text"/>
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label>
       الاسم الكامل :
       <span class="text-danger">
        *
       </span>
      </label>
      <input class="form-control" id="name" name="name" placeholder="سيتم تعبئته تلقائيًا" readonly="" type="text"              value="{{ old('name', $sr->user->name) }}">
     </div>
    </div>
    <script>
     function updateModifiedLastName() {
            let lastName = document.getElementById("last_name").value;
                       let select = document.getElementById("my_parent_id");
let alllastName = select.options[select.selectedIndex].text;
                                                let firstName = document.getElementById("first_name").value;



            let modifiedLastName = lastName;
            let allname=firstName+" "+alllastName;
if(lastName.startsWith('ال'))
        modifiedLastName=  lastName.substring(2);
            document.getElementById("modifiedLastname").value = modifiedLastName;
                        document.getElementById("name").value = allname;

        }
    </script>
   <div class="col-md-3">
    <div class="form-group text-right">
     <label>
      الكود / رقم القبول:
     </label>
     <input class="form-control" name="adm_no" placeholder="رقم القبول" type="text" value="{{ old('adm_no', $sr->adm_no) }}">
    </div>
   </div>
      <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">الجنس: <span class="text-danger">*</span></label>
                                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    <option {{ ($sr->user->gender  == 'Male' ? 'selected' : '') }} value="Male">ذكر</option>
                                    <option {{ ($sr->user->gender  == 'Female' ? 'selected' : '') }} value="Female">أنثى</option>
                                </select>
                            </div>
                        </div>

     <div class="form-group text-right">

                            <div class="form-group">
                                <label for="my_class_id">الصف: </label>
                                <select onchange="getClassSections(this.value)" name="my_class_id" required id="my_class_id" class="form-control select-search" data-placeholder="Select Class">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ $sr->my_class_id == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="section_id">الشعبة: </label>
                                <select name="section_id" required id="section_id" class="form-control select" data-placeholder="Select Section">
                                    <option value="{{ $sr->section_id }}">{{ $sr->section->name }}</option>
                                </select>
                            </div>
                        </div>
</div>
<div class="col-md-3">
    <label>
        <input name="active" type="checkbox" value="1" {{ old('active', $sr->active ?? 0) ? 'checked' : '' }}>
        فعال
    </label>
</div>


<div class="col-md-6">
    <div class="form-group text-right">
        <label class="d-block"> الصورة شخصية:</label>
        @if($sr->user->photo)
    <img src="{{ asset($sr->user->photo) }}" alt="صورة الطالب" style="max-width: 150px; border-radius: 8px;">
@else
    <span>لا توجد صورة</span>
@endif
        <input accept="image/*" class="form-input-styled" data-fouc name="photo" type="file">
        <span class="form-text text-muted">
            الأنواع المقبولة: jpeg, png. الحجم الأقصى: 2Mb
        </span>
    
    
</div>
</div>
        </fieldset>

        <!-- المعلومات الأساسية -->
        <h6>المعلومات الأساسية</h6>
        <fieldset>
           <div class="col-md-6">
    <div class="form-group text-right">
     <label>
      اسم الجد:
      <span class="text-danger">
       *
      </span>
     </label>
     <input class="form-control" name="grandfather_name" placeholder="" required="" type="text"  value="{{ old('grandfather_name', $parent_info->grandfather_name) }}">
    </div>
    <div class="form-group text-right">
     <label>
      اسم الجدة:
      <span class="text-danger">
       *
      </span>
     </label>
     <input class="form-control" name="grandmother_name" placeholder="" required="" type="text" value="{{ old('grandmother_name', $parent_info->grandmother_name) }}"> 
    </div>
    <div class="form-group text-right">
     <label>
      اسم الأم:
      <span class="text-danger">
       *
      </span>
     </label>
     <input class="form-control" name="mother_firstname" placeholder="" required="" type="text"  value="{{ old('mother_firstname', $parent_info->mother_firstname) }}"> 
    </div>
   <div class="form-group text-right">
  <label>كنية الأم :<span class="text-danger">*</span></label>
  <input class="form-control" name="mother_lastname" placeholder="" required type="text"
         value="{{ old('mother_lastname', ($personal_info->mother_lastname ?? ($parent_info->mother_lastname ?? ''))) }}">
</div>


   <div class="col-md-3">
                            <div class="form-group">
                                <label>تاريخ الميلاد:</label>
                                <input name="dob" value="{{ $sr->user->dob  }}" type="text" class="form-control date-pick" placeholder="Select Date...">

                            </div>
                        </div>

<div class="form-group text-right">
  <label>مكان الميلاد :<span class="text-danger">*</span></label>
  <input class="form-control" id="pob" name="pob" placeholder="" required type="text"
         value="{{ old('pob', $sr->pob) }}">
</div>
    <div class="col-md-3">
                            <div class="form-group">
                                <label for="nal_id">الجنسية: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $na)
                                        <option {{  ($sr->user->nal_id  == $na->id ? 'selected' : '') }} value="{{ $na->id }}">{{ $na->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

    </div>
    <h4 class="text-right">
     التعهدات:
    </h4>
   <div class="form-group text-right">
  @php
    $commitment_keys = ['behavior', 'academic', 'delay', 'fees'];
  @endphp

  @foreach(['سلوكي', 'تعليمي', 'تأخر دوام', 'أقساط'] as $index => $type)
    <div class="d-flex flex-row-reverse align-items-center mb-2" style="gap: 10px;">
      <!-- Checkbox للتحكم بالتفعيل -->
      <input class="form-check-input commitment-checkbox" id="commitment_{{ $commitment_keys[$index] }}" type="checkbox" />
      <!-- التسمية -->
      <label class="mb-0" for="commitment_{{ $commitment_keys[$index] }}">
        {{ $type }}
      </label>
      <!-- حقل السنة -->
      <input class="form-control commitment-year" disabled id="commitment_{{ $commitment_keys[$index] }}_year"
             max="2099" min="2000"
             name="commitment_{{ $commitment_keys[$index] }}_year"
             placeholder="السنة"
             style="width: 100px; text-align: center;"
             type="number"
             value="{{ old('commitment_'.$commitment_keys[$index].'_year', ($personal_info->{'commitment_'.$commitment_keys[$index].'_year'} ?? ($parent_info->{'commitment_'.$commitment_keys[$index].'_year'} ?? ''))) }}"/>
    </div>
  @endforeach
</div>

<script>
  document.querySelectorAll('.commitment-checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      const id = this.id;
      const yearInput = document.getElementById(id + '_year');
      yearInput.disabled = !this.checked;
      if (!this.checked) yearInput.value = '';
    });
  });
</script>

<br/>

<!-- ملاحظات المدرسة -->
<div class="mb-3 text-right">
  <label class="form-label text-right" for="school_notes">ملاحظات المدرسة:</label>
  <textarea class="form-control" id="school_notes" name="school_notes" placeholder="أدخل ملاحظات المدرسة هنا..." rows="5">
    {{ old('school_notes', ($personal_info->school_notes ?? ($parent_info->school_notes ?? ''))) }}
  </textarea>
</div>

<!-- ملاحظات الإدارة -->
<div class="mb-3 text-right">
  <label class="form-label text-end d-block" for="admin_notes">ملاحظات الإدارة:</label>
  <textarea class="form-control" id="admin_notes" name="admin_notes" placeholder="أدخل ملاحظات الإدارة هنا..." rows="5">
    {{ old('admin_notes', ($personal_info->admin_notes ?? ($parent_info->admin_notes ?? ''))) }}
  </textarea>
</div>

<!-- ملاحظات صحية -->
<div class="mb-3 text-right">
  <label class="form-label" for="health_notes">ملاحظات صحية:</label>
  <textarea class="form-control" id="health_notes" name="health_notes" placeholder="أدخل الملاحظات الصحية هنا..." rows="5">
    {{ old('health_notes', ($personal_info->health_notes ?? ($parent_info->health_notes ?? ''))) }}
  </textarea>
</div>

<!-- توصيات الأهل -->
<div class="mb-3 text-right">
  <label class="text-right" for="parent_recommendations">توصيات الأهل:</label>
  <textarea class="form-control" id="parent_recommendations" name="parent_recommendations" placeholder="أدخل توصيات الأهل هنا..." rows="5">
    {{ old('parent_recommendations', ($personal_info->parent_recommendations ?? ($parent_info->parent_recommendations ?? ''))) }}
  </textarea>
</div>
        </fieldset>

        <!-- معلومات العائلة -->
        <h6>معلومات العائلة</h6>
        <fieldset>
     <div class="form-group col-md-4 text-right ">
    <label class="form-label" for="father_job">وظيفة الأب</label>
    <input class="form-control" id="father_job" name="father_job" type="text" value="{{ old('father_job', $parent_info->father_job ?? '') }}"/>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="father_education">مستوى تعليم الأب</label>
    <input class="form-control" id="father_education" name="father_education" type="text" value="{{ old('father_education', $parent_info->father_education ?? '') }}"/>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="father_workplace">جهة عمل الأب</label>
    <input class="form-control" id="father_workplace" name="father_workplace" type="text" value="{{ old('father_workplace', $parent_info->father_workplace ?? '') }}"/>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="father_nationality">الجنسية</label>
    <select class="form-control" id="father_nationality" name="father_nationality">
        <option value="">اختر</option>
        @foreach($nationals as $nal)
            <option value="{{ $nal->id }}" {{ old('father_nationalityy', $parent_info->father_nationalityy ?? '') == $nal->id ? 'selected' : '' }}>
                {{ $nal->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="father_birth_date">تاريخ ميلاد الأب</label>
    <input class="form-control" id="father_birth_date" name="father_birth_date" type="date" value="{{ old('father_birth_date', $parent_info->father_birth_date ?? '') }}"/>
</div>
  <div class="col-md-3">
        <div class="form-group text-right">
            <label>رقم الجوال:<span class="text-danger">*</span></label>
            <input value="{{ old('phone', $sr->user->phone ?? '') }}" type="text" name="phone" class="form-control" maxlength="10" pattern="\d{10}" title="يجب أن يكون 10 أرقام">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group text-right">
            <label>رقم الهاتف:</label>
            <input value="{{ old('father_phone', $parent_info->father_phone ?? '') }}"type="text" name="father_phone" class="form-control" maxlength="8" pattern="\d{8}" title="يجب أن يكون 8 أرقام">
        </div>
    </div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="mother_job">مهنة الأم</label>
    <input class="form-control" id="mother_job" name="mother_job" type="text" value="{{ old('mother_job', $parent_info->mother_job ?? '') }}"/>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="mother_education">مستوى تعليم الأم</label>
    <input class="form-control" id="mother_education" name="mother_education" type="text" value="{{ old('mother_education', $parent_info->mother_education ?? '') }}"/>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="mother_workplace">جهة عمل الأم</label>
    <input class="form-control" id="mother_workplace" name="mother_workplace" type="text" value="{{ old('mother_workplace', $parent_info->mother_workplace ?? '') }}"/>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="mother_nationality">الجنسية</label>
    <select class="form-control" id="mother_nationality" name="mother_nationality">
        <option value="">اختر</option>
        @foreach($nationals as $nal)
            <option value="{{ $nal->id }}" {{ old('mother_nationality', $parent_info->mother_nationality ?? '') == $nal->id ? 'selected' : '' }}>
                {{ $nal->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-4 text-right">
    <label class="form-label" for="mother_birth_date">تاريخ ميلاد الأم</label>
    <input class="form-control" id="mother_birth_date" name="mother_birth_date" type="date" value="{{ old('mother_birth_date', $parent_info->mother_birth_date ?? '') }}"/>
</div>

   <div class="col-md-3 text-right">
        <div class="form-group text-right text-right">
            <label>رقم الجوال:<span class="text-danger">*</span></label>
            <input value="{{ old('phone2', $sr->user->phone2 ?? '') }}" type="text" name="phone2" class="form-control" maxlength="10" pattern="\d{10}" title="يجب أن يكون 10 أرقام">
        </div>
    </div>
    <div class="col-md-3 text-right">
        <div class="form-group text-right">
            <label>رقم الهاتف:</label>
            <input value="{{ old('mother_phone', $parent_info->mother_phone ?? '') }}"type="text" name="mother_phone" class="form-control" maxlength="8" pattern="\d{8}" title="يجب أن يكون 8 أرقام">
        </div>
    </div>
<div class="form-group col-md-4 text-right">
    <label class="form-label" for="siblings">الإخوة</label>
    <select class="form-control" id="siblings" name="siblings[]" multiple>
        @foreach($students as $student)
            <option value="{{ $student->id }}" {{ in_array($student->id, $siblings_ids) ? 'selected' : '' }}>
                {{ $student->name }}
            </option>
        @endforeach
    </select>
</div>

   
   <!-- تفعيل Select2 -->
   <script>
    $(document).ready(function() {
            $('.selectb').select2({
                placeholder: "اختر الإخوة",
                allowClear: true
            });
        });
   </script>
   <div class="col-md-3 text-right">
    <label>
     <input name="m_deceased" type="checkbox" value="1"/>
     الأم متوفاة
    </label>
   </div>
   <div class="col-md-3 text-right">
    <label>
     <input name="f_deceased" type="checkbox" value="1"/>
     الأب متوفي
    </label>
   </div>
   <div class="col-md-3 text-right">
    <label>
     <input name="separated" type="checkbox" value="1"/>
     الزوجان منفصلان
    </label>
   </div>
        </fieldset>

        <!-- معلومات رسمية -->
        <h6>معلومات رسمية</h6>
        <fieldset>
            <div class="row text-right">
       <div class="col-md-6">
  <div class="form-group text-right">
    <label for="civil_registry_office">أمانة السجل المدني:</label>
    <input class="form-control" name="civil_registry_office" type="text" value="{{ old('civil_registry_office', ($personal_info->civil_registry_office ?? ($parent_info->civil_registry_office ?? ''))) }}"/>
  </div>
</div>

    
  <div class="col-md-6">
    <div class="form-group text-right">
        <label for="governorate">
            المحافظة:
        </label>
        <input class="form-control" name="governorate" type="text" value="{{ old('governorate', $personal_info->governorate ?? '') }}"/>
    </div>
</div>

    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="registration_place">
       محل القيد:
      </label>
      <input class="form-control" id="registration_place" name="registration_place" type="text" value="{{ old('registration_place', $personal_info->registration_place ?? '') }}"/>
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="registration_date">
       تاريخ القيد:
      </label>
      <input class="form-control" name="registration_date" type="date" value="{{ old('registration_date', ($personal_info->name ?? ($parent_info->name ?? ''))) }}"/>
     </div>
    </div>
   <div class="col-md-6">
  <div class="form-group text-right">
    <label for="registration_number">
      رقم القيد:
    </label>
    <input class="form-control" name="registration_number" type="text"
      value="{{ old('registration_number', $personal_info->registration_number ?? $parent_info->registration_number ?? '') }}"/>
  </div>
</div>


    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="national_id">
       الرقم الوطني:
      </label>
      
      <input class="form-control" name="national_id" type="text" value="{{ old('national_id', ($personal_info->national_id ?? ($parent_info->national_id ?? ''))) }}"/>

     </div>
    </div>
   </div>
        </fieldset>

        <!-- معلومات إضافية -->
        <h6>معلومات إضافية</h6>
        <fieldset>
            <div class="row text-right">
    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="form_date">
       تاريخ كتابة الاستمارة:
      </label>
      <input class="form-control" name="form_date" type="date" value="{{ old('form_date', ($personal_info->form_date ?? ($parent_info->form_date ?? ''))) }}"/>
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="confirmation_date">
       تاريخ التثبيت:
      </label>
      <input class="form-control" name="confirmation_date" type="date" value="{{ old('confirmation_date', ($personal_info->confirmation_date ?? ($parent_info->confirmation_date ?? ''))) }}"/>
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="identified_by">
       معرف من قبل:
      </label>
      <input class="form-control" name="identified_by" type="text" value="{{ old('identified_by', ($personal_info->identified_by ?? ($parent_info->identified_by ?? ''))) }}"/>
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="exception_reason">
       استثناء:
      </label>
      <input class="form-control" name="exception_reason" type="text" value="{{ old('exception_reason', ($personal_info->exception_reason ?? ($parent_info->exception_reason ?? ''))) }}"/>
     </div>
    </div>
    <div class="container mt-4">
     <div class="form-group text-right">
      <div class="form-check" style="direction: rtl;">
      <label class="form-check-label" for="withdrawal" style="padding-right: 1.8em; position: relative;">
  <input class="form-check-input" id="withdrawal" name="withdrawal" type="checkbox" value="1"
         style="position: absolute; right: 0.2em; top: 0.1em;"
         {{ old('withdrawal', $personal_info->withdrawal ?? false) ? 'checked' : '' }}>
  انسحاب
</label>

      </div>
     </div>
     <div class="row mt-3" id="withdrawal_fields">
      <div class="form-group text-right">
       <label for="transfer_school">
        المدرسة التي انتقل إليها:
       </label>
       <input class="form-control" name="transfer_school" type="text" value="{{ old('transfer_school', ($personal_info->transfer_school ?? ($parent_info->transfer_school ?? ''))) }}"/>
      </div>
      <div class="form-group text-right">
       <label for="withdrawal_date">
        تاريخ الانسحاب:
       </label>
       <input class="form-control" name="withdrawal_date" type="date" value="{{ old('withdrawal_date', ($personal_info->withdrawal_date ?? ($parent_info->withdrawal_date ?? ''))) }}"/>
      </div>
     </div>
    </div>
   </div>
        </fieldset>
   <!-- معلومات الاتصال -->
        <h6>معلومات الاتصال</h6>
        <fieldset>
            <div class="row">
    <div class="mb-3">
     <label class="form-label" for="approved_mobile">
      اختر الجوال المعتمد للطالب:
     </label>
     <select class="form-control" id="approved_mobile" name="approved_mobile" onchange="toggleCustomMobile()">
    <option value="" {{ old('approved_mobile', ($personal_info->approved_mobile ?? ($parent_info->approved_mobile ?? ''))) == '' ? 'selected' : '' }}>
        -- اختر --
    </option>
    <option value="mother" {{ old('approved_mobile', ($personal_info->approved_mobile ?? ($parent_info->approved_mobile ?? ''))) == 'mother' ? 'selected' : '' }}>
        جوال الأم
    </option>
    <option value="father" {{ old('approved_mobile', ($personal_info->approved_mobile ?? ($parent_info->approved_mobile ?? ''))) == 'father' ? 'selected' : '' }}>
        جوال الأب
    </option>
    <option value="other" {{ old('approved_mobile', ($personal_info->approved_mobile ?? ($parent_info->approved_mobile ?? ''))) == 'other' ? 'selected' : '' }}>
        غير ذلك
    </option>
</select>

    </div>
    <div class="mb-3" id="custom_mobile_div" style="display: none;">
     <label class="form-label" for="custom_mobile">
      أدخل رقم الجوال المعتمد:
     </label>
     <input class="form-control" id="custom_mobile" name="custom_mobile" placeholder="أدخل رقم الجوال" type="text" value="{{ old('custom_mobile', ($personal_info->custom_mobile ?? ($parent_info->custom_mobile ?? ''))) }}"/>
    </div>
    <div class="mb-3" id="kinship" style="display: none;">
     <label class="form-label" for="kinship">
      صلة القرابة  :
     </label>
     <input class="form-control" id="kinship" name="kinship" placeholder="صلة القرابة  " type="text" value="{{ old('kinship', ($personal_info->kinship ?? ($parent_info->kinship ?? ''))) }}"/>
    </div>
   </div>
   <script>
    function toggleCustomMobile() {
        let selectedValue = document.getElementById("approved_mobile").value;
        let customMobileDiv = document.getElementById("custom_mobile_div");
        let kinship = document.getElementById("kinship");

        if (selectedValue === "other") {
            customMobileDiv.style.display = "block";
                         kinship.style.display = "block";
// إظهار حقل الإدخال
        } else {
            customMobileDiv.style.display = "none";
                        kinship.style.display = "none"; // إخفاؤه إذا تم اختيار الأم أو الأب
 // إخفاؤه إذا تم اختيار الأم أو الأب
            document.getElementById("custom_mobile").value = "";
             // مسح القيمة المدخلة
                         document.getElementById("kinship").value = "";

        }
    }
   </script>

    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="region">
       المنطقة:
      </label>
      <input class="form-control" name="region" required="" type="text" value="{{ old('region', ($personal_info->region ?? ($parent_info->region ?? ''))) }}"/>
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="address">
       العنوان الكامل:
      </label>
<input class="form-control" name="address" required type="text" value="{{ old('address', $sr->user->address) }}" />
     </div>
    </div>
    <div class="col-md-6">
     <div class="form-group text-right">
      <label for="housing_sector">
       قطاع السكن:
      </label>
      <input class="form-control" name="housing_sector" required="" type="text" value="{{ old('housing_sector', $personal_info->housing_sector )}}">
     </div>
    </div>
   
     <div class="col-12">
      <div class="form-group text-right">
       <div class="form-check" style="direction: rtl;">
        <label class="form-check-label" for="transport_service" style="padding-right: 1.8em; position: relative;">
  <input class="form-check-input" id="transport_service" name="transport_service" type="checkbox" value="1"
         style="position: absolute; right: 0.2em; top: 0.1em;"
         {{ old('transport_service', $personal_info->transport_service ?? false) ? 'checked' : '' }}>
  مشترك بخدمة النقل
</label>

       </div>
      </div>
     </div>
  
    <div id="transport_fields">
     <div class="col-md-6">
      <div class="form-group text-right">
       <label for="subscription_type">
        نوع الاشتراك:
       </label>
       <input class="form-control" name="subscription_type" type="text" value="{{ old('subscription_type', ($personal_info->subscription_type ?? ($parent_info->subscription_type ?? ''))) }}"/>
      </div>
     </div>
     <div class="col-md-6">
      <div class="form-group text-right">
       <label for="transport_group">
        مجموعة النقل:
       </label>
       <input class="form-control" name="transport_group" type="text" value="{{ old('transport_group', ($personal_info->transport_group ?? ($parent_info->transport_group ?? ''))) }}"/>
      </div>
     </div>
   
   </div>
                 </fieldset>
   
        <!-- معلومات التسجيل -->
        <h6>معلومات التسجيل</h6>
        <fieldset>
        <div class="row">
   <div class="col-md-3">
    <div class="form-group text-right">
   <label for="year_admitted">
  سنة القبول:
  <span class="text-danger">*</span>
</label>
<select class="select-search form-control" data-placeholder="اختيار" id="year_admitted" name="year_admitted" required>
  <option value="" {{ old('year_admitted', $sr->year_admitted) == '' ? 'selected' : '' }}></option>

  @for($y = date('Y', strtotime('-10 years')); $y <= date('Y'); $y++)
    <option value="{{ $y }}" {{ old('year_admitted', $sr->year_admitted) == $y ? 'selected' : '' }}>
      {{ $y }}
    </option>
  @endfor
</select>


    </div>
   </div>

    <div class="col-md-3">
     <div class="form-group text-right">
    <label for="first_class_id">
  الصف المسجل به:
  <span class="text-danger">*</span>
</label>
<select class="select-search form-control" id="first_class_id" name="first_class_id" required>
  <option value="" {{ old('first_class_id', $sr->first_class_id ?? '') == '' ? 'selected' : '' }}></option>
  @foreach($my_classes as $c)
    <option value="{{ $c->id }}" {{ old('first_class_id', $sr->first_class_id ?? '') == $c->id ? 'selected' : '' }}>
      {{ $c->name }}
    </option>
  @endforeach
</select>
</div>
                                   </div>
<div class="col-md-3">
  <div class="form-group text-right">
    <label for="Rtype">
      نوع التسجيل :
      <span class="text-danger">*</span>
    </label>
    <select class="select form-control text-right" id="Rtype" name="Rtype" required>
      <option value="" {{ old('Rtype', ($sr->Rtype ?? ($sr->Rtype ?? ''))) == '' ? 'selected' : '' }}></option>
      <option value="New" {{ old('Rtype', ($sr->Rtype ?? ($sr->Rtype ?? ''))) == 'New' ? 'selected' : '' }}>مستجد</option>
      <option value="Transfer" {{ old('Rtype', ($sr->Rtype ?? ($sr->Rtype ?? ''))) == 'Transfer' ? 'selected' : '' }}>منقول</option>
    </select>
  </div>
</div>


<div class="col-md-6">
  <div class="form-group text-right">
    <label>المدرسة السابقة :<span class="text-danger">*</span></label>
    <input class="form-control" id="lastschool" name="lastschool" type="text" value="{{ old('lastschool',$sr->lastschool)}}"/>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group text-right">
    <label>وثيقة التسجيل :<span class="text-danger">*</span></label>
    <input class="form-control" id="rdocument" name="rdocument" type="text" value="{{ old('rdocument',$sr->rdocument)}}"/>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group text-right">
    <label>رقم الوثيقة :<span class="text-danger">*</span></label>
    <input class="form-control" id="ndocument" name="ndocument" type="text" value="{{ old('ndocument',$sr->ndocument)}}"/>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group text-right">
    <label>تاريخ الوثيقة :<span class="text-danger">*</span></label>
    <input class="form-control" id="ddocument" name="ddocument" type="text" value="{{ old('ddocument',$sr->ddocument)}}"/>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group text-right">
    <label>ملاحظات التسجيل :<span class="text-danger">*</span></label>
    <input class="form-control" id="note_register" name="note_register" type="text" value="{{ old('note_register',$sr->note_register)}}"/>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group text-right">
    <label>رقم الشهادة :<span class="text-danger">*</span></label>
    <input class="form-control" id="certificate_number" name="certificate_number" type="text" value="{{ old('certificate_number',$sr->certificate_number)}}"/>
  </div>
</div>

@if($sr->file)
    <div class="form-group text-right">
        <a href="{{ asset('storage/' . $sr->file) }}" target="_blank" class="btn btn-info">
            تحميل الإضبارة الحالية
        </a>
    </div>
@endif

<div class="form-group text-right">
    <label>الإضبارة (ملف PDF فقط):</label>
    <input accept=".pdf" class="form-control" name="file" type="file"/>
    <small class="text-muted">في حال رفع ملف جديد سيتم استبدال القديم</small>
</div>
</div>

  
                  


<script>
document.addEventListener('DOMContentLoaded', function () {
      toggleCustomMobile();
updateModifiedLastName();
  const otherRadio = document.getElementById('other');
  const extraFields = document.getElementById('extraFields');

  document.querySelectorAll('input[name="mobile_owner"]').forEach(radio => {
    radio.addEventListener('change', function () {
      extraFields.style.display = otherRadio.checked ? 'block' : 'none';
    });
  });
});
</script>
        </fieldset>

    </form>
</div>

<script>
    $('.wizard-form').steps({
        headerTag: 'h6',
        bodyTag: 'fieldset',
        transitionEffect: 'fade',
        titleTemplate: '<span class="number">#index#</span> #title#',
        autoFocus: true
    });
</script>
@endsection
