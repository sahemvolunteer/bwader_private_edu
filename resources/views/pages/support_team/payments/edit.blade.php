@extends('layouts.master')
@section('page_title', 'تعديل القسط')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">تعديل القسط</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="ajax-update" method="post" action="{{ route('payments.update', $payment->id) }}">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">{{ __('msg.Title') }} <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="title" value="{{ $payment->title }}" required type="text" class="form-control" placeholder="Eg. School Fees">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="my_class_id" class="col-lg-3 col-form-label font-weight-semibold">{{ __('msg.Class') }} </label>
                            <div class="col-lg-9">
                                <input class="form-control" title="Class" disabled value="{{ $payment->my_class_id ? $payment->my_class->name : 'All Classes' }}" type="text">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="method" class="col-lg-3 col-form-label font-weight-semibold">{{ __('msg.Method') }}</label>
                            <div class="col-lg-9">
                                <input title="method" value="{{ ucwords($payment->method) }}" disabled class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-lg-3 col-form-label font-weight-semibold">{{ __('msg.Amount') }} بالليرة سورية </label>
                            <div class="col-lg-9">
                                <input disabled class="form-control" value="{{ $payment->amount }}" id="amount" type="text">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-lg-3 col-form-label font-weight-semibold">الوصف</label>
                            <div class="col-lg-9">
                                <input class="form-control" value="{{ $payment->description }}" name="description" id="description" type="text">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ __('msg.submit') }}<i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--Payment Edit Ends--}}

@endsection
