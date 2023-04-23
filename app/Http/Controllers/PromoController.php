<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'voucher_id' => 'required'
        ]);

        $user = Auth::user();
        $voucher = Voucher::where('id', $validatedData['voucher_id'])->first();

        if($user->point < $voucher->price) {
            return redirect('/voucher')->with('error', 'Your point is insufficient');
        }

        $user->point = $user->point - $voucher->price;
        $user->save();

        $hasVoucher = $user->vouchers()->where('voucher_id', $voucher->id)->first();
        if($hasVoucher == NULL) {
            $user->vouchers()->attach($voucher, ['qty' => 1]);
        } else {
            $user->vouchers()->updateExistingPivot($voucher->id, ['qty' => 1 + $hasVoucher->promo->qty]);
        }

        return redirect()->back()->with('success', 'Voucher has been redeemed successfully!');
    }
}
