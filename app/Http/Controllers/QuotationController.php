<?php

namespace App\Http\Controllers;

use App\Quotation;
use App\Investment;
use App\Investmentplan;
use App\Customer;
use App\Mail\QuotationEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PDF;
use Carbon\Carbon;
use NumberToWords\NumberToWords;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
        return view('Quotations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_with_initial' => 'required|string|max:255',
            'address' => 'required|string',
            'nic_no' => 'required|string|max:12',
            'paying_term' => 'required|string',
            'mode_of_payment' => 'required|string',
            'plan_id' => 'required',
            'subplan' => 'required',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $quotation = new Quotation();
        $quotation->name_with_initial = $request->name_with_initial;
        $quotation->nic_no = $request->nic_no;
        $quotation->address = $request->address;
        $quotation->period = 0;
        $quotation->paying_term = $request->paying_term;
        $quotation->mode_of_payment = $request->mode_of_payment;
        $quotation->sales_by = $request->user()->id;
        $quotation->plan_id = $request->plan_id;
        $quotation->sub_plan_id = $request->subplan;
        $quotation->email = $request->email;
        $quotation->status = 1;
        $quotation->save();

        $plainPassword = generatePassword(8);

        $customer = new Customer();
        $customer->name_with_initial = $request->name_with_initial;
        $customer->fullname = $request->name_with_initial; // if fullname exists
        $customer->address = $request->address;
        $customer->nic_no = $request->nic_no;
        $customer->email = $request->email;

        $customer->password = Hash::make($plainPassword);  // hashed
        $customer->password_plain = $plainPassword;        // readable password

        $customer->save();

        // Generate PDF
        $pdf = PDF::loadView('Quotations.quotation', ['quotaion' => $quotation]);
        $pdfPath = storage_path("app/public/quotation_{$quotation->id}.pdf");
        $pdf->save($pdfPath);

        // Email with login credentials
        Mail::to($quotation->email)->send(new QuotationEmail($quotation, $plainPassword, $pdfPath));

        return response()->json(['success' => true, 'message' => 'Quotation Created & Login Sent!']);
    }

    public function dashboard(){
      
        return view('Dashboard.quotation');
    }
    public function edit($id){
       
        $user = Auth::user();
        $permission = $user->can('quotation-edit');
        if(!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        if (request()->ajax()) {
            $data =   Quotation::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

        public function update(Request $request)
    {
    
        $user = Auth::user();

        // Check permission
        if (!$user->can('quotation-edit')) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        // Validation rules
        $rules = [
            'name_with_initial' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'nic_no' => 'required|string|max:20',
            'paying_term' => 'required|string|max:50',
            'mode_of_payment' => 'required|string|max:50',
            'plan_id' => 'required',
            'subplan' => 'required',
        ];

        $error = Validator::make($request->all(), $rules);

    

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        // Find record
        $quotation = Quotation::find($request->hidden_id);

        if (!$quotation) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        // Update values
        $quotation->name_with_initial = $request->name_with_initial;
        $quotation->address = $request->address;
        $quotation->nic_no = $request->nic_no;
        $quotation->plan_id=$request->plan_id;
        $quotation->sub_plan_id=$request->subplan;
       
       
        $quotation->paying_term = $request->paying_term;
        $quotation->mode_of_payment = $request->mode_of_payment;

        $quotation->save();

    
         return response()->json(['success' => true, 'message' => 'Quotation successfully updated']);
    }

    

    public function show($id)
    {
        
       
         $quotation = DB::table('quotations')
            ->select(
                'quotations.*',                
                'investmentplans.invest_amount',
                'investmentplans.monthly_income',
                'investmentplans.term_of_years',
                'investmentplans.guaranteed_maturity',
                'mainplan.plan',
                'mainplan.id AS planid'
            )
            ->join('investmentplans', 'quotations.sub_plan_id', '=', 'investmentplans.id')
            ->join('investmentplans AS mainplan', 'quotations.plan_id', '=', 'mainplan.id')
            ->where('quotations.id', $id)
            ->first();
        $plans = InvestmentPlan::whereNotIn('plan_id',[0])->get();
        return response()->json([
            'quotation' => $quotation,
            'plans' => $plans
        ]);
    }

     public function getplans()
    {
        $plans = InvestmentPlan::where('plan_id',0)->get();
        return response()->json([
            'plans' => $plans
        ]);
    }
    public function getsubplans($id)
        {
            $plans = InvestmentPlan::where('plan_id',$id)->get();
            return response()->json([
                'sub_plans' => $plans
            ]);
        }

    

    public function approvel(Request $request)
    {
       
        $user = Auth::user();

        // Check permission
        if (!$user->can('quotation-approvel')) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        // Validation rules
        $rules = [
            'installment_date' => 'required'
        ];

        $error = Validator::make($request->all(), $rules);

    

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        // Find record
        $quotation = Quotation::find($request->quotaion_id);

        if (!$quotation) {
            return response()->json(['error' => 'Record not found'], 404);
        }
      
        // Update values
        $quotation->installment_date = $request->installment_date;
        $quotation->approved = 1;
        $quotation->approved_by = $request->user()->id;
        $quotation->approved_date = Carbon::now();

        $quotation->save();

        $exists = Customer::where('nic_no', $request->nic_no)->exists();

        if (!$exists){
        $customer = new Customer();
        $customer->name_with_initial = $request->name_with_initial;
        $customer->address = $request->address;
        $customer->nic_no = $request->nic_no;
        $customer->branch = Session::get('emp_location');
        $customer->save();
        }


        $investment = new Investment();
        $investment->name_with_initial = $request->name_with_initial;
        $investment->address = $request->address;
        $investment->nic_no = $request->nic_no;
        
        $investment->initial_investment = $request->initial_investment;
        $investment->period = $request->period;
        $investment->paying_term = $request->paying_term;
        $investment->mode_of_payment = $request->mode_of_payment;
        $investment->installment_date = $request->installment_date;
        $investment->plan_id = $request->plan;
       // $investment->location_id = $request->location_id;
       // $investment->block = $request->block;
        
        $investment->sales_by = $request->sales_by; // or pass manually
        $investment->approved_by = auth()->id() ?? 0;
        $investment->approved = 1;
        $investment->status = 1;
        $investment->quotation_id = $request->quotaion_id;
        
        $investment->save();
       

        return response()->json(['success' => 'Quotation successfully Approved']);
    }



    public function quotationsview(){
        $user = Auth::user();

         $quotations = DB::table('quotations')
         ->join('investmentplans', 'quotations.plan_id', '=', 'investmentplans.id')
          ->select('quotations.*', 'investmentplans.plan AS planName', 'investmentplans.term_of_years')
            ->where('quotations.status', 1)
            ->orderBy('id', 'desc')
            ->get();
         

        return view('Quotations.index', compact('quotations'));
    }
    
    public function quotaionappove(){
        $quotations=Quotation::where('status', 1)->where('approved',0)->get();
        return view('Quotations.approve', compact('quotations'));
    }


        public function quotaionappovedview(){
       
        $quotations = DB::table('quotations')
            ->join('users', 'quotations.approved_by', '=', 'users.id')
            ->join('employees', 'users.emp_id', '=', 'employees.emp_id')
            ->select('quotations.*', 'employees.emp_name_with_initial')
            ->where('quotations.status', 1)
            ->get();

        return view('Quotations.approvedquotaion', compact('quotations'));
    }
    
    public  function destroy($id){
      
        $user = Auth::user();
        $permission = $user->can('quotation-delete');
        if(!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        $data = Quotation::findOrFail($id);
        $data->delete();
    }

     public function generatequotation($id) {
        $quotaion = DB::table('quotations')
            ->select(
                'quotations.*',                
                'investmentplans.invest_amount',
                'investmentplans.monthly_income',
                'investmentplans.monthly_installment',
                'investmentplans.installment',
                'investmentplans.term_of_years',
                'investmentplans.guaranteed_maturity',
                'mainplan.plan',
                'mainplan.id AS planid'
            )
            ->join('investmentplans', 'quotations.sub_plan_id', '=', 'investmentplans.id')
            ->join('investmentplans AS mainplan', 'quotations.plan_id', '=', 'mainplan.id')
            ->where('quotations.id', $id)
            ->first();

            // dd($quotaion);
    
       
$amountInWords = convertNumberToWords($quotaion->monthly_income);

       
        $data = [
            'quotaion'       => $quotaion,
            'amountInWords'  => $amountInWords,
        ];

        $pdf = PDF::loadView('Quotations.quotation', $data)->setPaper('A4', 'portrait');
        return $pdf->download('policy.pdf');
}





    
}

function convertNumberToWords($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $dictionary  = [
        0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four',
        5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen',
        14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
        18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty',
        30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety',
        100 => 'hundred', 1000 => 'thousand', 1000000 => 'million'
    ];

    if (!is_numeric($number)) return false;

    $number = floatval($number);
    if ($number < 0) return $negative . convertNumberToWords(abs($number));

    $integerPart = floor($number);
    $fractionPart = round(($number - $integerPart) * 100); // only keep 2 decimals

    $string = convertWholeNumber($integerPart, $dictionary, $hyphen, $conjunction, $separator);

    if ($fractionPart > 0) {
        $string .= $conjunction . convertWholeNumber($fractionPart, $dictionary, $hyphen, $conjunction, $separator) . ' CENTS';
    }

    return strtoupper($string . ' ONLY');
}

function convertWholeNumber($number, $dictionary, $hyphen, $conjunction, $separator) {
    switch (true) {
        case $number < 21:
            return $dictionary[$number];
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            return $dictionary[$tens] . ($units ? $hyphen . $dictionary[$units] : '');
        case $number < 1000:
            $hundreds = (int) ($number / 100);
            $remainder = $number % 100;
            return $dictionary[$hundreds] . ' ' . $dictionary[100] . ($remainder ? $conjunction . convertWholeNumber($remainder, $dictionary, $hyphen, $conjunction, $separator) : '');
        default:
            foreach ([1000000 => 'million', 1000 => 'thousand'] as $base => $baseName) {
                if ($number >= $base) {
                    $numBaseUnits = (int) ($number / $base);
                    $remainder = $number % $base;
                    $result = convertWholeNumber($numBaseUnits, $dictionary, $hyphen, $conjunction, $separator) . ' ' . $baseName;
                    if ($remainder) {
                        $result .= $remainder < 100 ? $conjunction : $separator;
                        $result .= convertWholeNumber($remainder, $dictionary, $hyphen, $conjunction, $separator);
                    }
                    return $result;
                }
            }
    }
}
