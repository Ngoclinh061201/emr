
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$( document ).ready(function() {
    dmm();

});
// function countdown time
function startTimer(duration, display) {
    var timer = duration;
    setInterval(function () {
        seconds = parseInt(timer % 60, 10);

        display.textContent = seconds;

        if (--timer < 0) {
            timer = 0;
        }
    }, 1000);
}

function removeRow(id, url, page, urlLoadAjax)
{
    $.ajax({
        type: 'DELETE',
        datatype: 'JSON',
        data: {id},
        url: url,
        success: function(result) {
            if(result.error == false) {
                toastr.success('Xóa thành công')
                $('#rowId_' + id).remove();
                $('.loadAjax').load(urlLoadAjax + page + ' .loadAjax');
                // display = document.querySelector('#time');
                // startTimer(2, display);
                // setTimeout(function(){
                //     window.location.reload()
                // }, 3000)
            } else {
                toastr.error('Xóa thất bại.')
            }
        },
    })
}

var base_url = window.location.origin;
$('#city_id').on('change', function(){
    var city_id = document.getElementById('city_id').value;
    $.ajax({
        url:'http://localhost/emr/public/emr/patient/add/loadDistrict',
        dataType: 'json',
        type: "GET",
        data: {
            city_id: city_id,
        },
       
    }).done(function(districts) {
        var select = $('#district_id'); // Chọn thẻ select đổ dữ liệu các huyện
        select.empty(); // Xóa tất cả các option cũ nếu có
        select.append('<option value=""> Chọn huyện </option>'); // Thêm option mặc định
        districts.forEach(function(value) {
        select.append('<option value="' + value.id + '">' + value.name + '</option>'); // thêm option các huyện
        });
    });
})

$('#district_id').on('change', function(){
    var district_id = document.getElementById('district_id').value;
    $.ajax({
        url:'http://localhost/emr/public/emr/patient/add/loadWard',
        dataType: 'json',
        type: "GET",
        data: {
            district_id: district_id,
        },
       
    }).done(function(wards) {
        var select = $('#ward_id'); // Chọn thẻ select đổ dữ liệu các xã
        select.empty(); // Xóa tất cả các option cũ nếu có
        select.append('<option value=""> Chọn xã/phường </option>'); // Thêm option mặc định
        wards.forEach(function(value) {
        select.append('<option value="' + value.id + '">' + value.name + '</option>'); // thêm option các xã
        });
    });
})


$('.search_khoa_nguyen').on('keyup', function(){
    let full_name = $('.search_khoa_nguyen').val()
    console.log(full_name);
    $.ajax({
        type: 'GET',
        data: {full_name},
        url: base_url + '/emr/patient/loadPatientName',
        success: function(result) {
            $('.result_search_khoa_nguyen').html(result)
        }
    })
})
// console.log($('.select_search'));
// $(".select_search").on('change', function(){
//     alert(this.value)
//   });
// $('.select_search').on('change', function(){
//     let full_name = $('.select_search').val()
//     console.log(full_name);
//     // $.ajax({
//     //     type: 'GET',
//     //     data: {full_name},
//     //     url: base_url + '/emr/patient/loadPatientName',
//     //     success: function(result) {
//     //         $('.result_search_khoa_nguyen').html(result)
//     //     }
//     // })
// })
// $('#search_khoa_nguyen').on('keyup', function(){
//     let full_name =$('#search_khoa_nguyen').val()
//     // console.log(full_name);
//     $.ajax({
//         type: 'GET',
//         data: {full_name},
//         url: base_url + '/emr/patient/loadPatientName',
//         success: function(result) {
//             $('#fullname_patient').html(result)
//         }
//     })
// })

// $('#select_patient').on('keyup', function(){
//     alert('Starting...')
//     // $.ajax({
//     //     type: 'GET',
//     //     data: {full_name},
//     //     url: base_url + '/emr/patient/loadPatientName',
//     //     success: function(result) {
//     //         $('#selected_patient').html(result)
//     //     }
//     // })
// });



$('#url_image').on('change', function(){
    let url_image = $(this).val()
    if (url_image != '') {
        $('#link_show_image').attr('href', url_image)
        $('#show_image').attr('src', url_image)
        $('#box_show_image').css('display', 'block')
    } else {
        $('#box_show_image').css('display', 'none')
    }
})

function dmm (){
    $.ajax({
        url: 'http://localhost/emr/public/emr/appointment',
        type: 'GET',
        dataType: 'json',
        data: {
            flag: 1
        },
    }).done(function(appointments) {
        show(appointments);
        
    });
} 
$( "#appointment-tab-first" ).on( "click", function() {
    dmm();
});

$( "#appointment-tab-second").on( "click", function() {
    $.ajax({
        url:'http://localhost/emr/public/emr/appointment/accepted',
        type: 'GET',
        dataType: 'json',
        data: {
            flag: 1
        },
    }).done(function(appointments) {
        show(appointments);
    })
});
$( "#appointment-tab-third").on( "click", function() {
    
    $.ajax({
        url:'http://localhost/emr/public/emr/appointment/accepted',
        type: 'GET',
        dataType: 'json',
        data: {
            flag: 0
        },
    }).done(function(appointments) {
        show(appointments);
    })
});

function show(appointments){
    var html = '';
    appointments.forEach( (value) => {
        html += '<tr id="rowId">';
        html += '<td>' + value.id + '</td>';
        html += '<td>' + value.name + '</td>';
        html += '<td>' + value.phone + '</td>';
        html += '<td>' + value.date + '</td>';
        html += '<td>' + value.time + '</td>';
        html += '<td>' + (value.room ? value.room :'') + '</td>';
        html += '<td>' + (value.doctor ? value.doctor :'') + '</td>';
        html += '<td>' + (value.status ? 'Đã xác nhận' : 'Chưa xác nhận') + '</td>';
        html += '<td>' + value.updated_at + '</td>';
        html += '<td><div class="btn btn-sm btn-outline-info btn-inline-block mb-1" id= "tab-action">';
        html += '<a href="appointment/' + value.id + '/edit" class="btn btn-sm btn-outline-info btn-inline-block mb-1">';
        html += '<i class="fas fa-tools"></i> Sửa</a>';
        html += '<form action= "appointment/' + value.id + '/destroy">';
        html += '<button onclick="return confirm("Are you sure you want to delete?")" class="btn btn-sm btn-outline-danger btn-inline-block mb-1"data-toggle="tooltip" data-placement="top" type="submit"><i class="fas fa-trash"></i> Xóa</button></form>';
        html += '<a href="patient/' + value.id + '/add" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-outline-info btn-inline-block mb-1">';
        html += '<i class="fas fa-tools"></i> Thêm</a></div></td></tr>';
      });
    $('#appointment-all').html(html);
};

function activateTab(tab) {
    var tabs = document.querySelectorAll('.nav-link');
    tabs.forEach(function(t) {
      t.classList.remove('active');
    });
    tab.classList.add('active');
  }

    var tabFirst = document.getElementById('appointment-tab-first');
    var tabSecond = document.getElementById('appointment-tab-second');
    var tabThird = document.getElementById('appointment-tab-third');
    tabFirst.addEventListener('click', function() {
      activateTab(tabFirst);
    });
    tabSecond.addEventListener('click', function() {
      activateTab(tabSecond);
    });
    tabThird.addEventListener('click', function() {
      activateTab(tabThird);
    });

$( "#search-submit").on( "click", function() {
    var inputValue = document.getElementById('searchh').value;
    $.ajax({
        url:'http://localhost/emr/public/emr/appointment/search',
        type: 'GET',
        dataType: 'json',
        data: {
            flag: inputValue
        },
    }).done(function(appointments) {
        show(appointments);
    })
});

$('#search-patient-submit').on( "click", function() {
    console.log('Starting...')
    var patient_infor = document.getElementById('search-patient').value;
    $.ajax({
        url:'http://localhost/emr/public/emr/patient/search',
        type: 'GET',
        dataType: 'json',
        data: {
            patient_infor: patient_infor
        },
    }).done(function(patients) {
        var html = '';
        patients.forEach( (value) => {
            html += '<tr id="rowId">';
            html += '<td>' + value.id + '</td>';
            html += '<td>' + value.patient_id + '</td>';
            html += '<td>' + value.full_name + '</td>';
            html += '<td>' + value.phone_patient + '</td>';
            html += '<td>' + value.city_id +',' + value.district_id +','+value.ward_id + '</td>';
            html += '<td>' + value.updated_at + '</td>';
            
            html += '</tr>';
          });
        $('#patients-all').html(html);
    })
});