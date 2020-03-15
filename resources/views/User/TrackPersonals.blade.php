@extends('Layouts.Pannel.Template')

@section('css')

<link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/css/persian-datepicker.min.css" type="text/css">


@endsection
@section('content')


     {{-- filtering --}}
     <div class="card filtering container-fluid" >
       
        <div class="card-body" style="height:300px">
          <div class="card-title">
            <h5 class="text-center">مسیر حرکت خدمت رسان ها</h5>
            <hr>
          </div>
          <div class="row " >
            <div class="form-group col-md-6">
                <form method="GET">
              <label for="recipient-name" class="col-form-label">انتخاب خدمت رسان</label>

              <select name="personal" id="personals_type"  class="js-example-basic-single" dir="rtl">
                <option></option>


                @foreach($khedmatResans as $khedmatresann)
                                            <option value="{{$khedmatresann->id}}"
                                              @if (!empty($khedmatResan))

                                              @if ($khedmatresann->id == $id[0])
                                              selected="selected"
                                              @endif
                                              @endif

                                              > {{$khedmatresann->personal_firstname}} {{$khedmatresann->personal_lastname}} - {{$khedmatresann->personal_mobile}}</option>
                                        @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="recipient-name" class="col-form-label">تاریخ: </label>
            {{-- <input type="text" name="date" class="form-control date" id="date"


            @if (!empty($id))

            value="{{$id[1]}}"

            @endif


           >  
            --}}
           <input type="text" id="date" name="date"
           autocomplete="off"
           class="form-control text-right date-picker-shamsi"

           @if (!empty($id))

            value="{{$id[1]}}"

            @endif

            dir="ltr">


          </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">


              <button type="submit" class="btn btn-outline-primary">نمایش</button>
              {{-- {{$khedmatResans}} --}}
            </form>
            </div>
          </div>
        </div>
      </div>
  {{-- end filtering --}}

  @if (!empty($id[0]))

     {{-- map --}}
     <div class="card container-fluid">
        <div class="card-body">
          <div class="row" >
            <div class="col-md-12">

                <div id="map" style="width: 100%; height: 500px"></div>

            </div>
          </div>
        </div>
      </div>
  {{-- end map --}}
  @endif




@endsection

@section('js')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>

  {{-- <script src="{{route('BaseUrl')}}/Pannel/assets/js/jquery/jquery.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/js/persian-date.min.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/js/persian-datepicker.min.js"></script> --}}


<script type="text/javascript">
    $(document).ready(function() {
        $(".date").pDatepicker({
            format: 'YYYY-MM-DD',
            "autoClose": true,
            "calendarType": "gregorian",


            "calendar": {
    "persian": {
      "locale": "fa",
      "showHint": true,
      "leapYearMode": "algorithmic"
    },
    "gregorian": {
      "locale": "en",
      "showHint": true
    }
  },


        });
    });
</script>





    @if (!empty($id[0]))


    <!-- map-->
    <script>
      // Creating map options
      var mapOptions = {
          center: [36.318, 59.576],
          zoom: 11
      }
      // Creating a map object
      var map = new L.map('map', mapOptions);
      // Creating a Layer object
      var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
     // var layer = new L.TileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png');


     var greenIcon = L.icon({
    iconUrl: '{{route('BaseUrl')}}/mapmarker/marker-icon.png',

    iconSize:     [15, 25], // size of the icon
    iconAnchor:   [7, 20], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
    });




    var latlngs1 = [];
    var latlngs2 = [];
    var latlngs3 = [];
    var latlngs4 = [];
    var latlngs5 = [];


var number = 1;
     @foreach($khedmatResan as $key=>$position)
          L.marker([{{$position->tool}}, {{$position->arz}}],{icon: greenIcon}).addTo(map)
        .bindPopup('<style>table, th, td {border: 1px solid black;  padding: 8px;}</style><table><tr><td>شمارش</td><td>{{$key+1}}</td></tr><tr><td>ساعت</td><td>{{\Morilog\Jalali\Jalalian::forge($position->created_at)->format('H:i:s')}}</td></tr><tr><td>تاریخ</td><td>{{\Morilog\Jalali\Jalalian::forge($position->created_at)->format('%Y-%m-%d')}}</td></tr></table>')
        .openPopup();

     @php
$kes=$key-1;
     @endphp

@if($kes>0)
 var hour ={{\Morilog\Jalali\Jalalian::forge($position->created_at)->format('H')}}-{{\Morilog\Jalali\Jalalian::forge($khedmatResan[$kes]->created_at)->format('H')}};
         var min ={{\Morilog\Jalali\Jalalian::forge($position->created_at)->format('i')}}-{{\Morilog\Jalali\Jalalian::forge($khedmatResan[$kes]->created_at)->format('i')}};

       if(hour>0){
        number++;
       }else{

if(min>25){
  number++;
}

       }
 
@endif









        // if((time)>=1){
        //   number++;
        // }

if(number === 1){

  latlngs1.push([{{$position->tool}},{{$position->arz}}])

}else if(number === 2){

  latlngs2.push([{{$position->tool}},{{$position->arz}}])

}else if(number ===3){
  latlngs3.push([{{$position->tool}},{{$position->arz}}])

}else if(number == 4){
  latlngs4.push([{{$position->tool}},{{$position->arz}}])

}else if (number === 5){
  latlngs5.push([{{$position->tool}},{{$position->arz}}])

}else if (number === 6){
  latlngs6.push([{{$position->tool}},{{$position->arz}}])

}else if (number === 7){
  latlngs7.push([{{$position->tool}},{{$position->arz}}])

}


      @endforeach



      // Adding layer to the map
      map.addLayer(layer);

      var polyline = L.polyline(latlngs1, {color: 'blue', weight: 10 , opacity: 0.6}).addTo(map);
      var polyline = L.polyline(latlngs2, {color: 'green', weight: 10 , opacity: 0.6}).addTo(map);
      var polyline = L.polyline(latlngs3, {color: 'yellow', weight: 10 , opacity: 0.6}).addTo(map);
      var polyline = L.polyline(latlngs4, {color: 'purple', weight: 10 , opacity: 0.6}).addTo(map);
      var polyline = L.polyline(latlngs5, {color: 'red', weight: 10 , opacity: 0.6}).addTo(map);
      var polyline = L.polyline(latlngs6, {color: 'blue', weight: 10 , opacity: 0.6}).addTo(map);
      var polyline = L.polyline(latlngs7, {color: 'blue', weight: 10 , opacity: 0.6}).addTo(map);


    </script>

    @endif
@endsection
