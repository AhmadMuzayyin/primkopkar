<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiJasaController extends Controller
{
    public function index()
    {
        return view('transaksi_jasa.index');
    }
}
