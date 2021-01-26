@extends('layouts.master')
@section('css')
    @toastr_css
@endsection
@section('title')
    {{trans('main_trans.Grades')}}
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('main_trans.Title')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('main_trans.Grades')}}</li>
            </ol>
        </div>
    </div>
</div>
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
                    {{ trans('grades_trans.add_Grade') }}
                </button>
                <br><br>
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered p-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('grades_trans.name')}}</th>
                                <th>{{trans('grades_trans.Notes')}}</th>
                                <th>{{trans('grades_trans.Processes')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $index=>$grade)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$grade->name}}</td>
                                    <td>{{$grade->notes}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $grade->id }}"
                                                title="{{ trans('grades_trans.Edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $grade->id }}"
                                                title="{{ trans('grades_trans.Delete') }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <!-- Start Edit_modal_Grade -->
                                    <div class="modal fade" id="edit{{ $grade->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        {{ trans('grades_trans.Edit') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('grades.update')}}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="Name"
                                                                       class="mr-sm-2">{{ trans('grades_trans.stage_name_ar') }}
                                                                    :</label>
                                                                <input id="id" type="hidden" name="id" class="form-control" value="{{$grade->id}}">
                                                                <input id="Name" type="text" name="Name" value="{{$grade->getTranslation('name','ar')}}" class="form-control" required>
                                                            </div>
                                                            <div class="col">
                                                                <label for="Name_en"
                                                                       class="mr-sm-2">{{ trans('grades_trans.stage_name_en') }}
                                                                    :</label>
                                                                <input type="text" class="form-control" value="{{$grade->getTranslation('name','en')}}" name="Name_en">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleFormControlTextarea1">{{ trans('grades_trans.Notes') }}
                                                                :</label>
                                                            <textarea class="form-control" name="Notes" id="exampleFormControlTextarea1"
                                                                      rows="3">{{$grade->notes}}</textarea>
                                                        </div>
                                                        <br><br>
                                                    </div>
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
                                    <!-- End Edit_modal_Grade -->

                                    <!-- Start Delete_modal_Grade -->
                                    <div class="modal fade" id="delete{{ $grade->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        {{ trans('grades_trans.Delete') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('grades.destroy')}}" method="POST">
                                                    @csrf
                                                    <input id="id" type="hidden" name="id" class="form-control" value="{{$grade->id}}">
                                                    <div class="modal-body">
                                                        {{ trans('Grades_trans.Warning_Grade') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('grades_trans.Close') }}</button>
                                                        <button type="submit"
                                                                class="btn btn-danger">{{ trans('grades_trans.Delete') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Delete_modal_Grade -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<!-- Start add_modal_Grade -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                    id="exampleModalLabel">
                    {{ trans('grades_trans.add_Grade') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('grades.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- add_form -->
                        <div class="row">
                            <div class="col">
                                <label for="Name"
                                       class="mr-sm-2">{{ trans('grades_trans.stage_name_ar') }}
                                    :</label>
                                <input id="Name" type="text" name="Name" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="Name_en"
                                       class="mr-sm-2">{{ trans('grades_trans.stage_name_en') }}
                                    :</label>
                                <input type="text" class="form-control" name="Name_en">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label
                                for="exampleFormControlTextarea1">{{ trans('grades_trans.Notes') }}
                                :</label>
                            <textarea class="form-control" name="Notes" id="exampleFormControlTextarea1"
                                      rows="3"></textarea>
                        </div>
                        <br><br>
                </div>
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
<!-- End add_modal_Grade -->


</div>
<!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
