@extends('layout/master')

@section('title', 'Dashboard')

@section('container')
<div id="loading_page">
  
</div>

<div class="container-fluid">

  <!-- Page-Title -->
  <div class="row">
    <div class="col-sm-12">
      <h4 class="page-title">Distribusi Peramalan Titik Panas Provinsi Riau</h4>
    </div>
  </div>

  <!-- end page title end breadcrumb -->


  <div class="row">

    <div class="col-lg-8">
      <div class="card-box">
        <div class="col-auto mb-3">
          <form class="form-inline">

            <div class="form-row align-items-center ">

              <div class="col-auto mb-1">
                <div class="input-group row">
                  <div class="col-sm-12">
                    <div class="input-group">

                      <select id="selected_kabupaten_forecast" required class="form-control">
                        <option disabled selected>Pilih Kabupaten</option>
                        @foreach ($kabupaten_row AS $kr)

                        <option value="{{$kr->kabupaten}}">{{$kr->kabupaten}}</option>
                        @endforeach

                      </select>
                    </div><!-- input-group -->
                  </div>
                </div>
              </div>

              <div class="col-auto mb-1">
                <a onclick="do_forecasting()" class="btn btn-success waves-effect waves-light ">Update</a>
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



        <div class="cardc ol-sm-12   m-b-20">


          <div class="col-12" style="z-index: 99;">

            <input type="hidden" id="data_riaumap" value="">

            <img class="card-img-top img-fluid" src="adminto/images/riau-map.png" usemap="#riaumap" alt="Card image cap">


            <map name="riaumap" id="riaumap">
              <area id="kejadian" target="_self" alt="Bengkalis" title="Bengkalis" href="#" coords="408,342,389,330,394,263,409,264,435,249,457,242,476,241,496,239,504,230,507,215,513,215,530,227,549,232,569,229,585,216,647,260,650,293,615,337,606,325,579,310,567,310,559,296,513,345,504,337,465,327,451,337,429,331" shape="poly">
              <area id="kejadian" target="_self" alt="Dumai" title="Dumai" href="#" coords="419,75,410,101,417,135,429,153,442,165,457,193,469,210,476,239,493,239,498,228,506,215,513,209,524,221,546,230,565,227,582,214,566,201,551,198,533,203,515,201,511,196,496,192,488,185,480,176,487,176,493,179,496,169,498,179,510,188,523,190,537,189,545,188,563,171,567,146,575,138,560,118,556,107,546,100,527,113,515,119,506,115,494,119,491,134,489,144,491,150,477,146,468,115" shape="poly">
              <area id="kejadian" target="_self" alt="Indragiri Hulu" title="Indragiri Hulu" href="#" coords="762,533,763,633,770,645,763,651,763,660,771,663,763,668,756,685,748,705,748,727,732,741,734,755,747,764,747,783,736,782,724,783,713,771,700,766,700,759,682,747,665,751,656,744,644,744,623,737,601,744,591,734,589,720,577,698,587,681,597,668,601,653,595,641,596,634,615,639,621,628,627,630,647,626,645,613,654,609,662,589,703,591,723,567,728,543,735,535" shape="poly">
              <area id="kejadian" target="_self" alt="Indragiri Hilir" title="Indragiri Hilir" href="#" coords="766,535,777,534,798,523,810,512,822,501,860,483,886,461,908,440,929,452,948,463,958,477,972,484,987,494,1001,553,975,558,964,555,954,559,940,569,929,576,935,582,929,589,930,598,939,598,944,601,966,600,970,608,985,609,997,626,979,626,971,631,954,636,958,642,943,660,921,662,921,670,919,687,918,701,923,705,924,714,907,723,835,710,807,748,774,781,757,788,749,778,753,766,746,760,736,754,734,747,751,734,754,706,765,675,776,665,766,657,776,648,765,633" shape="poly">
              <area id="kejadian" target="_self" alt="Rokan hulu" title="Rokan hulu" href="#" coords="393,258,381,262,374,269,368,277,360,287,346,291,338,281,331,286,318,290,263,248,257,252,249,249,235,254,205,254,199,262,208,274,216,278,218,285,211,291,200,303,214,308,232,314,232,320,218,314,218,321,231,342,213,356,223,359,222,378,245,398,242,411,233,429,243,434,242,443,254,466,267,466,286,459,301,451,316,437,327,448,363,481,373,481,390,505,404,501,411,470,406,458,398,463,385,454,373,449,372,439,349,434,331,420,318,400,328,394,346,372,356,365,386,330" shape="poly">
              <area id="kejadian" target="_self" alt="Rokan Hilir" title="Rokan Hilir" href="#" coords="264,15,259,37,261,56,272,79,271,94,263,109,263,123,263,141,263,154,255,160,260,168,272,175,283,175,287,185,289,198,290,209,286,221,285,236,285,244,271,246,270,252,281,259,312,280,328,289,333,277,341,282,347,289,361,287,370,271,375,259,396,255,397,261,409,262,439,246,459,241,475,239,466,222,458,200,440,168,414,136,406,101,418,70,402,68,378,66,361,69,349,75,331,82,337,92,355,99,370,104,363,109,352,108,333,104,314,93,299,85,286,74,275,61" shape="poly">
              <area id="kejadian" target="_self" alt="Kampar" title="Kampar" href="#" coords="321,400,332,396,347,374,360,368,385,334,466,382,487,392,486,406,473,422,476,430,483,432,479,447,495,463,511,450,524,442,529,445,541,439,550,457,560,476,549,490,526,492,523,506,528,512,523,538,515,545,512,561,516,571,501,575,498,586,505,596,506,616,496,619,479,583,478,569,460,550,446,578,435,608,435,618,427,627,416,628,405,617,375,620,365,609,353,564,368,560,374,543,363,536,365,525,375,510,367,495,349,498,341,497,337,512,290,460,314,440,358,481,370,484,380,495,390,510,407,506,416,472,409,455,400,459,391,456,389,447,377,447,377,436,353,435,337,423,332,412,323,406" shape="poly">
              <area id="kejadian" target="_self" alt="Pelalawan" title="Pelalawan" href="#" coords="553,489,572,469,606,434,630,432,664,424,734,423,771,413,800,412,810,399,830,420,840,408,846,416,851,408,857,412,871,399,889,405,895,422,894,434,906,436,896,454,882,459,862,478,818,499,805,514,774,530,738,530,725,538,719,570,704,588,660,586,654,607,637,610,648,624,636,625,620,624,616,634,597,633,569,624,564,616,549,602,532,592,516,565,522,545,529,540,530,519,534,509,527,506,529,496,551,495" shape="poly">
              <area id="kejadian" target="_self" alt="Kepulauan Meranti" title="Kep. Meranti" href="#" coords="619,211,638,212,662,216,703,225,719,231,721,245,724,282,718,293,713,314,718,316,733,313,744,325,747,337,756,332,764,316,779,306,796,306,829,319,866,362,859,374,851,376,856,383,851,395,844,385,841,393,831,404,816,387,777,383,757,383,740,387,716,378,706,364,710,352,701,354,676,336,669,316,671,297,663,279,669,260,665,253,678,252,671,244,655,243,638,237,623,225" shape="poly">
              <area id="kejadian" target="_self" alt="Pekanbaru" title="Pekanbaru" href="#" coords="490,410,475,424,487,431,489,438,482,446,489,455,493,460,504,450,511,445,523,438,529,438,528,429,523,421,515,413,512,401,503,410" shape="poly">
              <area id="kejadian" target="_self" alt="Kuansing" title="Kuansing" href="#" coords="412,633,426,633,431,628,437,621,439,609,446,593,452,588,450,578,461,556,476,573,474,584,491,611,494,618,504,625,509,619,506,594,501,586,505,579,519,576,533,598,542,603,551,605,567,626,592,635,597,657,588,674,576,695,574,702,588,730,597,744,597,753,585,758,575,756,566,756,554,749,558,739,545,724,526,725,511,720,496,707,474,685,459,683,434,658,422,657" shape="poly">
              <area id="kejadian" target="_self" alt="Siak" title="Siak" href="#" coords="411,345,430,334,441,340,461,338,464,332,477,334,498,341,513,350,529,333,542,327,558,305,564,315,604,329,611,342,621,340,655,292,660,304,657,324,673,351,691,359,731,394,762,392,805,396,795,406,763,412,723,420,654,421,630,430,607,429,563,475,547,434,535,436,533,424,528,410,513,391,500,406,492,403,489,389,474,376,466,377" shape="poly">
            </map>

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
                <span class="badge badge-primary badge-pill pull-left m-t-10"> <span id="badge_linguistik">-</span> </span>
                <h2 class="mb-0 text-primary" id=""> <span id="angka_peramalan">-</span> </h2>
                <p class="text-muted ">Kejadian Titik Panas</p>
              </div>
              <div class="progress progress-bar-info-alt progress-sm mb-0">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">

                </div>
              </div>
            </div>
          </div>

        </div>


      </div>
      <div class="card-box">
        <h4 class="header-title mt-0 m-b-30">Data Aktual Titik Panas</h4>
        <div id="chartContent">
          <canvas id="lineChart_aktual" width="300" height="200"></canvas>
        </div>
      </div>

    </div>
    <!-- end col



  </div>



</div>

@endsection