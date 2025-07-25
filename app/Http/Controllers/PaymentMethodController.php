<?php

namespace App\Http\Controllers;
use App\Models\cards;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
  $paymentMethod=PaymentMethod::all();
  return view('paymob.layout.Payment Methods',compact('paymentMethod'));
    }

    /**
     * Show the form for creating a new resource.
     */
       public function process(Request $request){
$card=cards::all();

$request->validate([
    'card_name'=>'required|string|min:2|max:50',
    'card_number'=>"required|digits:16|regex:/^[0-9]{16}$/",
     'cvv' => 'required|string|size:3',


     'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/']
],
 [
    'expiry_date.required' => 'The expiration date is required.',
    'expiry_date.regex' => ' The date format must be MM/YY.',
]);

$expiry = $request->input('expiry_date');
list($month, $year) = explode('/', $expiry);


$fullYear = 2000 + (int)$year;

$currentMonth = date('n');
$currentYear = date('Y');

if ($fullYear < $currentYear || ($fullYear == $currentYear && $month < $currentMonth)) {
    return redirect()->back()->withErrors(['expiry_date' => 'The card has already expired.'])->withInput();
}

}
    public function create()
    {


    return view('paymob.Payment.createpayment');;
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
