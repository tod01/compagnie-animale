<link rel="stylesheet" type="text/css" href="{{ url('/css/announcement.css') }}"/>
@extends('layouts.app')
@section('content')
        <div class="row" class="template">
            <div class="col-md-6 offset-2">
                <form id="form-search" method="post" action="{{route('offers')}}">
                    @csrf
                    <div class="card flex-column card-search">

                        <div class="d-flex flex-row">
                            <div>
                                <select name="species" class="custom-select">
                                    <option class="option-select" value="0">Tous les animaux</option>
                                    @if(isset($species))
                                        @foreach($species as $specie)
                                            <option class="option-select"
                                                    value={{$specie->id}}
                                                    @if($id == $specie->id)
                                                        selected
                                                @endif>
                                                {{$specie->species}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="md-form mt-0 flex-fill">
                                <input name="keyWords" class="form-control form-control-key-words" type="text"
                                       placeholder="Mots clés..." value="{{$keyWords ?? ''}}">
                            </div>
                            <div class="md-form mt-0 md-form-control-where">
                                <input class="form-control" name="where" type="search" id="address-input" placeholder="Où ?" />
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary item">Rechercher</button>
                            </div>
                        </div>
                        
                        <!-- start -->
                        
                        <!--
                        <div class="price-popover row mt-3">
                            
                            <a href="#" class="btn btn-primary" tabindex="0" data-toggle="popover" data-trigger="focus" data-popover-content="#a1" data-placement="top">Popover Example</a>

                               
                            <div id="a1" class="hidden">
                                <div class="popover-heading"></div>

                                <div class="popover-body">
                                    <div class="double-slider">
                                        <input type="range" name="range_from" oninput="price_slider(event, this.value);" class="from" value="0" min="0" 
                                        max="150" data-prev-value="0">
                                        <div class="progressbar_from"></div>
                                        <input type="range" name="range_to" oninput="price_slider(event, this.value);" class="to"
                                            value="150" min="0" max="150"  data-prev-value="150">
                                        <div class="progressbar_to"></div>
                                            <span class="value-output-from">0</span>
                                            <span class="value-output-to">150</span>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>-->
                        <!--
                        <a tabindex="0"
                            class="btn btn-lg btn-primary" 
                            role="button" 
                            data-html="true" 
                            data-toggle="popover" 
                            data-placement="bottom" 
                            data-trigger="focus" 
                            title="<b>Example popover</b> - title" 
                            data-content="<div class='double-slider'>
                                <input type='range' name='range_from' oninput='price_slider(event, this.value);' class='from' value='0' min='0' 
                                max='150' data-prev-value='0'>
                                <div class='progressbar_from'></div>
                                <input type='range' name='range_to' oninput='price_slider(event, this.value);' class='to'
                                 value='150' min='0' max='150'  data-prev-value='150'>
                                <div class='progressbar_to'></div>
                                
                                <span class='value-output-from'>0</span>
                                <span class='value-output-to'>150</span>
                            </div>
                            ">RSS <i class="fa fa-rss" aria-hidden="true"></i>
                        </a>-->

 
                            
                        <!-- end -->

                    </div>
                </form>
            </div>
        </div>

      
    <div class="row">
        <div class="col-md-6 offset-2">
            <div class="card">
                <?php $professionals = type_of_user_count($id, $keyWords, 1); $particulars = type_of_user_count($id, $keyWords, 0); ?>
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <span class="form-control" aria-label="Text input with checkbox">Annonces suggerées: {{sizeof(Session::get('posts'))}}</span>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    
                                        <input type="checkbox" id="professionals" checked="checked" value="1" onclick="get_particular_ads(event);" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                                <span class="form-control"  aria-label="Text input with checkbox">Professionnels: {{$professionals}} </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" id="particulars" checked="checked" value="0" onclick="get_particular_ads(event);" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                                <span class="form-control" aria-label="Text input with checkbox">Particuliers: {{$particulars}} </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <select name="ads_order" onchange="get_particular_ads(event);" id="inputState" class="form-control">
                                <option value="relevent" selected>En ordre de {{Auth::check() ? 'pertinence' : 'popularité'}}</option>
                                <option value="recent">Annonces Recentes</option>
                                <option value="asc_prices">Prix croissants</option>
                                <option value="desc_prices">Prix décroissants</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="card-body" id="post-data">
                    @include('Pages.ads_data')
                </div>
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>

    <div class="ajax-load text-center mt-2 font-weight-bold">
        <p class=""><img src="http://demo.itsolutionstuff.com/plugin/loader.gif" alt="Loader" class="text-primary">Loading More post</p>
    </div>

@endsection

@section('javascript')
<script>
    var placesAutocomplete = places({
        appId: 'plWX56NAPLFE',
        apiKey: 'f65bda7b66761d1ef2d3aad05def6d15',
        container: document.querySelector('#address-input')
    });
</script>
@endsection