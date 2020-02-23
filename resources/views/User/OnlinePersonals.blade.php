@extends('Layouts.Pannel.Template')

@section('content')


     {{-- filtering --}}
     <div class="container-fluid">
     <div class="card filtering" >
        <div class="card-body">
          <div class="row " >
            <div class="form-group col-md-2">
                <form method="GET">
              <label for="recipient-name" class="col-form-label">دسته اصلی</label>

              <select name="personal" id="personals_type1"  class="js-example-basic-single" dir="rtl">
                <option>همه</option>



            </select>
          </div>
          <div class="form-group col-md-2">
            <form method="GET">
          <label for="recipient-name" class="col-form-label">زیر شاخه اول</label>

          <select name="personal" id="personals_type2"  class="js-example-basic-single" dir="rtl">
            <option>همه</option>



        </select>
      </div>
      <div class="form-group col-md-2">
        <form method="GET">
      <label for="recipient-name" class="col-form-label">زیر شاخه دوم</label>

      <select name="personal" id="personals_type3"  class="js-example-basic-single" dir="rtl">
        <option>همه</option>



    </select>
  </div>
  <div class="form-group col-md-2">
    <form method="GET">
  <label for="recipient-name" class="col-form-label">زیر شاخه سوم</label>

  <select name="personal" id="personals_type4"  class="js-example-basic-single" dir="rtl">
    <option>همه</option>



</select>
</div>
<div class="form-group col-md-2">
    <form method="GET">
  <label for="recipient-name" class="col-form-label">انتخاب خدمت</label>

  <select name="personal" id="personals_type5"  class="js-example-basic-single" dir="rtl">
    <option>همه</option>



</select>
</div>

<div class="form-group col-md-2">


    <button type="submit" class="btn btn-outline-primary">نمایش</button>
    {{-- {{$khedmatResans}} --}}
  </form>
  </div>

          </div>
        </div>
      </div>
    </div>
  {{-- end filtering --}}


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

@endsection

@section('js')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>

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

       var latlngs = [];

       var greenIcon = L.icon({
      iconUrl: '{{route('BaseUrl')}}/online-marker-icon.png',

      iconSize:     [50, 50], // size of the icon
      iconAnchor:   [20, 20], // point of the icon which will correspond to marker's location
      popupAnchor:  [0, -50] // point from which the popup should open relative to the iconAnchor
      });






       @foreach($online as $position)
            L.marker([{{$position->tool}}, {{$position->arz}}],{icon: greenIcon}).addTo(map)
          .bindPopup('خدمت رسان با کد {{$position->personal_id}} <br>')
          .openPopup();

      latlngs.push([{{$position->tool}},{{$position->arz}}])


        @endforeach



        // Adding layer to the map
        map.addLayer(layer);



      </script>
@endsection
