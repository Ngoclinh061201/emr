<?php

namespace App\Http\Controllers\CMS;

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

class BlogController extends Controller {
 public function index (){
 return view ('web.blog.index');
 }

}