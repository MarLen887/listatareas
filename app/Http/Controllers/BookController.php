<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    public function index()
    {
        return Inertia::render('Tareas/Index', [
            'books' => Book::paginate(10)
        ]);        
    }

    public function create()
    {
        return Inertia::render('Tareas/Create', [
            'authors' => Author::all()
        ]);
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'tarea' => 'required|max:150',
            'image' => 'required|file|mimes:png,jpg,gif',
            'id' => 'required|numeric',
            'authors' => 'required|array'
        ]);
        $book = Book::create($request->all());
        if ($request->hasFile('image')) {
            $imgName = microtime(true) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/img', $imgName);
            $book->image = '/img/' . $imgName;
            $book->save();
        }
        $book->authors()->sync($request->authors);
        return redirect('tareas/create')->with('success', 'Tarea creada');
    }


    public function updateTareas(Request $request){
        $request->validate([
            'tarea' => 'required|max:150',
            'image' => 'required|file|mimes:png,jpg,gif',
            'id' => 'required|numeric',
            'authors' => 'required|array'
        ]);
    
        $book = Book::find($request->id);
        $book->update($request->input());
        if($request->hasFile('image')){
            Storage::disk('public')->delete($book->image);
            $imgName = microtime(true) . '.' . $request->file('image')
                ->getClientOriginalExtension();
            $request->file('image')->storeAs('public/img', $imgName);
            $book->image = '/img/' . $imgName;
            $book->save();
        }
        $book->authors()->sync($request->authors);
        
        return redirect('tareas')->with('success', 'Tarea actualizada');
    }    

   
        public function show(Book $book, $id)
    {
        $book = Book::with('authors')->findOrFail($id);
        // $countries = Country::all();
        return Inertia::render('Tareas/Show', [
            'book' => $book,
            'authors' => $book->authors
            // 'countries' => $book->countries,
        ]);
        
    }

    public function edit(Book $book, $id)
    {
        $book = Book::with('authors')->findOrFail($id); 
        return Inertia::render('Tareas/Edit', [
            'authors' => Author::all(),
            'book' => $book,
            'authorsOfBook' => $book->authors
        ]);
    }

    public function update(Request $request, Book $book)
    {
        //
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('tareas')->with('success', 'Tarea eliminada');
    }
    

}
