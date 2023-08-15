<?php

namespace App\Http\Controllers\emr;

use App\Http\Controllers\Controller;
use App\Http\Requests\emr\PatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Ward;
use Buihuycuong\Vnfaker\VNFaker;
use App\Helpers\Helper;
use App\Models\Diagnosis;
use App\Models\GeneralClinical;
use App\Models\HospitalHistory;
use App\Models\Vital;
use Illuminate\Support\Facades\Session;
use App\Models\Appointment;

use function PHPUnit\Framework\isNull;

class PatientController extends Controller
{
    public $menuActive = 'patientMenu';
    public $childMenuActive = 'childPatientMenu';
    public function index(Request $request)
    {
        $menuActive = $this->menuActive;
        $childMenuActive = $this->childMenuActive;
        if(!empty($request->patient_id)){
            $all_patients = Patient::where('patient_id', $request->patient_id)->paginate(20)->withQueryString();
            return view('admin.patients.index', compact('all_patients', 'menuActive', 'childMenuActive'));
            
        }
        $all_patients = Patient::orderByDesc('id')->paginate(20)->withQueryString();
        return view('admin.patients.index', compact('all_patients', 'menuActive', 'childMenuActive'));
    }

    public function create($id = null)
    {
            $patientInfor = $id ? Appointment::find($id) : '';
            $menuActive = $this->menuActive;
            $childMenuActive = '';

            $ethnics = DB::table('ethnics')->orderBy('id')->get();
            $provinces = Province::all();
            $province = Province::first();
            $districts = $province->districts;
            $wards = Ward::first(); 
            return view('admin.patients.create', compact('patientInfor','ethnics', 'provinces', 'districts', 'menuActive', 'childMenuActive'));
        
    }
   
    public function loadDistrict(Request $request)
    {
        $city_id = $request->input('city_id');
        $districts = District::where('province_id', $city_id)->get();
        return response($districts, 200);
    }

    public function loadWard(Request $request)
    {
        $district_id = $request->input('district_id');
        $wards = Ward::where('district_id', $district_id)->get();
        return response($wards, 200);
    }

    public function searchPatient(Request $request){
        
        $patientInfor = $request->input('patient_infor');
        $patients = Patient::where('full_name', 'like', '%'.$patientInfor.'%')
        ->orWhere('patient_id', 'like', '%'.$patientInfor.'%')->get();
        return response($patients, 200);
    }

    public function loadPatientName(Request $request)
    {
        $patients = Patient::where('full_name', 'like', '%'.$request->full_name.'%')->orWhere('patient_id', 'like', '%'.$request->full_name.'%')->get();
        // dd($patients);
        if(count($patients) > 0) {
            $results = '';
            foreach($patients as $patient) {
                $results .= '<option value="'. $patient->patient_id .'">'. $patient->patient_id . '-' . $patient->full_name .'-'. Helper::getPatientAddress($patient->city_id, $patient->district_id, $patient->ward_id, $patient->home_address) .'</option>';
            }
            return $results;
        }
        return '<option value="">Không tìm thấy kết quả</option>';
    }

    public function store(PatientRequest $request)
    {
        $user_auth = auth()->user()->id;
        $patient_id = 'BN' . time();
        $params = [
            'patient_id' => $patient_id,
            'title' => $request->title,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'identity_number' => $request->identity_number,
            'phone_patient' => $request->phone_patient,
            'occupation' => $request->occupation,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'nationality' => $request->nationality,
            'ethnic_id' => $request->ethnic_id,
            'religion' => $request->religion,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'home_address' => $request->home_address,
            'marital_status' => $request->marital_status,
            'name_next_of_kin' => $request->name_next_of_kin,
            'home_next_of_kin' => $request->home_next_of_kin,
            'phone_next_of_kin' => $request->phone_next_of_kin,
            'type_of_object' => $request->type_of_object,
            'health_insurance_id' => $request->health_insurance_id,
            'health_insurance_date' => $request->health_insurance_date,
            'creator_id' => $user_auth,
            
        ];
        $new_patient = new Patient($params);
        if($new_patient->save()){
            return redirect()->route('patient.index')->withSuccess('Thêm bệnh nhân mới thành công.');
        }
        return redirect()->route('patient.index')->withErrors('Có lỗi, thử lại sau.');
    }
    public function selectpatient(Request $request,$id)
    { 
        $selectedpatient = Patient::where('id',$request->id)->get();
        if(!empty($selectedpatient)) {
            // $request->session()->put('id', $request->selected_patient);
            Session::put('patient_id', $selectedpatient[0]->id);
            return redirect()->route('patient.index');
        }
        if(isNull($selectedpatient)){
            Session::forget('patient_id');
            return redirect()->route('patient.index'); 
        }
    }

    public function edit($id)
    {
        $menuActive = $this->menuActive;
        $childMenuActive = '';
        $ethnics = DB::table('ethnics')->orderBy('id')->get();
        $patient = Patient::findOrFail($id);
        $province_id = $patient->city_id;
        $district_id = $patient->district_id;
        $provinces = Province::all();
        $districts = District::where('province_id', $province_id)->get();
        $wards = Ward::where('district_id', $district_id)->get();
        return view('admin.patients.edit', compact('ethnics', 'provinces', 'districts', 'wards', 'patient', 'menuActive', 'childMenuActive'));
    }

    public function update(PatientRequest $request, $id)
    {
        $user_auth = auth()->user()->id;
        $params = [
            'title' => $request->title,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'identity_number' => $request->identity_number,
            'phone_patient' => $request->phone_patient,
            'occupation' => $request->occupation,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'nationality' => $request->nationality,
            'ethnic_id' => $request->ethnic_id,
            'religion' => $request->religion,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'home_address' => $request->home_address,
            'marital_status' => $request->marital_status,
            'name_next_of_kin' => $request->name_next_of_kin,
            'home_next_of_kin' => $request->home_next_of_kin,
            'phone_next_of_kin' => $request->phone_next_of_kin,
            'type_of_object' => $request->type_of_object,
            'health_insurance_id' => $request->health_insurance_id,
            'health_insurance_date' => $request->health_insurance_date,
            'creator_id' => $user_auth,
        ];
        
            if(!empty(Patient::where('id', $id)->first())){
                try{
                    Patient::where('id', $id)->update($params);
                    return redirect()->route('patient.index')->withSuccess('Cập nhật bệnh nhân thành công');
                } catch(\Exception $err){
                    return redirect()->route('patient.edit')->withErrors($err->getMessage());
                }
                return redirect()->route('patient.index')->withErrors('Không tìm thấy bệnh nhân');
            }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $account = Patient::where('id', $id)->first();
        if($account) {
            $patient_id = $account->patient_id;
            // DB::transaction();
            try {
                $history = HospitalHistory::where('patient_id', $patient_id)->get();
                $vitals = Vital::where('patient_id', $patient_id)->get();
                $generals = GeneralClinical::where('patient_id', $patient_id)->get();
                $diagnosis = Diagnosis::where('patient_id', $patient_id)->get();
                $lab_result = DB::table('lab_result')->where('patient_id', $patient_id)->get();
                $imaging_result = DB::table('imaging_result')->where('patient_id', $patient_id)->get();
                $subclinical_services = DB::table('subclinical_service')->where('patient_id', $patient_id)->get();
                if (!empty($history)) {
                    HospitalHistory::where('patient_id', $patient_id)->delete();
                }
                if (!empty($vitals)) {
                    Vital::where('patient_id', $patient_id)->delete();
                }
                if (!empty($generals)) {
                    GeneralClinical::where('patient_id', $patient_id)->delete();
                }
                if (!empty($diagnosis)) {
                    Diagnosis::where('patient_id', $patient_id)->delete();
                }
                if (!empty($lab_result)) {
                    DB::table('lab_result')->where('patient_id', $patient_id)->delete();
                }
                if (!empty($imaging_result)) {
                    DB::table('imaging_result')->where('patient_id', $patient_id)->delete();
                }
                if (!empty($subclinical_services)) {
                    DB::table('subclinical_service')->where('patient_id', $patient_id)->delete();
                }
                if(session()->get('patient_id') == $patient_id) {
                    Session::forget('patient_id');
                }
                
                Patient::destroy($id);
                // DB::commit();
                return response()->json([
                    'error' => false,
                    'message' => 'Xóa Thành Công'
                ]);

            }
            catch (\Exception $err) {
                // DB::rollback();
                return response()->json([
                    'error' => true,
                    'message' => $err->getMessage(),
                ]);
            }
            // Patient::destroy($id);
            // return response()->json([
            //     'error' => false,
            //     'message' => 'Xóa Thành Công'
            // ]);
        }

        return response()->json([
            'error' => true,
        ]);
    }
}
