<link rel="stylesheet" type="text/css" href="{{ url('/css/post.css') }}"/>
@foreach($posts as $post)
    <div class="row">
    
        <div class="col-lg-12">
            <div class="single-post">
                <p class="type-of-user">
                    <strong>{!! $post->user->type_of_user ? "<span class=\"text-info\">[Pro]</span>":"" !!}{{$post->user->first_name}}</strong> <span>{{time_elapsed_string($post->updated_at)}}</span>
                </p>
                <div class="image-container">
                    <div class="row">
                        <div class="show-image">
                            <!-- <img src=" asset('storage/'.$post->photos[0]->path)" alt=""> -->
                           
                            @if(sizeof($post->photos) > 0 && strpos($post->photos[0]->path, '/uploads') !== 0)
                                <a href=""><img src="{{asset('storage/images/'.$post->photos[0]->path)}}" alt=""></a>
                            @elseif (strpos($post->photos[0]->path, '/uploads') == 0)
                                
                                <a href=""><img src="{{asset('storage'.$post->photos[0]->path)}}" alt=""></a>
                            @else
                                <a href=""><img src="{{asset('storage/cat.jpg')}}" alt=""></a>
                            @endif
                        </div>
                        <div>
                            <h2><a href="">{{$post->title.' '. $post->id}}</a></h2>
                            @if($post->price)
                                <strong class="price">{{$post->price}} euro{{$post->price > 0 ? "s":""}}</strong>
                            @else
                                <strong class="price">Gratuit</strong>
                            @endif
                            <div>
                                <strong class="price">{{$post->user_position}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                <p class="post-text">
                    {{substr($post->description, 0, 96)}}
                </p>
                
                <p><a href="{{ url('/offers/'.$post->id) }}" class="read-more-btn" onclick="get_interaction(event, {{$post->id}}, 'VIEW', 'offers/');" >Read more</a>
                    <a href=""  onclick="get_interaction(event, {{$post->id}}, 'LIKE', 'offers/'); like_unlike(event); " class="liketoggle mr-2 mt-0">
                        <i class="{{App\Models\Interaction::where('personId', Auth::id() ,'and')->where('postId', $post->id, 'and')->where('eventType', 'LIKE')->count() ? 'fas' : 'far' }} fa-heart"></i>
                     </a>
                </p>
            </div>
        </div>
        
    </div>

@endforeach
