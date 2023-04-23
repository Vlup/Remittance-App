<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;

use App\Models\Voucher;
class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $json = Voucher::all()->toJson();
        $data = json_decode($json, true, JSON_UNESCAPED_SLASHES);
        return response()->json($data, Response::HTTP_OK);
    }
}
