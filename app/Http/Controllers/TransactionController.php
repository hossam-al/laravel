<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\cards;
use App\Models\Transaction;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $user = User::findOrFail($user_id);


        $transactions = Transaction::with('user')->get();
        return view('paymob.layout.transaction', compact('transactions', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $methods = PaymentMethod::all();
        $users = User::all();
        return   view('paymob.layout.create', compact('methods', 'users'));
    }
    function normalizeName($name)
    {
        return Str::lower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate(
            [
                'card_name' => 'required|string|min:2|max:50',
                'card_number' => "required|digits:16|regex:/^[0-9]{16}$/",
                'cvv' => 'required|string|size:3',
                'amount' => 'required|numeric|min:50|max:3000000',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'type' => 'required|string',

                'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/']
            ],
            [
                'expiry_date.required' => 'The expiration date is required.',
                'expiry_date.regex' => ' The date format must be MM/YY.',
            ]
        );

        $expiry = $request->input('expiry_date');
        list($month, $year) = explode('/', $expiry);


        $fullYear = 2000 + (int)$year;

        $currentMonth = date('n');
        $currentYear = date('Y');
        if ($fullYear < $currentYear || ($fullYear == $currentYear && $month < $currentMonth)) {
            return redirect()->back()->withErrors(['expiry_date' => 'The card has already expired.'])->withInput();
        }
        $card = cards::where('card_number', $request->card_number)->first();

        if ($card != null) {
            if ($card && $this->normalizeName($card->user->name) == $this->normalizeName($request->card_name) && $request->card_number == $card['card_number'] && $request->cvv == $card['cvv'] && $month == $card['expiry_month'] && $year == $card['expiry_year']) {
                $user_id = Auth::user()->id;
                $transaction_number = 'TXN-' . strtoupper(uniqid());
                $user = User::findOrFail($user_id);
                if ($request['type'] === 'withdraw') {
                    $balance = $user->balance();
                    if ($balance < $request['amount']) {
                        return redirect()->route('transaction.create')->with('error', 'الرصيد غير كافي لإجراء عملية السحب.');
                    } else {
                        Transaction::create([
                            'user_id' => $user_id,
                            'transaction_number' => $transaction_number,
                            'amount' => $request->amount,
                            'status' => 'pending',
                            'type' => $request->type,
                            'payment_method_id' => $request->payment_method_id
                        ]);
                    }
                } else {
                    // Handle deposit transactions
                    Transaction::create([
                        'user_id' => $user_id,
                        'transaction_number' => $transaction_number,
                        'amount' => $request->amount,
                        'status' => 'pending',
                        'type' => $request->type,
                        'payment_method_id' => $request->payment_method_id
                    ]);
                }
                return redirect()->route('transaction.index')->with('success', 'تم تنفيذ العملية ويتم الان مراجعتها');
            } else {
                return redirect()->back()->with('error', 'The card details are incorrect.');
            }
        } else {
            return redirect()->back()->with('error', 'The card details are incorrect.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
    public function pending()
    {
        $transactions = Transaction::with(['user', 'paymentMethod'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('paymob.layout.pending', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:success,failed',
        ]);

        $txn = Transaction::findOrFail($id);

        if ($txn->status !== 'pending') {
            return back()->with('error', 'المعاملة ليست معلقة.');
        }

        $txn->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة المعاملة.');
    }
    public function dashboard()
    {
        $id = Auth::user()->id;


        $user = User::findOrFail($id);

        $count = $user->transactions()->count();

        $successCount = $user->transactions()->where('status', 'success')->count();
        $failedCount  = $user->transactions()->where('status', 'failed')->count();
        $pendingCount = $user->transactions()->where('status', 'pending')->count();
        $cards = cards::where('user_id', $id)->first();

        return view('paymob.layout.index', compact('cards', 'count', 'successCount', 'failedCount', 'pendingCount'));
    }
}
