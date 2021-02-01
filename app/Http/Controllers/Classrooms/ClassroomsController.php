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
        $classes = Classroom::select('id','grade_id','name_class')->with('grade')->get();
        $grades = Grade::select('id','name')->get();
        //return $grades;
        return view('pages.My_classes.My_Classes',compact('classes','grades'));
    }

    public function store(Request $request){
        try{
           // return $request;
                    //$validated = $request->validated();

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
        catch (\Exception $e){
            return redirect()->route('class.get')->withErrors(trans('messages.ExErr'));
        }

    }

    public function update(Request $request){
        try {
            $class_id = $request->id;
            $class = Classroom::findOrFail($class_id);
            $class->update([
                $class->name_class = ['en' => $request->Name_en, 'ar' => $request->Name]
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('class.get');
        }
        catch (\Exception $e){
            //return redirect()->route('grades.get')->withErrors(['error'=>$e->getMessage()]);
            return redirect()->route('class.get')->withErrors(trans('messages.ExErr'));
        }
    }

    public function destroy(Request $request){
        try{
            $class_id = $request->id;
            Classroom::findOrFail($class_id)->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('class.get');
        }
        catch (\Exception $e){
            return redirect()->route('class.get')->withErrors(trans('messages.ExErr'));
        }
    }
}
