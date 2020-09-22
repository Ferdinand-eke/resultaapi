<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Settings;
use Validator;
use Illuminate\Support\Str;


class SettingsController extends Controller
{
    /*Listing out the 
    settings available*/

    public function settings_List()
    {
        //
        $settings = Settings::all();

        return response()->json([
            'success' => true,
            'data' => $settings
        ], 200);
        
    }


    /*Savin a 
     settings to thr DB*/
    public function settings_Save(Request $request)
    {
        //
        $validator =  Validator::make($request->all(), [
        'setting_name' => 'required',
        'status' => 'required',
        'user_id' => 'required',
        'slug' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->messages()
            ], 201);
        }else{


            //$settings = Settings::create($request->all());
            $settings =  Settings::create([
                'setting_name' => $request->input('setting_name'),
                'status' => $request->input('status'),
                'user_id' => $request->input('user_id'),
                'slug' => Str::slug($request->input('setting_name'))
                
               
            ]);

            return response()->json([
                'success' => true,
                'data' => $settings,
                'message' => 'settings saved succesfully'
            ], 201);

        }
        
    }

    /*Edit request for a particular 
    settings by $id or $slug
    */
    public function settings_Edit(Request $request, $slug)
    {
        //
        // $settings = Settings::find();

        $settings = Settings::where('slug', $slug)->first();
        return response()->json([
            'success' => true,
            'data' => $settings
        ], 200);
        
    }

        /*Updating a particular
     settings by $id or $slug*/
     public function settings_Update(Request $request, $slug)
     {
         //
        // $settings = Settings::create($request->all());


         $settings = Settings::where('slug', $slug)->first();
        //  $settings->setting_name = $request->input('setting_name');
        //  $settings->status = $request->input('status');
         $settings->update($request->all());
      
         
         return response()->json([
             'success' => true,
             'data' => $settings,
             'message' => 'settings updated succesfully'
         ], 200);
       
     }

     public function settings_Delete(Request $request, $slug)
     {
         //
        // $settings = Settings::create($request->all());


         $settings = Settings::where('slug', $slug)->first();
        //  $settings->setting_name = $request->input('setting_name');
        //  $settings->status = $request->input('status');
         $settings->delete();
      
         
         return response()->json([
             null,
             'message' => 'settings deleted succesfully'
         ], 204);
       
     }




}
