<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Peramalan TBS - FTS AVERAGE BASED</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
  <meta content="Coderthemes" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />




  <!-- App favicon -->
  <link rel="shortcut icon" href="adminto/images/favicon.ico">

  <!-- Notification css (Toastr) -->
  <link href="adminto/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

  <!-- App css -->
  <link href="adminto/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="adminto/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="adminto/css/style.css" rel="stylesheet" type="text/css" />

  <!-- loading -->
  <link href="adminto/css/loading.css" rel="stylesheet" type="text/css" />

  <script src="adminto/js/modernizr.min.js"></script>

  <!-- Custom box css -->
  <link href="adminto/plugins/custombox/dist/custombox.min.css" rel="stylesheet">

  <!-- Plugins css-->
  <link href="adminto/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
  <!-- DataTables -->
  <link href="adminto/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="adminto/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="adminto/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

  <link href="adminto/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <!-- form Uploads -->
  <link href="adminto/plugins/fileuploads/css/dropify.min.css" rel="stylesheet" type="text/css" />
  @toastr_css

</head>

<body>

  <!-- Navigation Bar-->
  <header id="topnav">
    <div class="topbar-main">
      <div class="container-fluid">

        <!-- Logo container-->
        <div class="logo">
          <!-- Text Logo -->
          <!--<a href="index.html" class="logo">-->
          <!--<span class="logo-small"><i class="mdi mdi-radar"></i></span>-->
          <!--<span class="logo-large"><i class="mdi mdi-radar"></i> Adminto</span>-->
          <!--</a>-->
          <!-- Image Logo -->
          <a href="{{'/'}}" class="logo">
            <span class="logo-small"><i class="mdi mdi-radar"></i></span>
            <span class="logo-large"><i class="mdi mdi-radar"></i> FTS-AB</span>
          </a>
        </div>
        <!-- End Logo container-->

        <div class="menu-extras topbar-custom">

          <ul class="list-unstyled topbar-right-menu float-right mb-0">

            <li class="menu-item">
              <!-- Mobile menu toggle-->
              <a class="navbar-toggle nav-link">
                <div class="lines">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </a>
              <!-- End mobile menu toggle-->
            </li>



            <li class="dropdown notification-list">
              <!-- <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="adminto/images/users/avatar-1.png" alt="user" class="rounded-circle">
              </a> -->
              <!-- <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                  @if(Session::get('status_login') == 1)
                  <a href="{{'logout'}}" class="dropdown-item notify-item">
                    <i class="ti-power-off m-r-5"></i> Logout
                    @endif
                    @if(Session::get('status_login') == 0)
                    <a href="#login-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="dropdown-item notify-item">
                      <i class="ti-power-off m-r-5"></i> Login

                    </a>
                    @endif
                  </a>




                </div> -->
            </li>

          </ul>
        </div>

        <!-- End Notification bar -->
        <!-- end menu-extras -->

        <div class="clearfix"></div>

      </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="navbar-custom">
      <div class="container-fluid">
        <div id="navigation">
          <!-- Navigation Menu-->

          <ul class="navigation-menu">
            <li class="has-submenu">
              <a href="{{'/'}}"><i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span> </a>
            </li>

            @if(Session::get('status_login') == 1)
            <li class="has-submenu">
              <a href="#"><i class="mdi mdi-layers"></i> <span>Data </span> </a>
              <ul class="submenu ">
                <li><a href="{{'data'}}">Datasets</a></li>
                <li class="has-submenu">
                  <a href="#">Normalisasi Data</a>
                  <ul class="submenu" style="left:195px !important">
                    <li>
                      <a href="{{'normalisasi-latih'}}">Pelatihan</a>
                    </li>
                    <li>
                      <a href="{{'normalisasi-uji'}}">Pengujian</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="has-submenu">
              <a href="#"><i class="mdi mdi-calculator"></i> <span>FTS Cheng </span> </a>
              <ul class="submenu">
                <li><a href="{{'pelatihan'}}">Pelatihan</a></li>
                <li><a href="{{'pengujian'}}">Pengujian</a></li>
              </ul>
            </li>
            @endif

            </a>



          </ul>
          <!-- End navigation menu -->
        </div> <!-- end #navigation -->
      </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
  </header>
  <!-- End Navigation Bar-->

  <!-- Modal -->
  <div id="login-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
      <span>&times;</span><span class="sr-only">Close</span>
    </button>

    <div class="custom-modal-text">

      <div class="text-center">
        <h4 class="text-uppercase font-bold mb-0">Sign In</h4>
      </div>
      <div class="p-20">

        @if(\Session::has('alert'))
        <div class="alert alert-danger">
          <div>{{Session::get('alert')}}</div>
        </div>
        @endif
        @if(\Session::has('alert-success'))
        <div class="alert alert-success">
          <div>{{Session::get('alert-success')}}</div>
        </div>
        @endif

        <input id="title" type="hidden" class="input-large form-control" value="Login berhasil" placeholder="Enter a title ..." />

        <form class="form-horizontal m-t-20" action="{{'loginPost'}}" method="POST">
          {{csrf_field()}}
          <div class="form-group">
            <div class="col-xs-12">
              <input class="form-control" type="text" name="email_l" required="" placeholder="Email">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-12">
              <input class="form-control" type="password" name="password_l" required="" placeholder="Password">
            </div>
          </div>



          <div class="form-group text-center m-t-30">
            <div class="col-xs-12">
              <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">Log In</button>
            </div>
          </div>


        </form>

      </div>
    </div>

  </div>


  <div class="wrapper">
    @yield('container')

  </div>
  <!-- end wrapper -->


  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          Peramalan Titik Panas Provinsi Riau Menggunakan Metode Cheng - Yusuf Dwi Putra
        </div>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  @jquery
  @toastr_js
  @toastr_render

  <!-- jQuery  -->
  <script src="adminto/js/jquery.min.js"></script>
  <script src="adminto/js/popper.min.js"></script>
  <script src="adminto/js/bootstrap.min.js"></script>
  <script src="adminto/js/waves.js"></script>
  <script src="adminto/js/jquery.slimscroll.js"></script>

  <!-- App js -->
  <script src="adminto/js/jquery.core.js"></script>
  <script src="adminto/js/jquery.app.js"></script>
  <script src="adminto/plugins/custombox/dist/custombox.min.js"></script>
  <script src="adminto/plugins/custombox/dist/legacy.min.js"></script>

  <!-- Toastr js -->
  <script src="adminto/plugins/toastr/toastr.min.js"></script>

  <!-- Plugins Js -->
  <script src="adminto/plugins/select2/js/select2.min.js" type="text/javascript"></script>

  <!-- Required datatable js -->
  <script src="adminto/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="adminto/plugins/datatables/dataTables.bootstrap4.min.js"></script>

  <script src="adminto/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- file uploads js -->
  <script src="adminto/plugins/fileuploads/js/dropify.min.js"></script>

  <!-- Chart JS -->
  <script src="adminto/plugins/chart.js/Chart.bundle.min.js"></script>
  <script src="adminto/pages/jquery.chartjs.init.js"></script>

  <!-- image size auto -->
  <script src="adminto/js/imageMapResizer.min.js"></script>


  <script type="text/javascript">
    // Date Picker
    jQuery('#datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
      autoclose: true,
      todayHighlight: true,
      format: "yyyy-mm",
      startView: "months",
      minViewMode: "months"
    });

    jQuery('.datepicker-autoclose-modal').datepicker({
      autoclose: true,
      todayHighlight: true,
      format: "yyyy-mm-dd",
    });

    jQuery('.datepicker-autoclose-modal-year').datepicker({
      autoclose: true,
      todayHighlight: true,
      format: "yyyy",
      startView: "years",
      minViewMode: "years"
    });

    jQuery('#date-range').datepicker({
      toggleActive: true
    });

    // Select2
    $(".select2").select2();

    // Default Datatable
    $('#datatable').DataTable();

    // Responsive Datatable
    $('.responsive-datatable').DataTable();

    function clearChart(id_chart) {
      event.preventDefault();
      var parent = document.getElementById('chartContent')
      var child = document.getElementById(id_chart)
      parent.removeChild(child);
      parent.innerHTML = '<canvas id="' + id_chart + '" width="300" height="200"></canvas>';
      return;
    }

    function renderChart(aktual, prediksi, label, id_chart) {
      const labels = label
      const datas = {
        labels: labels,
        datasets: [

          {
            label: 'Data Prediksi',
            data: prediksi,
            borderColor: 'rgba(50, 168, 82, 1)',
            backgroundColor: 'rgba(220, 247, 228, 0.1)'
          },
          {
            label: 'Data TBS Olah',
            data: aktual,
            borderColor: 'rgba(104, 105, 188, 1)',
            backgroundColor: 'rgba(105, 105, 188, 0.1)'
          }
        ]
      };
      var ctx = document.getElementById(id_chart).getContext("2d")
      var myChart = new Chart(ctx, {
        type: 'line',
        data: datas
      });
    }

  </script>

  <script type="text/javascript">
    $('.dropify').dropify({
      messages: {
        'default': 'Drag and drop a file here or click',
        'replace': 'Drag and drop or click to replace',
        'remove': 'Remove',
        'error': 'Ooops, something wrong appended.'
      },
      error: {
        'fileSize': 'The file size is too big (1M max).'
      }
    });
  </script>

  <script type="text/javascript">
    function do_forecasting() {

      id_chart = "lineChart_aktual"

      $('#loading_page').html("");
      $('#loading_page').append('<div class="loading"></div>');
      $('#lineChart_aktual').html("");
      $('#angka_peramalan').html("");
      $('#badge_tanggal').html("");
      clearChart(id_chart)

      $.ajax({

        url: '{{url("forecasting")}}',
        type: 'GET',
        dataType: 'json',
        success: 'success',

        success: function(data) {
          $('#loading_page').html("");
          toastr.success('Sukses melakukan peramalan!')
          // console.log(data);

          //set untuk chart
          var tbs_olah = data[1]['tbs_normalisasi']; // data actual
          var prediksi = data[1]['prediksi']; // data prediksi
          var labels = data[0];
          renderChart(tbs_olah, prediksi, labels, id_chart);

          //set untuk peramalan 
          $('#angka_peramalan').append(((Math.round(data[1]['prediksi_next'])) - 1))
          $('#badge_tanggal').append(data[2])
        },
        error: function(data) {
          // console.log(data['responseText']);
          $('#loading_page').html("");
          toastr.error('Gagal melakukan peramalan! ')
        }
      })


    }
    $(document).ready(function() {
      $('map').imageMapResize();
    })

    $("map.area").hover(function() {
      $(this).fadeOut(100);
      $(this).fadeIn(500);
    });
  </script>

</body>

</html>