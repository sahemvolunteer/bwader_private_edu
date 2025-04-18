<form method="post" action="{{ route('marks.selector') }}">
    @csrf
    <div class="row">
        <div class="col-md-10">
            <fieldset>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exam_id" class="col-form-label font-weight-bold" style="text-align: right; display: block;">الاختبار:</label>
                            <select required id="exam_id" name="exam_id" data-placeholder="اختر الاختبار" class="form-control select">
                                @foreach($exams as $ex)
                                    <option {{ $selected && $exam_id == $ex->id ? 'selected' : '' }} value="{{ $ex->id }}">{{ $ex->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="my_class_id" class="col-form-label font-weight-bold" style="text-align: right; display: block;">الصف:</label>
                            <select required onchange="getClassSubjects(this.value)" id="my_class_id" name="my_class_id" class="form-control select">
                                <option value="">اختر الصف</option>
                                @foreach($my_classes as $c)
                                    <option {{ ($selected && $my_class_id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="section_id" class="col-form-label font-weight-bold" style="text-align: right; display: block;">الشعبة:</label>
                            <select required id="section_id" name="section_id" data-placeholder="اختر الصف أولًا" class="form-control select">
                                @if($selected)
                                    @foreach($sections->where('my_class_id', $my_class_id) as $s)
                                        <option {{ $section_id == $s->id ? 'selected' : '' }} value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="subject_id" class="col-form-label font-weight-bold" style="text-align: right; display: block;">المادة:</label>
                            <select required id="subject_id" name="subject_id" data-placeholder="اختر الصف أولًا" class="form-control select-search">
                                @if($selected)
                                    @foreach($subjects->where('my_class_id', $my_class_id) as $s)
                                        <option {{ $subject_id == $s->id ? 'selected' : '' }} value="{{ $s->id }}">{{ $s->name }}</option>
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
                <button type="submit" class="btn btn-primary">إدارة الدرجات <i class="icon-paperplane ml-2"></i></button>
            </div>
        </div>

    </div>

</form>
