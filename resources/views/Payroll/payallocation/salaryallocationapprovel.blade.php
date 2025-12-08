@extends('layouts.app')

@section('content')

<main>
    <div class="page-header shadow">
        <div class="container-fluid">
            @include('layouts.attendant&leave_nav_bar')
           
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="card mb-2">
            <div class="card-body">
                <form class="form-horizontal" id="formFilter">
                    <div class="form-row mb-1">
                        <div class="col">
                            <label class="small font-weight-bold text-dark">Company</label>
                            <select name="company" id="company" class="form-control form-control-sm" required>
                            </select>
                        </div>
                        <div class="col">
                            <label class="small font-weight-bold text-dark">Department</label>
                            <select name="location" id="location" class="form-control form-control-sm" required>
                            </select>
                        </div>
                        <div class="col">
                            <label class="small font-weight-bold text-dark">Month</label>
                            <input type="month" id="month" name="month" class="form-control form-control-sm" placeholder="yyyy-mm" required>
                        </div>
                        <div class="col">
                            <label class="small font-weight-bold text-dark">Close Date</label>
                            <input type="date" id="closedate" name="closedate" class="form-control form-control-sm" required>
                        </div>
                        <div class="col">
                            <br>
                            <button type="submit" class="btn btn-primary btn-sm filter-btn" id="btn-filter"><i class="fas fa-search mr-2"></i>Filter</button>
                            <button type="button" class="btn btn-danger btn-sm filter-btn" id="btn-clear"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;Clear</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-0 p-2 main_card">
                <div class="row">
                    <div class="col-12">
                        <div class="message"></div>
                        <div class="d-flex justify-content-end mb-2">
                            <button id="approve_att" class="btn btn-primary btn-sm">Approve All</button>
                        </div>
                        <div class="table-responsive table_outer">
                            <table class="table table-striped table-bordered table-sm small" id="salarytable">
                                <thead>
                                <tr>
                                    <th>ETF N</th>
                                    <th>Employee Name</th>
                                    <th>Location</th>
                                    <th>Basic</th>
                                    <th>Fule Allowance</th>
                                    <th>Transport Allowance</th>
                                  
                                </tr>
                                </thead>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Area Start -->
    <div class="modal fade" id="AttendviewModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title" id="staticBackdropLabel">View Attendence</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div id="message"></div>
                            <table id='attendTable' class="table table-striped table-bordered table-sm small">
                                <thead>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div id="htmlbutton"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Area End -->
</main>
              
@endsection


@section('script')

<script>
$(document).ready(function () {

    $('#attendant_menu_link').addClass('active');
    $('#attendant_menu_link_icon').addClass('active');
    $('#attendantmaster').addClass('navbtnactive');

    $('.table_outer').css('display', 'none');
    $('#approve_att').css('display', 'none');

    let msg = '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
        'Please select Department, Month and filter to load records.' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '</div>';

    $('.main_card').append(msg);

    let company = $('#company');
    let location = $('#location');

    company.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '{{url("company_list_sel2")}}',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                }
            },
            cache: true
        }
    });

    location.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '{{url("location_list_sel2")}}',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    company: company.val()
                }
            },
            cache: true
        }
    });

    //load_dt('');
    function load_dt(company,location, month, closedate){

        $('.alert').remove();
        $('.table_outer').css('display', 'block');
        $('#approve_att').css('display', 'block');

         $.ajax({
            url: "{{ route('get_employee_allocation') }}",
            method: "POST",
            data: {
                company: company,
                location: location,
                month: month,
                closedate: closedate,
                _token: '{{csrf_token()}}'
            },
            success: function (response) {
                // Destroy existing DataTable (if already initialized)
                if ($.fn.DataTable.isDataTable('#salarytable')) {
                    $('#salarytable').DataTable().destroy();
                }

                // Clear existing rows
                $('#salarytable tbody').empty();

               
                // Re-initialize with new data
                $('#salarytable').DataTable({
                    data: response.data, // assuming response is array of emp_data
                    columns: [
                        { data: 'emp_etfno' },
                        { data: 'emp_name_with_initial' },
                        { data: 'emp_location' },
                        { data: 'basic', defaultContent: '' },
                        { data: 'fuel_allowance', defaultContent: 'Not Complete the Target' },
                        { data: 'vehicle_allowance', defaultContent: 'Not Complete the Target' }
                    ]
                });
            }
        });


        
    }

    $('#formFilter').on('submit',function(e) {
        e.preventDefault();
        let location = $('#location').val();
        let company = $('#company').val();
        let month = $('#month').val();
        let closedate = $('#closedate').val();

        load_dt(company, location, month, closedate);
    });

    document.getElementById('btn-clear').addEventListener('click', function() {
    document.getElementById('formFilter').reset();

                $('#company').val('').trigger('change');   
                $('#department').val('').trigger('change');
                $('#month').val('');
                                  

                // load_dt('', '', '');
    });

    $(document).on('click', '#approve_att', function (e) {
        e.preventDefault();
        let department = $('#department').val();
        let company = $('#company').val();
        let month = $('#month').val();
        let closedate = $('#closedate').val();

        //js confirm alert
        if (confirm("Are you sure you want to approve this attendance?")) {

            $.ajax({
                url: "AttendentAprovelBatch",
                method: "POST",
                data: {
                    department: department,
                    company: company,
                    month: month,
                    closedate: closedate,
                    _token: $('input[name=_token]').val(),
                },
                success: function (data) {
                    $('.message').html("<div class='alert alert-success'>"+data.msg+"</div>");
                    $('#attendtable').DataTable().clear().destroy();

                    $('.table_outer').css('display', 'none');
                    $('#approve_att').css('display', 'none');
                }
            });

        }

    });

});

$(document).on('click', '.view_button', function () {
    id = $(this).attr('uid');
    date = $(this).attr('data-date');
    emp_name_with_initial = $(this).attr('data-name');

    var formdata = {
        _token: $('input[name=_token]').val(),
        id: id,
        date: date
    };
    // alert(date);
    $('#form_result').html('');
    $.ajax({
        url: "getAttendanceApprovel",
        dataType: "json",
        data: formdata,
        success: function (data) {
            $('#AttendviewModal').modal('show');
            var htmlhead = '';
            htmlhead += '<tr><td>Emp ID :' + id + '</td><td >Name :' + emp_name_with_initial + '</td></tr>';
            htmlhead += '<tr><th>Date</th><th>Check in</th><th>Check out</th></tr>';
            var html = '';
            var htmlbutton = '';

            html += '<tr>';


            var errorcount = 0;
            for (var count = 0; count < data.length; count++) {
                html += '<tr>';
                if (data[count].firsttimestamp >= data[count].lasttimestamp) {
                    errorcount++

                    html += '<td contenteditable class="timestamp" data-timestamp="timestamp" data-id="' + data[count].id + '">' + data[count].date + '</td>';
                    html += '<td contenteditable class="timestamp " data-timestamp="timestamp" data-id="' + data[count].id + '">' + data[count].firsttimestamp + '</td>';
                    html += '<td contenteditable class="timestamp text-danger" data-timestamp="timestamp" data-id="' + data[count].id + '">' + data[count].lasttimestamp + '</td>';

                } else {
                    html += '<td contenteditable class="timestamp" data-timestamp="timestamp" data-id="' + data[count].id + '">' + data[count].date + '</td>';
                    html += '<td contenteditable class="timestamp " data-timestamp="' + data[count].id + '" data-id="' + data[count].id + '">' + data[count].firsttimestamp + '</td>';
                    html += '<td contenteditable class="timestamp " data-timestamp="timestamp" data-id="' + data[count].id + '">' + data[count].lasttimestamp + '</td>';

                }

            }
            if (errorcount == 0) {
                htmlbutton += '<tr > <td > <button type="button" class="btn btn-success pull-left" id="approvel">Approval</button></td><tr >';
            }

            $('#attendTable thead').html(htmlhead);
            $('#attendTable tbody').html(html);
            $('#htmlbutton').html(htmlbutton);
        }
    })
});

$(document).on('click', '#approvel', function () {
    var _token = $('input[name="_token"]').val();
    var emp_id = $('#emp_id').text();

    if (emp_id != '') {
        $.ajax({
            url: "AttendentAprovel",
            method: "POST",
            data: {
                emp_id: emp_id,
                _token: _token
            },
            success: function (data) {
                $('#message').html(data);
                fetch_data();
            }
        });
    } else {
        $('#message').html("<div class='alert alert-danger'>Both Fields are required</div>");
    }
});
</script>

@endsection