<?php

use Illuminate\Database\Seeder;
use JeroenZwart\CsvSeeder\CsvSeeder;

use App\Models\Ad;
use App\Models\Animal;
use App\Models\User;
use App\Models\Photo;

class AdsTableSeeder extends CsvSeeder
{
    public function __construct() {
        $this->file = '/database/data/ads.csv';
        $this->tablename = 'ads';
        $this->header = FALSE;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Recommended when importing larger CSVs
	    #DB::disableQueryLog();
	    #parent::run();

        DB::table('ads')->delete();
        DB::table('animals')->delete();

        
        $json = File::get("database/data/interaction_real_data.json");
        $data = json_decode($json);
        $digits = 5;
        $users = User::all('id')->toArray();

        foreach($data as $obj) {
            $userId = $users[array_rand($users)]['id'];

            $new_animal = Animal::create([
                'created_at' => get_random_time("2020/04/01",  now()),
                'age'        => rand (0, 2),
                'number_of_litters' => rand(0, 10),
                'identification_number' => rand(pow(10, $digits-1), pow(10, $digits)-1),
                'is_race' => rand(0, 1),
                'is_vaccinated' => rand(0, 1),
                'race_id' => rand(0, 1)
            ]);

            $new_ad = Ad::create(array(
                'created_at' => $new_animal->created_at,
                'description'=> $obj->description,
                'category_id' => 1,
                'type_of_post'=> ($obj->price == "0") ? 0 : 1,
                'price' => intval($obj->price),
                'animal_id' =>  $new_animal->id,
                'user_id' => $userId,
                'title'   => $obj->title,
                'user_position' => $obj->address
            ));

            Photo::create([
                'created_at' => $new_ad->created_at,
                'ad_id'      => $new_ad->id,    
                'path'       => $obj->img,            
            ]);
        }
        

    }
}
