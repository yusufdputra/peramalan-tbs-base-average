@extends('layout.master')

@section('title', 'Dashboard')

@section('container')
<div id="loading_page">

</div>

<div class="container-fluid">

  <!-- Page-Title -->
  <div class="row">
    <div class="col-sm-12">
      <h4 class="page-title">Peramalan </h4>
    </div>
  </div>

  <!-- end page title end breadcrumb -->


  <div class="row">

    <div class="col-lg-8">
      <div class="card-box">
        <div class="col-auto mb-3">
          <form class="form-inline">

            <div class="form-row align-items-center ">
              <div class="button-list">
                <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger waves-effect waves-light">Hapus</a>
                <a href="#import-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-warning waves-effect waves-light">Import</a>
                <a href="#tambah-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success waves-effect waves-light">Tambah </a>
                <button type="button" onclick="do_forecasting()" class="btn btn-primary waves-effect waves-light">Prediksi</button>
              </div>
            </div>
          </form>
        </div>


        <div class="col-lg-12">
          <!-- notifikasi form validasi -->
          @if ($errors->has('file'))
          <div class="alert alert-danger">
            <div>{{$errors->first('file')}}</div>
          </div>
          @endif


          @if ($success = Session::get('success'))
          <div class="alert alert-success">
            <div>{{$success}}</div>
          </div>
          @endif

          @if ($error = Session::get('error'))
          <div class="alert alert-danger">
            <div>{{$error}}</div>
          </div>
          @endif
        </div>



        <div class="card col-sm-12   m-b-20">
          <div class="table-responsive">


            <table class="responsive-datatable text-center table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

              <thead>
                <tr>
                  <th>No.</th>
                  <th>Tanggal</th>
                  <th>TBS Olah</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data['datasets'] as $key=> $value)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{date_format (new DateTime($value->tanggal), 'd-F-Y')}}</td>
                  <td>{{$value->tbs_olah}}</td>
                  <td>

                    <a href="#edit-modal" data-id='{{$value->id}}' data-tanggal="{{$value->tanggal}}" data-tbs="{{$value->tbs_olah}}" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success waves-effect waves-light edit_row"><i class="fa fa-edit"></i></a>
                    <a href="#hapus-row-modal" data-id='{{$value->id}}' data-tbs="{{$value->tbs_olah}}" data-tanggal="{{date_format (new DateTime($value->tanggal), 'd-F-Y')}}" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger waves-effect waves-light hapus_row"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>



      </div>
    </div>
    <!-- end col -->
    <div class="col-lg-4">
      <div class="card-box">
        <div class="row ">
          <div class="col-lg-12">
            <?php
            ?>


            <h4 class="header-title mt-2 mr-2">Peramalan Besok:</h4>

            <div class="widget-box-2">
              <div class="widget-detail-2">
                <span class="badge badge-primary badge-pill pull-left m-t-10"> <span id="badge_tanggal">Tanggal: </span> </span>
                <h2 class="mb-0 text-primary" id=""> <span id="angka_peramalan">-</span> </h2>
                <p class="text-muted ">TBS</p>
              </div>
              <div class="progress progress-bar-info-alt progress-sm mb-0">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">

                </div>
              </div>
            </div>
          </div>

        </div>


      </div>


    </div>

  </div>

  <div class="row">

    <div class="col-lg-12">
      <div class="card-box">
        <h4 class="header-title mt-0 m-b-30">Grafik</h4>
        <div id="chartContent">
          <canvas id="lineChart_aktual" width="300" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Import-->
<div id="import-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">
    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Import Data</h4>
    </div>
    <div class="p-20">
      <form action="import" method="POST" enctype="multipart/form-data">
        <div class="input-group">
          @csrf

          <input type="file" required accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" class="dropify" />

        </div>
        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-block btn-xs waves-effect waves-light" type="submit">Import</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Modal Hapus data-->
<div id="hapus-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>
  <div class="custom-modal-text">
    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Hapus Data</h4>
    </div>
    <div class="p-20">
      <form action="remove_data" method="POST" enctype="multipart/form-data">
        <p class="text-muted m-b-15 font-13">
          Silahkan pilih tanggal yang ingin dihapus!
        </p>
        <div class="input-group">
          @csrf

          <input type="text" name="start_date" class="form-control datepicker-autoclose-modal" placeholder="Pilih Tanggal Awal" required autocomplete="off">
          <input type="text" name="end_date" class="form-control datepicker-autoclose-modal" placeholder="Pilih Tanggal Akhir" required autocomplete="off">

        </div>
        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-danger btn-block btn-xs waves-effect waves-light" type="submit">Hapus</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- end row -->
<div id="tambah-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">
    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Tambah Dataset</h4>
    </div>
    <div class="p-20">
      <form action="store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="text-left">
          <div class="row mb-3">
            <label for="nama" class="col-4 col-xl-3 col-form-label">Tanggal</label>
            <div class="col-8 col-xl-9">
              <input class="form-control" type="date" autocomplete="off" name="tanggal" required="" placeholder="Pilih Tanggal">
            </div>
          </div>
          <div class="row mb-3">
            <label for="nama" class="col-4 col-xl-3 col-form-label">TBS Olah</label>
            <div class="col-8 col-xl-9">
              <input class="form-control" type="number" autocomplete="off" name="tbs" required="" placeholder="Jumlah TBS">
            </div>
          </div>

        </div>
        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-block btn-xs waves-effect waves-light" type="submit">Tambah</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<div id="edit-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">
    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Edit Dataset</h4>
    </div>
    <div class="p-20">
      <form action="update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="text-left">
          <input type="hidden" name="id" id="edit_id">
          <div class="row mb-3">
            <label for="nama" class="col-4 col-xl-3 col-form-label">Tanggal</label>
            <div class="col-8 col-xl-9">
              <input class="form-control" type="date" autocomplete="off" id="edit_tanggal" name="tanggal" required="" placeholder="Pilih Tanggal">
            </div>
          </div>
          <div class="row mb-3">
            <label for="nama" class="col-4 col-xl-3 col-form-label">TBS Olah</label>
            <div class="col-8 col-xl-9">
              <input class="form-control" type="number" autocomplete="off" id="edit_tbs" name="tbs" required="" placeholder="Jumlah TBS">
            </div>
          </div>

        </div>
        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-block btn-xs waves-effect waves-light" type="submit">Ubah</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<div id="hapus-row-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">
    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Hapus Dataset</h4>
    </div>
    <div class="p-20">
      <form action="delete" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="text-center">
          <input type="hidden" id='id_hapus' name='id'>
          <h5 class="text-center" id="exampleModalLabel">Apakah anda yakin ingin mengapus data tanggal <h6 class="badge badge-danger" id="datasets_hapus"></h6> ?</h5>

        </div>
        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-block btn-xs waves-effect waves-light" type="submit">Hapus</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>



@endsection