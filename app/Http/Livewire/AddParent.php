<?php

namespace App\Http\Livewire;

use App\Models\Blood;
use App\Models\My_Parent;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\ParentAttachment;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class AddParent extends Component
{
    use WithFileUploads;

    public $currentStep = 1,

        // Father_INPUTS
        $Email, $Password,
        $Name_Father, $Name_Father_en,
        $National_ID_Father, $Passport_ID_Father,
        $Phone_Father, $Job_Father, $Job_Father_en,
        $Nationality_Father_id, $Blood_Type_Father_id,
        $Address_Father, $Religion_Father_id,

        // Mother_INPUTS
        $Name_Mother, $Name_Mother_en,
        $National_ID_Mother, $Passport_ID_Mother,
        $Phone_Mother, $Job_Mother, $Job_Mother_en,
        $Nationality_Mother_id, $Blood_Type_Mother_id,
        $Address_Mother, $Religion_Mother_id;

    public $successMessage = '';
    public $catchError = '';
    public $photos = [];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'Email' => 'required|email',
            'Password' => 'required',
            //Father information
            'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Father' => 'min:10|max:10',
            'Address_Father' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            //Mother information
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Mother' => 'min:10|max:10',
            'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required'
        ]);
    }

    public function render()
    {
        $Nationalities = Nationality::select('id','name')->get();
        $Type_Bloods = Blood::select('id','name')->get();
        $Religions = Religion::select('id','name')->get();
        return view('livewire.add-parent',compact('Nationalities','Type_Bloods','Religions'));
    }

    public function firstStepSubmit(){

        $this->validate([
            'Email' => 'required|email',
            'Password' => 'required',
            //Father information
            'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Father' => 'min:10|max:10',
            'Address_Father' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
        ]);

        $this->currentStep = 2;
    }

    public function back($step){
        $this->currentStep = $step;
    }

    public function secondStepSubmit(){
        $this->validate([
            //Mother information
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Mother' => 'min:10|max:10',
            'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required'
        ]);
        $this->currentStep = 3;
    }

    //clearForm
    public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father ='';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father ='';
        $this->Religion_Father_id ='';
        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother ='';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother ='';
        $this->Religion_Mother_id ='';
    }

    public function submitForm(){
        try{
            $my_parent = new My_Parent();
            //insert Data in database
            $my_parent->email = $this->Email;
            $my_parent->password = Hash::make($this->Password);

            //Father Information
            $my_parent->father_name = ['en' =>$this->Name_Father_en ,'ar' =>$this->Name_Father];
            $my_parent->father_job = ['en' =>$this->Job_Father_en ,'ar' =>$this->Job_Father];
            $my_parent->father_national_id = $this->National_ID_Father;
            $my_parent->father_phone = $this->Phone_Father;
            $my_parent->nationality_father_id = $this->Nationality_Father_id;
            $my_parent->father_passport_id = $this->Passport_ID_Father;
            $my_parent->religion_father = $this->Religion_Father_id;
            $my_parent->blood_type_father = $this->Blood_Type_Father_id;
            $my_parent->father_address = $this->Address_Father;

            //Mother Information
            $my_parent->mother_name = ['en' =>$this->Name_Mother_en ,'ar' =>$this->Name_Mother];
            $my_parent->mother_job = ['en' =>$this->Job_Mother_en ,'ar' =>$this->Job_Mother];
            $my_parent->mother_national_id = $this->National_ID_Mother;
            $my_parent->mother_phone = $this->Phone_Mother;
            $my_parent->nationality_mother_id = $this->Nationality_Mother_id;
            $my_parent->mother_passport_id = $this->Passport_ID_Mother;
            $my_parent->religion_mother = $this->Religion_Mother_id;
            $my_parent->blood_type_mother = $this->Blood_Type_Mother_id;
            $my_parent->mother_address = $this->Address_Mother;
            $my_parent->save();

            //save attachments if exist
            $parent_id = $my_parent->id;
            if(!empty($this->photos)){
                foreach ($this->photos as $index=>$photo){
                    $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(),'parent_attachments');
                    $data[$index] = $photo->getClientOriginalName();
                }
                ParentAttachment::insert([
                    'file_name' => json_encode($data),
                    'parent_id' => $parent_id,
                    'created_at' =>Carbon::now(),
                    'updated_at' =>Carbon::now()
                ]);
            }

            $this->successMessage = trans('messages.success');
            $this->clearForm();
            $this->currentStep = 1;
        }
        catch (\Exception $e){
            $this->catchError = $e->getMessage();
        }


    }


}
