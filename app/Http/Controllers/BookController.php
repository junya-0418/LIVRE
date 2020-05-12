<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mybook;
use BookService;
use App\Repositories\Book\BookRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class BookController extends Controller
{
    public function __construct(BookRepositoryInterface $book_repository)
    {
        $this->middleware('auth')->except(['index', 'search', 'show', 'wantCheck']);
        $this->book_repository = $book_repository;
    }

    public function index(Request $request) {

//        $mybooks = $this->book_repository->getMyBooksFromUserId( Auth::user()->id );
        $books = Mybook::with(['owner'])
            ->orderBy(Mybook::CREATED_AT, 'desc')->paginate(15);

        return $books;

    }

    public function show($id) {

        $book = Mybook::where('id', $id)->with(['owner'])->first();

        return $book ?? abort(404);

    }

    public function search(Request $request) {

        $query = $request->searchWord;

        $posts = BookService::getBookInformationFromGoogleBooksApi($query);

        return $posts;
    }

    public function store(Mybook $mybook, Request $request) {

        $mybook->book_id = $request->bookId;
        $mybook->title = $request->title;
        $mybook->imageLinks = $request->imageLinks;

        $authors = array($request->authors);

        for ($i = 1; $i <= count($authors); $i++) {
            $author = 'author'.$i;
            $mybook->$author = $authors[$i - 1];
        }

        $mybook->publisher = $request->publisher;
        $mybook->description = $request->description;

        $mybook->user_id = $request->user()->id;
        $mybook->save();

        return $mybook->book_id;

    }

    public function update(Mybook $mybook, $id) {

        $mybook = Mybook::find($id);

        $mybook->reading_status = 1;

        $mybook->update();

        $user_id = Auth::user()->id;

        return redirect()->route('users.show', ['id' => $user_id]);

    }

    public function delete($id) {

        $mybook = Mybook::find($id);

        $mybook->delete();

        $user_id = Auth::user()->id;

        return redirect()->route('users.show', ['id' => $user_id]);

    }

    public function wantCheck($id) {

        $mybook = Mybook::find($id);

        $check = $mybook->isWantedBy(Auth::user());

        $counts = $mybook->count_wants;

        $want_users = Mybook::where('id', $id)->with(['wants'])->get();

        return ['check' => $check, 'counts' => $counts, 'want_users' => $want_users];


    }

    public function want(Request $request, $id)
    {
        $book = Mybook::where('id', $id)->first();

        $book->wants()->detach($request->user()->id);
        $book->wants()->attach($request->user()->id);

        $counts = $book->wants()->count();
        $want_users = Mybook::where('id', $id)->with(['wants'])->get();

        return ['counts' => $counts, 'want_users' => $want_users];
    }

    public function unwant(Request $request, $id)
    {
        $book = Mybook::where('id', $id)->first();

        $book->wants()->detach($request->user()->id);

        $counts = $book->wants()->count();
        $want_users = Mybook::where('id', $id)->with(['wants'])->get();

        return ['counts' => $counts, 'want_users' => $want_users];
    }
}
