<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function books(Request $request)
    {
        $books = Book::whereStatus('PUBLISHED')->orderBy('id', 'DESC')->paginate(10);
        return view('books.index', compact('books'));
    }

    public function bookDetails($slug, Request $request)
    {
        $book = Book::whereSlug($slug)->firstOrFail();
        return view('books.detail', compact('book'));
    }
}
