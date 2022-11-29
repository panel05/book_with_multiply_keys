<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        $books =  Book::all();
        return $books;
    }
    
    public function show($id)
    {
        $book = Book::find($id);
        return $book;
    }
    public function destroy($id)
    {
        Book::find($id)->delete();
    }
    public function store(Request $request)
    {
        $Book = new Book();
        $Book->author = $request->author;
        $Book->title = $request->title;
        $Book->save();
    }

    public function update(Request $request, $id)
    {
        $Book = Book::find($id);
        $Book->author = $request->author;
        $Book->title = $request->title;
    }

    public function bookCopies($title)
    {	
        $copies = Book::with('copy_c')->where('title','=', $title)->get();
        return $copies;
    }


    public function konyvek($number){
        //route missing
        $books = DB::table('books')
        ->selectRaw('author, count(*)')
        ->orderby('author')
        ->having('count(*)', '>=', $number)
        ->get();
    return $books;
    }


    public function bkezdo($letter){
        //route missing
        $authors = DB::table('books')
        ->select('author')
        ->whereRaw('auhtor LIKE', $letter, '%')
        ->get();
        return $authors;
    }



}
