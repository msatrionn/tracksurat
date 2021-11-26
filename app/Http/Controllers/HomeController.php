<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->level == 'admin') {
            return redirect('dashboard');
        } elseif (auth()->user()->level == 'tata_usaha') {
            return redirect('dashboard');
        } elseif (auth()->user()->level == 'kepala_sekolah') {
            return redirect('dashboard_kepsek');
        } elseif (auth()->user()->level == 'disposisi') {
            return redirect('dashboard_waka');
        }
    }
}
