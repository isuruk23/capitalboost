<!DOCTYPE html>
<html>
<head>
    <title>{{ $quotaion->plan }} - {{ $quotaion->term_of_years }} Years</title>
    <style>
        @page {
            margin: 0px 5px 0px 5px; /* top, right, bottom, left */
        }

        body {font-family: Arial, sans-serif; margin: 0; background-image: url("{{ public_path('images/gray_logo.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .header { margin-bottom: 10px; }
        .footer { margin-bottom: 20px; }
        .mt10{ margin-top:10px; }
        .mt20{ margin-top:20px; }
        .mt30{ margin-top:30px; }
        .mt50{ margin-top:50px; }
        .mt70{ margin-top:100px; }
        .header img, .footer img { width: 100%; }
        .page { page-break-after: always; margin: 50px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size:14px; }
        th, td { border: 1px solid #000; padding: 8px; }
        .signature-section { margin-top: 40px; font-size:14px; }
        .flex-container { display: flex; justify-content: space-between; margin-top: 30px; }
        .text-bold { font-weight: bold; }
        .no-border-table {
            width: 100%;
            border-collapse: collapse;
        }

        .no-border-table th,
        .no-border-table td {
            border: none;
            padding: 6px;
            height: 40px; /* Set row height here */
        }
        .page {
            page-break-after: always;
            margin: 50px;
        }

        .page:last-of-type {
            page-break-after: auto;
        }
    </style>
</head>
<body>
    <!-- Page 1 -->
    <div class="page">
        <div class="header">
            <img src="{{ public_path('images/header.png') }}">
        </div>

        <table class="no-border-table" style="margin-top: 30px;">
             <tr> 
              <td > </td>
              <td class="text-bold">Quotation ID : #{{ str_pad($quotaion->id, 6, '0', STR_PAD_LEFT) }}</td>
              </tr>
                <tr>
                    <td class="text-bold"><h4>PRODUCT :  {{ $quotaion->plan }} - {{ $quotaion->term_of_years }} Years</h4></td>
                    <td><div class="text-bold">Date – {{ date('d/m/Y', strtotime($quotaion->created_at)) }}</div></td>
                </tr>
        </table>
        
        <table class="no-border-table " style="margin-top: 10px;">
                <tr>
                    <td><span class="text-bold">Full Name</span> </td>
                    <td> : </td>
                    <td>{{ $quotaion->name_with_initial }}</td>
                </tr>
                
                <tr>
                    <td><span class="text-bold">Name with Initial</span></td>
                    <td> : </td>
                    <td>{{ $quotaion->name_with_initial }}</td>
                </tr>
                <tr>
                    <td><span class="text-bold">Address :</span></td>
                    <td> : </td>
                    <td> {{ $quotaion->address }}</td>
                </tr>
                <tr>
                    <td><span class="text-bold">NIC No :</span> </td>
                    <td> : </td>
                    <td>{{ $quotaion->nic_no }}</td>
                </tr>
                @if(in_array($quotaion->planid, [4]))
                <tr>
                    <td><span class="text-bold">Monthly Cultivation Contribution :</span></td>
                    <td> : </td>
                    <td>Rs {{ number_format($quotaion->monthly_installment, 2) }}</td>
                </tr>
                @else

                <tr>
                    <td><span class="text-bold">Initial Construction Contribution :</span></td>
                    <td> : </td>
                    <td>Rs {{ number_format($quotaion->invest_amount, 2) }}</td>
                </tr>

                @endif
                <tr>
                    <td><span class="text-bold">Project Period :</span></td>
                    <td> : </td>
                    <td>{{ $quotaion->term_of_years }} Years</td>
                </tr>
                <tr>
                    <td><span class="text-bold">Paying Term :</span></td>
                    <td> : </td>
                    <td>{{ $quotaion->paying_term }}</td>
                </tr>
                <tr>
                    <td><span class="text-bold">Monthly Income :</span></td>
                    <td> : </td>
                    <td>  @if(!empty($quotaion->monthly_income)) Rs {{ number_format($quotaion->monthly_income, 2) }} X {{ ($quotaion->term_of_years * 12) }} <div>({{ $amountInWords }}) @else - @endif</td>
                </tr>
                <tr>
                    <td><span class="text-bold">Mode of Payment :</span></td>
                    <td> : </td>
                    <td>{{ $quotaion->mode_of_payment }}</td>
                </tr>
                <tr>
                    <td><span class="text-bold">Expect of the land :</span></td>
                    <td> : </td>
                    <td> </td>
                </tr>
        </table>
    <div class="footer mt70">
            <!-- <img src="{{ public_path('images/footer.png') }}"> -->
        </div>
        
    </div>

    <!-- Page 2 -->
    <div class="page">
        <div class="header">
              <!-- <img src="{{ public_path('images/header.png') }}"> -->
             
        </div>

     <table class="no-border-table">
                <tr>
                    <td class="text-bold"><h4>PRODUCT :  {{ $quotaion->plan }} - {{ $quotaion->term_of_years }} Years</h4></td>
                    <td><div class="text-bold">Date – {{ date('d/m/Y', strtotime($quotaion->created_at)) }}</div></td>
                </tr>
        </table>
        @if(in_array($quotaion->planid, [1, 2, 6, 7]))
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Invest Amount</th>
                    <th width="120px">Monthly Income</th>
                    <th>Yearly Return</th>
                    <th colspan="2" >Total Return</th>
                </tr>
            </thead>
            <tbody>
                @for($year = 1; $year <= $quotaion->term_of_years; $year++)
                <tr>
                    <td>{{ str_pad($year, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $year === 1 ? number_format($quotaion->invest_amount, 2) . ' (One time)' : '' }}</td>
                    <td>Rs {{ number_format($quotaion->monthly_income) }} x 12</td>
                    <td>Rs {{ number_format($quotaion->monthly_income * 12) }}</td>
                   
                    @if($year == $quotaion->term_of_years)
                   <td>Rs {{ number_format($quotaion->monthly_income * 12 * $quotaion->term_of_years) }}</td>
                   <td>Rs {{ number_format($quotaion->guaranteed_maturity) }}</td>
                    @else
                     <td colspan="2"></td>
                    @endif
                </tr>
                @endfor
                <tr>
                    <td colspan="5" style="text-align: right">Total</td>
                    <td>Rs {{number_format($quotaion->guaranteed_maturity+($quotaion->monthly_income * 12 * $quotaion->term_of_years))}}</td>
                </tr>
            </tbody>
        </table>
        @endif
         @if(in_array($quotaion->planid, [3,4,5]))
          <table style="width: 80%">
                <tr>
                    <td class="text-bold">Investment Amount</td>
                    <td>Rs  {{ number_format($quotaion->invest_amount) }}</td>
                </tr>
                <tr>
                    <td class="text-bold">Terms</td>
                    <td>{{ $quotaion->term_of_years }} Years</td>
                </tr>
                   @if(in_array($quotaion->planid, [4]))
                 <tr>
                    <td class="text-bold"> Payment Terms</td>
                    <td>{{ $quotaion->installment }} Months</td>
                </tr>
                   @endif
                <tr>
                    <td class="text-bold">Guaranteed Maturity</td>
                    <td>Rs  {{ number_format($quotaion->guaranteed_maturity) }}</td>
                </tr>
              
            </table>

         @endif
        <div style="margin-top: 10px;">
            <table style="width: 80%">
                <tr>
                    <td class="text-bold">Account Name</td>
                    <td>Dynamicgreen Plantations (pvt) Ltd</td>
                </tr>
                <tr>
                    <td class="text-bold">Account NO</td>
                    <td>1000565858</td>
                </tr>
                <tr>
                    <td class="text-bold">Bank</td>
                    <td>Commercial Bank</td>
                </tr>
                <tr>
                    <td class="text-bold">Branch</td>
                    <td>Rajagiriya</td>
                </tr>
            </table>
        </div>

        <div class="signature-section">
            <div class="text-bold">Conditions :</div>
            <ol>
                <li>This Quotation valid only 30 days.</li>
                <li>This is a price notice and the terms of the agreement will be applied.</li>
            </ol>
            <table class="no-border-table mt50">
                <tr>
                    <td style="text-align: center; font-size:14px;">  
                        <div>....................................................</div>
                        <div>Signature</div>
                        <div class="text-bold">Agri Investment Manager / Consultant</div>
                    </td>
                    <td style="text-align: center;  font-size:14px;">
                       <div>....................................................</div>
                        <div>Signature</div>
                        <div class="text-bold">Customer</div>
                    </td>
                    
                </tr>
         </table>

            
        </div>
        <div class="footer mt50">
            <img src="{{ public_path('images/footer.png') }}">
        </div>
        
    </div>
</body>
</html>