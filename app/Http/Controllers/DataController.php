<?php

namespace App\Http\Controllers;

use App\Datasets;
use App\Imports\DataActualImport;
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
            if ($query != false) {
                Session::flash('success', 'Data berhasil diimport!');
            } else {
                Session::flash('error', 'Terjadi kesalahan saat import!');
            }
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
            if ($query) {
                Session::flash('success', 'Data berhasil dihapus!');
            } else {
                Session::flash('error', 'Data Gagal dihapus!');
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Data Gagal dihapus!');
        }
        //alihkan halaman kembali
        return redirect('/');
    }


}
