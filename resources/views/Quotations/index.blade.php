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
                            @can('quotation-create')
                               <button type="button" class="btn btn-outline-primary btn-sm fa-pull-right" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Create Quotaion</button>
                            @endcan
                        </div>
                        <div class="col-12">
                            <hr class="border-dark">
                        </div>
                        <div class="col-12">
                            <div class="center-block fix-width scroll-inner">
                            @can('quotation-list')
                                <table class="table table-bordered table-hover" id="titletable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID </th>
                                                <th>Name with Inisials</th> 
                                                <th>Address</th>   
                                                <th>NIC</th>   
                                                <th>Invenstment Plan</th> 
                                                <th>Paying Term</th>   
                                                <th>Payment Mode</th> 
                                                <th>E-mail</th>  
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
                                                <td>{{$quotation->planName}}</td>
                                                <td>{{$quotation->term_of_years}} Years</td>
                                                <td>{{$quotation->mode_of_payment}}</td>
                                                <td>{{$quotation->email}}</td>
                                                <td>  
                                                    <a href="generatequotation/{{$quotation->id}}" name="generate" id="{{$quotation->id}}" class="generate btn btn-outline-primary btn-sm" type="submit"><i class="fa fa-file"></i></a>
                                                    <button name="edit" id="{{$quotation->id}}" class="edit btn btn-outline-primary btn-sm" type="submit"><i class="fas fa-pencil-alt"></i></button>
                                                    <button type="submit" name="delete" id="{{$quotation->id}}" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                                                                          
                                               
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
                        <h5 class="modal-title" id="staticBackdropLabel">Create Quotaion</h5>
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
                                                <input type="text" class="form-control form-control-sm {{ $errors->has('name_with_initial') ? 'is-invalid' : '' }}" id="name_with_initial" name="name_with_initial" value="{{ old('name_with_initial') }}" >
                                                @if ($errors->has('name_with_initial'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name_with_initial') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="nic_no">NIC No</label>
                                                <input type="text" class="form-control form-control-sm {{ $errors->has('nic_no') ? 'is-invalid' : '' }}" id="nic_no" name="nic_no" value="{{ old('nic_no') }}" >
                                                @if ($errors->has('nic_no'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('nic_no') }}
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            </div>
                                            <div class="form-row mb-2">
                                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="address">Address</label>
                                                <textarea class="form-control form-control-sm {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" rows="1" >{{ old('address') }}</textarea>
                                                @if ($errors->has('address'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('address') }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                            <div class="form-row mb-2">
                                            
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="plan_id">Plan</label>
                                                <select class="form-control form-control-sm {{ $errors->has('plan_id') ? 'is-invalid' : '' }}" id="plan_id" name="plan_id">
                                                    
                                                   
                                                </select>
                                                @if ($errors->has('plan_id'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('plan_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                             <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="subplan">Sub Plan</label>
                                                <select class="form-control form-control-sm {{ $errors->has('subplan') ? 'is-invalid' : '' }}" id="subplan" name="subplan">
                                                    <option value="">-- Select Plan --</option>
                                                   
                                                </select>
                                                @if ($errors->has('subplan'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('subplan') }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                           
                                            <div class="form-row mb-2">
                                            

                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="paying_term">Paying Term</label>
                                                <select class="form-control form-control-sm {{ $errors->has('paying_term') ? 'is-invalid' : '' }}" id="paying_term" name="paying_term" >
                                                    <option value="">-- Select Paying Term --</option>
                                                    <option value="Monthly" {{ old('paying_term') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                    <option value="Quarterly" {{ old('paying_term') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Annually" {{ old('paying_term') == 'Annually' ? 'selected' : '' }}>Annually</option>
                                                    <option value="Single" {{ old('paying_term') == 'Single' ? 'selected' : '' }}>Single</option>
                                                </select>
                                                @if ($errors->has('paying_term'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('paying_term') }}
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                                <label for="mode_of_payment">Mode Of Payment</label>
                                                <select class="form-control form-control-sm {{ $errors->has('mode_of_payment') ? 'is-invalid' : '' }}" id="mode_of_payment" name="mode_of_payment" >
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
                                                <label for="email">E-mail</label>
                                                <input type="text" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" >
                                                @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                            </div>
                                            
                                            <input type="hidden" name="action" id="action" value="Add" />
                                            <input type="hidden" name="hidden_id" id="hidden_id" />
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        
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


             $.ajax({
                url: 'getinvestmentplans', // Make sure this matches your route
                type: 'GET',
                success: function (data) {
                    let plans = data.plans;

                    // If you want to populate a dropdown for plans
                    let planSelect = $('#plan_id'); // make sure this is a <select> in your form
                    planSelect.empty();

                   // Add default "Select Plan" option
                        planSelect.append(
                            $('<option>', {
                                value: '',
                                text: '-- Select Plan --'
                            })
                        );

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

            $(document).on('change', '#plan_id', function () {
                const selectedPlanId = $(this).val();

                if (!selectedPlanId) return;

                $.ajax({
                    url: 'getinvestmentsubplans/' + selectedPlanId, // Update this to match your actual route
                    type: 'GET',
                    success: function (data) {
                        let subPlans = data.sub_plans;

                        let subPlanSelect = $('#subplan'); // Make sure this <select> exists in your form
                        subPlanSelect.empty();

                        subPlans.forEach(subPlan => {
                        const fullText = `${subPlan.plan} - ${subPlan.term_of_years} Years`;

                        subPlanSelect.append(
                            $('<option>', {
                                value: subPlan.id,
                                text: fullText
                            })
                        );
                    });

                    },
                    error: function (xhr) {
                        $('#responseMessage').html(
                            `<div class="alert alert-danger">Error loading sub plan data</div>`
                        );
                    }
                });
            });



            $('#shift_menu_link').addClass('active');
            $('#shift_menu_link_icon').addClass('active');
            $('#shift_link').addClass('navbtnactive');

           

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

                $.ajax({
                    url: action_url,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (data) {
            let html = '';

            if (data.errors) {
                html = '<div class="alert alert-danger">';
                for (let count = 0; count < data.errors.length; count++) {
                    html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
                $('#form_result').html(html);
            }

            if (data.success) {
                html = '<div class="alert alert-success">' + data.message + '</div>';
                $('#form_result').html(html);

                $('#formQuatation')[0].reset();  // Make sure you're resetting the correct form ID

                // Hide the modal and reload after 3 seconds
                setTimeout(function () {
                    $('#formModal').modal('hide'); // Hide modal after 3 seconds
                    location.reload();             // Reload to reflect new data
                }, 3000);
            }

        },
        error: function (xhr) {
            let html = '<div class="alert alert-danger">';
            if (xhr.status === 422 && xhr.responseJSON?.['errors']) {
                xhr.responseJSON['errors'].forEach(function (error) {
                    html += '<p>' + error + '</p>';
                });
            } else {
                html += '<p>An unexpected error occurred.</p>';
            }
            html += '</div>';
            $('#form_result').html(html);
        }
                });
            });

            
            $(document).on('click', '.edit', function () {
    var id = $(this).attr('id');
    $('#form_result').html('');

    $.ajax({
        url: "Quotations/" + id + "/edit",
        dataType: "json",
        success: function (data) {
            const quotation = data.data;

            // Fill basic fields
            $('#name_with_initial').val(quotation.name_with_initial);
            $('#address').val(quotation.address);
            $('#nic_no').val(quotation.nic_no);
            $('#initial_investment').val(quotation.initial_investment);
            $('#period').val(quotation.period);
            $('#plan_id').val(quotation.plan_id);
            $('#paying_term').val(quotation.paying_term);
            $('#mode_of_payment').val(quotation.mode_of_payment);
            $('#hidden_id').val(id);

            // Load sub plans and select correct one
            loadSubPlans(quotation.plan_id, quotation.sub_plan_id);

            // Show modal
            $('.modal-title').text('Edit Quotations');
            $('#action_button').html('Edit');
            $('#action').val('Edit');
            $('#formModal').modal('show');
        }
    });
});

// Function to load sub plans
function loadSubPlans(selectedPlanId, activeSubPlanId) {
    $.ajax({
        url: 'getinvestmentsubplans/' + selectedPlanId,
        type: 'GET',
        success: function (data) {
            let subPlans = data.sub_plans;
            let subPlanSelect = $('#subplan');
            subPlanSelect.empty();

            subPlans.forEach(subPlan => {
                const fullText = `${subPlan.plan} - ${subPlan.term_of_years} Years`;
                subPlanSelect.append(
                    $('<option>', {
                        value: subPlan.id,
                        text: fullText
                    })
                );
            });

            // Set the selected sub plan from DB
            subPlanSelect.val(activeSubPlanId);
        },
        error: function () {
            $('#responseMessage').html(
                `<div class="alert alert-danger">Error loading sub plan data</div>`
            );
        }
    });
}



            var user_id;

            $(document).on('click', '.delete', function () {
                id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                
                $.ajax({
                    url: "Quotations/" + id +"/delete",
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

     
        });
    </script>

@endsection