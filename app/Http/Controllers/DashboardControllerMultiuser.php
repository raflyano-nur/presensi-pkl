<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardControllerMultiuser extends Controller
{
    public function DashboardAdmin()
    {
        return view('page.admin.dashboard', [
            "titlePage" => "dashboard"
        ]);
    }

    public function DashboardSiswa()
    {
        return view('siswa.dashboard', [
            "titlePage" => "dashboard"
        ]);
    }

    public function DashboardPembimbing()
    {
        return view('pembimbing.dashboard', [
            "titlePage" => "dashboard"
        ]);
    }
    
    public function DashboardWaliKelas()
    {
        return view('waliKelas.dashboard', [
            "titlePage" => "dashboard"
        ]);
    }
}
