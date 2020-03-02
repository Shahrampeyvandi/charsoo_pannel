@extends('Layouts.Pannel.Template')

@section('content')


{{-- filtering --}}
<div class="container-fluid">
  <div class="card filtering">
    <div class="card-body">
      <div class="row ">
        @if (auth()->user()->hasRole('admin_panel'))
        <div class="form-group col-md-6">
          <form method="GET">
            <label for="recipient-name" class="col-form-label">دسته اصلی</label>
            <select size="5" class="form-control" name="personal" id="personals_type1" dir="rtl">
              {!! $list !!}
            </select>
        </div>
        @endif



        <div class="form-group col-md-6">
          <form method="GET">
            <label for="recipient-name" class="col-form-label">انتخاب خدمت</label>

            <select class="form-control" name="personal" id="service_name" dir="rtl">
              {!! $service_options !!}
            </select>
        </div>



      </div>
      <div class="row">
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
    <div class="row">
      <div class="col-md-12">

        <div id="map" style="width: 100%; height: 500px"></div>

      </div>
    </div>
  </div>
</div>
{{-- end map --}}

@endsection


@section('css')
<style>
  select {
    font-family: 'FontAwesome', 'sans-serif';
  }
</style>
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
      iconUrl: '{{route('BaseUrl')}}/mapmarker/online-marker-icon.png',

      iconSize:     [50, 50], // size of the icon
      iconAnchor:   [20, 20], // point of the icon which will correspond to marker's location
      popupAnchor:  [0, -30] // point from which the popup should open relative to the iconAnchor
      });






       @foreach($online as $key=>$position)
            L.marker([{{$position->tool}}, {{$position->arz}}],{icon: greenIcon}).addTo(map)
          .bindPopup('{{$person[$key]->personal_firstname}} {{$person[$key]->personal_lastname}}<br>{{$person[$key]->personal_mobile}}')
          .openPopup();

      latlngs.push([{{$position->tool}},{{$position->arz}}])


        @endforeach



        // Adding layer to the map
        map.addLayer(layer);


      $(document).ready(function(){
        $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
          });

        $('#personals_type1').click(function(){
          var data = $(this).val();
          $.ajax({
          type:'post',
          url:'{{route("Order.Category.getService")}}',
          data:{data:data},
          success:function(data){ 
          $('#service_name').html(data)
            }
          })
        });
      });
</script>

@endsection