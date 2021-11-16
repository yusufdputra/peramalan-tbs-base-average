<?php
//get data set

use App\data_sets;
use App\DataLatihModel;
use App\DataUjiModel;
use App\DataTransformModel;
use App\PelatihanModel;
use App\PengujianModel;
use App\DatasetModel;
use App\Datasets;
use App\Http\Controllers\DataController;
use Carbon\Carbon;
use Dotenv\Result\Result;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


function fts_py()
{

  //call py

  $py = shell_exec('C:\xampp\htdocs\fts_ab Dini Fisabti\app\ftsab.py');

  $tanggal = Datasets::select('tanggal')->get();
  $arr_tanggal = [];
  foreach ($tanggal as $key => $value) {
    $arr_tanggal[$key] = $value->tanggal;
  };
  $last_date = Carbon::parse(end($arr_tanggal));
  $date = $last_date->modify('+1 day')->format('d-F-Y');

  $peramalan = (json_decode($py));


  return (array( $arr_tanggal, $peramalan,$date));
}
