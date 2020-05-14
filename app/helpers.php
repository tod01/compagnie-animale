<?php
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Ad;

if(!function_exists('time_elapsed_string')) {

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

if(!function_exists('get_ads_from_the_sessions')) {
    function get_ads_from_the_sessions($session_name="posts") {
        /* get the ads stored from the sessions */

        return Ad::whereIn('ads.id', Session::get($session_name));
    }
}

if(!function_exists('get_ordered_posts')) {
    
    function get_ordered_posts($posts) {
        /* Return the posts in $posts order from the Ad table */
        
        $ids_ordered = implode(',', $posts);

        $posts = Ad::whereIn('ads.id', $posts)->orderByRaw("FIELD(ads.id, $ids_ordered)");

        return $posts;
    }
}

if(!function_exists('join_ads_its_owner')) {
    function join_ads_its_owner($posts, $type_of_user) {
        /* join the ads to its owner depending on the user type */
        
        return $posts->join('users', 'users.id','=','ads.user_id')->where('type_of_user', $type_of_user)
                           ->get(['ads.id', 'price', 'user_id', 'title', 'description', 'user_position', 'type_of_post', 'ads.updated_at']);
    }
}

if(!function_exists('type_of_user_count')) {
    function type_of_user_count($id="0", $keywords=null, $type_of_user) {
        /* count the number of ads for this user */
        
        return join_ads_its_owner(get_ads_from_the_sessions("relevent_posts"), $type_of_user)->count();

        /*$result = Ad::join('users',"ads.user_id", "=", "users.id")
                ->join('animals', "animals.id", "=", "ads.animal_id");

        if(!empty($keywords)) {
            $result->where('description', 'LIKE',  "%$keywords%");
                    //->orWhere('title', 'LIKE', "%$keywords%"); // why it is not working ????
        }


        if($id != "0") {

            $result->where('animals.race_id', "=", $id);
        }

        $result->select('type_of_user')
                ->groupBy('type_of_user')
                ->having('type_of_user','=', $type_of_user);

        return $result->count();
        */




    }
}


/* start Recommendation system */

if(!function_exists('get_user_region_name')) {

    function get_user_region_name(){

        $regionName = \Location::get(\request()->ip());

        if($regionName) {
            $regionName = $regionName->regionName;
        }else { // we can't get user location when he is in localhost
            $regionName = 'unknown'; // by default
        }

        return $regionName;
    }
}

if(!function_exists('python_process')) {
    
    function python_process($algorithm, $id=null) {
        $path =  base_path('recommender_system/Recommendation.py');
       // dd($_SERVER['DOCUMENT_ROOT']);
        
        $regionName = get_user_region_name();

        $process = new Process("python3 \"{$path}\" \"{$algorithm}\" \"{$id}\" \"{$regionName}\" ");
        $process->setTimeout(3600);
        $process->run();
        
      #  $process = new Process([$command, $options_cwd, $torun], realpath($this->config['path']));
        // executes after the command finishes
    
        if(!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        #preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        
        #$outputs = preg_replace('#\"#' , '', explode("\n", $process->getOutput())[0]);
        #dd($process->getOutput());
        return json_decode($process->getOutput(), true);
    }
}

if(!function_exists('get_results')) {
    function get_results($algorithm, $id=null) {
        
        #$data = str_replace(["[", "]"], "", $data);
        #dd($json_data);

        #file_put_contents(base_path('/public/tmp/tmp.json'), stripslashes($json_data));
        
        return python_process($algorithm, $id);
        
    }
}

/* start of search engine system */

if(!function_exists('get_query_results')) {

    function get_query_results($query, $label) {

        $path =  base_path('recommender_system/SearchEngine.py');
        

        $process = new Process("python3 \"{$path}\" \"{$query}\" \"{$label}\" ");
        $process->setTimeout(3600);
        $process->run();
        
        if(!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
       
        #dd($process->getOutput());
        
        return json_decode($process->getOutput(), true);
    }
}

/* end recommandation system */


/* start of pagination system */



if(!function_exists('get_random_time')) {
    // Find a randomDate between $start_date and $end_date
    function get_random_time($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);
        
        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }
}

