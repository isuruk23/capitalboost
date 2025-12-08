<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CustomerController extends Controller
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
         $customers = Customer::all();
         return view('customer.index', compact('customers'));
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


     $rules = array(
          'name_with_initial' => 'required|string|max:255',
        'fullname'          => 'required|string|max:255',
        'address'           => 'required|string|max:255',
        'nic_no'            => 'required|string|max:20|unique:customers,nic_no',
        'dateofbirth'       => 'nullable|date',
        'phone'             => 'nullable|string|max:20',
        'mobile'            => 'required|string|max:20',
        'email'             => 'nullable|email|max:255',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $customer = new Customer();
        $customer->name_with_initial = $request->name_with_initial;
        $customer->address = $request->address;
        $customer->nic_no = $request->nic_no;
        $customer->fullname = $request->fullname;
        $customer->address = $request->address;
        $customer->dateofbirth = $request->dateofbirth;
        $customer->phoneno = $request->phone;
        $customer->mobileno = $request->mobile;
        $customer->branch = $request->mobile;
        $customer->email = $request->email;
        $customer->save();
        
          return response()->json(['success' => 'Customer created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
