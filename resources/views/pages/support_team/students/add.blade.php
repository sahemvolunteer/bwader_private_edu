

@extends('layouts.master')
@section('page_title', 'قبول طالب جديد')
@section('content')

        <div class="card">
          
<div class="d-flex justify-content-center">
    <h6 class="card-title">يرجى ملء الحقول التالية لإضافة طالب جديد</h6>


                {!! Qs::getPanelOptions() !!}
            </div>

            <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation" action="{{ route('students.store') }}" data-fouc>
               @csrf
                <h6> بطاقة الطالب </h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group text-right">
                                <label> الاسم  : <span class="text-danger ">*</span></label>
                                <input id="first_name" value="{{ old('name') }}" required type="text" name="name" placeholder="" class="form-control">
                                </div>
                            </div>
                              <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="my_parent_id">الأب: </label>
                                <select  id="my_parent_id" data-placeholder="اختر..."  name="my_parent_id" id="my_parent_id" class="select-search form-control">
                                    <option  value=""></option>
                                        @foreach($parents as $p)
                <option value="{{ $p->name }}">{{ $p->name }}</option>
            @endforeach
                                </select>
                            </div>
                        </div>
                           <div class="col-md-6">
    <div class="form-group text-right">
        <label>الكنية: <span class="text-danger ">*</span></label>
        <input id="last_name" required type="text" placeholder="أدخل الكنية" class="form-control" oninput="updateModifiedLastName()">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group text-right">
        <label>الكنية بلا التعريف: <span class="text-danger ">*</span></label>
        <input id="modifiedLastname" type="text" placeholder="سيتم تعبئته تلقائيًا" class="form-control" readonly>
    </div>
</div>
   <div class="col-md-6">
    <div class="form-group text-right">
        <label> الاسم كامل : <span class="text-danger ">*</span></label>
        <input id="allname" type="text" placeholder="سيتم تعبئته تلقائيًا" class="form-control" readonly>
    </div>
</div>

    <script>
        function updateModifiedLastName() {
            let lastName = document.getElementById("last_name").value;
                        let alllastName = document.getElementById("my_parent_id").value;
                                                let firstName = document.getElementById("first_name").value;



            let modifiedLastName = lastName;
            let allname=firstName+" "+alllastName;
if(lastName.startsWith('ال'))
        modifiedLastName=  lastName.substring(2);
            document.getElementById("modifiedLastname").value = modifiedLastName;
                        document.getElementById("allname").value = allname;

        }
    </script>
 



                          </div>
                        
                            <div class="col-md-3">
                            <div class="form-group text-right">
                                <label> الكود / رقم القبول:</label>
                                <input type="text" name="adm_no" placeholder="رقم القبول" class="form-control" value="{{ old('adm_no') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group text-right 
  ">
                                <label for="gender">الجنس : <span class="text-danger">*</span></label>
                                <select class="select form-control text-right  " id="gender" name="gender" required data-fouc data-placeholder="">
                                    <option value=""></option>
                                    <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">ذكر</option>
                                    <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">أنثى</option>
                                </select>
                            </div>
                        </div>
                         <div class="row">
                        <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="my_class_id">الصف: <span class="text-danger">*</span></label>
                                <select onchange="getClassSections(this.value)" data-placeholder="" required name="my_class_id" id="my_class_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                </select>
                        </div>
                            </div>

                        <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="section_id">الشعبة: <span class="text-danger">*</span></label>
                                <select data-placeholder="اختر الصف" required name="section_id" id="section_id" class="select-search form-control">
                                    <option {{ (old('section_id')) ? 'selected' : '' }} value="{{ old('section_id') }}">{{ (old('section_id')) ? 'Selected' : '' }}</option>
                                </select>
                            </div>
                        </div>

              


                  
<div class="col-md-3">
<label>
      <input type="checkbox" name="agree" value="1">
      فعال
    </label>
</div>
</fieldset>

<h6>المعلومات الأساسية     </h6>
                <fieldset>
    <div class="col-md-6">
                            <div class="form-group text-right">
                                <label>اسم الجد: <span class="text-danger">*</span></label>
                                <input value="{{ old('grandfather') }}" class="form-control" placeholder="" name="grandfather" type="text" required>
                            </div>
                    
                         <div class="form-group text-right">
                                <label>اسم الجدة: <span class="text-danger">*</span></label>
                                <input value="{{ old('grandmoather') }}" class="form-control" placeholder="" name="grandmoather" type="text" required>
                            </div>
                       
                          <div class="form-group text-right">
                                <label>اسم الأم: <span class="text-danger">*</span></label>
                                <input value="{{ old('firstmoathername') }}" class="form-control" placeholder="" name="firstmoathername" type="text" required>
                            </div>
                     
                          <div class="form-group text-right">
                                <label>كنية الأم : <span class="text-danger">*</span></label>
                                <input value="{{ old('lastmoathername') }}" class="form-control" placeholder="" name="lastmoathername" type="text" required>
                            </div>
                       
                           <div class="col-md-3">
                            <div class="form-group text-right">
                                <label>تاريخ الميلاد:</label>
                                <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="">

                            </div>

                        </div>
                           <div class="form-group text-right">
                                <label>مكان المبلاد : <span class="text-danger">*</span></label>
                                <input value="{{ old('lastmoathername') }}" class="form-control" placeholder="" name="lastmoathername" type="text" required>
                            </div>
                              
 <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="nal_id">الجنسية: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $nal)
                                        <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>   </div>
                <h4 class="text-right">التعهدات:</h4>
    <div class="form-group text-right">
        @foreach(['سلوكي', 'تعليمي', 'تأخر دوام', 'أقساط'] as $index => $type)
            <div class="d-flex align-items-center justify-content-end mb-2">
                <!-- مربع الاختيار -->
                <input class="form-check-input ml-2 commitment-checkbox" type="checkbox" id="commitment_{{ $index }}" name="commitments[{{ $index }}][type]" value="{{ $type }}">
                
                <!-- التسمية بجانب مربع الاختيار -->
                <label class="ml-2" for="commitment_{{ $index }}">{{ $type }}</label>

                <!-- حقل إدخال السنة بجانب التعهد -->
                <input type="number" name="commitments[{{ $index }}][year]" class="form-control ml-2 commitment-year" placeholder="السنة" min="2000" max="2099" disabled style="width: 100px; text-align: center;">
            </div>
        @endforeach
    </div>
    <script>
document.querySelectorAll('.commitment-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        this.nextElementSibling.nextElementSibling.disabled = !this.checked;
    });
});
</script>
                            
    <br>
       <div class="mb-3">
            <label for="admin_notes" class="form-label">ملاحظات المدرسة:</label>
            <textarea class="form-control" name="admin_notes" id="admin_notes" rows="5" placeholder="أدخل ملاحظات الإدارة هنا..."></textarea>
        </div>
          <!-- ملاحظات الإدارة -->
        <div class="mb-3">
            <label for="admin_notes" class="form-label text-end d-block">ملاحظات الإدارة:</label>
            <textarea class="form-control" name="admin_notes" id="admin_notes" rows="5" placeholder="أدخل ملاحظات الإدارة هنا..."></textarea>
        </div>

        <!-- ملاحظات صحية -->
        <div class="mb-3">
            <label for="health_notes" class="form-label">ملاحظات صحية:</label>
            <textarea class="form-control" name="health_notes" id="health_notes" rows="5" placeholder="أدخل الملاحظات الصحية هنا..."></textarea>
        </div>

        <!-- توصيات الأهل -->
        <div class="mb-3">
            <label for="parent_recommendations" class="form-label" class="text-right">توصيات الأهل:</label>
            <textarea class="form-control" name="parent_recommendations" id="parent_recommendations" rows="5" placeholder="أدخل توصيات الأهل هنا..."></textarea>
        </div>


                      
                        </fieldset>
                       
         
          <h6>معلومات العائلة
      </h6>
    <fieldset>
                         <div class="col-md-6">
                            <div class="form-group text-right">
                                <label>  مهنة الأب  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                            </div>
                                <div class="form-group text-right">
                                <label>   وضع الأب التعليمي  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                            </div>
                              <div class="form-group text-right">
                                <label>   مكان عمل  الأب   : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                 <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="nal_id">جنسية الأب: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $nal)
                                        <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                                    <div class="col-md-3">
                            <div class="form-group text-right">
                                <label>رقم الجوال:<span class="text-danger ">*</span></label>
                                <input value="{{ old('phone') }}" required type="text" type="text" name="phone" class="form-control" placeholder="" maxlength ="10" pattern="\d{10}" title="يجب أن يكون10  أرقام">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group text-right">
                                <label>رقم الهاتف:</label>
                                <input value="{{ old('phone2') }}" type="text" name="phone2" class="form-control" placeholder="" maxlength="8" pattern="\d{8}" title="يجب أن يكون 8 أرقام" >
                            </div>
                        </div>

                  

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group text-right">
                                <label>الأب تاريخ الميلاد:</label>
                                <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="">
 </div>
                            </div>
 
                        </div>
                            <div class="col-md-6">
                            <div class="form-group text-right">
                                <label>  مهنة الأم  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                            </div>
                                <div class="form-group text-right">
                                <label>   وضع الأم التعليمي  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                            </div>
                              <div class="form-group text-right">
                                <label>   مكان عمل  الأم   : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                 <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="nal_id">جنسية الأم: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $nal)
                                        <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             </div>
                                    <div class="col-md-3">
                            <div class="form-group text-right">
                                <label>رقم الجوال:<span class="text-danger ">*</span></label>
                                <input value="{{ old('phonemother') }}" required type="text" type="text" name="phonemother" class="form-control" placeholder="" maxlength="10" pattern="\d{10}" title="يجب أن يكون 10 أرقام" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group text-right">
                                <label>رقم الهاتف:</label>
                                <input value="{{ old('phone2mother') }}" type="text" name="phone2mother" class="form-control" placeholder=""  maxlength="8" pattern="\d{8}" title="يجب أن يكون 8 أرقام">
                            </div>
                        </div>

                  

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group text-right">
                                <label>الأم تاريخ الميلاد:</label>
                                <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="">
 </div>
                            </div>
                             <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="my_parent_id">الأخ: </label>
                        
        <select name="siblings[]" class=" select-search  form-control selectb" multiple>
                                    <option  value=""></option>
                        @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }} </option>
            @endforeach
                                </select>
                            </div>
                        </div>
   
<!-- تفعيل Select2 -->
<script>
$(document).ready(function() {
    $('.selectb').selectb({
        placeholder: "اختر الإخوة",
        allowClear: true
    });
});
</script>


                                                     <div class="col-md-3">
<label>
      <input type="checkbox" name="agree" value="1">
      الأم متوفاة
    </label>
</div>
                            <div class="col-md-3">
<label>
      <input type="checkbox" name="agree" value="1">
      الأب متوفي 
    </label>
</div>
                           <div class="col-md-3">
<label>
      <input type="checkbox" name="agree" value="1">
      الزوجان منفصلان 
    </label>
</div>


                       </div>
    </fieldset>
<h6>معلومات رسمية</h6>
<fieldset>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="civil_registry_office">أمانة السجل المدني:</label>
                <input type="text" name="civil_registry_office" class="form-control" value="{{ old('civil_registry_office') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="governorate">المحافظة:</label>
                <input type="text" name="governorate" class="form-control" value="{{ old('governorate') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="registration_place">محل القيد:</label>
                <input type="text" name="registration_place" class="form-control" value="{{ old('registration_place') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="registration_date">تاريخ القيد:</label>
                <input type="date" name="registration_date" class="form-control" value="{{ old('registration_date') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="registration_number">رقم القيد:</label>
                <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="national_id">الرقم الوطني:</label>
                <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}">
            </div>
        </div>
    </div>
</fieldset>

<h6>معلومات إضافية</h6>
<fieldset>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="form_date">تاريخ كتابة الاستمارة:</label>
                <input type="date" name="form_date" class="form-control" value="{{ old('form_date') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="confirmation_date">تاريخ التثبيت:</label>
                <input type="date" name="confirmation_date" class="form-control" value="{{ old('confirmation_date') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="identified_by">معرف من قبل:</label>
                <input type="text" name="identified_by" class="form-control" value="{{ old('identified_by') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="exception_reason">استثناء:</label>
                <input type="text" name="exception_reason" class="form-control" value="{{ old('exception_reason') }}">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group text-right">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="withdrawal" name="withdrawal" value="1" {{ old('withdrawal') ? 'checked' : '' }}>
                    <label class="form-check-label" for="withdrawal">انسحاب</label>
                </div>
            </div>
        </div>

        <div id="withdrawal_fields" style="display: none;">
            <div class="col-md-6">
                <div class="form-group text-right">
                    <label for="transfer_school">المدرسة التي انتقل إليها:</label>
                    <input type="text" name="transfer_school" class="form-control" value="{{ old('transfer_school') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-right">
                    <label for="withdrawal_date">تاريخ الانسحاب:</label>
                    <input type="date" name="withdrawal_date" class="form-control" value="{{ old('withdrawal_date') }}">
                </div>
            </div>
        </div>
    </div>
</fieldset>


<h6>معلومات الاتصال</h6>
<fieldset>
    <div class="row">
        <div class="row">
<div class="mb-3">
    <label for="approved_mobile" class="form-label">اختر الجوال المعتمد للطالب:</label>
    <select class="form-control" id="approved_mobile" name="approved_mobile" onchange="toggleCustomMobile()">
        <option value="">-- اختر --</option>
        <option value="mother">جوال الأم</option>
        <option value="father">جوال الأب</option>
        <option value="other">غير ذلك</option>
    </select>
</div>

<div class="mb-3" id="custom_mobile_div" style="display: none;">
    <label for="custom_mobile" class="form-label">أدخل رقم الجوال المعتمد:</label>
    <input type="text" class="form-control" id="custom_mobile" name="custom_mobile" placeholder="أدخل رقم الجوال">
</div>
<div class="mb-3" id="kinship" style="display: none;">
    <label for="kinship" class="form-label"> صلة القرابة  :</label>
    <input type="text" class="form-control" id="kinship" name="kinship" placeholder="صلة القرابة  ">
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
                <label for="region">المنطقة:</label>
                <input type="text" name="region" class="form-control" value="{{ old('region') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="full_address">العنوان الكامل:</label>
                <input type="text" name="full_address" class="form-control" value="{{ old('full_address') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <label for="housing_sector">قطاع السكن:</label>
                <input type="text" name="housing_sector" class="form-control" value="{{ old('housing_sector') }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group text-right">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="transport_service" name="transport_service" value="1" {{ old('transport_service') ? 'checked' : '' }}>
                    <label class="form-check-label" for="transport_service">مشترك بخدمة النقل</label>
                </div>
            </div>
        </div>

        <div id="transport_fields" style="display: none;">
            <div class="col-md-6">
                <div class="form-group text-right">
                    <label for="subscription_type">نوع الاشتراك:</label>
                    <input type="text" name="subscription_type" class="form-control" value="{{ old('subscription_type') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-right">
                    <label for="transport_group">مجموعة النقل:</label>
                    <input type="text" name="transport_group" class="form-control" value="{{ old('transport_group') }}" required>
                </div>
            </div>
        </div>
    </div>
</fieldset>



  


                <h6> معلومات التسجيل</h6>
                <fieldset>
                         <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="year_admitted">سنة القبول: <span class="text-danger">*</span></label>
                                <select data-placeholder="اختيار" required name="year_admitted" id="year_admitted" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 10 years')); $y<=date('Y'); $y++)
                                        <option {{ (old('year_admitted') == $y) ? 'selected' : '' }} value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                          <div class="row">
                        <div class="col-md-3">
                            <div class="form-group text-right">
                                <label for="my_class_id">الصف: <span class="text-danger">*</span></label>
                                <select onchange="getClassSections(this.value)" data-placeholder="" required name="my_class_id" id="my_class_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                </select>
                        </div>
                            </div>
                                                        </div>

                           <div class="col-md-3">
                            <div class="form-group text-right 
  ">
                                <label for="Rtype">نوع التسجيل : <span class="text-danger">*</span></label>
                                <select class="select form-control text-right  " id="Rtype" name="Rtype" required data-fouc data-placeholder="">
                                    <option value=""></option>
                                    <option {{ (old('Rtype') == 'New') ? 'selected' : '' }} value="New">مستجد</option>
                                    <option {{ (old('Rtype') == 'Female') ? 'selected' : '' }} value="Female">منقول</option>
                                </select>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group text-right">
                                <label> المدرسة السابقة  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                             <div class="col-md-6">
                            <div class="form-group text-right">
                                <label>  وثيقة التسجيل  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                             <div class="col-md-6">
                            <div class="form-group text-right">
                                <label>  رقم الوثيقة  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                             <div class="col-md-6">
                            <div class="form-group text-right">
                                <label>  تاريخ الوثيقة  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                             <div class="col-md-6">
                            <div class="form-group text-right">
                                <label> ملاحظات التسجيل   : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                             <div class="col-md-6">
                            <div class="form-group text-right">
                                <label>   رقم الشهادة  : <span class="text-danger ">*</span></label>
                                <input id="lastschool" value="{{ old('lastschool') }}"  type="text" name="lastschool" placeholder="" class="form-control">
                                </div>
                            </div>
                                <div class="form-group">
        <label>الإضبارة (ملف PDF فقط):</label>
        <input type="file" name="file" class="form-control" accept=".pdf" required>
    </div>

                    </div>
                   
                  </div>
                </fieldset>

 
            </form>
    
        
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const otherRadio = document.getElementById('other');
        const extraFields = document.getElementById('extraFields');

        document.querySelectorAll('input[name="mobile_owner"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (otherRadio.checked) {
                    extraFields.style.display = 'block';
                } else {
                    extraFields.style.display = 'none';
                }
            });
        });
    });
</script>
    @endsection
