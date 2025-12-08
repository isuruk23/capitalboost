
<div class="row nowrap" style="padding-top: 5px;padding-bottom: 5px;">
@auth
  @if(auth()->user()->can('investment-plan')
  || auth()->user()->can('investment-list')
  || auth()->user()->can('plan-instalment'))
      <div class="dropdown">
        @can('investment-plan')
        <a role="button" class="btn navbtncolor" href="{{ route('investmentplans') }}" id="shift_link">Investment Plan <span class="caret"></span></a>
        @endcan
        @can('investment-list')
        <a role="button" class="btn navbtncolor" href="{{ route('investment') }}" id="work_shift_link">Investment<span class="caret"></span></a>
        @endcan
        @can('plan-instalment')
        <a role="button" class="btn navbtncolor" href="{{ route('installmentpayments') }}" id="additional_shift_link">Installment Payment Details <span class="caret"></span></a>
        @endcan



      </div>
  @endif
    @endauth
    </div>


