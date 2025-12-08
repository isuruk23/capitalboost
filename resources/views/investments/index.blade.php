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
                        <hr class="border-dark">
                    </div>
                    <div class="col-12">
                        <div class="center-block fix-width scroll-inner">
                        <table class="table table-striped table-bordered table-sm small nowrap" style="width: 100%" id="jobtable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>NIC</th>
                                <th>Address</th>
                                <th>Initial Investment (Rs)</th>
                                <th>Period</th>
                                <th>Installment Date</th>
                                <th>Sales By</th>
                                <th>Approved By</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($investments as $index => $investment)
                            <tr>
                            <td>{{ $investment->id }}</td>
                                <td>{{ $investment->name_with_initial }}</td>
                                <td>{{ $investment->nic_no }}</td>
                                <td>{{ $investment->address }}</td>
                                <td>{{ number_format($investment->initial_investment, 2) }}</td>
                                <td>{{ $investment->period }}</td>
                                <td>{{ \Carbon\Carbon::parse($investment->installment_date)->format('Y-m-d') }}</td>
                                <td>{{ $investment->salesBy }}</td>
                                <td>{{ $investment->approvedBy }}</td>
                                <td>
                                    @if ($investment->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('investments.show', $investment->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                   
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="16" class="text-center text-muted">No investments found.</td>
                            </tr>
                            @endforelse
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
                                <div class="form-group col-md-6">
                                        <label>Plan</label>
                                        <input type="text" name="plan" value="{{ old('plan', $plan->plan ?? '') }}" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Plan Value</label>
                                        <input type="text" name="plan_value" value="{{ old('plan_value', $plan->plan_value ?? '') }}" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Installment</label>
                                        <input type="number" name="installment" value="{{ old('installment', $plan->installment ?? '') }}" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Monthly Installment</label>
                                        <input type="text" name="monthly_installment" value="{{ old('monthly_installment', $plan->monthly_installment ?? '') }}" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Total Payment</label>
                                        <input type="text" name="total_payment" value="{{ old('total_payment', $plan->total_payment ?? '') }}" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Guaranteed Maturity</label>
                                        <input type="text" name="guaranteed_maturity" value="{{ old('guaranteed_maturity', $plan->guaranteed_maturity ?? '') }}" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Illustrated Maturity</label>
                                        <input type="text" name="illustrated_maturity" value="{{ old('illustrated_maturity', $plan->illustrated_maturity ?? '') }}" class="form-control form-control-sm">
                                    </div>
                                   
                                </div>
                                <button type="submit" name="action_button" id="action_button" class="btn btn-outline-primary btn-sm fa-pull-right px-4"><i class="fas fa-plus"></i>&nbsp;Add Plan</button>
                               
                                @if(isset($plan))
                                    <a href="{{ url('/investmentplans') }}" class="btn btn-secondary">Cancel</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
              
@endsection


@section('script')



@endsection
