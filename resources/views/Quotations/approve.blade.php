@extends('layouts.app')

@section('content')

    <main>
        <div class="page-header shadow">
            <div class="container-fluid">
                @include('layouts.quotation_nav_bar')
               
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body p-0 p-2">
                    <div class="row">
                      
                       
                        <div class="col-12">
                            <div class="center-block fix-width scroll-inner">
                            @can('quotation-approvel')
                                <table class="table table-bordered table-hover" id="titletable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID </th>
                                                <th>Name with Inisials</th> 
                                                <th>Address</th>   
                                                <th>NIC</th>   
                                                <th>Invenstment</th>   
                                                <th>Period</th>   
                                                <th>Paying Term</th>   
                                                <th>Payment Mode</th>   
                                                <th>Action</th>   
                                            </tr>
                                        </thead>
                                      
                                        <tbody>
                                        @foreach($quotations as $quotation)
                                            <tr>
                                            
                                                <td>{{$quotation->id}}</td>
                                                <td>{{$quotation->name_with_initial}}</td>
                                                <td>{{$quotation->address}}</td>
                                                <td>{{$quotation->nic_no}}</td>
                                                <td>{{$quotation->initial_investment}}</td>
                                                <td>{{$quotation->period}}</td>
                                                <td>{{$quotation->paying_term}}</td>
                                                <td>{{$quotation->mode_of_payment}}</td>
                                                <td>  
                                                <button name="approve" id="approve" data-id="{{$quotation->id}}" class="approve btn btn-primary btn-sm" type="submit">
                                                    <i class="fa fa-check-circle"></i>  
                                                </button>
                                                       
                                                                                          
                                               
                                            </tr>
                                           @endforeach
                                         
                                        </tbody>
                                    </table>
                            @endcan
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
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <span id="form_result"></span>
                                <form  method="POST" id="formQuatation">
                                            {{ csrf_field() }}
                                            <div class="form-row mb-2">
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="name_with_initial">Name with Initial</label>
                                                <input type="text" class="form-control form-control-sm {{ $errors->has('name_with_initial') ? 'is-invalid' : '' }}" id="name_with_initial" name="name_with_initial" value="{{ old('name_with_initial') }}" readonly>
                                                @if ($errors->has('name_with_initial'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name_with_initial') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="address">Address</label>
                                                <textarea class="form-control form-control-sm {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" rows="3" readonly>{{ old('address') }}</textarea>
                                                @if ($errors->has('address'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('address') }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                            <div class="form-row mb-2">
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="nic_no">NIC No</label>
                                                <input type="text" class="form-control form-control-sm {{ $errors->has('nic_no') ? 'is-invalid' : '' }}" id="nic_no" name="nic_no" value="{{ old('nic_no') }}" readonly>
                                                @if ($errors->has('nic_no'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('nic_no') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="initial_investment">Initial Investment</label>
                                                <input type="number" step="0.01" class="form-control form-control-sm {{ $errors->has('initial_investment') ? 'is-invalid' : '' }}" id="initial_investment" name="initial_investment" value="{{ old('initial_investment') }}" readonly>
                                                @if ($errors->has('initial_investment'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('initial_investment') }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                            <div class="form-row mb-2">
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="period">Period</label>
                                                <select class="form-control form-control-sm {{ $errors->has('period') ? 'is-invalid' : '' }}" id="period" name="period" readonly>
                                                    <option value="">-- Select Period --</option>
                                                    <option value="1" {{ old('period') == '1 year' ? 'selected' : '' }}>1 year</option>
                                                    <option value="2" {{ old('period') == '2 years' ? 'selected' : '' }}>2 years</option>
                                                    <option value="3" {{ old('period') == '3 years' ? 'selected' : '' }}>3 years</option>
                                                    <option value="4" {{ old('period') == '3 years' ? 'selected' : '' }}>4 years</option>
                                                    <option value="5" {{ old('period') == '3 years' ? 'selected' : '' }}>5 years</option>
                                                    <option value="6" {{ old('period') == '3 years' ? 'selected' : '' }}>6 years</option>
                                                </select>
                                                @if ($errors->has('period'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('period') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="paying_term">Paying Term</label>
                                                <select class="form-control form-control-sm {{ $errors->has('paying_term') ? 'is-invalid' : '' }}" id="paying_term" name="paying_term" readonly>
                                                    <option value="">-- Select Paying Term --</option>
                                                    <option value="Single" {{ old('paying_term') == 'Single' ? 'selected' : '' }}>Single</option>
                                                    <option value="Monthly" {{ old('paying_term') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                    <option value="Quarterly" {{ old('paying_term') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Annually" {{ old('paying_term') == 'Annually' ? 'selected' : '' }}>Annually</option>
                                                </select>
                                                @if ($errors->has('paying_term'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('paying_term') }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                            <div class="form-row mb-2">
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="mode_of_payment">Mode Of Payment</label>
                                                <select class="form-control form-control-sm {{ $errors->has('mode_of_payment') ? 'is-invalid' : '' }}" id="mode_of_payment" name="mode_of_payment" readonly>
                                                    <option value="">-- Select Mode --</option>
                                                    <option value="Cash" {{ old('mode_of_payment') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="Bank Transfer" {{ old('mode_of_payment') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                    <option value="Cheque" {{ old('mode_of_payment') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                                </select>
                                                @if ($errors->has('mode_of_payment'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('mode_of_payment') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="installment_date">Installment Date</label>
                                                <input type="date" class="form-control form-control-sm {{ $errors->has('installment_date') ? 'is-invalid' : '' }}" id="installment_date" name="installment_date" value="{{ old('installment_date') }}">
                                                @if ($errors->has('installment_date'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('installment_date') }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                           
                                            <input type="hidden" name="action" id="action" value="Add" />
                                            <input type="hidden" name="quotaion_id" id="quotaion_id" />
                                            <input type="hidden" name="plan" id="plan" />
                                            <input type="hidden" name="sales_by" id="sales_by" />
                                            <button type="submit" class="btn btn-primary btn-block">Approve Quotaion</button>
                                        
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
        $(document).ready(function(){

            $('#organization_menu_link').addClass('active');
            $('#organization_menu_link_icon').addClass('active');
            $('#banklink').addClass('navbtnactive');

           

            $('#create_record').click(function(){
                $('.modal-title').text('Create Quotation');
                $('#action_button').html('Create');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#formQuatation')[0].reset();

                

                $('#formModal').modal('show');
            });

            $('#formQuatation').on('submit', function(event){
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Add') {
                    action_url = "{{ route('quotations.store') }}";
                }
                if ($('#action').val() == 'Edit') {
                    action_url = "{{ route('quotations.update') }}";
                }
                if ($('#action').val() == 'Approve') {
                    action_url = "{{ route('quotationsapprovel') }}";
                }

                $.ajax({
                    url: action_url,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (data) {//alert(data);
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#formQuatation')[0].reset();
                            
                            location.reload()
                        }
                        $('#form_result').html(html);
                    }
                });
            });

            // $(document).on('click', '.edit', function () {
            //     var id = $(this).attr('id');
            //     $('#action').val('Edit');
            //     $('#form_result').html('');
            //     $.ajax({
            //         url: "Bank/" + id + "/edit",
            //         dataType: "json",
            //         success: function (data) {
            //             $('#name').val(data.result.bank);
            //             $('#code').val(data.result.code);
            //             $('#hidden_id').val(id);
            //             $('.modal-title').text('Edit Bank');
            //             $('#action_button').html('Edit');
            //             $('#action').val('Edit');
            //             $('#formModal').modal('show');
            //         }
            //     })
            // });

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "Bank/destroy/" + user_id,
                    beforeSend: function () {
                        $('#ok_button').text('Deleting...');
                    },
                    success: function (data) {//alert(data);
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#dataTable').DataTable().ajax.reload();
                            alert('Data Deleted');
                        }, 2000);
                        location.reload()
                    }
                })
            });

            $('.approve').on('click', function() {
            var quotaionId = $(this).data('id');
            $('#formModal .modal-title').text('Approve Quotation');
            $('#submitBtn').html('<i class="fas fa-save mx-2"></i> Approve Quotation');
            $('#action').val('Approve');
            $('#quotaion_id').val(quotaionId);
            $('#formModal form')[0].reset();
            
           
            $.ajax({
                url: 'quotaionview/' + quotaionId, // Make sure this matches your route
                type: 'GET',
                success: function (data) {
                    let quotation = data.quotation;
                    let plans = data.plans;

            
                // Fill quotation fields
                $('#quotation_id').val(quotation.id);
                $('#name_with_initial').val(quotation.name_with_initial);
                $('#address').val(quotation.address);
                $('#nic_no').val(quotation.nic_no);
                $('#initial_investment').val(quotation.invest_amount);
                $('#period').val(quotation.term_of_years);
                $('#paying_term').val(quotation.paying_term);
                $('#mode_of_payment').val(quotation.mode_of_payment);
                $('#installment_date').val(quotation.installment_date);
                $('#sales_by').val(quotation.sales_by);
                $('#plan').val(quotation.sub_plan_id);

                // If you want to populate a dropdown for plans
                let planSelect = $('#plan_id'); // make sure this is a <select> in your form
                planSelect.empty();
                plans.forEach(plan => {
                    planSelect.append(
                        $('<option>', {
                            value: plan.id,
                            text: plan.plan
                        })
                    );
                });

                // Optionally set selected plan
                planSelect.val(quotation.plan_id);
                },
                error: function (xhr) {
                    $('#responseMessage').html(
                        `<div class="alert alert-danger">Error loading plan data</div>`
                    );
                }
            });

            
            $('#formModal').modal('show');
        });


//     $('#approvelForm').on('submit', function (event) {
//     event.preventDefault();

//     $.ajax({
//         url: "{{ route('investment.store') }}",
//         method: "POST",
//         data: $(this).serialize(),
//         dataType: "json",
//         success: function (data) {
//             let html = '';

//             if (data.errors) {
//                 html = '<div class="alert alert-danger">';
//                 for (let count = 0; count < data.errors.length; count++) {
//                     html += '<p>' + data.errors[count] + '</p>';
//                 }
//                 html += '</div>';
//                 $('#form_result').html(html);
//             }

//             if (data.success) {
//                 html = '<div class="alert alert-success">' + data.message + '</div>';
//                 $('#form_result').html(html);

//                 $('#approvelForm')[0].reset();  // Make sure you're resetting the correct form ID
//                 $('#formModal').modal('hide');  // Optionally hide the modal after submission
//                 setTimeout(function () {
//                     location.reload(); // Reload to reflect new data
//                 }, 1000);
//             }
//         },
//         error: function (xhr) {
//             let html = '<div class="alert alert-danger">';
//             if (xhr.status === 422 && xhr.responseJSON?.['errors']) {
//                 xhr.responseJSON['errors'].forEach(function (error) {
//                     html += '<p>' + error + '</p>';
//                 });
//             } else {
//                 html += '<p>An unexpected error occurred.</p>';
//             }
//             html += '</div>';
//             $('#form_result').html(html);
//         }
//     });
// });

        });
    </script>

@endsection