@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            <div class="row " style=" margin-bottom: 20px; margin-left:10px">
                <label for ="search" style="display: flex; align-items: center;"></label>
                    <input type="text" name="search" id="searchh" value="" placeholder="   Tìm kiếm bằng SĐT, Tên, Ngày khám (yyyy/mm/dd)" style="width: 500px; height:40px; margin-right: 10px; border-radius: 25px;">
                    <button id="search-submit" class="btn btn-primary" style= " color:white">Tìm kiếm</button>
            <div class="row " style=" margin-left: 100px">
                <a href="{{ url('emr/appointment/create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm lịch khám
                </a>
            </div>
            </div><!-- /.row -->
                @include('admin.layouts.alert')
                <!-- Main content -->
                <div class="row">
                    <div class="col-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            
                            <li class="nav-item">
                              <a class="nav-link" id="appointment-tab-first">Tất cả lịch khám {{--({{( !empty($appointments) ? count($appointments) : '0' )}})--}}</a>
                            </li>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="appointment-tab-second">Đã xác nhận{{--({{ !empty($appointmentsAccepted) ? count($appointmentsAccepted) : '0' }})--}}</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="appointment-tab-third">Chưa xác nhận {{--({{( !empty($appointments) ? count($appointments) : '0' )}})--}}</a>
                            </li>
                            
                          </ul>
                        </div>
                        <div class="card-body">
                        
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                          
                            <div>
                                <!-- Appointment content -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <!-- <h3 class="card-title">Tất cả cuộc hẹn</h3> -->

                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0 loadAjax">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:15px">ID</th>
                                                            <th>@lang('Họ và tên')</th>
                                                            <th>@lang('Số điện thoại')</th>
                                                            <th>@lang('Ngày hẹn')</th>
                                                            <th>@lang('Thời gian')</th>
                                                            <th>@lang('Phòng')</th>
                                                            <th>@lang('Bác sĩ')</th>
                                                            <th>@lang('Status')</th>
                                                            <th>@lang('Updated at')</th>
                                                            <th>@lang('Action')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id ='appointment-all'>
                                                    
                                                                                                                    
                                                            <tr>
                                                                <td colspan="6">Không có kết quả</td>
                                                            </tr> 
                                                        
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- @if (count($paginateVerifieds) != 0)
                                                {{ $paginateVerifieds->links() }}
                                            @endif --}}
                                            <!-- /.card-body -->
                                        </div>

                                        <!-- /.card -->
                                    </div>
                                </div>
                                <!-- /.content -->
                            </div>
                            </div>
                            
                            </div>
                        <!-- /.card -->
                      </div>
                    </div>
                </div>
                <!-- /.content -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
@endsection