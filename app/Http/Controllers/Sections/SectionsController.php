<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSections;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Support\Facades\App;

class SectionsController extends Controller
{
    public function index(){
        $grades = Grade::select('id','name')->with(['sections'=>function($query){
            $query->select('id','name_section','status','grade_id','class_id')->with(['my_class'=>function($query){
                $query->select('id','name_class','grade_id');
            }]);
        }])->orderBy('id','asc')->get();

        //return $grades;

        return view('pages.sections.sections',compact('grades'));
    }

    public function getClassesByGradeId($grade_id){
       // $currentLang = App::getLocale();
        $classes = Classroom::select('id','name_class')->where('grade_id',$grade_id)->get();

//        $data = [
//            'classes' => $classes,
//            'lang' => $currentLang
//        ];
        return $classes;
    }

    public function store(StoreSections $request){

        try {
            $validated = $request->validated();
            $data = $request->all();
            $section = new Section();
            $section->name_section = ['ar' => $data['Name_Section_Ar'], 'en' => $data['Name_Section_En']];
            $section->grade_id = $data['Grade_id'];
            $section->class_id = $data['Class_id'];
            $section->status = 1; //Active
            $section->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('section.get');
        }
        catch (\Exception $e){
            return redirect()->route('section.get')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(StoreSections $request){
        try{
            $validated = $request->validated();
            $data = $request->all();
            $section = Section::where('id',$data['id'])->first();
            $section->name_section = ['ar' => $data['Name_Section_Ar'], 'en' => $data['Name_Section_En']];
            $section->grade_id = $data['Grade_id'];
            $section->class_id = $data['Class_id'];
            if(isset($data['Status'])) {
                $section->status = 1; //Active
            } else {
                $section->status = 2; //Not active
            }
            $section->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('section.get');
        }
        catch (\Exception $e){
            return redirect()->route('section.get')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request){
        try{
            $data = $request->all();
            Section::findOrFail($data['id'])->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('section.get');
        }
        catch (\Exception $e){
            return redirect()->route('section.get')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
