<?php

namespace App\Http\Controllers\emr;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\emr\appointment\AppointmentRequest;
use App\Mail\Appointment as MailAppointment;
use App\Models\Patient;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Helpers;
use App\Helpers\Helper;

class AppointmentController extends Controller
{
    private $result;
    public $menuActive = 'appointmentMenu';
    public $childMenuActive = 'childNewAppointmentMenu';

    public function show (Request $request ){
        $flag = $request->input('flag');

        if($flag){
           
            $appointments = DB::table('appointments')->orderByDesc('updated_at')->latest()->get();
            return response($appointments, 200);
            
        }
        else{
               
            return view('admin.appointments.index');
        }

    }
    public function searchPhone(Request $request){
        $input= $request->input('flag');
        if(!empty($input)){
            $appointments = DB::table('appointments')
            ->where('phone', 'like', '%' . $input . '%')
            ->orWhere('name', 'like', '%' . $input . '%')
            ->orWhere('date', 'like', '%' . $input . '%')
            ->orderByDesc('date')->latest()->get();
            return response($appointments, 200);
            
        }
        
    }
    public function showAppointmentAccepted(Request $request){
        
        $flag = $request->input('flag');
        if($flag==1){
            $appointments = DB::table('appointments')->where('status', 1)->orderByDesc('date')->latest()->get();
        }else 
        {
            $appointments = DB::table('appointments')->where('status', 0)->orderByDesc('date')->latest()->get();
        }
       
        return response($appointments, 200);
        // return view('admin.appointments.index', compact('appointments') );

    }
    public function create()
    {
      
        return view('admin.appointments.add');
    }
    
    public function storee(AppointmentRequest $appointmentRequest){
        dd('â');
        $appointment = new Appointment();
        $appointment->name = $appointmentRequest->name;
        $appointment->phone = $appointmentRequest->phone;
        $appointment->date = $appointmentRequest->date;
        $appointment->time = $appointmentRequest->time;
        $appointment->room = $appointmentRequest->room;
        $appointment->doctor = $appointmentRequest->doctor;
        $appointment->status = $appointmentRequest->status;
        $appointment->save();
       
        return redirect('emr/appointment')->with('success', 'Add successfully');
    }
    public function edit($id)
    {
            $appointment=Appointment::find($id);
            
            return view('admin.appointments.edit', compact('appointment'));
    }

    public function store(AppointmentRequest $appointmentRequest)
    {
        
        $now = strtotime('now');
        $date_appointment = strtotime($appointmentRequest->date . $appointmentRequest->time);
        if ($now > $date_appointment) {
            return redirect()->route('appointmentPatient.add')->withErrors('Thời gian cuộc hẹn không hợp lệ');
        }
        if(!empty($appointmentRequest->services)) {
            $services = implode(', ', $appointmentRequest->services);
        } else {
            $services = '';
        }
        // try{
        //     DB::beginTransaction();
        //     Appointment::create([
        //         'name' => $appointmentRequest->name,
        //         'phone' => $appointmentRequest->phone,
        //         'date' => $appointmentRequest->date,
        //         'time' => $appointmentRequest->time,
        //         'services' => $services,
        //         'more_info' => $appointmentRequest->more_info,
        //         'email' => $appointmentRequest->mail,
        //     ]);
        //     // $new_appointment = Appointment::where('token', $token)->first();
        //     // if(!empty($new_appointment)){
        //     //     Mail::to($appointmentRequest->email)->send(new MailAppointment($new_appointment));
        //     // }
      
            
        // } catch(\Exception $err) {
        //     DB::rollBack();
        //     dd ('aa');
        //     return redirect()->route('appointmentPatient.index')->withErrors($err->getMessage());
        $appointment = new Appointment();
        $appointment->name = $appointmentRequest->name;
        $appointment->phone = $appointmentRequest->phone;
        $appointment->date = $appointmentRequest->date;
        $appointment->time = $appointmentRequest->time;
        $appointment->services = $services;
        $appointment->more_info = $appointmentRequest->more_info;
        $appointment->email = $appointmentRequest->email;
        $appointment->status = '0';
        $appointment->save();
       
        return redirect()->route('appointmentPatient.index')->with('success','Nhận cuộc gọi từ lễ tân để xác nhận đặt lịch thành công');

    }
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        $appointment->name = $request->name;
        $appointment->phone = $request->phone;
        $appointment->date = $request->date;
        $appointment->time= $request->time;
        $appointment->room = $request->room;
        $appointment->doctor = $request->doctor;
        $appointment->status = $request->status;
        $appointment->update();
        return redirect('emr/appointment')->with('success', 'Edit successfully');
    }

    public function destroy (Request $request, $id)  
    {     
        $appointment = Appointment::find($id);
        $appointment->delete();
        return redirect('emr/appointment')->with('success', 'Delete successfully');
    }
    
    public function showPatientAccepted()
    {   
        $menuActive = $this->menuActive;
        $childMenuActive = $this->childMenuActive;
        return view('admin.appointments.homeVerified', [
            'appointmentVerifieds' => Appointment::where('email_verified_at', '!=', null)->orderByDesc('updated_at')->paginate(10)->withQueryString(),
            'menuActive' => $menuActive,
            'childMenuActive' => $childMenuActive,
        ]);
    }

    public function showPatientPending()
    {
        // dd(count(Appointment::where('email_verified_at', '!=', null)->get()));
        $menuActive = $this->menuActive;
        $childMenuActive = 'childPendingAppointmentMenu';
        return view('admin.appointments.home', [
            'paginatePendings' => Appointment::where('email_verified_at', null)->orderByDesc('created_at')->paginate(10)->withQueryString(),
            'appointmentPendings' => Appointment::where('email_verified_at', null)->get(),
            'paginateVerifieds' => Appointment::where('email_verified_at', '!=', null)->orderByDesc('updated_at')->get(),
            'appointmentVerifieds' => Appointment::where('email_verified_at', '!=', null)->get(),
            'menuActive' => $menuActive,
            'childMenuActive' => $childMenuActive,
        ]);
    }

    public function index()
    {
        $generalInfoActive = 'generalInfoActive';
        $appointmentActive = 'appointmentActive';
        return view('web.appointment.index', compact('generalInfoActive', 'appointmentActive'));
   
        
    }
    
    

    public function checkTimeOut($createdTokenTime)
    {
        if(time() - strtotime($createdTokenTime) <= 60*5) {
            return true;
        } 
        return false;
    }
    // Xử lý đặt lịch và hiển thị kết quả
    public function appointmentProcess($token)
    {
        $generalInfoActive = 'generalInfoActive';
        $appointmentActive = 'appointmentActive';
        $appointment = Appointment::where('token', $token)->where('email_verified_at', null);
        if(!empty($appointment->first())){
            if($this->checkTimeOut($appointment->first()->created_at)){
                try{
                    $update = $appointment->update(['email_verified_at' => Carbon::now()]);
                    Session::flash('success', 'Đặt lịch thành công');
                } catch(\Exception $err) {
                    Session::flash('error', $err->getMessage());
                }   
                return view('client.appointment.appointmentverified', compact('generalInfoActive', 'appointmentActive'));
            } else {
                return view('client.appointment.appointmentverified', [
                    'timeout' => 'Link hết hạn',
                    'generalInfoActive' => $generalInfoActive,
                    'appointmentActive' => $appointmentActive,
                ]);
            }
        } else {
            return abort(404);
        }
    }

    public function addNewPatient(Request $request)
    {
        $checkExistPatient = Patient::where('email', $request->get('email'))->get();
        $validated = $request->validate([
            'full_name' => ['required','max:255'],
            'email' => ['required', 'email'],
            'phone_patient' => ['bail', 'required', 'numeric'],
            'identity_number' => ['bail', 'required', 'min:12', 'max:12'],
        ]);
        $checkExistPatient = Patient::where('email', $request->get('email'))->first();
        // Nếu bệnh nhân đã tồn tại
        if(!empty($checkExistPatient)) {
            $message = 'Bệnh nhân có địa chỉ email: '.$checkExistPatient->email.' đã tồn tại: '. Helper::getPatientInfo($checkExistPatient->patient_id);
            return redirect()->route('appointment.showPatientAccepted')->withErrors($message);
        }

        // Nếu là bệnh nhân mới
        if($validated) {
            $patient_id = 'BN' . time();
            $params = [
                'patient_id' => $patient_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'identity_number' => $request->identity_number,
                'phone_patient' => $request->phone_patient,
                'sex' => $request->sex,
            ]; 
            $new_patient = new Patient($params);
            if($new_patient->save()){
                $id = Patient::where('email', $request->get('email'))->first()->id;
                return redirect()->route('patient.edit', $id)->withSuccess('Thêm bệnh nhân mới thành công. Cập nhật thêm thông tin');
            }
            return redirect()->route('appointment.showPatientAccepted')->withErrors('Có lỗi, thử lại sau.');
        }
    }

    
}
