@extends('ieptbma::template.main')
@section('content')
<link rel="stylesheet" href="{{asset('admin/plugins/select2/select2.min.css')}}">
<style>
    .select2-results__option{
        padding: 15px;    
    }
    .select2-container .select2-selection--single{
        height: 45px;
        padding: 9px;
    }
</style>
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li>Mapa dos Cartórios do Maranhão</li>
    </ul>
</div>
<h2 class="titulo">Mapa dos Cartórios do Maranhão</h2>
<p></p>
<div id="g-about" class="row" style="height:100%">
    <select id="type" onchange="filterMarkers(this.value);">
        <option value=""> --Todos-- </option>
        @foreach( $cidades as $k=>$r )
            <option value="{{$r->id_municipio}}"> {{$r->cidade}}</option>
        @endforeach
    </select>
</div>
<p></p>
<div id="g-about" class="row" style="height:100%">
    <div id="map" style="height:500px"></div>
</div>
    <script>
        var gmarkers1 = [];
        var markers1 = [];
        var infowindow;
        var center;

        // Cartórios p/ municípios
        // ID, DESCRICAO, LATITUDE, LONGITUDE, IDMUNICIPIO

        markers1 = [
            @foreach( $cartorios as $k=>$r )
            [
                {{$r->id_cartorio}},
                '{{$r->cartorio}}',
                {{$r->latitude}},
                {{$r->longitude}},                
                {{$r->municipio_id}}
            ],                    
            @endforeach
        ]

        /**
        * Function to init map
        */

        function initMap() {
            center = new google.maps.LatLng(-4.566625, -45.085905);
            var mapOptions = {
                zoom: 6,
                center: center,
                mapTypeId: google.maps.MapTypeId.TERRAIN
            };

            infowindow = new google.maps.InfoWindow({
                content: ''
            });

            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            for (i = 0; i < markers1.length; i++) {
                addMarker(markers1[i]);
            }
        }

        /**
        * Function to add marker to map
        */
        function addMarker(marker) {
            var category = marker[4];
            var title = marker[1];
            var pos = new google.maps.LatLng(marker[2], marker[3]);
            var content = marker[1];

            marker1 = new google.maps.Marker({
                title: title,
                position: pos,
                category: category,
                map: map
            });

            gmarkers1.push(marker1);

            // Marker click listener
            google.maps.event.addListener(marker1, 'click', (function (marker1, content) {
                return function () {
                    infowindow.setContent(content);
                    infowindow.open(map, marker1);
                    map.panTo(this.getPosition());
                    map.setZoom(9);
                }
            })(marker1, content));

            google.maps.event.addListener(infowindow,'closeclick',function(){
                for (i = 0; i < markers1.length; i++) {
                    marker = gmarkers1[i];
                    marker.setVisible(true);
                }
                document.getElementById('type').value="";
                map.setZoom(6);
                map.panTo(center);
            });
        }

        /**
        * Function to filter markers by category
        */

        filterMarkers = function (category) {
            for (i = 0; i < markers1.length; i++) {
                marker = gmarkers1[i];
                // If is same category or category not picked
                if (marker.category == category) {
                    marker.setVisible(true);
                    map.panTo(marker.getPosition());
                    map.setZoom(9);

                    infowindow.setContent(marker.getTitle());
                    infowindow.open(map, marker);
                }
                else if (category.length === 0){
                    marker.setVisible(true);
                }
                else {
                    marker.setVisible(false);
                }
            }
        }
        
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQPDoBc8cYOc2G_MEPyA_Ub_DpzSAZaoc&callback=initMap"
    async defer></script>
@stop

@section('scripts')
<script src="{{asset('admin/plugins/select2/select2.full.min.js')}}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $("#type").select2();
    });
</script>
@stop