<?php

namespace App\Http\Controllers;

use App\Investmentplan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InvestmentplanController extends Controller
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
        $plans = InvestmentPlan::whereNotIn('plan_id', [0])->orderBy('plan_id')->get();
   
        return view('investmentplans.index', compact('plans'));
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
          $planId = (int) $request->input('plan_id');

    $rules = [
        'plan_id' => 'required|integer',
    ];

    // Conditional rules based on selected plan
    if (in_array($planId, [1, 2, 6, 7])) {
        $rules = array_merge($rules, [
            'invest_amount' => 'required|numeric',
            'monthly_income' => 'required|numeric',
            'guaranteed_maturity' => 'required|numeric',
        ]);
    } elseif ($planId === 3) {
        $rules = array_merge($rules, [
            'invest_amount' => 'required|numeric',
            'term_of_years' => 'required|integer',
            'guaranteed_maturity' => 'required|numeric',
        ]);
    } elseif (in_array($planId, [4, 5])) {
        $rules = array_merge($rules, [
            'invest_amount' => 'required|numeric',
            'term_of_years' => 'required|integer',
            'guaranteed_maturity' => 'required|numeric',
            'monthly_installment' => 'required|numeric',
            'installment' => 'required|integer',
            'total_payment' => 'required|numeric',
        ]);
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        // Return array of messages in "errors" key
        return response()->json(['errors' => $validator->errors()->all()], 422);
    }

    
        $data = $request->all();
        $data['plan'] = $request->plan . ' - ' . $request->invest_amount;
        $data['status'] = 1;

        InvestmentPlan::create($data);
    
        return response()->json(['success' => true, 'message' => 'Investment Plan saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Investmentplan  $investmentplan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        
        
       
        $plan = InvestmentPlan::find($id);

        

        if (!$plan) {
            return response()->json(['error' => 'Plan not found'], 404);
        }

        return response()->json($plan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investmentplan  $investmentplan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = InvestmentPlan::find($id);
        

        if (!$plan) {
            return response()->json(['error' => 'Plan not found'], 404);
        }
        
        return response()->json($plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investmentplan  $investmentplan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $planId = (int) $request->input('plan_id');

        $rules = [
            'plan_id' => 'required|integer',
        ];

        // Conditional rules based on selected plan
        if (in_array($planId, [1, 2, 6, 7])) {
            $rules = array_merge($rules, [
                'invest_amount' => 'required|numeric',
                'monthly_income' => 'required|numeric',
                'guaranteed_maturity' => 'required|numeric',
            ]);
        } elseif ($planId === 3) {
            $rules = array_merge($rules, [
                'invest_amount' => 'required|numeric',
                'term_of_years' => 'required|integer',
                'guaranteed_maturity' => 'required|numeric',
                'security_land' => 'required|string',
            ]);
        } elseif (in_array($planId, [4, 5])) {
            $rules = array_merge($rules, [
                'invest_amount' => 'required|numeric',
                'term_of_years' => 'required|integer',
                'guaranteed_maturity' => 'required|numeric',
                'monthly_installment' => 'required|numeric',
                'installment' => 'required|integer',
                'total_payment' => 'required|numeric',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Return array of messages in "errors" key
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $plan = InvestmentPlan::findOrFail($id);
        $data = $request->all();
        $data['plan'] = $request->plan . ' - ' . number_format($request->invest_amount, 0);
        $data['status'] = 1;

        $plan->update($data);
        return response()->json(['success' => true, 'message' => 'Investment Plan updated successfully!']);
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investmentplan  $investmentplan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = InvestmentPlan::findOrFail($id);
        $plan->delete();

        return redirect()->back()->with('success', 'Investment Plan deleted successfully!');
    }
}
