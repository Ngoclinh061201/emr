<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('emr.dashboard') }}" class="brand-link">
      {{-- <img src="{{ asset('assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-original-577x577/s3/062013/emr_emergency_medical_response_logo.png?itok=FM5CTCE4" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">EMR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          {{-- <img src="{{ asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image"> --}}
          <img src="https://media.istockphoto.com/photos/happy-healthcare-practitioner-picture-id138205019?k=20&m=138205019&s=612x612&w=0&h=KpsSMVsplkOqTnAJmOye4y6DcciVYIBe5dYDgYXLVW4=" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          {{-- Quản lý hành chính --}}
          @hasanyrole('Super Admin|Nurse|Doctor')
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-hospital-user"></i>
                {{-- <i class="nav-icon far fa-hospital-user"></i> --}}
                <p>
                  Quản lý bệnh nhân
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('patient.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <i class="nav-icon fas fa-user-injured"></i>
                    <p>Danh sách bệnh nhân</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('hospital-history.create') }}" class="nav-link">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Quá trình khám bệnh</p>
                  </a>
                </li>
              </ul>
            </li>
          @endhasanyrole

          <!-- Khám bệnh và điều trị -->
          @hasanyrole('Super Admin|Doctor|Technicians')
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-procedures"></i>
                {{-- <i class="nav-icon fas fa-user-circle"></i> --}}
                <p>
                  Quản lý bệnh án
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              @hasanyrole('Super Admin|Doctor')
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('vital.create') }}" class="nav-link">
                      <i class="nav-icon fas fa-heartbeat"></i>
                      <p>Sinh hiệu</p>
                    </a>
                  </li>
                </ul>
              
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('generalclinical.create') }}" class="nav-link">
                      <i class="nav-icon fas fa-stethoscope"></i>
                      <p>Lâm sàng tổng quát</p>
                    </a>
                  </li>
                </ul>
              @endhasanyrole
              @hasanyrole('Super Admin|Technicians')
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('labresult.create') }}" class="nav-link">
                    <i class="nav-icon fas fa-vial"></i>
                    <p>Xét nghiệm</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('imagingresult.create') }}" class="nav-link">
                    <i class="nav-icon fas fa-photo-video"></i>
                    <p>Nhập kết quả CĐHA</p>
                  </a>
                </li>
              </ul>
              @endhasanyrole
              @hasanyrole('Super Admin|Doctor')
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('diagnosis.create') }}" class="nav-link">
                      <i class="nav-icon fas fa-diagnoses"></i>
                      <p>Chẩn đoán hình ảnh</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('summaryemr.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-book"></i>
                      <p>Tổng kết bệnh án</p>
                    </a>
                  </li>
                </ul>
              @endhasanyrole
            </li>
          @endhasanyrole

          {{-- Quản lý Account --}}
          @hasanyrole('Super Admin|Admin')
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                {{-- <i class="nav-icon fas fa-bars"></i> --}}
                <i class="nav-icon fas fa-user-circle"></i>
                <p>
                  @lang('Account Management')
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('account.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>@lang('Account List')</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('permission.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>@lang('List of permission group')</p>
                  </a>
                </li>

              </ul>
            </li>
          @endhasanyrole

          {{-- Quản lý Lịch Hẹn --}}
          @hasanyrole('Super Admin|Nurse|Receptionist')
            <li class="nav-item menu-open">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                  @lang('Quản lý lịch khám')
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                {{-- @hasanyrole('Super Admin|Doctor')
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    <p>@lang('New Appointment')</p>
                  </a>
                </li> --}}
                {{-- @endhasanyrole --}}
                @hasanyrole('Super Admin|Nurse|Receptionist')
                  <li class="nav-item" id="appointment-all-sidebar">
                    <a href="{{url('emr/appointment')}}" class="nav-link">
                      <i class="nav-icon fas fa-exchange-alt"></i>
                      <p>@lang('Tất cả lịch khám')</p>
                      
                    </a>
                  </li>
                  
                  
                @endhasanyrole
              </ul>
            </li>
          @endhasanyrole

          @hasanyrole('Super Admin|Writer')
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                @lang('Quản lý bài viết')
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @hasanyrole('Super Admin|Writer')
                <li class="nav-item" id="appointment-all-sidebar">
                  <a href="{{url('cms/post')}}" class="nav-link">
                    <i class="nav-icon fas fa-exchange-alt"></i>
                    <p>@lang('Tất cả bài viết')</p>
                    
                  </a>
                </li>
              @endhasanyrole
            </ul>
          </li>
        @endhasanyrole

          {{-- Đăng xuất --}}
          <li class="nav-item menu-open mb-5">
            <form action="{{ route('auth.logout.post') }}" method="post">
              @csrf
              <button type="submit" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  @lang('Log out')
                </p>
              </button>
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>