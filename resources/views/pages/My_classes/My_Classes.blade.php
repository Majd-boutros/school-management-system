@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ trans('My_Classes_trans.title_page') }}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    {{ trans('My_Classes_trans.title_page') }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                        {{ trans('My_Classes_trans.add_class') }}
                    </button>
                    <br><br>
                        <form action="{{route('classes.filter')}}" method="post">
                            @csrf
                            <select id="gradeFilter" name="filter">
                                <option value="0">{{ trans('My_Classes_trans.chooseGrade') }}</option>
                                @foreach($grades as $grade)
                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                @endforeach
                            </select>

                            <button type="submit" id="filter" class="button x-small">{{ trans('My_Classes_trans.Filter') }}</button>
                        </form>
                    <br><br>
                        <button type="button" class="btn btn-danger" id="deleteMultipleBtn">{{ trans('My_Classes_trans.MultiDel') }}</button>
                    <br><br>

                    <div class="table-responsive">
                        <input type="checkbox" id="select_all" /> {{ trans('My_Classes_trans.select_all') }}<br>
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('My_Classes_trans.Name_class') }}</th>
                                <th>{{ trans('grades_trans.name') }}</th>
                                <th>{{ trans('My_Classes_trans.Processes') }}</th>
                                <th>{{trans('My_Classes_trans.Select')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data_filters))
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
                            @else
                                @foreach ($classes as $index=>$class)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $class->name_class }}</td>
                                        <td>{{ $class->grade->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#edit{{ $class->id }}" data-grade="{{$class->grade->id}}"
                                                    title="{{ trans('grades_trans.Edit') }}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#delete{{ $class->id }}"
                                                    title="{{ trans('grades_trans.Delete') }}"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="checkVal" value="{{$class->id}}">
                                        </td>
                                    </tr>

                                    <!-- edit_modal_Grade -->
                                    <div class="modal fade" id="edit{{ $class->id }}" tabindex="-1" role="dialog"
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
                                                                       value="{{$class->getTranslation('name_class','ar')}}"
                                                                       required>
                                                                <input id="id" type="hidden" name="id" class="form-control"
                                                                       value="{{$class->id}}">
                                                            </div>
                                                            <div class="col">
                                                                <label for="Name_en"
                                                                       class="mr-sm-2">{{ trans('My_Classes_trans.chooseGrade') }}
                                                                    :</label>
                                                                <input type="text" class="form-control"
                                                                       value="{{$class->getTranslation('name_class','en')}}"
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
                                                                        <option value="{{ $grade->id }}" @if($class->grade->id == $grade->id) selected @endif>{{ $grade->name }}</option>
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
                                    <div class="modal fade" id="delete{{ $class->id }}" tabindex="-1" role="dialog"
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
                                                               value="{{$class->id}}">
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
                            @endif
                        </table>
                    </div>


                        <!-- delete_all_modal_Class -->
                        <div class="modal fade" id="delete_all" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                            id="exampleModalLabel">
                                            {{ trans('My_Classes_trans.delete_classes') }}
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
                                            <input type="hidden" id="delete_all_id" name="delete_all_id" value="">
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

                </div>
            </div>
        </div>


        <!-- add_modal_class -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            {{ trans('My_Classes_trans.add_class') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form class=" row mb-30" action="{{route('class.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="repeater">
                                    <div data-repeater-list="List_Classes">
                                        <div data-repeater-item>
                                            <div class="row">

                                                <div class="col">
                                                    <label for="Name"
                                                           class="mr-sm-2">{{ trans('My_Classes_trans.Name_class') }}
                                                        :</label>
                                                    <input class="form-control" type="text" name="Name" />
                                                </div>


                                                <div class="col">
                                                    <label for="Name_class_en"
                                                           class="mr-sm-2">{{ trans('My_Classes_trans.Name_class_en') }}
                                                        :</label>
                                                    <input class="form-control" type="text" name="Name_class_en" />
                                                </div>


                                                <div class="col">
                                                    <label for="Name_en"
                                                           class="mr-sm-2">{{ trans('My_Classes_trans.Name_Grade') }}
                                                        :</label>

                                                    <div class="box">
                                                        <select class="fancyselect" name="Grade_id">
                                                           @foreach ($grades as $grade)
{{--                                                                <option value="0">{{trans('My_Classes_trans.chooseGrade')}}</option>--}}
                                                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col">
                                                    <label for="Name_en"
                                                           class="mr-sm-2">{{ trans('My_Classes_trans.Processes') }}
                                                        :</label>
                                                    <input class="btn btn-danger btn-block" data-repeater-delete
                                                           type="button" value="{{ trans('My_Classes_trans.delete_row') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-20">
                                        <div class="col-12">
                                            <input class="button" data-repeater-create type="button" value="{{ trans('My_Classes_trans.add_row') }}"/>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                        <button type="submit"
                                                class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                                    </div>


                                </div>
                            </div>
                        </form>
                    </div>


                </div>

            </div>

        </div>
    </div>
    </div>

    </div>

    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render

<script>
    $(document).ready(function (){
        $('#filter').prop('disabled', true);
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkVal').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkVal').each(function(){
                    this.checked = false;
                });
            }
        });

        $('#deleteMultipleBtn').on('click',function () {

            var id_chk = [];

            //console.log(id_chk);

            $('.checkVal:checked').each(function () {
                id_chk.push($(this).val());
            });

            if(id_chk.length > 0){
                $('#delete_all').modal('show');
                $('#delete_all_id').val(id_chk);
            }
        });
        $('#gradeFilter').change(function (){
            if($(this).children("option:selected").val() == 0){
                $('#filter').prop('disabled', true);
            }else {
                $('#filter').prop('disabled', false);
            }
        })
    });

</script>

@endsection
