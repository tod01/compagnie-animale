<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Animal;
use App\Models\Race;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function addAnimal(StorePost $request) {
        $animal = new Animal();
        $animal->age = $request['animal_age'];
        $animal->number_of_litters = $request['number_litter'];
        $animal->identification_number = $request['animal_id_number'];
        $animal->is_race = $request['race_belonging'];
        $animal->is_vaccinated = $request['is_tattooed_or_chipped'];
        $animal->race_id = $request['type_of_race'];
        $animal->save();

        return $animal->id;
    }
}
