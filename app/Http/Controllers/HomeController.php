<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->middleware('auth');
        $this->book = $book;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = $this->book->all();
    
        return view('dashboard.index', compact('books'));
        
    }
    public function books() {
        //
            $books = $this->book->paginate(15);
           
            

        return view('dashboard.books',compact('books'));


    }

    public function store(Request $request) {
        //store data

        $request->validate([
            'title' => 'required',
            'isbn' => 'required',
            'description' => 'required',
            'about_author' => 'required',

        ]);

        $this->book->create(
            [
                'title' => $request->title,
                'isbn' => $request->isbn,
                'description' => $request->description,
                'about_author' => $request->about_author,
    
            ]

        );

        return redirect()->back()->with('success','Book added successfully!');

    }
    public function update(Request $request, $id){

        $request->validate([
            'title' => 'required',
            'isbn' => 'required',
            'description' => 'required',
            'about_author' => 'required',
        ]);

        $this->book->find($id)->update(
            [
                'title' => $request->title,
                'isbn' => $request->isbn,
                'description' => $request->description,
                'about_author' => $request->about_author,
            ]
        );

        return back()->with('success','Book updated successfully!');

    }
   
    public function archive($id){
        
        $this->book->find($id)->delete();

        return back()->with('success','Book Archived successfully!');
    }
    public function destroy($id){
        
        $this->book->find($id)->forceDelete();

        return back()->with('success','Book deleted successfully!');
    }
}
