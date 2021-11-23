<?php

namespace App\Http\Controllers;

use App\Datasets;
use App\Imports\DataActualImport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataController extends Controller
{


    public function forecasting()
    {

        try {
            return fts_py();
        } catch (\Throwable $th) {
            $msg = 'Data Kabupaten yang dipilih tidak tersedia! '.$th;
            return $msg;
        }
    }

    public function import(Request $request)
    {

        //validasi format
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        //get file excel
        $file = $request->file('file');

        //membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        //upload ke folder file_data didalam folder public
        $file->move('file_data', $nama_file);

        try {
            //import data
            $query = Excel::import(new DataActualImport, public_path('/file_data/' . $nama_file));

            //notifikasi dg session
            self::notif($query);
        } catch (\Throwable $th) {
            Session::flash('error', 'Terjadi kesalahan saat import!');
        }

        //alihkan halaman kembali
        return redirect('/');
    }

    public function remove_data(Request $request)
    {
        try {
            $query = Datasets::whereBetween('tanggal', [$request->start_date, $request->end_date])->delete();

            //notifikasi dg session
            self::notif($query);
        } catch (\Throwable $th) {
            Session::flash('error', 'Data Gagal dihapus!');
        }
        //alihkan halaman kembali
        return redirect('/');
    }

    public function update(Request $request)
    {
        // cek tanggal
        if (($request->tanggal_old != $request->tanggal) && (Datasets::where('tanggal', $request->tanggal)->exists())) {
            Session::flash('error', 'Oppss... Tanggal sudah ada!');
            return redirect('/');
        }
        $query = Datasets::where('id', $request->id)
        ->update([
            'tanggal'       => $request->tanggal,
            'tbs_olah'      => $request->tbs,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
        self::notif($query);
        
        return redirect('/');
    }

    public function store(Request $request)
    {
        // cek tanggal
        if (Datasets::where('tanggal', $request->tanggal)->exists()) {
            Session::flash('error', 'Oppss... Tanggal sudah ada!');
            return redirect('/');
        }
        $query = Datasets::insert([
            'tanggal'       => $request->tanggal,
            'tbs_olah'      => $request->tbs,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
            
        ]);

        self::notif($query);
        
        return redirect('/');
    }

    public function delete(Request $request)
    {
       $query = Datasets::where('id', $request->id)
       ->delete();

       self::notif($query);
        
       return redirect('/');
    }

    static function notif($query)
    {
        //notifikasi dg session
        if ($query) {
            Session::flash('success', 'Berhasil!');
        } else {
            Session::flash('error', 'Oppss... Terjadi Kesalahan!');
        }
    }


}
