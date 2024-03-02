@extends('backend.partials.master')
@section('title')
    {{ __('parcel.title') }}
@endsection
@section('maincontent')
    <!-- wrapper  -->
    <div class="container-fluid  dashboard-content">
        <!-- pageheader -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('levels.dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('parcel.index')}}" class="breadcrumb-link">{{ __('parcel.title') }}</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <section class="mt-1">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="lat" name="lat" value="">
                    <input type="hidden" id="long" name="long" value="">
                    <div class="ls-inner-container fixed-map">
                        <!-- Map -->
                        <div id="fixed-map-container">
                            <div id="map" data-map-zoom="9" data-map-scroll="true">
                                <!-- map goes here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end timeline  -->
    </div>
    <!-- end wrapper  -->
@endsection()
<!-- css  -->
@push('styles')
    <link rel="stylesheet" href="{{static_asset('backend')}}/css/logs.css">
    <link rel="stylesheet" href="{{static_asset('backend/css/map/style.css')}}">
@endpush

@push('scripts')
    <script>
        var urlImage = '{{ static_asset('backend/images/default/motorcycle.png') }}';
        var parcels = @json($mapParcels);
        var mapLat = '';
        var mapLong = '';

    </script>
    <script type="text/javascript" src="{{ static_asset('backend/js/parcel/map/map.js') }}"></script>
    <script type="text/javascript" src="{{ static_asset('backend/js/parcel/map/typed.js') }}"></script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{googleMapSettingKey()}}&libraries=places&callback=initAutocomplete">
    </script>
    <script type="text/javascript" src="{{static_asset('backend/js/parcel/map/infobox.min.js')}}"></script>
    <script type="text/javascript" src="{{static_asset('backend/js/parcel/map/markerclusterer.js')}}"></script>
    <script type="text/javascript" src="{{static_asset('backend/js/parcel/map/locationShowMaps.js')}}"></script>
@endpush
