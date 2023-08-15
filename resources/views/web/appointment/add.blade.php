!DOCTYPE html>
<html lang="en">

@include('web.layouts.head')

<body>
    <header class="BgScrollEffect about-us">
        <div class="BackgroundImage"></div>
        
        <!-- Include navbar -->
        @include('web.layouts.navbar')

        <div class="container WrapContent">
            <div class="ContentOnBackGround ElementScrollEffect right">
                <h5 class="heading--sub">Giới thiệu</h5>
                <span class="dash"></span>
                <h2 class="heading">ĐẶT HẸN</h2>
                <p class="text">Các chuyên gia răng hàm mặt có nhiều năm kinh nghiệm.</p>
                <a class="content--btn content--btn--left mr-3 d-inline-block" href="#">
                    <span>ĐỘI NGŨ</span>
                </a>
                <a class="content--btn content--btn--right d-inline-block" href="#">
                    <span>GIỜ LÀM VIỆC</span>
                </a>
            </div>
        </div>
    </header>

    
    <section class="MakeAppointment">
        <div class="container WrapHeadingContent">
            <div class="HeadingContent  ElementScrollEffect left">
                <h5 class="heading--sub">Lựa chọn dịch vụ bạn mong muốn</h5>
                <span class="dash"></span>
                <h2 class="heading">Tạo một cuộc hẹn ngay</h2>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ url('appointmentPatient)}}" method="POST" class="form" id="form-1">
                            @csrf
                            <div class="spacer"></div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Tên đầy đủ<span class="mandatory"> *</span></label>
                                        <input id="name" name="name"  type="text" placeholder="VD: Khoa Nguyễn" class="form-control">
                                        <span class="form-message"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Điện thoại<span class="mandatory"> *</span></label>
                                        <input id="phone" name="phone"type="text" maxlength="10" placeholder="Số điện thoại" class="form-control">
                                        <span class="form-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Ngày khám<span class="mandatory"> </span></label>
                                        <input id="date" min="" name="date" type="date" class="form-control">
                                        <span class="form-message"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="time" class="form-label">Thời gian<span class="mandatory"> </span></label>
                                        <select name="time" id="formTimes" class="form-control">
                                            <option value="">Thời gian</option>
                                            <option value="08:00:00"> 08:00 </option>
                                            <option value="08:00:00"> 09:00 </option>
                                            <option value="08:00:00"> 10:00 </option>
                                            <option value="08:00:00"> 11:00 </option>
                                            <option value="08:00:00"> 13:00 </option>
                                            <option value="07:00:00"> 14:00 </option>
                                            <option value="07:00:00"> 15:00 </option>
                                            <option value="07:00:00"> 16:00 </option>
                                        </select>
                                        <span class="form-message"></span>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <button type ="submit" class="form-submit">BOOK NOW</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
            </div>
        </div>
    </section>

