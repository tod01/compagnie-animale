
{{-- @extends('layouts.app', ['title' => 'Adds']) --}}
@extends('layouts.app')
@section('content')
    @auth()
        <animal-post user_id="{{ Auth::user()->id }}"></animal-post>
    @else
        <div class="row">
            <div class="col-md-8 offset-md-2">
                 <div class="card">
                     <div class="card-header">
                         <h4 class="alert-heading">Dear users</h4>
                     </div>
                    <div class="card-body">
                        <div class="alert alert-warning" role="alert">
                            <p>The creation of an Account is FREE and mandatory to be able to place your ads on Compagnie Animal.
                                <a href="{{route('register')}}"> Create your account </a> or <a href="{{ route('login') }}">log in</a>
                            </p>
                        </div>
                    </div>
                     <div class="card-footer">
                         <p class="mb-0"><a href=""><i class="fa fa-question-circle" aria-hidden="true"></i> See the advantage of having your own account.</a></p>
                         
                     </div>
                </div>
            </div>
        </div>
       
    @endauth
@endsection

@section('javascript')
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.9.1/mapbox-gl.js"></script>
    <!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
    <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoidG9kMDEiLCJhIjoiY2s1dGc5OXd1MG11dTNwcXM3b3Zqd2ZhMCJ9.2FV2pJLXPg8c6xzTgWyHkw';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-2.3522, 48.8566],
                zoom: 5
            });

            var geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                placeholder: 'Où se situe votre animal ?',
                marker: {
                color: 'orange'
            },
            mapboxgl: mapboxgl
            });

            map.addControl(geocoder);

            // Add geolocate control to the map.
            map.addControl(
            new mapboxgl.GeolocateControl({
                    positionOptions: {
                        enableHighAccuracy: true
                    },
                    trackUserLocation: true
                })
            );


            // After the map style has loaded on the page,
            // add a source layer and default styling for a single point
            map.on('load', function() {
            map.addSource('single-point', {
                type: 'geojson',
                data: {
                type: 'FeatureCollection',
                features: []
                }
            });

            map.addLayer({
                id: 'point',
                source: 'single-point',
                type: 'circle',
                paint: {
                'circle-radius': 10,
                'circle-color': '#448ee4'
                }
            });

            // Listen for the `result` event from the Geocoder
            // `result` event is triggered when a user makes a selection
            //  Add a marker at the result's coordinates
            geocoder.on('result', function(e) {
                map.getSource('single-point').setData(e.result.geometry);
                document.querySelector('#ads_location').value = e.result['place_name'];
                console.log(document.querySelector('#ads_location').value);
            });
});

    </script>
@endsection

<!--
<script>

    var placesAutocomplete = places({
        appId: 'plWX56NAPLFE',
        apiKey: 'f65bda7b66761d1ef2d3aad05def6d15',
        container: document.querySelector('#address-input')
    });
    places(placesAutocomplete);
</script>

-->