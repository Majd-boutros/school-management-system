<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClasses;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Grade;


class ClassroomsController extends Controller
{
    public function index(){
        $classes = Classroom::select('grade_id','name_class')->with('grade')->get();
        $grades = Grade::select('id','name')->get();
        //return $grades;
        return view('pages.My_classes.My_Classes',compact('classes','grades'));
    }

    public function store(StoreClasses $request){
        $validated = $request->validated();
        $classes = $request->List_Classes;

        $data = [];

        foreach ($classes as $index=>$class){
            $data[$index] = [
                'name_class' => ['ar'=>$class['Name'] , 'en' => $class['Name_class_en']],
                'grade_id' => $class['Grade_id']
            ];
            Classroom::create($data[$index]);
        }

        toastr()->success(trans('messages.success'));

        return redirect()->route('class.get');
    }
}
