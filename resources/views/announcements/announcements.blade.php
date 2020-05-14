<link rel="stylesheet" type="text/css" href="{{ url('/css/announcement.css') }}"/>
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <form id="form-search" method="post" action="announcements">
                    @csrf
                    <div class="card flex-column card-search">
                        <!--<div class="d-flex">
                            <div class="btn-group btn-group-toggle btn-group-toggle-what" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="options" id="radio-announcements" checked> Annonces
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="options" id="radio-eleveurs"> Éleveurs
                                </label>
                            </div>
                            <div class="btn-group btn-group-toggle btn-group-toggle-type" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="options" id="radio-ventes" checked> Ventes
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="options" id="radio-dons"> Dons
                                </label>
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary btn-prix">Prix</button>
                            </div>
                            <div class="slider flex-fill align-self-center"></div>
                        </div>-->
                        <div class="d-flex flex-row">
                            <div>
                                <select name="species" class="custom-select">
                                    <option class="option-select" value="0">Tous les animaux</option>
                                    @foreach($species as $specie)
                                        <option class="option-select"
                                                value={{$specie->id}}
                                                @if($id == $specie->id)
                                                    selected
                                                @endif>
                                            {{$specie->species_type}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!--<div class="dropdown dropdown-especes item">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuPets"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tous les animaux
                                </button>
                                <div name="ok" type="especes" class="dropdown-menu pr-0" aria-labelledby="dropdownMenuButton">
                                    <option value="1" class="dropdown-item active by-default" href="#">Tous les animaux</option>
                                    <option value="2" class="dropdown-item">Chats</option>
                                    <option value="3" class="dropdown-item">Chiens</option>
                                </div>
                            </div>-->
                            <!--<div class="md-form mt-0" id="div-form-control-race">
                                <input class="form-control form-control-key-words-races" id="form-control-race"
                                       type="text"
                                       placeholder="Quelles races ?">
                            </div>-->
                            <div class="md-form mt-0 flex-fill">
                                <input name="keyWords" class="form-control form-control-key-words" type="text"
                                       placeholder="Mots clés..." value="{{$keyWords}}">
                            </div>
                            <div class="md-form mt-0 md-form-control-where">
                                <input name="where" class="form-control" type="text"
                                       placeholder="Où ?">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary item">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($anns as $ann)
        titre : {{$ann->title}}
        <br/>
        com : {{$ann->description}}
        <br/><br/>
    @endforeach
@endsection
<script type="text/javascript" src="{{ url('/js/announcement.js') }}"></script>


