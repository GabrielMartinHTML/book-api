<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        foreach (['genre', 'author'] as $field) {
            if ($request->query($field)) {
                $query->where($field, $request->query($field));
            }
        }

        return $query->get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'genre' => 'required|string',
            'pages' => 'required|integer|min:1',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         return Book::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string',
        'author' => 'required|string',
        'genre' => 'required|string',
        'pages' => 'required|integer|min:1',
    ]);

    $book->update($validated);

    return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

    	$book->delete();

   	return response()->noContent();
    }
}
