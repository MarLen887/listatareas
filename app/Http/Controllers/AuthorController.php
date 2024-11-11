<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Country;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function index()
    {
        $countries = Country::all();
        $authors = Author::with('country:id,title','books:tarea')->get();
        return Inertia::render('Equipos/Index', [
            'authors' => $authors,
            'countries' => $countries
        ]); 
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'lead' => 'required|max:15',
            'members' => 'required|max:30',
            'fecha_entrega' => 'required|date',
            'country_id' => 'required|numeric'
        ]);
        
        // $author = new Author($request->input());
        // $author->save();    
        $author = Author::create($request->only(['name', 'lead', 'members', 'fecha_entrega', 'country_id']));    
        return redirect('equipos');        
    }

    public function show(Author $author)
    {
        //
    }

    public function edit(Author $author)
    {
        //
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|max:20',
            'lead' => 'required|max:15',
            'members' => 'required|max:30',
            'fecha_entrega' => 'required|date',
            'country_id' => 'required|numeric'
        ]);
        // $author->update($request->input());
        $author->update($request->only(['name', 'lead', 'members', 'fecha_entrega', 'country_id']));
        return redirect('equipos');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect('equipos');
    }
}
