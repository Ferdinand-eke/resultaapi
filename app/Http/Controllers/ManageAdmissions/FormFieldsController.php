<?php

namespace App\Http\Controllers\ManageAdmissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
Use App\Modells\AsmissionFormFields;
use Illuminate\Support\Facades\Schema;
Use App\Modells\ApplicationSubmissions;

class FormFieldsController extends Controller
{
    //
        /*Listing out the  Form Fields */

        public function admin_ListFormFields()
        {
            //AsmissionFormFields
            $formFields = AsmissionFormFields::all();
    
            return response()->json([
                'success' => true,
                'message' => 'gotten',
                'data' => $formFields
            ], 200);
            
        }

          /*Saving a  settings to thr DB*/
     public function admin_StoreFormFields(Request $request)
     {
         //
         $validator =  Validator::make($request->all(), [
         'admission_id' => 'required',
         'label' => 'required',
         'type' => 'required',
         'option' => 'required'
         ]);
 
         if ($validator->fails()){
             return response()->json([
                 'success' => false,
                 'message' => $validator->messages()
             ], 201);
         }else{

            $thatName = $request->input('label');
           // $dbKeyname = str_replace('','_',$request->input('label'));
           if ($thatName == trim($thatName) && strpos($thatName, ' ') !== false) {
            $dbKeyname = preg_replace('/\s+/', '_', $thatName);
           }else{
            $dbKeyname = $request->input('label');
           }
            
            $tableName = 'application_submissions';
            $fieldsAvail =  DB::getSchemaBuilder()->getColumnListing($tableName);

            if (in_array($dbKeyname, $fieldsAvail)){


                return response()->json([
                    'success' => true,
                    'data' => $dbKeyname,
                    'data2' => $fieldsAvail,
                    'mesage' => 'true',
                    'message2' => 'this colum name already exists'
                ], 201);
            }else{

                // type will be = $request->input('type');
                $type = 'string';
                $length = 70;
                $fieldName = $dbKeyname;
            //    $newColumn = Schema::table($tableName, function(Blueprint $table) use ($alldata)
            //     {
            //        $colname=$alldata[$dbKeyname];
            //        $coltype=$alldata[$request->input('type')];
            //        $table->$coltype($colname);
            //     });

            try {
                DB::beginTransaction();  
                        
                    $newColumn = Schema::table($tableName, function ($table) use ($type, $length, $fieldName) {
                            $table->$type($fieldName, $length)->nullable();
                        });


                            //saving form fields to db
                            $formFields =  AsmissionFormFields::create([
                            'admission_id' => $request->input('admission_id'),
                            'label' => $request->input('label'),
                            'type' => $request->input('type'),
                            'option' => $request->input('option'),
                            'key_name' => $fieldName,
                            'slug' => time().Str::slug($request->input('label'.'type')).Str::random(40)
                            // Str::slug($request->input('setting_name'))  
                        ]);

                        DB::commit();
                    
                        return response()->json([
                            'success' => true,
                            'data' => $formFields,
                            'message' => 'form field added succesfully'
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

                $formFields2 = AsmissionFormFields::all();
                return response()->json([
                    'success' => false,
                    'data' => $dbKeyname,
                    'data2' => $fieldsAvail,
                    'data3' => $formFields2,
                    'data4' => $newColumn,
                    'mesage' => 'false'
                ], 201);
            }


            // return response()->json([
            //     'success' => true,
            //     'data' => $fieldsAvail,
            //     'data2' => $dbKeyname
            // ], 201);
            // dd($fieldsAvail);
            // dd($dbKeyname);

    
           
 
         }
         
     }


    /*Generate form   */
    public function admin_GenerateForrm(Request $request)
    {
        //

        $formFields = AsmissionFormFields::all();
        $cand_regform = ApplicationSubmissions::all();
        return response()->json([
            'success' => true,
            'data' => $formFields,
            'data2' => $cand_regform
        ], 200);
        
    }
     


                 /*Edit request for a particular form field form by $id or $slug  */
    public function admin_EditFormFields(Request $request, $id)
    {
        //

        $formFields = AsmissionFormFields::find($id);
        return response()->json([
            'success' => true,
            'data' => $formFields
        ], 200);
        
    }

        /*Updating a particular registration form by $id or $slug*/
        public function admin_UpdateFormField(Request $request, $id)
        {
            //

            $formFields = AsmissionFormFields::find($id);

            $formFields->update($request->all());
        
            
            return response()->json([
                'success' => true,
                'data' => $formFields,
                'message' => 'Form field updated succesfully'
            ], 200);
            
        }


                  /*deleting a particular registration form by $id or $slug*/
     public function admin_DeleteFormField(Request $request, $id)
     {
         //
      
         $formFields = AsmissionFormFields::find($id);
         $formFields->delete();
      
         
         return response()->json([
             null,
             'message' => 'Form field deleted succesfully'
         ], 204);
       
     }


}
