@extends('layouts.master')
@section('page_title', 'إعدادات النظام')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title font-weight-semibold">تحديث إعدادات النظام</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form enctype="multipart/form-data" method="post" action="{{ route('settings.update') }}">
                @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 border-right-2 border-right-blue-400">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">اسم المدرسة <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="system_name" value="{{ $s['system_name'] }}" required type="text" class="form-control" placeholder="اسم المدرسة">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="current_session" class="col-lg-3 col-form-label font-weight-semibold">السنة الدراسية الحالية <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select data-placeholder="اختر..." required name="current_session" id="current_session" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 3 years')); $y<=date('Y', strtotime('+ 1 years')); $y++)
                                        <option {{ ($s['current_session'] == (($y-=1).'-'.($y+=1))) ? 'selected' : '' }}>{{ ($y-=1).'-'.($y+=1) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">اختصار المدرسة</label>
                            <div class="col-lg-9">
                                <input name="system_title" value="{{ $s['system_title'] }}" type="text" class="form-control" placeholder="اختصار المدرسة">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">رقم الهاتف</label>
                            <div class="col-lg-9">
                                <input name="phone" value="{{ $s['phone'] }}" type="text" class="form-control" placeholder="رقم الهاتف">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">البريد الإلكتروني</label>
                            <div class="col-lg-9">
                                <input name="system_email" value="{{ $s['system_email'] }}" type="email" class="form-control" placeholder="البريد الإلكتروني للمدرسة">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">عنوان المدرسة <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input required name="address" value="{{ $s['address'] }}" type="text" class="form-control" placeholder="عنوان المدرسة">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">نهاية هذا الفصل</label>
                            <div class="col-lg-6">
                                <input name="term_ends" value="{{ $s['term_ends'] }}" type="text" class="form-control date-pick" placeholder="تاريخ نهاية الفصل">
                            </div>
                            <div class="col-lg-3 mt-2">
                                <span class="font-weight-bold font-italic">M-D-Y أو M/D/Y</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">بداية الفصل القادم</label>
                            <div class="col-lg-6">
                                <input name="term_begins" value="{{ $s['term_begins'] }}" type="text" class="form-control date-pick" placeholder="تاريخ بداية الفصل">
                            </div>
                            <div class="col-lg-3 mt-2">
                                <span class="font-weight-bold font-italic">M-D-Y أو M/D/Y</span>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="lock_exam" class="col-lg-3 col-form-label font-weight-semibold">قفل الامتحانات</label>
                            <div class="col-lg-3">
                                <select class="form-control select" name="lock_exam" id="lock_exam">
                                    <option {{ $s['lock_exam'] ? 'selected' : '' }} value="1">نعم</option>
                                    <option {{ $s['lock_exam'] ?: 'selected' }} value="0">لا</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                    <span class="font-weight-bold font-italic text-info-800">{{ __('msg.lock_exam') }}</span>
                            </div>
                        </div> --}}
                </div>
                <div class="col-md-6 text-right">
                    {{-- الرسوم الدراسية --}}
               {{-- <fieldset>
                   <legend><strong>رسوم الفصل القادم</strong></legend>
                   @foreach($class_types as $ct)
                   <div class="form-group row text-right">
                       <label class="col-lg-3 col-form-label font-weight-semibold">{{ $ct->name }}</label>
                       <div class="col-lg-9">
                           <input class="form-control" value="{{ $s['next_term_fees_'.strtolower($ct->code)] }}" name="next_term_fees_{{ strtolower($ct->code) }}" placeholder="{{ $ct->name }}" type="text">
                       </div>
                   </div>
                   @endforeach
               </fieldset> --}}
                    <hr class="divider">

                    {{-- الشعار --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">تغيير الشعار:</label>
                        <div class="col-lg-9">
                            <div class="mb-3">
                                <img style="width: 100px" height="100px" src="{{ $s['logo'] }}" alt="">
                            </div>
                            <input name="logo" accept="image/*" type="file" class="file-input" data-show-caption="false" data-show-upload="false" data-fouc>
                        </div>
                    </div>
                </div>
            </div>

                <hr class="divider">

                <div class="text-right">
                    <button type="submit" class="btn btn-danger">حفظ البيانات <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>

    {{-- نهاية إعدادات النظام --}}

@endsection
