<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Use App\Models\AdmissionReg;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdmissionsController extends Controller
{
    //
        /*Listing out the 
    admissions available*/

    public function admin_ListAdmissions()
    {
        //
        $admission = AdmissionReg::all();

        return response()->json([
            'success' => true,
            'message' => 'gotten',
            'data' => $admission
        ], 200);
        
    }

       /*Savin a 
     settings to thr DB*/
     public function admin_SaveAdmission(Request $request)
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
         'admin_id' => 'required'
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
                   $admission =  AdmissionReg::create([
                    'automatic_admission' => $request->input('automatic_admission'),
                    'e_exam_required' => $request->input('e_exam_required'),
                    'class_id' => $request->input('class_id'),
                    'max_class_count' => $request->input('max_class_count'),
                    'application_fee_required' => $request->input('application_fee_required'),
                    'application_fee' => $request->input('application_fee'),
                    'application_starts' => $request->input('application_starts'),
                    'application_ends' => $request->input('application_ends'),
                    'cut_off' => $request->input('cut_off'),
                    'brief' => $request->input('brief'),
                    'admission_reg_status' => $request->input('admission_reg_status'),
                    'strict' => $request->input('strict'),
                    'admin_id' => $request->input('admin_id'),

                    'slug' => time().Str::slug($request->input('application_starts')).Str::random(40)
                   // Str::slug($request->input('setting_name'))
                    
                    
                   
                ]);

                // $admissionRegform = AdmissionRegform::create([

                //     'admission_id' => $request->input('class_id'),
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
     public function admin_EditAdmission(Request $request, $slug)
     {
         //
 
         $admission = AdmissionReg::where('slug', $slug)->first();
         return response()->json([
             'success' => true,
             'data' => $admission
         ], 200);
         
     }


        /*Updating a particular
     admission by $id or $slug*/
     public function admin_UpdateAdmission(Request $request, $slug)
     {
         //

         $admission = AdmissionReg::where('slug', $slug)->first();

         $admission->update($request->all());
      
         
         return response()->json([
             'success' => true,
             'data' => $admission,
             'message' => 'admission updated succesfully'
         ], 200);
       
     }


     public function admin_DeleteAdmission(Request $request, $slug)
     {
         //
      
         $admission = AdmissionReg::where('slug', $slug)->first();
        //  $settings->setting_name = $request->input('setting_name');
        //  $settings->status = $request->input('status');
         $admission->delete();
      
         
         return response()->json([
             null,
             'data' => $admission,
             'message' => 'admission deleted succesfully'
         ], 204);
       
     }


}
