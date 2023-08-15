<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\emr\AccountController;
use App\Http\Controllers\emr\AppointmentController;
use App\Http\Controllers\emr\DashboardController;
use App\Http\Controllers\emr\DiagnosisController;
use App\Http\Controllers\emr\GeneralClinicalController;
use App\Http\Controllers\emr\HospitalHistoryController;
use App\Http\Controllers\emr\ImagingResultController;
use App\Http\Controllers\emr\LabResultController;
use App\Http\Controllers\emr\PatientController;
use App\Http\Controllers\emr\PdfController;
use App\Http\Controllers\emr\PermissionController;
use App\Http\Controllers\emr\summaryemr;
use App\Http\Controllers\emr\SummaryEmrController;
use App\Http\Controllers\emr\VitalController;
use App\Http\Controllers\LangController;
use App\Mail\Appointment as MailAppointment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMS\BlogController;
use App\Http\Controllers\CMS\PostController;
use phpDocumentor\Reflection\PseudoTypes\True_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/lang/{lang}', [LangController::class, 'changeLang'])->name('lang');

/** -------Web----------- */
Route::get('/home', function() {
    $homeActive = 'homeActive';
    return view('web.home', compact('homeActive'));
});
    # Load ajax time List
Route::get('/loadTimeList', function(Request $request){
    if(!empty($request->value)) {
        if($request->value == date('Y-m-d')) {
            $time_today = true;
        } else {
            $time_today = false;
        }
        $appointment_times = [];
        $timeList = '<option value="">Thời gian</option>';
        
        $appointment_date = Appointment::where('date', $request->value)->get();
        if (!empty($appointment_date)) {
            foreach($appointment_date as $date) {
                array_push($appointment_times, $date->time);
            }
        }

        $timeList .= '<option'; 
        if (in_array('08:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '08:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="08:00">08:00 Sáng</option>';

        $timeList .= '<option'; 
        if (in_array('09:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '09:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="09:00">09:00 Sáng</option>';

        $timeList .= '<option'; 
        if (in_array('10:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '10:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="10:00">10:00 Sáng</option>';

        $timeList .= '<option'; 
        if (in_array('11:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '11:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="11:00">11:00 Sáng</option>';

        $timeList .= '<option'; 
        if (in_array('13:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '13:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="13:00">13:00 Chiều</option>';

        $timeList .= '<option'; 
        if (in_array('14:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '14:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="14:00">14:00 Chiều</option>';

        $timeList .= '<option'; 
        if (in_array('15:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '15:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="15:00">15:00 Chiều</option>';
        
        $timeList .= '<option'; 
        if (in_array('16:00:00', $appointment_times) || ($time_today && (strtotime('now') > strtotime($request->value . '16:00:00')))) {
            $timeList .= ' hidden="true"';
        }
        $timeList .= ' value="16:00">16:00 Chiều</option>';

        return response()->json([
            'error' => true,
            'message' => $timeList,
        ]);
    } else {
        response()->json([
            'error' => false,
            'message' => '<option value="">Thời gian</option>',
        ]);
    }
});
/** --------End Web ---------*/

# Auth
Route::get('/login', [AuthController::class, 'index'])->name('auth.login.get');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout.post');

# Reset password
Route::get('/forgot-password', [ResetPasswordController::class, 'showForgetPasswordForm'])->name('auth.forgot.get');
Route::post('/forgot-password', [ResetPasswordController::class, 'submitForgetPasswordForm'])->name('auth.forgot.post');
Route::get('/recovery-password/{token}', [ResetPasswordController::class, 'showRecoveryPasswordForm'])->name('auth.recovery.get');
Route::post('/recovery-password', [ResetPasswordController::class, 'submitRecoveryPasswordForm'])->name('auth.recovery.post');

Route::get('/', [DashboardController::class, 'index'])->name('emr.dashboard');

# CMS
Route::prefix('/cms')->middleware(['auth'])->group(function(){
    route::prefix('/post')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/create', [PostController::class, 'create']);
        Route::post('/store', [PostController::class, 'store']);
        Route::get('/{id}/edit', [PostController::class, 'edit']);
        Route::post('/{id}/update', [PostController::class, 'update']);
        Route::get('/{id}/delete', [PostController::class, 'destroy']);
    });
   
});

# EMR 
Route::prefix('emr')->middleware(['auth'])->group(function(){
    # Route patients
    Route::prefix('/patient')->middleware(['role:Super Admin|Doctor|Nurse'])->controller(PatientController::class)->group(function(){
        Route::get('/', 'index')->name('patient.index');
        Route::get('/add', 'create')->name('patient.create');
        Route::post('/add', 'store')->name('patient.store');
        Route::get('/select/{id}', 'selectpatient');
        Route::get('/edit/{id}', 'edit')->name('patient.edit');
        Route::post('/{id}', 'update')->name('patient.update');
        Route::get('/add/loadDistrict', 'loadDistrict');
        Route::get('/add/loadWard', 'loadWard');
        Route::get('/search','searchPatient');
        Route::delete('/destroy', 'destroy');
        Route::get('/{id}/add', 'create');
    });
    # Search ajax Patient
    Route::middleware(['role:Super Admin|Doctor|Nurse|Technicians'])->controller(PatientController::class)->group(function(){
        Route::get('/patient/loadPatientName', 'loadPatientName');
    });

    Route::prefix('/hospital-history')->middleware(['role:Super Admin|Doctor|Nurse'])->controller(HospitalHistoryController::class)->group(function(){
        Route::get('/', 'create')->name('hospital-history.create');
        Route::post('/', 'store')->name('hospital-history.store');
    });
    Route::prefix('/vital')->middleware(['role:Super Admin|Doctor'])->controller(VitalController::class)->group(function(){
        Route::get('/', 'create')->name('vital.create');
        Route::post('/', 'store')->name('vital.store');
    });
    Route::prefix('/generalclinical')->middleware(['role:Super Admin|Doctor'])->controller(GeneralClinicalController::class)->group(function(){
        Route::get('/', 'create')->name('generalclinical.create');
        Route::post('/', 'store')->name('generalclinical.store');
    });
    Route::prefix('/labresult')->middleware(['role:Super Admin|Technicians'])->controller(LabResultController::class)->group(function(){
        Route::get('/', 'create')->name('labresult.create');
        Route::post('/', 'store')->name('labresult.store');
        
        Route::post('/selectclinicalpatient', 'selectSubclinicalPatient')->name('patient.selectclinicalpatient');
    });

    Route::prefix('/imagingresult')->middleware(['role:Super Admin|Technicians'])->controller(ImagingResultController::class)->group(function(){
        Route::get('/', 'create')->name('imagingresult.create');
        Route::post('/', 'store')->name('imagingresult.store');
        Route::post('/imageclinicalpatient', 'imageSubclinicalPatient')->name('patient.imageclinicalpatient');

    });
    Route::prefix('/diagnosis')->middleware(['role:Super Admin|Doctor'])->controller(DiagnosisController::class)->group(function(){
        Route::get('/', 'create')->name('diagnosis.create');
        Route::post('/', 'store')->name('diagnosis.store');
    });
    Route::prefix('/summaryemr')->middleware(['role:Super Admin|Doctor'])->controller(SummaryEmrController::class)->group(function(){
        Route::get('/', 'index')->name('summaryemr.index');
    });

    Route::prefix('/pdf')->middleware(['role:Super Admin|Doctor'])->controller(PdfController::class)->group(function(){
        Route::get('/', 'index')->name('pdf.index');
    });
    

    # Route Account
    Route::prefix('/account')->middleware(['role:Super Admin|Admin'])->controller(AccountController::class)->group(function(){
        Route::get('/', 'index')->name('account.index');
        Route::get('/add', 'create')->name('account.create');
        Route::post('/add', 'store')->name('account.store');
        Route::get('/{id}/edit', 'edit')->name('account.edit');
        Route::put('/{id}', 'update')->name('account.update');
        Route::delete('/destroy', 'destroy');
    });

    # Route Permission
    Route::prefix('/permission')->middleware(['role:Super Admin|Admin'])->controller(PermissionController::class)->group(function(){
        Route::get('/', 'index')->name('permission.index');
        Route::get('/add', 'create')->name('permission.create');
        Route::post('/add', 'store')->name('permission.store');
        Route::get('/{id}/edit', 'edit')->name('permission.edit');
        Route::get('/{id}', 'show')->name('permission.show');
        Route::put('/{id}', 'update')->name('permission.update');
        Route::delete('/destroy', 'destroy');
    });

    # Route Appointments
    Route::prefix('/appointment')->middleware(['role:Super Admin|Doctor|Nurse|Receptionist'])->controller(AppointmentController::class)->group(function(){
        // Route::get('/', 'showPatientAccepted')->name('appointment.showPatientAccepted');
        Route::get('/','show');
        Route::get('/create', 'create');
       
        Route::post('/', 'storee');
        Route::get('/accepted', 'showAppointmentAccepted');
        Route::get('/search', 'searchPhone');
        Route::get('/{id}/edit', 'edit');
        Route::put('/{id}', 'update');
        Route::get('/{id}/destroy', 'destroy');
        Route::get('/pending', 'showPatientPending')->name('appointment.showPatientPending');
        Route::post('/add', 'store')->name('appointment.store');
        Route::post('/add/patient', 'addNewPatient')->name('addpatient.addNewPatient');
       
        
        Route::get('/{id}', 'show')->name('appointment.show');
        Route::delete('/{id}', [AppointmentController::class, 'destroy']);
    });
 });

# Route Appointments Patient side
Route::prefix('/appointmentPatient')->group(function(){
    Route::get('/', [AppointmentController::class, 'index'])->name('appointmentPatient.index');
    Route::post('/add', [AppointmentController::class, 'store'])->name('appointmentPatient.store');

    Route::get('/add/{token}', [AppointmentController::class, 'appointmentProcess'])->name('appointmentPatient.verified.get');
    // Route::put('/add/{token}', [AppointmentController::class, 'emailVerified'])->name('appointmentPatient.verified.post');
   
        
});



