@foreach ($data_filters as $index=>$filter)
    <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $filter->name_class }}</td>
        <td>{{ $filter->grade->name }}</td>
        <td>
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                    data-target="#edit{{ $filter->id }}" data-grade="{{$filter->grade->id}}"
                    title="{{ trans('grades_trans.Edit') }}"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                    data-target="#delete{{ $filter->id }}"
                    title="{{ trans('grades_trans.Delete') }}"><i
                    class="fa fa-trash"></i></button>
        </td>
        <td>
            <input type="checkbox" class="checkVal" value="{{$filter->id}}">
        </td>
    </tr>

    <!-- edit_modal_Grade -->
    <div class="modal fade" id="edit{{ $filter->id }}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                        id="exampleModalLabel">
                        {{ trans('My_Classes_trans.edit_class') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('class.update')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="Name"
                                       class="mr-sm-2">{{ trans('grades_trans.stage_name_ar') }}
                                    :</label>
                                <input id="Name" type="text" name="Name"
                                       class="form-control"
                                       value="{{$filter->getTranslation('name_class','ar')}}"
                                       required>
                                <input id="id" type="hidden" name="id" class="form-control"
                                       value="{{$filter->id}}">
                            </div>
                            <div class="col">
                                <label for="Name_en"
                                       class="mr-sm-2">{{ trans('My_Classes_trans.chooseGrade') }}
                                    :</label>
                                <input type="text" class="form-control"
                                       value="{{$filter->getTranslation('name_class','en')}}"
                                       name="Name_en" required>
                            </div>
                        </div><br>
                        <div class="col">
                            <label
                                class="mr-sm-2">{{ trans('My_Classes_trans.chooseGrade') }}
                                :</label>
                            <select class="form-control form-control-lg" name="Grade_id">
                                @foreach ($grades as $grade)
                                    {{--<option value="0">{{trans('My_Classes_trans.chooseGrade')}}</option>--}}
                                    <option value="{{ $grade->id }}" @if($filter->grade->id == $grade->id) selected @endif>{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br><br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('grades_trans.Close') }}</button>
                            <button type="submit"
                                    class="btn btn-success">{{ trans('grades_trans.submit') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- delete_modal_Class -->
    <div class="modal fade" id="delete{{ $filter->id }}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                        id="exampleModalLabel">
                        {{ trans('My_Classes_trans.delete_class') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('class.destroy')}}" method="post">
                        @csrf
                        {{ trans('My_Classes_trans.Warning_Class') }}
                        <input id="id" type="hidden" name="id" class="form-control"
                               value="{{$filter->id}}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('My_Classes_trans.Close') }}</button>
                            <button type="submit"
                                    class="btn btn-danger">{{ trans('My_Classes_trans.Delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
