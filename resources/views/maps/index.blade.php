@extends('layouts.global')

@section('title')
    Coba Nerapin Maps
@endsection
@push('additional-style')
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            /* position: absolute; */
            top: 0;
            bottom: 0;
            width: 100%;
        }
        #video {
            border: 1px solid black;
            box-shadow: 2px 2px 3px black;
            width: 320px;
            height: 240px;
        }
        #photo {
            border: 1px solid black;
            box-shadow: 2px 2px 3px black;
            width: 320px;
            height: 240px;
        }
        #canvas {
            display: none;
        }
        .camera {
            width: 340px;
            display: inline-block;
        }
        .output {
            width: 340px;
            display: inline-block;
        }

    </style>
@endpush
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-8">
                <div id="map" style="width: 600px; height: 400px"></div>
            </div>
            <div class="col-md-4">
                <div id="container">
                    <div class="camera">
                        <video id="video"></video>
                        {{-- <button id="startbutton">Ambil Photo</button> --}}
                    </div>
                    <!-- Trigger canvas web API -->
                    <div class="controller">
                        <button id="startbutton" class="btn btn-primary btn-block">Ambil Foto</button>
                    </div>
                    <!-- Webcam video snapshot -->
                    <canvas id="canvas"></canvas>

                    <div class="output" style="display: none" id="output">
                        <img id="photo" alt="Photo ditampilkan di sini">
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('additional-scripts')
<script src="{{ asset('js/camera.js') }}"></script>
    <script>
        const sucofindo = [106.8418796, -6.2516778];
        // TO MAKE THE MAP APPEAR YOU MUST
        // ADD YOUR ACCESS TOKEN FROM
        // https://account.mapbox.com
        // mapboxgl.accessToken = 'pk.eyJ1IjoibXVoc2luYWhhZGkiLCJhIjoiY2trbzM2M3h6MDlnNTJwdG9pZTVwM281aSJ9.z3ybty6LTTfZUq8pD-QvOg';
        mapboxgl.accessToken = "{{ env('MAPBOX_API_KEY') }}";
        var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11',
            center: sucofindo, // starting position
            zoom: 12 // starting zoom
        });

        map.on('load', function() {
            map.loadImage(
                'https://3.bp.blogspot.com/-n4f-fWB8Uag/VzxrB0GtPPI/AAAAAAAAAnA/s1zKF7C27-M6Dsp7ibcWqoNGApr9lEfHwCLcB/w1200-h630-p-k-no-nu/lowongan%2Bkerja%2Bpalangkaraya%2Btelkomsel.PNG',
                function(error, image) {
                    if (error) throw error;
                    map.addImage('cat', image);
                    map.addSource('point', {
                        'type': 'geojson',
                        'data': {
                            'type': 'FeatureCollection',
                            'features': [{
                                'type': 'Feature',
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': sucofindo
                                }
                            }]
                        }
                    });
                    map.addLayer({
                        'id': 'points',
                        'type': 'symbol',
                        'source': 'point',
                        'layout': {
                            'icon-image': 'cat',
                            'icon-size': 0.15
                        }
                    });
                }
            );
        });

        var marker = new mapboxgl.Marker()
            .setLngLat([30.5, 50.5])
            .addTo(map);
        // Store the marker's longitude and latitude coordinates in a variable
        var lngLat = marker.getLngLat();
        // Print the marker's longitude and latitude values in the console
        console.log('Longitude: ' + lngLat.lng + ', Latitude: ' + lngLat.lat)

        // Add geolocate control to the map.
        map.addControl(
            new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },

                trackUserLocation: true
            })

        );

        // The `click` event is an example of a `MapMouseEvent`.
        // Set up an event listener on the map.
        map.on('click', function(e) {
            // The event object (e) contains information like the
            // coordinates of the point on the map that was clicked.
            let latitude = e.lngLat.lat;
            let longitude = e.lngLat.lng;
            alert("Clicked");
            $("#latitude").text(latitude);
            $("#longitude").text(longitude);
            console.log('Latitude: ' + latitude + '\n Longitude: ' + longitude);
        });

    </script>
@endpush
