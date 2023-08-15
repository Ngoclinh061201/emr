@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Chỉnh sửa lịch khám</h1>
                    </div>
                    <div class="col-sm-9">
                        <a href="{{ url('emr/appointment') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-left"></i>   Trở về
                        </a>
                    </div>
                </div><!-- /.row -->

                @include('admin.layouts.alert')

                <!-- Main content -->
            
                <div class="modal-body">
                        <form action="{{ url('emr/appointment/'.$appointment->id) }}" method="POST" class="form" id="form-1">
                            @method('PUT')
                            @csrf
                            <div class="spacer"></div>
                    
                            <div class="row">
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="fullname" class="form-label">Họ và Tên<span class="mandatory"> </span></label>
                                    <input id="fullname" name="name" type="text" class="form-control" value = "{{$appointment->name}}">
                                    <span class="form-message"></span>
                                </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone-number" class="form-label">Điện thoại<span class="mandatory"></span></label>
                                        <input id="phone-number" name="phone" type="text" class="form-control" value = "{{ $appointment->phone }}">
                                        <span class="form-message"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="formDate" class="form-label">Ngày khám<span class="mandatory"> </span></label>
                                    <input id="date" name="date" type="text" class="form-control" value =" {{$appointment->date}}">
                                    <span class="form-message"></span>
                                </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="formTimes" class="form-label">Thời gian<span class="mandatory"></span></label>
                                        <input id="time" name="time"type="text" class="form-control"  value =" {{$appointment->time}}">
                                        <span class="form-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="formDate" class="form-label">Số phòng<span class="mandatory"> </span></label>
                                    <input id="room" name="room" type="text" class="form-control" value =" {{$appointment->room}}">
                                    <span class="form-message"></span>
                                </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="formTimes" class="form-label">Bác sĩ<span class="mandatory"></span></label>
                                        <input id="doctor" name="doctor"  type="text" class="form-control" value =" {{$appointment->doctor}}">
                                        <span class="form-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="formDate" class="form-label">Trạng thái<span class="mandatory"> </span></label>
                                    <select name="status" id="formTimes" class="form-control" value ="{{$appointment->status}}">
                                            <option value="0"> Chưa xác nhận </option>
                                            <option value="1"> Đã xác nhận </option>
                                        </select>
                                </div>
                                </div>
                                
                            </div>
                   
                            
                            <button type="submit" class="btn btn-primary btn-submit-form"><i class="fas fa-plus"></i> @lang('Update')</button>
                            <button type="reset" class="btn btn-danger btn-sm">
                         <i class="fa fa-ban"></i> Reset</button>
                    
                        </form>
                    </div>
                </div>
                <!-- /.content -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

    </div>
@endsection