<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrades;
use Illuminate\Http\Request;
use App\Models\Grade;

class gradesController extends Controller
{
    public function index(){
        $grades = Grade::select('id','name','notes')->get();
        return view('pages.grades.grades',compact('grades'));
    }

    public function store(StoreGrades $request){

        try{
            $validated = $request->validated();
            $grade = new Grade();
            $grade->name = ['en'=>$request->Name_en,'ar'=>$request->Name];
            $grade->notes = $request->Notes;
            if($grade){
                $grade->save();
                toastr()->success(trans('messages.success'));
            }else{
                toastr()->error(trans('messages.error'));
            }

            return redirect()->route('grades.get');
        }
        catch (\Exception $e){
            //return redirect()->route('grades.get')->withErrors(['error'=>$e->getMessage()]);
            return redirect()->route('grades.get')->withErrors(trans('messages.ExErr'));

        }

    }

    public function update(StoreGrades $request){

        try{
            $validated = $request->validated();
            $grade_id = $request->id;
            $grade = Grade::findOrFail($grade_id);
//        $data = [
//          'name' => ['ar'=>$request->Name , 'en' => $request->Name_en],
//            'notes' => $request->Notes
//        ];

            $grade->update([
                $grade->name = ['en'=>$request->Name_en,'ar'=>$request->Name],
                $grade->notes = $request->Notes
            ]);

            if($grade){
                $grade->save();
                toastr()->success(trans('messages.Update'));
            }else{
                toastr()->error(trans('messages.error'));
            }

            return redirect()->route('grades.get');
        }
        catch (\Exception $e){
                //return redirect()->route('grades.get')->withErrors(['error'=>$e->getMessage()]);
                return redirect()->route('grades.get')->withErrors(trans('messages.ExErr'));
        }
    }

    public function destroy(Request $request){
        try{
            $grade_id = $request->id;
            Grade::findOrFail($grade_id)->delete();;
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('grades.get');
        }
        catch (\Exception $e){
            return redirect()->route('grades.get')->withErrors(trans('messages.ExErr'));
        }
    }
}
