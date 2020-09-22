<?php

namespace App\Http\Controllers\ManageAdmissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Use App\Modells\Admission;
Use App\Modells\AdReg;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ManageAdmController extends Controller
{
    //

     //
        /*Listing out the 
    admissions available*/

    public function admin_ListAdmissionsReg()
    {
        //
        $admission = Admission::all();

        // $adreg = AdReg::all();
        //$adreg = $admission->adreg->get();

        if($admission){
            return response()->json([
                'success' => true,
                'message' => 'gotten',
                'data' => $admission,
          
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'no data',
                'data' => $admission
            ], 200);
        }
      
        
    }

       /*Savin a 
     settings to thr DB*/
     public function admin_StoreAdmissionReg(Request $request)
     {
         //
         $validator =  Validator::make($request->all(), [
         'automatic_admission' => 'required|boolean',
         'e_exam_required' => 'required|boolean',
         'class_id' => 'required',
         'max_class_count' => 'required',
         'application_fee_required' => 'required|boolean',
         'application_fee' => 'required',
         'application_starts' => 'required',
         'application_ends' => 'required',
         'cut_off' => 'required',
         'brief' => 'required',
         'strict' => 'required|boolean',
         'admission_reg_status' => 'required|boolean',
         //'admin_id' => 'required'
         ]);
 
         if ($validator->fails()){
             return response()->json([
                 'success' => false,
                 'message' => $validator->messages()
             ], 201);
         }else{
 
            try {
                DB::beginTransaction(); 
                        
                   //saving admission to db
                   $admission =  Admission::create([
                    'application_starts' => $request->input('application_starts'),
                    'application_ends' => $request->input('application_ends'),
                   
                    'brief' => $request->input('brief'),
                   
                    'admin_id' => $request->input('admin_id'),
                    'automatic_admission' => $request->input('automatic_admission'),
                    'e_exam_required' => $request->input('e_exam_required'),
                    'class_id' => $request->input('class_id'),
                    'max_class_count' => $request->input('max_class_count'),
                    'application_fee_required' => $request->input('application_fee_required'),
                    'application_fee' => $request->input('application_fee'),

                    'cut_off' => $request->input('cut_off'),
                    'admission_reg_status' => $request->input('admission_reg_status'),
                    'strict' => $request->input('strict'),
                   
                    // 'admission_id' => $request->input('admission_id'),

                    'slug' => time().Str::slug($request->input('application_starts')).Str::random(40)
                   // Str::slug($request->input('setting_name'))
                ]);

                // $admissionReg = AdReg::create([

                    
                   
                //     'slug' => time().Str::slug($request->input('admission reg')).Str::random(40)
                // ]);
    
            DB::commit();
                    
                    return response()->json([
                        'success' => true,
                        'data' => $admission,
                       
                        'message' => 'admission saved succesfully'
                    ], 201);
   
                    // return redirect()->back();
            } catch (\PDOException $e) {
                // Woopsy
                return response()->json([
                    'success' => false,
                    'message' => $e
                ], 201);
                DB::rollBack();
            }
 
       
 
         }
         
     }


       /*Edit request for a particular 
    admission by $id or $slug
    */
     public function admin_EditAdmissionReg(Request $request, $slug)
     {
         //
 
         $admission = Admission::where('slug', $slug)->first();
         return response()->json([
             'success' => true,
             'data' => $admission
         ], 200);
         
     }


        /*Updating a particular
     admission by $id or $slug*/
     public function admin_UpdateAdmissionReg(Request $request, $slug)
     {
         //

         $admission = Admission::where('slug', $slug)->first();

        //  $admission->application_starts = $request->input('application_starts');
        //  $admission->application_ends = $request->input('application_ends');
        //  $admission->brief = $request->input('brief');

        //  $admission->adreg->automatic_admission = $request->input('automatic_admission');
        //  $admission->adreg->e_exam_required = $request->input('e_exam_required');
        //  $admission->adreg->class_id = $request->input('class_id');
        //  $admission->adreg->max_class_count = $request->input('max_class_count');

        //  $admission->adreg->application_fee_required = $request->input('application_fee_required');
        //  $admission->adreg->application_fee = $request->input('application_fee');

        //  $admission->adreg->cut_off = $request->input('cut_off');
        //  $admission->adreg->admission_reg_status = $request->input('admission_reg_status');
        //  $admission->adreg->strict = $request->input('strict');

         //  $admission->update($request->all());
      
        //  $admission->adreg->save();
        //  $admission->save();

        $admission->update($request->all());
        // $admission->adreg->update($request->all());
      
        
        return response()->json([
            'success' => true,
            'data' => $admission,
           
            'message' => 'admission updated succesfully'
        ], 200);
         
       
     }


     public function admin_DeleteAdmissionReg(Request $request, $slug)
     {
         //
      
         $admission = Admission::where('slug', $slug)->first();
        //  $settings->setting_name = $request->input('setting_name');
        //  $settings->status = $request->input('status');
         $admission->delete();
         $admission->adreg->delete();
      
         
         return response()->json([
             null,
             'data' => $admission,
             'message' => 'admission deleted succesfully'
         ], 204);
       
     }

}
