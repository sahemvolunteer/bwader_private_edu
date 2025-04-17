@extends('layouts.master')
@section('page_title', 'تحديد كشف درجات الطالب')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-books mr-2"></i> تحديد كشف درجات الطالب</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('marks.bulk_select') }}">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <fieldset>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="my_class_id" class="col-form-label font-weight-bold">الصف:</label>
                                        <select required onchange="getClassSections(this.value)" id="my_class_id" name="my_class_id" class="form-control select">
                                            <option value="">اختر الصف</option>
                                            @foreach($my_classes as $c)
                                                <option {{ ($selected && $my_class_id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="section_id" class="col-form-label font-weight-bold">الفصل:</label>
                                        <select required id="section_id" name="section_id" data-placeholder="اختر الصف أولاً" class="form-control select">
                                            @if($selected)
                                                @foreach($sections as $s)
                                                    <option {{ ($section_id == $s->id ? 'selected' : '') }} value="{{ $s->id }}">{{ $s->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </fieldset>
                    </div>

                    <div class="col-md-2 mt-4">
                        <div class="text-right mt-1">
                            <button type="submit" class="btn btn-primary">عرض كشوف الدرجات <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>

    @if($selected)
        <div class="card">
            <div class="card-body">
                <table class="table datatable-button-html5-columns">
                    <thead>
                    <tr>
                        <th>الرقم التسلسلي</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>رقم القيد</th>
                        <th>الإجراء</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $s->user->photo }}" alt="photo"></td>
                            <td>{{ $s->user->name }}</td>
                            <td>{{ $s->adm_no }}</td>
                            <td><a class="btn btn-danger" href="{{ route('marks.year_select', Qs::hash($s->user_id)) }}">عرض كشف الدرجات</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
