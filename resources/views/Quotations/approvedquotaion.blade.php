@extends('layouts.app')

@section('content')

<main>
                   
<div class="page-header shadow">
        <div class="container-fluid">
            @include('layouts.quotation_nav_bar')
           
        </div>
    </div>
    <div class="container-fluid mt-4">
                        <div class="row">
                        
                           
                            <div class="col-lg-12">
                                <div id="default">
                                    <div class="card mb-4">
                                      
                                        <div class="card-body">
                                        <div class="datatable table-responsive">
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
                                                <th>Approved By</th>   
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
                                                <td>{{$quotation->emp_name_with_initial}}</td>
                                                <td>  <button name="edit" id="{{$quotation->id}}" class="edit btn btn-primary btn-sm" type="submit">Edit</button>  
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
                    </div>


					 
                    
                </main>
              
@endsection


@section('script')

<script>
$(document).ready(function(){
    $('#shift_menu_link').addClass('active');
    $('#shift_menu_link_icon').addClass('active');
    $('#work_shift_link_ap').addClass('navbtnactive');

});
</script>

@endsection