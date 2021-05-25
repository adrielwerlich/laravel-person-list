<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Response;

class PersonController extends Controller
{
    //
    public function createPerson(Request $request) {

        $person = Person::create([
            'name' => $request->get('name'),
            'lastName' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'isJur' => $request->get('isJur'),
            'cpf' => $request->get('cpf'),
            'cnpf' => $request->get('cnpf')
        ]);

        return $person;
    }

    public function getPersons() {

        return Response::json(Person::get()->all());

    }

    public function updatePerson(Request $request) {

        $person = Person::findOrFail($request->get('id'));

        return $person->update($request->all());
    }

    public function deletePerson(Request $request) {

        $person = Person::findOrFail($request->get('id'));

        return $person->delete();
    }

    public function getPerson(Request $request) {

        $person = Person::findOrFail($request->get('id'));

        return $person;
    }
}
