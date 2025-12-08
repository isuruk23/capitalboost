<?php

namespace App\Http\Controllers;

use App\Investment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use mPDF;

use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
     //  $investments = Investment::all();
       
        $investments = DB::table('investments')
        ->join('users as sales_user', 'investments.sales_by', '=', 'sales_user.id')
        ->join('users as approved_user', 'investments.approved_by', '=', 'approved_user.id')
        ->join('employees as sales_emp', 'sales_user.emp_id', '=', 'sales_emp.emp_id')
        ->join('employees as approved_emp', 'approved_user.emp_id', '=', 'approved_emp.emp_id')
        ->select(
            'investments.*',
            'sales_emp.emp_name_with_initial AS salesBy',
            'approved_emp.emp_name_with_initial AS approvedBy'
        )
        ->where('investments.approved',1)
        ->get();

  
        return view('investments.index', compact('investments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name_with_initial' => 'required|string',
            'nic_no' => 'required|string',
            'address' => 'required|string',
            'initial_investment' => 'required|numeric',
            'period' => 'required|string',
            'paying_term' => 'required|string',
            'mode_of_payment' => 'required|string',
            'plan_id' => 'required|integer',
            'location_id' => 'integer',
            'installment_date' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
   
     
        $investment = new Investment();
        $investment->name_with_initial = $request->name_with_initial;
        $investment->nic_no = $request->nic_no;
        $investment->address = $request->address;
        $investment->initial_investment = $request->initial_investment;
        $investment->period = $request->period;
        $investment->paying_term = $request->paying_term;
        $investment->mode_of_payment = $request->mode_of_payment;
        $investment->plan_id = $request->plan_id;
       // $investment->location_id = $request->location_id;
       // $investment->block = $request->block;
        $investment->installment_date = $request->installment_date;
        $investment->sales_by = auth()->id() ?? 0; // or pass manually
        $investment->approved_by = auth()->id() ?? 0;
        $investment->status = 1;
    
        $investment->save();
    
     

     
        $quotation = DB::table('quotations')->where('id', $request->quotation_id)->update(['approved' => 1]);
  return response()->json(['success' => true, 'message' => 'Quotation Approved!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show(Investment $investment,$id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investment $investment)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        //
    }

    

    public function installmentpayments(){
       $investments = DB::table('investments')
        ->where('approved', 1)
        ->get();

         return view('investments.payments', compact('investments'));
    }
}
