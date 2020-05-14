<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Ad;
use App\Models\Animal;
use App\Models\Race;
use App\Models\Interaction;
use App\Models\SessionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder;
use Response;
use \Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Session;

class OfferController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function save_posts_in_session($posts_ids, $relevent_ads=0) {

        Session::put('posts', $posts_ids);
        
        /* store default relevent ads */
        if($relevent_ads) {
            Session::put('relevent_posts', $posts_ids);
        }
    }
    
    public function paginate($items, $perPage = 15, $page = null, $options = []) {

        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function get_data_ids_list_order($ids_list, $species_id="0", $where=null) {

        /* return data from Ad in order of $ids_list variable */


        $items = get_ordered_posts($ids_list);

        if($where) {
            $items = $items->where('user_position', 'like', "%$where%");
        }

        if($species_id !== "0") {
            $items = $items->join('animals', 'ads.animal_id', '=', 'animals.id')
                           ->where('animals.race_id', '=', $species_id);

            $items = $items->get(['ads.id', 'price', 'user_id', 'title', 'description']);

            return $items;
        }

        return $items->get();
    }

    

    public function index(Request $request)
    {
       
        // TODO:: lorsque le user n'est pas connecté, le suggerer de se connecter
        // TODO:: lorsqu'il est connecté le mettre un champ pour avoir les annonces populaires

        //TODO:: 1 - User not connected --> show him his city's most popular ads...
       

        if(!Auth::check()) {
            $ads_id = get_results("Popularity", null);
        }else {
            $ads_id = get_results("Hybrid", Auth::id());
        }

        $this->save_posts_in_session($ads_id, 1);

        /* display results */
        /* sort posts results in ids order */
        $posts = $this->get_data_ids_list_order($ads_id);
        
        /* pagination system */
        $posts = $this->paginate($posts, 10, request('page'), ['path' => request()->path()]);
        //dd($posts);
        $species = Race::all();
        $id = 0;
        $keyWords = ""; 

        /* ajax for infinite result */
        if($request->ajax()) {
            $view = view('Pages.ads_data', compact('posts', 'species', 'id', 'keyWords'))->render();
            return response()->json(['html' => $view, 'lastPage' => $posts->lastPage(), 'currentPage' => $posts->currentPage()]);
        }

        $posts = $posts->items();

        return view('Pages.offers', compact('posts', 'species', 'id', 'keyWords'));
    }


    public function filter_results(Request $request) {
        
        /* filter posts */
        
        /* get relevant posts */
        $posts = get_ordered_posts(Session::get('posts'));
         
        $pecies = Race::all();
        $id = 0;
        $keyWords = "";

        if($request->status == 'false') {
            $posts = join_ads_its_owner($posts, !$request->ads_order);
        } else {
            $posts = $posts->get();
        } 
        
        if($request->ads_order == 'relevent') {
            $posts = get_ordered_posts(Session::get('relevent_posts'))->get();
        }else if ($request->ads_order == 'recent') {
            $posts = $posts->sortByDesc('updated_at');
        }else if($request->ads_order == 'asc_prices') {
            $posts = $posts->sortBy('price');
        }else if($request->ads_order == 'desc_prices') {
            $posts = $posts->sortByDesc('price');
        }  
        
        //do not allow both buttons to be deselected
        if($request->status != "default") {
             /* save into the session the updated posts */
            $this->save_queried_posts_into_session($posts, 0);
        }

        #TODO:: WHY ALL PAGES ARE RENDERED DIRECTLY 

        $view = view('Pages.ads_data', compact('posts', 'species', 'id', 'keyWords'))->render();
        return response()->json(['success' => true, 'html' => $view, 'nber_of_posts' => count($posts)]);

    }


    public function search(Request $request)
    {
       
        $keyWords = $request->keyWords;
        $id = $request->species;
       
        $where = $request->where;
        
        $species = Race::all();
        
        # if user has given key words
        if($keyWords) {
            $ids_list = get_query_results($keyWords, "title");
            
            #Use these ids to save the most N relevant into the interaction table. By default N=3
            //$this->save_most_relevant_results($ids_list, 3);
             /* sort posts results in ids order */
            $posts = $this->get_data_ids_list_order($ids_list, $id, $where);
            
        }else {

            $posts = get_ordered_posts(Session::get('posts'));

            if($id != "0") {
                $posts = $posts->join('animals', 'ads.animal_id', '=', 'animals.id')
                           ->where('animals.race_id', '=', $id);
            }
            
            if($where) {
                $posts = $posts->Where('user_position', 'like', "%$where%");
            }

            $posts = $posts->get();
        }

        /* save request result */
        $this->save_queried_posts_into_session($posts, 1);

         /* pagination system */
         $posts = $this->paginate($posts, 10, request('page'), ['path' => request()->path()]);
         //dd($posts);

         $posts = $posts->items();

        /* ajax for infinite result*/
        if($request->ajax()) {
            $view = view('Pages.ads_data', compact('posts', 'species', 'id', 'keyWords'))->render();
            return response()->json(['html' => $view, 'lastPage' => $posts->lastPage(), 'currentPage' => $posts->currentPage()]);
        }

        return view('Pages.offers', compact('posts', 'species', 'id', 'keyWords'));

        #return view('Pages.offers', ['posts' => $anns, 'species' => $species, 'id' => $id, 'keyWords' => $keyWords]);
    }

    public function save_queried_posts_into_session($posts, $relevent_ads=0) {

        /* not change the session, if the new posts are empty */
        if($posts->count() == 0) {
            return;
        }

        //dd($posts[0]);
        /* convert $posts to array */
        $posts_array = [];
        foreach($posts as $post) {
            array_push($posts_array, $post['id']);
        }

        /* save into the session */
        $this->save_posts_in_session($posts_array, $relevent_ads);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        #dd($id);
        $post = Ad::find($id);
       
        return view('Pages.post', compact('post'));
    }

    public function interaction(Request $request) {

        /* if user is not connected, use cookies */

        if(Auth::check()){
            $personId = Auth::id();
        }else {

            //get user id from cookies
            $personId = Cookie::get('personId');
            
            // create a new cookie
            if($personId == null) {
                //Create a response instance
                $current_timestamp = Carbon::now()->timestamp;
                Cookie::queue(Cookie::make('personId', $current_timestamp, strtotime("+1 year")));

                $personId = Cookie::get('personId');
            } 
        }

        // this interaction already exists 
        $interaction = Interaction::where('personId', $personId ,'and')->where('postId', $request['id'], 'and')->where('eventType', $request['eventType']);
            
        if($interaction->count()) {
            
            /* if the user dislike or unfollow the ads */
            if(in_array($request['eventType'], ['FOLLOW', 'LIKE'])) {
                $interaction->delete();
                return Response::json('Interaction deleted');
            }

            return Response::json('[User exists] VIEW/CONTACT Interaction');

        }else {
            /* if the interaction doesn't exist, create a new one */
            $new_interaction = new Interaction();
            $new_interaction->created_at = now();
            $new_interaction->eventType  = $request['eventType'];
            $new_interaction->personId   = $personId;
            $new_interaction->postId     = $request['id'];
            $new_interaction->sessionId  = session()->getId();
            $new_interaction->userRegion = get_user_region_name();
            $new_interaction->eventStrength = $request['eventStrength'];
            $new_interaction->save();

            return Response::json('Interaction saved');
        }

        return Response::json('User not connected');
    }

    /**
     * Save the most relevant results. This function is use for search query. To get user interactions
     */
    public function save_most_relevant_results($ids_list, $n=3) {
        if(Auth::check()) {
            dd('connected');
        }else {
            dd('not');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
