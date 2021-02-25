@extends('layouts.master')
@section('css')
    @toastr_css
@endsection
@section('title')
    {{trans('Sections_trans.add_section')}}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">{{trans('Sections_trans.add_section')}}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">{{trans('main_trans.Home')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('Sections_trans.add_section')}}</li>
                </ol>
                <input type="hidden" id="currentLang" value="{{ LaravelLocalization::getCurrentLocale() }}">
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <a class="button x-small" href="#" data-toggle="modal" data-target="#exampleModal">
                    {{ trans('Sections_trans.add_section') }}
                </a>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card-body">
                <div class="accordion gray plus-icon round">
                    @foreach($grades as $grade)
                        <div class="acd-group">
                            <a href="#" class="acd-heading">{{$grade->name}}</a>
                            <div class="acd-des">
                                <div class="table-responsive mt-15">
                                    <table class="table center-aligned-table mb-0">
                                        <thead>
                                            <tr class="text-dark">
                                                <th>#</th>
                                                <th>{{ trans('Sections_trans.Name_Section') }}
                                                </th>
                                                <th>{{ trans('Sections_trans.Name_Class') }}</th>
                                                <th>{{ trans('Sections_trans.Status') }}</th>
                                                <th>{{ trans('Sections_trans.Processes') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($grade->sections as $index=>$section)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $section->name_section }}</td>
                                                    <td>{{ $section->my_class->name_class }}
                                                    </td>
                                                    <td>
                                                        @if ($section->status === 1)
                                                            <label
                                                                class="badge badge-success">{{ trans('Sections_trans.Status_Section_AC') }}</label>
                                                        @else
                                                            <label
                                                                class="badge badge-danger">{{ trans('Sections_trans.Status_Section_No') }}</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="#"
                                                           class="btn btn-outline-info btn-sm"
                                                           data-toggle="modal"
                                                           data-target="#edit{{$section->id}}">{{trans('Sections_trans.Edit')}}
                                                        </a>
                                                        <a href="#"
                                                           class="btn btn-outline-danger btn-sm"
                                                           data-toggle="modal"
                                                           data-target="#delete{{$section->id}}">{{trans('Sections_trans.Delete')}}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <!--تعديل قسم جديد -->
                                                <div class="modal fade" id="edit{{$section->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" style="font-family: 'Cairo', sans-serif;" id="exampleModalLabel">
                                                                    {{ trans('Sections_trans.edit_Section') }}
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{route('section.update')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <input type="text" name="Name_Section_Ar" class="form-control"
                                                                               value="{{$section->getTranslation('name_section', 'ar')}}">
                                                                        </div>
                                                                        <div class="col">
                                                                            <input type="text" name="Name_Section_En" class="form-control"
                                                                               value="{{$section->getTranslation('name_section', 'en')}}">
                                                                            <input id="id" type="hidden" name="id" class="form-control"
                                                                               value="{{$section->id}}">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="col">
                                                                        <label for="inputName" class="control-label">{{trans('Sections_trans.Name_Grade')}}</label>
                                                                        <select name="Grade_id" class="custom-select">
                                                                            <!--placeholder-->
{{--                                                                            <option value="{{$grade->id}}">{{$grade->name}}</option>--}}
                                                                            @foreach ($grades as $grade)
                                                                                <option value="{{ $grade->id }}"
                                                                                    @if($grade->id == $section->my_class->grade_id) selected @endif
                                                                                >
                                                                                    {{ $grade->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <br>
                                                                    <div class="col">
                                                                        <label for="inputName" class="control-label">{{trans('Sections_trans.Name_Class')}}</label>
                                                                        <select name="Class_id" class="custom-select">
                                                                            <option value="{{ $section->my_class->id }}">
                                                                                {{ $section->my_class->name_class }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <br>
                                                                    <div class="col">
                                                                        <div class="form-check">
                                                                            @if ($section->status === 1)
                                                                                <input type="checkbox" checked class="form-check-input" name="Status" id="exampleCheck1">
                                                                            @else
                                                                                <input type="checkbox" class="form-check-input" name="Status" id="exampleCheck1">
                                                                            @endif
                                                                            <label class="form-check-label" for="exampleCheck1">{{trans('Sections_trans.Status')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">{{trans('Sections_trans.Close')}}
                                                                </button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">{{trans('Sections_trans.submit')}}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!--اضافة قسم جديد -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="font-family: 'Cairo', sans-serif;" id="exampleModalLabel">
                                                        {{trans('Sections_trans.add_section')}}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('section.store')}}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input type="text" name="Name_Section_Ar" class="form-control"
                                                                   placeholder="{{trans('Sections_trans.Section_name_ar')}}">
                                                            </div>
                                                            <div class="col">
                                                                <input type="text" name="Name_Section_En" class="form-control"
                                                                   placeholder="{{trans('Sections_trans.Section_name_en')}}">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="col">
                                                            <label for="inputName"
                                                                   class="control-label">{{trans('Sections_trans.Name_Grade')}}</label>
                                                            <select name="Grade_id" class="custom-select">
                                                                <!--placeholder-->
                                                                <option value="" selected
                                                                        disabled>{{trans('Sections_trans.Select_Grade')}}
                                                                </option>
                                                                @foreach ($grades as $grade)
                                                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <br>
                                                        <div class="col">
                                                            <label for="inputName"
                                                                   class="control-label">{{ trans('Sections_trans.Name_Class') }}</label>
                                                            <select name="Class_id" class="custom-select">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('Sections_trans.Close') }}</button>
                                                        <button type="submit"
                                                                class="btn btn-danger">{{ trans('Sections_trans.submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete_modal_Grade -->
                                    <div class="modal fade" id="delete{{$section->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                        {{ trans('Sections_trans.delete_Section') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('section.destroy')}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        {{ trans('Sections_trans.Warning_Section') }}
                                                        <input id="id" type="hidden" name="id" class="form-control"
                                                           value="{{$section->id}}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Sections_trans.Close')}}</button>
                                                            <button type="submit" class="btn btn-danger">{{trans('Sections_trans.submit')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@toastr_js
@toastr_render
<script>
$(document).ready(function (){

    $('select[name="Grade_id"]').change(function (){
        var grade_id = $(this).val();
        if(grade_id){
            $.ajax({
                url: "{{ URL::to('/grade/class') }}/" + grade_id,
                type: "GET",
                dataType: "json",
                success: function (response){
                    var currentlang = $('#currentLang').val();
                    $('select[name="Class_id"]').empty();

                    if(currentlang == 'ar'){
                        $.each(response,function (key,value){
                            var option = '<option value="' + value.id + '">' + value.name_class.ar +'</option>'
                            $('select[name="Class_id"]').append(option);
                        });

                    }else if(currentlang == 'en'){
                        $.each(response,function (key,value){
                            var option = '<option value="' + value.id + '">' + value.name_class.en +'</option>'
                            $('select[name="Class_id"]').append(option);
                        });
                    }

                },
            });
        }
    });

});
</script>
@endsection


