<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Quotation;
use App\Models\Customer;

class CusDashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $quotations = Quotation::where('email', $customer->email)
            ->with(['plan', 'subplan'])
            ->get();

        return view('customer.dashboard', compact('customer', 'quotations'));
    }
}
