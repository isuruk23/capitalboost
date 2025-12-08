
@extends('layouts.app')

@section('content')

<main>
    <div class="page-header shadow">
        <div class="container-fluid">
            @include('layouts.investment_nav_bar')
           
        </div>
    </div>

    <div class="container-fluid mt-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-12">
                        @can('holiday-create')
                            <button type="button" class="btn btn-outline-primary btn-sm fa-pull-right" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add Plan</button>
                        @endcan
                    </div>
                    <div class="col-12">
                        <hr class="border-dark">
                    </div>
                    <div class="col-12">
                        <div class="center-block fix-width scroll-inner">
                        <table class="table table-striped table-bordered table-sm small nowrap" style="width: 100%" id="plantable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Plan</th>
                                <th>Plan Value</th>
                                <th>Monthly Income</th>
                                <th>Guaranteed</th>
                                <th>Terms</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->plan }}</td>
                                    <td>{{ $item->invest_amount }}</td>
                                    <td>{{ $item->monthly_income }}</td>
                                    <td>{{ $item->guaranteed_maturity }}</td>
                                    <td>{{ $item->term_of_years }} Years</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                    <a class="btn btn-sm btn-info edit-plan" data-id="{{ $item->id }}">Edit</a>
                                        <form action="{{ url('/investmentplans/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this plan?');">
                                        {{ csrf_field() }}	
                                           
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Add Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <span id="form_result"></span>
                            <form method="POST" id="formPlan" action="">
                            {{ csrf_field() }}	
                            
                            <div class="form-row">
                                <div class="form-group col-6 col-sm-12 col-md-6 col-lg-6">
                                    <label for="plan_id">Plan</label>
                                    <select class="form-control form-control-sm {{ $errors->has('plan_id') ? 'is-invalid' : '' }}" id="plan_id" name="plan_id">
                                        <option value="">-- Select Plan --</option>
                                        {{-- Options loaded dynamically --}}
                                    </select>
                                    <input type="hidden" name="plan" id="plan">
                                    @if ($errors->has('plan_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('plan_id') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6" id="form_invest_amount">
                                    <label>Invest Amount</label>
                                    <input type="text" name="invest_amount" id="invest_amount" value="{{ old('invest_amount', $plan->invest_amount ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_initials_payment">
                                    <label>Initials Payment</label>
                                    <input type="text" name="initials_payment" id="initials_payment" value="{{ old('initials_payment', $plan->initials_payment ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_installment">
                                    <label>Installment</label>
                                    <input type="number" name="installment" id="installment" value="{{ old('installment', $plan->installment ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_monthly_installment">
                                    <label>Monthly Installment</label>
                                    <input type="text" name="monthly_installment" id="monthly_installment" value="{{ old('monthly_installment', $plan->monthly_installment ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_monthly_income">
                                    <label>Monthly Income</label>
                                    <input type="text" name="monthly_income" id="monthly_income" value="{{ old('monthly_income', $plan->monthly_income ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_total_payment">
                                    <label>Total Payment</label>
                                    <input type="text" name="total_payment" id="total_payment" value="{{ old('total_payment', $plan->total_payment ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_guaranteed_maturity">
                                    <label>Guaranteed Maturity</label>
                                    <input type="text" name="guaranteed_maturity" id="guaranteed_maturity" value="{{ old('guaranteed_maturity', $plan->guaranteed_maturity ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_illustrated_maturity">
                                    <label>Illustrated Maturity</label>
                                    <input type="text" name="illustrated_maturity" id="illustrated_maturity" value="{{ old('illustrated_maturity', $plan->illustrated_maturity ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_security_land">
                                    <label>Security Land</label>
                                    <input type="text" name="security_land" id="security_land" value="{{ old('security_land', $plan->security_land ?? '') }}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group col-md-6" id="form_term_of_years">
                                    <label>Term_of Years</label>
                                    <select class="form-control form-control-sm {{ $errors->has('term_of_years') ? 'is-invalid' : '' }}" id="term_of_years" name="term_of_years">
                                        <option value="">-- Select Plan --</option>
                                        <option value="1">1 Year</option>
                                        <option value="2">2 Year</option>
                                        <option value="3">3 Year</option>
                                        <option value="4">4 Year</option>
                                        <option value="5">5 Year</option>
                                        <option value="6">6 Year</option>
                                        <option value="7">7 Year</option>
                                        <option value="8">8 Year</option>
                                    </select>
                                    @if ($errors->has('term_of_years'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('term_of_years') }}
                                        </div>
                                    @endif
                                </div>
                                 <button type="submit" name="action_button" id="action_button" class="btn btn-outline-primary btn-sm fa-pull-right px-4"><i class="fas fa-plus"></i>&nbsp;Add Plan</button>
                               
                                @if(isset($plan))
                                    <a href="{{ url('/investmentplans') }}" class="btn btn-secondary">Cancel</a>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
              
@endsection


@section('script')

<script>
$(document).ready(function() {
        $('#plantable').DataTable({
        "order": [[1, "desc"]] // Order by 3rd column (Age), descending
        });

        $.ajax({
        url: 'getinvestmentplans', // Make sure this matches your route
        type: 'GET',
        success: function (data) {
            let plans = data.plans;

            let planSelect = $('#plan_id');
            planSelect.empty();

            // Add default "Select Plan" option
            planSelect.append(
                $('<option>', {
                    value: '',
                    text: '-- Select Plan --'
                })
            );

            // Populate plans
            plans.forEach(plan => {
                planSelect.append(
                    $('<option>', {
                        value: plan.id,
                        text: plan.plan
                    })
                );
            });

            // Optionally set selected plan (only if available)
            if (typeof quotation !== 'undefined' && quotation.plan_id) {
                planSelect.val(quotation.plan_id);
            }
        },
        error: function (xhr) {
            $('#responseMessage').html(
                `<div class="alert alert-danger">Error loading plan data</div>`
            );
        }
    });



    function toggleFields(planId) {
        const allFields = [
            '#form_invest_amount', '#form_monthly_income', '#form_guaranteed_maturity',
            '#form_term_of_years', '#form_monthly_installment', '#form_installment',
            '#form_total_payment', '#form_security_land', '#form_illustrated_maturity',
            '#form_initials_payment'
        ];

        const planMap = {
            1: ['#form_invest_amount', '#form_monthly_income', '#form_guaranteed_maturity', '#form_term_of_years'],
            2: ['#form_invest_amount', '#form_monthly_income', '#form_guaranteed_maturity', '#form_term_of_years'],
            3: ['#form_invest_amount', '#form_term_of_years', '#form_guaranteed_maturity', '#form_security_land'],
            4: ['#form_invest_amount', '#form_term_of_years', '#form_guaranteed_maturity', '#form_monthly_installment', '#form_installment', '#form_total_payment'],
            5: ['#form_invest_amount', '#form_term_of_years', '#form_guaranteed_maturity', '#form_monthly_installment', '#form_installment', '#form_total_payment', '#form_initials_payment'],
            6: ['#form_invest_amount', '#form_monthly_income', '#form_guaranteed_maturity', '#form_term_of_years'],
            7: ['#form_invest_amount', '#form_monthly_income', '#form_guaranteed_maturity', '#form_term_of_years']
        };

        allFields.forEach(id => $(id).hide());
        (planMap[planId] || []).forEach(id => $(id).show());
    }


    // On plan_id change
    $('#plan_id').change(function () {
        const selectedOption = $(this).find('option:selected');
        const selectedValue = parseInt(selectedOption.val());
        const selectedText = selectedOption.text();
        $('#plan').val(selectedText);
       toggleFields(selectedValue);
    });

    // Trigger on page load in case a plan is pre-selected
    const initialPlan = parseInt($('#plan_id').val());
    if (!isNaN(initialPlan)) {
        toggleFields(initialPlan);
    }

    // Insert modal
    $('#create_record').on('click', function() {
        $('#formModal .modal-title').text('Add New Plan');
        $('#action_button').html('Approve');
        $('#formModal form')[0].reset();
        $('#formModal form').attr('action', "{{ route('investmentplans.store') }}");
        $('#formModal form').find('input[name="_method"]').remove();


        $('#formModal').modal('show');
    });

    
    // Edit modal via AJAX
    $('.edit-plan').on('click', function() {
        var id = $(this).data('id');
       

        $.ajax({
            url: 'investmentplans/' + id+ '/edit',
            type: 'GET',
            dataType: 'json',
            success: function(plan) {
                $('#formModal .modal-title').text('Edit Plan');
           
                $('#action_button').html('Edit Plan');
                $('#action').val('Edit');
                let updateUrl = 'investmentplans/' + id;
                $('#formModal form').attr('action', updateUrl);

                // Add PUT method if not already added
                if ($('#formModal form').find('input[name="_method"]').length === 0) {
                    $('#formModal form').append('<input type="hidden" name="_method" value="PUT">');
                }
                toggleFields(plan.plan_id);
                // Fill form fields
                $('#plan_id').val(plan.plan_id);
                $('#plan_value').val(plan.plan_value);
                $('#installment').val(plan.installment);
                $('#monthly_installment').val(plan.monthly_installment);
                $('#total_payment').val(plan.total_payment);
                $('#guaranteed_maturity').val(plan.guaranteed_maturity);
                $('#illustrated_maturity').val(plan.illustrated_maturity);
                $('#installment').val(plan.installment);
                $('#invest_amount').val(plan.invest_amount);
                $('#monthly_income').val(plan.monthly_income);
                $('#illustrated_maturity').val(plan.illustrated_maturity);
                $('#initials_payment').val(plan.initials_payment);
                $('#term_of_years').val(plan.term_of_years);
                $('#status').val(plan.status);
                const planname = $('#plan_id option:selected').text();
                $('#plan').val(planname);
                $('#formModal').modal('show');
            },
            error: function(xhr) {
                alert('Failed to fetch plan details.');
            }
        });
    });

    $('#formPlan').on('submit', function (event) {
    event.preventDefault();

    var action_url = $(this).attr('action');

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
                $('#form_result').html(html);
            }

            if (data.success) {
                html = '<div class="alert alert-success">' + data.message + '</div>';
                $('#form_result').html(html);
                $('#formPlan')[0].reset();
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        }
    });
});



});
</script>
@endsection
