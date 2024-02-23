<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::all();
        return view('Admin.Finance.index', compact('finances'));
    }
}
