<?php

namespace App\Http\Controllers\ManageAdmissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Use App\Modells\Admission;
// Use App\Modells\AdReg;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ManageFormsController extends Controller
{
    //
    //
    /*Listing out the  registration form submitted*/

    public function admin_ListAdmissionRegForms()
    {
        //AsmissionFormFields
        $reform = AdReg::all();

        return response()->json([
            'success' => true,
            'message' => 'gotten',
            'data' => $reform
        ], 200);
        
    }


      /*Savin a  settings to thr DB*/
     public function admin_QueAdmissionRegForm(Request $request)
     {
         //
         $validator =  Validator::make($request->all(), [
         'cand_fname' => 'required',
         'cand_lname' => 'required',
         'cand_age' => 'required',
         'guardian' => 'required',
         'guardian_rel' => 'required',
         'class' => 'required',
         'photo' => 'required',
         'admission_id' => 'required'
        //  'slug' => 'required',
        //  'brief' => 'required',
        //  'strict' => 'required|boolean',
        //  'admission_reg_status' => 'required|boolean',
        //  'admin_id' => 'required'
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
                   $regform =  RegForm::create([
                    'cand_fname' => $request->input('cand_fname'),
                    'cand_lname' => $request->input('cand_lname'),
                    'cand_age' => $request->input('cand_age'),
                    'guardian' => $request->input('guardian'),
                    'guardian_rel' => $request->input('guardian_rel'),
                    'class' => $request->input('class'),
                    'photo' => $request->input('photo'),
                    'admission_id' => $request->input('admission_id'),

                    //Nb: later add: 'adreg_id' => $request->input('admission_id'),

                    'payment_status' => null,
                    'can_examscore' => null,

                    'reg_status' => 'que',
                    'slug' => time().Str::slug($request->input('cand_fname'.'cand_lname')).Str::random(40)
                   // Str::slug($request->input('setting_name'))  
                ]);

                    // $cand_slug = $regorm->slug;
    
            DB::commit();
                    
                    return response()->json([
                        'success' => true,
                        'data' => $regform,
                        'message' => 'registration form in que succesfully, to url where you continue process'
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


     public function user_CompleteAdmissionReg(Request $request, $admission_slug, $cand_slug){
                //Retrieve datas from AdmissionReg table
                 $admission = Admission::where('slug', $admission_slug)->first();
                 $feeRequired = $admission->adreg->application_fee_required; 
                 $examRequired = $admission->adreg->e_exam_required;
                 $cutOff = $admission->adreg->cut_off;
                 $automatic_admission = $admission->adreg->automatic_admission;

                //Retrieve datas from RegForm table
                 $cand_regform = RegForm::where('slug', $cand_slug)->first();
                 $payment = $cand_regform->payment_status;
                 $candScore = $cand_regform->can_examscore;

                 if($feeRequired == 1 && $payment == 'paid' ){

                    if($examRequired == 1 && $candScore > 0){

                        if($automatic_admission == 1){
                                    return response()->json([
                                        'success' => true,
                                        // 'data' => $regform,
                                        'message' => 'You have been offered and admission notification'
                                    ], 201);
                                }else{
                                    return response()->json([
                                        'success' => false,
                                        // 'data' => $regform,
                                        'message' => 'Wait for admin approval'
                                    ], 201);
                                }

                    }else{
                        return response()->json([
                            'success' => true,
                            // 'data' => $regform,
                            'message' => 'proceed to take exam'
                        ], 201);
                    }

                }elseif($feeRequired == 0){

                        if($automatic_admission == 1){
                            return response()->json([
                                'success' => true,
                                // 'data' => $regform,
                                'message' => 'You have been offered an admission notification'
                            ], 201);
                        }else{
                            return response()->json([
                                'success' => true,
                                // 'data' => $regform,
                                'message' => 'Wait for admin approval'
                            ], 201);
                        }
                }else{
                        return response()->json([
                            'success' => true,
                            // 'data' => $regform,
                            'message' => 'Pay application fees to complete registration'
                        ], 201);
                }

     }


            /*Edit request for a particular registratin form by $id or $slug  */
    public function admin_EditAdmissionRegForm(Request $request, $slug)
    {
        //

        $regform = RegForm::where('slug', $slug)->first();
        return response()->json([
            'success' => true,
            'data' => $regform
        ], 200);
        
    }

            /*Updating a particular registration form by $id or $slug*/
     public function admin_UpdateAdmissionRegForm(Request $request, $slug)
     {
         //

         $regform = RegForm::where('slug', $slug)->first();

         $regform->update($request->all());
      
         
         return response()->json([
             'success' => true,
             'data' => $regform,
             'message' => 'registration form updated succesfully'
         ], 200);
       
     }

          /*deleting a particular registration form by $id or $slug*/
     public function admin_DeleteAdmissionRegForm(Request $request, $slug)
     {
         //
      
         $regform = RegForm::where('slug', $slug)->first();
         $regform->delete();
      
         
         return response()->json([
             null,
             'data' => $admission,
             'message' => 'Registration form deleted succesfully'
         ], 204);
       
     }
}
