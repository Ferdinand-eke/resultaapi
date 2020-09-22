<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
ADMIN OPERATIONS
STARTS HERE
*/
//settings crud
Route::get('admin/settings', 'Admin\SettingsController@settings_List');
Route::post('admin/settings/save', 'Admin\SettingsController@settings_Save');

Route::get('admin/settings/edit/{slug}', 'Admin\SettingsController@settings_Edit');
Route::put('admin/settings/update/{slug}', 'Admin\SettingsController@settings_Update');
Route::delete('admin/settings/delete/{slug}', 'Admin\SettingsController@settings_Delete');


//Adnission crud
Route::get('admin/admissions', 'Admin\AdmissionsController@admin_ListAdmissions');
Route::post('admin/admissions/save', 'Admin\AdmissionsController@admin_SaveAdmission');

Route::get('admin/admissions/edit/{slug}', 'Admin\AdmissionsController@admin_EditAdmission');
Route::put('admin/admissions/update/{slug}', 'Admin\AdmissionsController@admin_UpdateAdmission');
Route::delete('admin/admissions/delete/{slug}', 'Admin\AdmissionsController@admin_DeleteAdmission');

//Registration_Form crud
Route::get('admin/regforms', 'Admin\RegFormController@admin_ListRegForms');
Route::post('admin/regforms/save', 'Admin\RegFormController@admin_SaveRegForm');

Route::get('admin/regforms/edit/{slug}', 'Admin\RegFormController@admin_EditRegForm');
Route::put('admin/regforms/update/{slug}', 'Admin\RegFormController@admin_UpdateRegForm');
Route::delete('admin/regforms/delete/{slug}', 'Admin\RegFormController@admin_DeleteRegForm');


/**========================================
 * || NEW ROUTES HERE MOFIFICATIONS starts||
   ========================================*/
//*** MY Redesign Routes starts*** */
//CREATING ADMISSIONS
//==========recent here===========//
Route::get('admin/admissionsreg/list', 'ManageAdmissions\ManageAdmController@admin_ListAdmissionsReg');
Route::post('admin/admissionsreg/save', 'ManageAdmissions\ManageAdmController@admin_StoreAdmissionReg');

Route::get('admin/admissionsreg/edit/{slug}', 'ManageAdmissions\ManageAdmController@admin_EditAdmissionReg');
Route::put('admin/admissionsreg/update/{slug}', 'ManageAdmissions\ManageAdmController@admin_UpdateAdmissionReg');
Route::delete('admin/admissionsreg/delete/{slug}', 'ManageAdmissions\ManageAdmController@admin_DeleteAdmissionReg');

//CREATING FORM FIELDS
Route::get('admin/formfields/list', 'ManageAdmissions\FormFieldsController@admin_ListFormFields');
Route::post('admin/formfields/save', 'ManageAdmissions\FormFieldsController@admin_StoreFormFields');

Route::get('admin/formfields/edit/{slug}', 'ManageAdmissions\FormFieldsController@admin_EditFormFields');
Route::put('admin/formfields/update/{slug}', 'ManageAdmissions\FormFieldsController@admin_UpdateFormField');
Route::delete('admin/formfields/delete/{slug}', 'ManageAdmissions\FormFieldsController@admin_DeleteFormField');

//CREATING APPLICATION SUBMISSIONS ROUTES
Route::get('admin/application/submissions/list', 'ManageAdmissions\SubmissionsController@admin_SubmissionsList');
Route::post('admin/application/submissions/receive', 'ManageAdmissions\SubmissionsController@admin_ReceiveApplication');
Route::put('admin/application/forms/complete/registration/{admission_slug}/{cand_slug}', 'ManageAdmissions\SubmissionsController@admin_UserCompleteApplication');


Route::get('admin/application/submissions/edit/{slug}', 'ManageAdmissions\SubmissionsController@admin_EditSubmissions');
Route::put('admin/application/submissions/update/{slug}', 'ManageAdmissions\SubmissionsController@admin_UpdateSubmissions');
Route::delete('admin/application/submissions/delete/{slug}', 'ManageAdmissions\SubmissionsController@admin_DeleteSubmissions');

//================user_CompleteReg=====================//


/**========================================
 * || NEW ROUTES HERE MOFIFICATIONS ends||
   ========================================*/

//submitting admissions admission registration forms

Route::get('admin/admissionsreg/forms/list', 'ManageAdmissions\ManageFormsController@admin_ListAdmissionRegForms');
Route::post('admin/admissionsreg/forms/que', 'ManageAdmissions\ManageFormsController@admin_QueAdmissionRegForm');

Route::get('admin/admissionsreg/forms/edit/{slug}', 'ManageAdmissions\ManageFormsController@admin_EditAdmissionReg');
Route::put('admin/admissionsreg/forms/update/{slug}', 'ManageAdmissions\ManageFormsController@admin_UpdateAdmissionRegForm');
Route::delete('admin/admissionsreg/forms/delete/{slug}', 'ManageAdmissions\ManageFormsController@admin_DeleteAdmissionRegForm');

Route::put('admin/admissionsreg/forms/complete/registration/{admission_slug}/{cand_slug}', 'ManageAdmissions\ManageFormsController@user_CompleteAdmissionReg');

//*** MY Redesign Routes ends*** */



/*
ADMIN OPERATIONS
ENDS HERE
*/


