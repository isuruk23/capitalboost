@extends('layouts.app')

@section('content')

<main>
    <div class="page-header shadow">
        <div class="container-fluid">
            @include('layouts.customer_nav_bar')
           
        </div>
    </div>

    <div class="container-fluid mt-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-12">
                        @can('customer-create')
                            <button type="button" class="btn btn-outline-primary btn-sm fa-pull-right" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add customer</button>
                        @endcan
                    </div>
                    <div class="col-12">
                        <hr class="border-dark">
                    </div>
                    <div class="col-12">
                        <div class="center-block fix-width scroll-inner">
                        <table class="table table-striped table-bordered table-sm small nowrap" style="width: 100%" id="customertable">
                            <thead>
                                <tr>
                                    <th>Customer Name </th>
                                    <th>NIC</th>
                                    <th>Date of Birth</th>
                                    <th>Phone No</th> 
                                    <th class="text-right">Action</th>   
                                </tr>
                            </thead>                            
                            <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{$customer->name_with_initial}}</td>
                                    <td>{{$customer->nic_no}}</td>                                    
                                    <td>{{$customer->dateofbirth}}</td>
                                    <td>{{$customer->phoneno}}</td>
                                    <td class="text-right">
                                        @can('customer-edit')
                                            <button name="edit" id="{{$customer->id}}" class="edit btn btn-outline-primary btn-sm" type="submit"><i class="fas fa-pencil-alt"></i></button>
                                        @endcan
                                        @can('customer-delete')
                                            <button type="submit" name="delete" id="{{$customer->id}}" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Area Start -->
    <div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title" id="staticBackdropLabel">Add customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <span id="form_result"></span>

                            <form method="POST"  class="form-horizontal" id="formCustomer">
                                {{ csrf_field() }}	

                                <div class="mb-3">
                                    <label for="name_with_initial" class="form-label">Name with Initial</label>
                                    <input type="text" class="form-control form-control-sm" id="name_with_initial" name="name_with_initial" >
                                </div>

                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control form-control-sm" id="fullname" name="fullname" >
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control form-control-sm" id="address" name="address" >
                                </div>

                                <div class="mb-3">
                                    <label for="nic_no" class="form-label">NIC Number</label>
                                    <input type="text" class="form-control form-control-sm" id="nic_no" name="nic_no" >
                                </div>

                                <div class="mb-3">
                                    <label for="dateofbirth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control form-control-sm" id="dateofbirth" name="dateofbirth">
                                </div>

                                <div class="mb-3">
                                    <label for="phoneno" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control form-control-sm" id="phoneno" name="phoneno">
                                </div>

                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control form-control-sm" id="mobile" name="mobile">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control form-control-sm" id="email" name="email">
                                </div>

                                  <div class="form-group mt-3">
                                    <button type="submit" name="action_button" id="action_button" class="btn btn-outline-primary btn-sm fa-pull-right px-4"><i class="fas fa-plus"></i>&nbsp;Add</button>
                                </div>
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                            </form>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center">
                            <h4 class="font-weight-normal">Are you sure you want to remove this data?</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger px-3 btn-sm">OK</button>
                    <button type="button" class="btn btn-dark px-3 btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Area End -->
</main>
              
@endsection


@section('script')

<script>

    //initialize_calendar();
    //cal2();

   

$(document).ready(function(){

            $('#customer_menu_link').addClass('active');
            $('#customer_menu_link_icon').addClass('active');
            $('#leavemaster').addClass('navbtnactive');

    
    $(document).ready(function () {
        $('#customertable').DataTable();
    });

    $('#create_record').click(function () {
        $('.modal-title').text('Add customer');
        $('#action_button').html('Add');
        $('#action').val('Add');
        $('#form_result').html('');

        //form reset
        $('#formCustomer')[0].reset();      


        $('#formModal').modal('show');
    });

    $('#formCustomer').on('submit', function (event) {
        event.preventDefault();
        var action_url = '';

        if ($('#action').val() == 'Add') {
            action_url = "{{ route('customer.store') }}";
        }
        if ($('#action').val() == 'Edit') {
            action_url = "{{ route('customer.update', $customer->id) }}";
        }


        $.ajax({
            url: action_url,
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (data) {

                var html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.message + '</div>';
                    $('#formCustomer')[0].reset();
                    //$('#titletable').DataTable().ajax.reload();
                   location.reload()
                }
                $('#form_result').html(html);
            }
        });
    });

    $(document).on('click', '.edit', function () {
        $('#action_button').html('Edit');
        $('#action').val('Edit');

        var id = $(this).attr('id');
        $('#form_result').html('');
        $.ajax({
            url: "customer/" + id + "/edit",
            dataType: "json",
            success: function (data) {
                $('#holiday_name').val(data.result.holiday_name);
                $('#holiday_type').val(data.result.holiday_type);

                let half_short = data.result.half_short;
                if(half_short == '1' ){
                    half_short = '1.00';
                }

                $('#half_short').val(half_short);

                if(data.result.half_short == 0.25 || data.result.half_short == 0.5) {
                    // $('.half_short_time').html(`
                    //     <div class="form-group mb-1">
                    //         <label class="small font-weight-bold text-dark">Start Time</label>
                    //         <input type="time" name="start_time" id="start_time" class="form-control form-control-sm" value="` + data.result.start_time + `" />
                    //     </div>
                    //     <div class="form-group mb-1">
                    //         <label class="small font-weight-bold text-dark">End Time</label>
                    //         <input type="time" name="end_time" id="end_time" class="form-control form-control-sm" value="` + data.result.end_time + `" />
                    //     </div>
                    // `);
                }else{
                    $('.half_short_time').html('');
                }

                $('#date').val(data.result.date);
                $('#work_level').val(data.result.work_level);
                $('#hidden_id').val(id);

                $('.modal-title').text('Edit Holiday');
                $('#action_button').val('Edit');
                $('#action').val('Edit');
                $('#formModal').modal('show');
            }
        })
    });

    var user_id;

    $(document).on('click', '.delete', function () {
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function () {
        $.ajax({
            url: "customer/destroy/" + user_id,
            beforeSend: function () {
                $('#ok_button').text('Deleting...');
            },
            success: function (data) {
                setTimeout(function () {
                    $('#confirmModal').modal('hide');
                    $('#user_table').DataTable().ajax.reload();
                    alert('Data Deleted');
                }, 2000);
                location.reload()
            }
        })
    });

});
</script>

@endsection