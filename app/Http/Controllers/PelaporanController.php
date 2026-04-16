<?php

namespace App\Http\Controllers;

use App\Models\ReportedRoad;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Nette\Utils\Json;
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
            'deskripsi' => 'string|nullable',
            'path_foto_jalanan' => 'array|required',
            'path_foto_jalanan.*' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180'
        ]);

        $imagePaths = [];

        if($request->hasFile('path_foto_jalanan')){
            foreach($request->file('path_foto_jalanan')as $file){

                $path = $file->store('path_foto_jalanan','public');

                $imagePaths[] = $path;
            };

            
        }
        $data['path_foto_jalanan'] = json_encode($imagePaths);
        $data['user_id'] = Auth::id();

        ReportedRoad::create($data);

        return redirect()->route('dashboard')->with('success','Berhasil Membuat Laporan!');
    }

    public function showLaporan($id)
    {
        $laporan = ReportedRoad::with('user')->findOrFail($id);

        return view('officer.detail-laporan',compact('laporan'));
    }

    public function destroy($id)
    {
        $laporan = ReportedRoad::findOrFail($id);

        $laporan->delete();

        return redirect()->back();
    }

}
