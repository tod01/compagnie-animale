@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-4 offset-md-2">
            <div class="row font-weight-bold mb-1">
                <div class="col-md-8">
                    {{$post->title}}
                </div>
                <div class="col-md-4 text-right">
                    {{ $post->created_at }}
                </div>
            </div>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride=" <!--Card image--> <!--Card image-->">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    @foreach($post->photos as $photo)
                        <div class="carousel-item active">
                            <img src="{{asset('storage/images/'.$photo->path)}}" alt="{{$post->title}} photo" class="d-block w-100" >
                        </div>
                    @endforeach
                   
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            
            <div class="starrating risingstar d-flex justify-content-left flex-row-reverse">
                <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 stars"></label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"></label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"></label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"></label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"></label>
                <span class="mr-2 mt-1 text-success font-italic">Votre avis compte</span>
            </div>

            <hr class="mt-3">
            <h4 class="font-weight-bolder text-info">Critères</h4>
            <div class="row">
                <div class="col-md-6">
                    <strong class="text-primary"><i class="fas fa-id-card"></i> Numero d'Identification</strong>
                    <p>
                        <em class="ml-4">{{$post->animal->identification_number}}</em>
                    </p>
                </div>
                <div class="col-md-6">
                    <strong class="text-primary"><i class="fas fa-donate"></i> Nature de l'offre</strong>
                    <p>
                        <em class="ml-4">{{$post->price ? "Vente: $post->price €" : 'Gratuit'}}</em>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong class="text-primary"><i class=""></i> Appartenance à une race</strong>
                    <p>
                        <em class="ml-4">{{$post->is_race ? 'Belonging/type/Not LOF/Not LOOF' : 'LOF / LOOF'}}</em>
                    </p>
                </div>
                <div class="col-md-6">
                    <strong class="text-primary"><i class="fas fa-birthday-cake"></i> Âge</strong>
                    <p>
                        <em class="ml-4">{{$post->age == 1 ? 'Moins de 8 semaines' : $post->age == 2 ? 'Adulte' : 'Plus de 8 semaines'}}</em>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <strong class="text-primary"><i class="fas fa-paw"></i> Nombre d'animaux dans la portée</strong>
                    <p>
                        <em class="ml-4">{{$post->animal->number_of_litters}}</em>
                    </p>
                </div>
                <div class="col-md-6">
                    <strong class="text-primary"><i class="fas fa-syringe"></i> Vacciné</strong>
                    <p>
                        <em class="ml-4">{{$post->animal->is_vaccinated ? 'Oui' : 'Non'}}</em>
                    </p>
                </div>
            </div>
            
            <hr>
            <h4 class="font-weight-bolder text-info">Description</h4>
            <p class="text-justify">
               {{$post->description}}
               <div class="text-right">
                    <a href="" class="text-danger"><i class="fas fa-exclamation-triangle"></i> Signaler l'annonce</a>
                </div>
            </p>
        </div>
        <div class="col-md-3 offset-md-1">
            <aside>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-5">
                                        <span style="width: 18rem; font-size:1.5em">
                                            <svg viewBox="0 0 200 200" width="1em" height="1em"><circle fill="#F3F7FA" cx="100" cy="100" r="100"></circle><path fill="#BCC2D0" d="M141.9 128.3c-27.1-1.4-79.3-.5-97.5-.1-7.9.2-15.6 2.6-22 7.2-4 2.9-7.9 6.9-10.2 12.3C29.1 178.9 62.1 200 100 200c13.3 0 26.4-2.6 38.6-7.7 8.3-3.7 16.1-8.5 23.3-14.1 2.5-12.9 7.1-48.5-20-49.9z"></path><path fill="#E1E4EB" d="M75.3 105.5l-.3 35.7c0 2.9.6 5.8 1.8 8.5l.2.5c3.6 8.2 12.1 13.1 21 12.1 4.2-.5 8.2-2.2 11.4-5 6.2-5.4 10.1-12.9 11.2-21l1.6-11.6-46.9-19.2z"></path><path fill="#BCC2D0" d="M118.5 144.5c.7-1.5 1.4-3.8 2.2-8.3l1.6-11.6-47-19.1 16.3 22.3c3.4 4.7 7.6 8.8 12.5 12 4.2 2.8 9.4 5.2 14.4 4.7z"></path><path fill="#E1E4EB" d="M148.5 82.1c-1.8 25-10.4 69.7-45 51.6 0 0-12.3-5.2-22.7-19.1-2.9-3.9-7.1-11.5-8.7-16.1L67.7 85c-6.1-16.6-3.3-35.4 8-49.1C82 28.2 95 22.2 108 22.3c22.8.2 31.2 10.4 36.1 24 3.2 8.8 5 26.5 4.4 35.8z"></path><path fill="#BCC2D0" d="M82 96.5c-1.5-5.3-10 2.1-10 2.1.9 2.4 2 4.7 3.2 7v3.1c5.2-1.6 8.3-7 6.8-12.2z"></path><path fill="#97A0B6" d="M83.3 11.4c-28.2 7.8-44.7 37.3-36.8 65.7 4.2 15.1 14.8 27.7 29.1 34.3v-10.7l4.5-9s38.5-14.6 53.2-49.3c0 0 5.4 15.1 11.8 27.6 1.2 2.5 2.5 4.9 3.7 7.1.1-.5.3-1 .4-1.5 2.1-8.9 2-18.1-.5-26.9-7.8-28.5-37.1-45.1-65.4-37.3z"></path><circle fill="#E1E4EB" cx="77.7" cy="95.8" r="9.9"></circle></svg>
                                        </span>
                                        <a href="">{{$post->user->first_name ." ".$post->user->last_name}}</a>
                                    </div>
                                    <div class="col-4 text-right">
                                        <!--<span><i class="far fa-thumbs-up"></i></span>  -->
                                        <?php $status = App\Models\Interaction::where('personId', Auth::id() ,'and')->where('postId', $post->id, 'and')->where('eventType', 'FOLLOW')->count(); ?>
                                        <button type="button" {!! Auth::check() ? '' : "data-toggle=\"modal\" data-target=\"#followingModal\"" !!} class="btn btn-{{ $status ? 'danger' : 'primary' }} btn-sm interaction" 
                                            onclick="get_interaction(event, {{$post->id}}, 'FOLLOW', ''); follow_unfollow(event, {{Auth::check()}}); ">
                                            {{ $status ? 'Unfollow' : 'Follow' }}
                                        </button>

                                        <div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="followingModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-info font-weight-bold" id="followingModalLabel">Cher utilisateur</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Veuillez-vous connecter pour suivre les annonces de cet utilisateur
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                                                        <a href="{{ url('/login') }}" type="button" class="btn btn-success">Se connecter</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-primary btn-lg btn-block interaction" data-toggle="modal" data-target="#sendMessage">
                                    <svg data-name="Calque 1" viewBox="0 0 24 24" width="1em" height="1em"><title>message</title>
                                    <path d="M21.6 0H2.4A2.41 2.41 0 000 2.4v14.4a2.41 2.41 0 002.4 2.4h16.8L24 24V2.4A2.41 2.41 0 0021.6 0zM18 14.4h-7.2a1.29 1.29 0 01-1.2-1.2 1.29 1.29 0 011.2-1.2H18a1.29 1.29 0 011.2 1.2 1.29 1.29 0 01-1.2 1.2zm0-3.6H6a1.29 1.29 0 01-1.2-1.2A1.29 1.29 0 016 8.4h12a1.29 1.29 0 011.2 1.2 1.29 1.29 0 01-1.2 1.2zm0-3.6H6A1.29 1.29 0 014.8 6 1.29 1.29 0 016 4.8h12A1.29 1.29 0 0119.2 6 1.29 1.29 0 0118 7.2z"></path></svg>
                                    Envoyer un message
                                </button>

                                <div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="sendMessageModal" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <form method="POST" action="{{ route('sendMessage') }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="sendMessageModal">Message à {{$post->user->first_name. ' '. $post->user->last_name}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                                @csrf
                                                @if(!Auth::check())
                                                    <div class="form-group">
                                                        <label for="sender_email" class="col-form-label">Votre email:</label>
                                                        <input type="text" required="required" placeholder="votrenom@mail.com" class="form-control" id="sender_email">
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Votre message:</label>
                                                    <textarea required="required" rows="10" placeholder="Je souhaiterais acheter ce beau {{strtolower($post->animal->race->species)}} serait il toujours disponible?" class="form-control" id="message-text"></textarea>
                                                </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary" onclick="get_interaction(event, {{$post->id}}, 'CONTACT', '' );">Envoyer le message</button>
                                            @if(!Auth::check())
                                                
                                                <small class="form-text">
                                                    <a href="" class="text-info">Créer un compte pour être informé des nouvelles annonces de {{$post->user->first_name. ' '. $post->user->last_name}} </a>
                                                </small>
                                                
                                            @endif
                                        </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- if the user is not connected -->

                                <!-- Modal -->
                                <!--<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-info font-weight-bold" id="messageModalLabel">Cher utilisateur</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Veuillez-vous connecter pour envoyer un message
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                                            <a href="{{ url('/login') }}" type="button" class="btn btn-success">Se connecter</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 text-info font-weight-bold">Vous pourrez être interessé à ces annonces</h5>
                            </div>
                            <div class="card-body suggested-ads">
                            <div class="single-post">
                                
                                    <p class="type-of-user">
                                        <strong>first_name</strong> <span>01/01/2020</span>
                                    </p>
                                    <div class="row">
                                        <!-- <img src=" asset('storage/'.$post->photos[0]->path)" alt=""> -->
                                        <div class="col-md-5">
                                            <a href=""><img src="{{asset('storage/cat.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col-md-7 suggested-ads-info">
                                            <h2><a href="">{{$post->title}}</a></h2>
                                            @if($post->price)
                                                <strong class="price">{{$post->price}} euro{{$post->price > 0 ? "s":""}}</strong>
                                            @else
                                                <strong class="price">Free</strong>
                                            @endif
                                            <div>
                                                <strong class="price">{{$post->user_position}}</strong>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </aside>
    
        </div>
    </div>

@endsection
