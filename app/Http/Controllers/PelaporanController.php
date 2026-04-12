<?php

namespace App\Http\Controllers;

use App\Models\ReportedRoad;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class PelaporanController extends Controller
{
    public function index()
    {
        return view('pelaporan');
    }

    public function laporan(Request $request)
    {
        $data = $request->validate([
            'nama_jalanan' => 'string|max:255|required',
            'path_foto_jalanan' => 'file|required',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180'
        ]);

        if($request->hasFile('path_foto_jalanan')){
            $imagePath = $request->file('path_foto_jalanan')->store('path_foto_jalanan','public');

            $data['path_foto_jalanan'] = $imagePath;
        }

        $data['user_id'] = Auth::id();

        ReportedRoad::create($data);

        return redirect()->route('dashboard')->with('success','Berhasil Membuat Laporan!');
    }

    public function showLaporan($id)
    {
        $laporan = ReportedRoad::with('user')->findOrFail($id);

        return view('officer.detail-laporan',compact('laporan'));
    }

}
