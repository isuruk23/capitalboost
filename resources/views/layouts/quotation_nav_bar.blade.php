
<div class="row nowrap" style="padding-top: 5px;padding-bottom: 5px;">

  @if(auth()->user()->can('quotation-list')
  || auth()->user()->can('approvel-list')
  || auth()->user()->can('approved-list'))
      <div class="dropdown">
      
        @can('quotation-list')
        <a role="button" class="btn navbtncolor" href="{{ route('quotationsview') }}" id="shift_link">Quotaions <span class="caret"></span></a>
        @endcan
        @can('approvel-list')
        <a role="button" class="btn navbtncolor" href="{{ route('quotaionappove') }}" id="work_shift_link">Approve<span class="caret"></span></a>
        @endcan
        @can('approved-list')
        <a role="button" class="btn navbtncolor" href="{{ route('quotaionappovedview') }}" id="work_shift_link_ap">Approved Quotaion<span class="caret"></span></a>
        @endcan
        @can('plan-instalment')
        <a role="button" class="btn navbtncolor" href="{{ route('installmentpayments') }}" id="additional_shift_link">Installment Payment Details <span class="caret"></span></a>
        @endcan



      </div>
  @endif
    </div>


