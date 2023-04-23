<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $histories = Transaction::where('sender_id', Auth::user()->id)->get();
        return view('pages.history', compact('histories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $validatedData = $request->validate([
            'recipient_currency' => 'required',
            'recipient_name' => 'required|min:3',
            'amount' => 'required|numeric|min:10000',
            'transfer_fee' => 'required',
        ]);

        $user = Auth::user();
        
        $response = Http::get("https://v6.exchangerate-api.com/v6/b0ac1c255cda5360668a0732/pair/" . $user->currency . "/" . $validatedData['recipient_currency'] . "/" . $validatedData['amount']);
        if ($response->successful()) {
            $data = $response->json();
            $validatedData['amount'] = $data["conversion_result"];
        } else {
            return redirect()->back()->with('error', 'Internal Server Error');
        }
        
        $validatedData['sender_id'] = $user->id;
        $point = round(0.00005 * $validatedData['amount'] ,0);
        
        
        $user->point = $user->point + $point;
        $user->save();
        
        if($request->input('voucher') != NULL) {
            $voucher = Voucher::where('id', $request->input('voucher'))->first();
            $discount = $voucher->percent_discount/100;
            $validatedData['transfer_fee'] = $validatedData['transfer_fee'] - round(($validatedData['transfer_fee']*$discount), 2);   

            $qty = $user->vouchers()->wherePivot('voucher_id', $voucher->id)
            ->first()
            ->promo
            ->qty;

            $user->vouchers()->updateExistingPivot($voucher->id, ['qty' => $qty - 1]);

            $user->vouchers()->wherePivot('qty', 0)->detach($voucher->id);     
        }

        Transaction::create($validatedData);

        return redirect()->back()->with('success', 'Transaction successfull!');

    }
}
