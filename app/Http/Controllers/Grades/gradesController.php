<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrades;
use Illuminate\Http\Request;
use App\Models\Grade;
use function PHPUnit\Framework\isEmpty;

class gradesController extends Controller
{
    public function index(){
       $grades = Grade::select('id','name','notes')->get();

        return view('pages.grades.grades',compact('grades'));
    }

    public function store(StoreGrades $request){

//        if(Grade::select('id')->where('name->ar',$request->Name)->orWhere('name->en',$request->Name_en)->exists()){
//            return redirect()->route('grades.get')->withErrors(trans('grades_trans.exists'));
//        }

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
//            if(Grade::select('id')->where('name->ar',$request->Name)->orWhere('name->en',$request->Name_en)->exists()){
//                return redirect()->route('grades.get')->withErrors(trans('grades_trans.exists'));
//            }

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

        if($request->has('mulCheck')){

            try {

                $grades_ids = $request->input('mulCheck');

                $grades = Grade::whereIn('id', $grades_ids)->with('classes')->get();
                $checkArr = [];
                $toDelete = [];

                foreach ($grades as $index=>$grade){
                    if(count($grade->classes)>0){
                        $checkArr[$index] = $grade->name;
                    }else{
                        $toDelete[$index] = $grade->id;
                    }
                }

                if(count($checkArr)>0){
                    return response()->json([
                        'success' => false,
                        'msg' => trans('grades_trans.warning_del_children').':',
                        'data' => $checkArr
                    ]);
                }else{
                    foreach ($toDelete as $item){
                        Grade::find($item)->delete();
                    }
                    return response()->json([
                        'success' => true,
                        'msg' => trans('messages.Delete'),
                        'data' => $toDelete
                    ]);
                }
            }catch (\Exception $e){
                return redirect()->route('grades.get')->withErrors(trans('messages.ExErr'));
            }

        }
        elseif(!$request->has('mulCheck') && $request->check==1){
            try{
                $grade_id = $request->id;
                $grade = Grade::where('id',$grade_id)->with('classes')->first();

               if(count($grade->classes)>0){
                   return redirect()->route('grades.get')->withErrors(trans('grades_trans.warning_del_children'));
               }else{
                   $grade->delete();
                   toastr()->error(trans('messages.Delete'));
                   return redirect()->route('grades.get');
               }
            }
            catch (\Exception $e){
                return redirect()->route('grades.get')->withErrors(trans('messages.ExErr'));
            }
        }
    }
}
