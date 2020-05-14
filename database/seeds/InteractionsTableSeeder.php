<?php

use Illuminate\Database\Seeder;

use App\Models\Interaction;
use App\Models\Ad;

class InteractionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interactions')->delete();

        $event_type = [
            'VIEW' => 2.0,
            'CONTACT' => 3.0,
            'LIKE' => 2.5,
            'FOLLOW' => 4.0,
            'SEARCH' => 1.5
        ];

        $randomTown = ['Nantes', 'Lyon', 'Bordeaux', 'Nice', 'Paris', 'Perpignan', 'Toulouse', 'Marseille', 'Caen', 'Lille', 'Rennes', 'Grenoble', 'Angers', 'Reims', 'Toulon', 'Nancy'];
        
        #$json = File::get("database/data/interaction_real_data.json");
        $ads = Ad::all('id')->toArray();
        for ($x = 0; $x <= 16000; $x++) {
            $randomKey = array_rand($event_type);
            $postId = $ads[array_rand($ads)]['id'];
            Interaction::create(array(
                'created_at' => get_random_time(now(), now()->addMinutes(60)),
                'eventType'=> $randomKey,
                'personId' => rand(2002, 5002),
                'postId'=> $postId,
                'sessionId' => session()->getId(),
                'eventStrength' =>  $event_type[$randomKey],
                'userRegion' => $randomTown[array_rand($randomTown)],
            ));
        }
        
    }
}
