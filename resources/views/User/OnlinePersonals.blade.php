@extends('Layouts.Pannel.Template')

@section('content')


<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div id="map" style="width: 100%; height: 500px"></div>
        </div>
    </div>
</div>


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
                    center: [36.30070, 59.578500],
                    zoom: 13
                }
                // Creating a map object
                var map = new L.map('map', mapOptions);
                // Creating a Layer object
                var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
               // var layer = new L.TileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png');
 
 
 
                // Adding layer to the map
                map.addLayer(layer);

</script>
@endsection