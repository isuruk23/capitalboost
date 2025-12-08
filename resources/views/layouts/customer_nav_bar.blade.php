
<div class="row nowrap" style="padding-top: 5px;padding-bottom: 5px;">

  @if(auth()->user()->can('customer-list')
  || auth()->user()->can('customer-list')
  || auth()->user()->can('customer-list'))
      <div class="dropdown">
        @can('customer-list')
        <a role="button" class="btn navbtncolor" href="{{ route('customer.index') }}" id="shift_link">Customers <span class="caret"></span></a>
        @endcan
       



      </div>
  @endif
    </div>


