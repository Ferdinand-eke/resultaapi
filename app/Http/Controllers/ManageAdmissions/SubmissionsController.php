<?php

namespace App\Http\Controllers\ManageAdmissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
Use App\Modells\ApplicationSubmissions;
Use App\Modells\Admission;

class SubmissionsController extends Controller
{
    //
       /*Listing out the  Form Fields */

       public function admin_SubmissionsList()
       {
           //AsmissionFormFields
           $submissions = ApplicationSubmissions::all();
   
           return response()->json([
               'success' => true,
               'message' => 'gotten',
               'data' => $submissions
           ], 200);
           
       }

              /*Receiving a  submission application to the DB*/
    public function admin_ReceiveApplication(Request $request)
     {
         //
         $validator =  Validator::make($request->all(), [
        //  'admission_id' => 'required'
         
         ]);
 
         if ($validator->fails()){
             return response()->json([
                 'success' => false,
                 'message' => 'failed validation',
                 'message' => $validator->messages()
             ], 201);
         }else{
 
            try {
                DB::beginTransaction(); 
               
                               //saving admission to db
                        $submissions =  ApplicationSubmissions::create( $request->all());

                    // $cand_slug = $regorm->slug;
    
            DB::commit();
                    
                    return response()->json([
                        'success' => true,
                        'data' => $submissions,
                        'message' => 'form field added succesfully'
                    ], 201);
   
                    // return redirect()->back();
            } catch (\PDOException $e) {
                // Woopsy
                return response()->json([
                    'success' => false,
                    'message1' => 'error happened',
                    'message' => $e
                ], 201);
                DB::rollBack();
            }
 
         }
         
     }


     public function admin_UserCompleteApplication(Request $request, $admission_slug, $cand_slug){
        //Retrieve datas from AdmissionReg table
         $admission = Admission::where('slug', $admission_slug)->first();
         $feeRequired = $admission->application_fee_required; 
         $examRequired = $admission->e_exam_required;
         $cutOff = $admission->cut_off;
         $automatic_admission = $admission->automatic_admission;

        //Retrieve datas from candidate submissions table
         $cand_regform = ApplicationSubmissions::where('slug', $cand_slug)->first();
         $payment = $cand_regform->payment_status;
         $candScore = $cand_regform->can_examscore;

         if($feeRequired == 1 && $payment == 'paid' ){

            if($examRequired ==1 ){
                if( $candScore >= $cutOff){

                    if($automatic_admission == 1){
                        return response()->json([
                            'success' => true,
                            // 'data' => $regform,
                            'message' => 'You have been offered and admission notification 1'
                        ], 201);
                    }else{
                        return response()->json([
                            'success' => true,
                            // 'data' => $regform,
                            'message' => 'Wait for admin approval 1'
                        ], 201);
                    }
                }else{
                    return response()->json([
                        'success' => true,
                        // 'data' => $regform,
                        'message' => 'Your score is below the cutoff score 1'
                    ], 201);
                }

            }else{
                return response()->json([
                    'success' => true,
                    // 'data' => $regform,
                    'message' => 'proceed to take exam 1'
                ], 201);
            }

        }elseif($examRequired ==1 ){
            if( $candScore >= $cutOff){

                if($automatic_admission == 1){
                    return response()->json([
                        'success' => true,
                        // 'data' => $regform,
                        'message' => 'You have been offered and admission notification 2'
                    ], 201);
                }else{
                    return response()->json([
                        'success' => true,
                        // 'data' => $regform,
                        'message' => 'Wait for admin approval 2'
                    ], 201);
                }
            }else{
                return response()->json([
                    'success' => true,
                    // 'data' => $regform,
                    'message' => 'Your score is below the cutoff score 2'
                ], 201);
            }

        }elseif($automatic_admission == 1){
            return response()->json([
                'success' => true,
                // 'data' => $regform,
                'message' => 'NB:vreate new studen at this point of logic. You have been offered and admission notification 22'
            ], 201);
            }else{
                return response()->json([
                    'success' => true,
                    // 'data' => $regform,
                    'message' => 'Wait for admin approval 2'
                ], 201);
            }
        

}







}
