<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Http\Requests\StorebookRequest;
use App\Http\Requests\UpdatebookRequest;
use App\Models\auther;
use App\Models\category;
use App\Models\publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Ambil query awal untuk model Book
        $query = Book::query();
        // Filter berdasarkan kategori jika dipilih
        if ($request->has('category') && $request->name) {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan status jika dipilih
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Ambil data buku dengan relasi kategori, author, dan publisher
        $books = $query->with(['category', 'auther', 'publisher'])->paginate(10);

        // Ambil daftar kategori untuk dropdown
        $categories = Category::all();

        // Kirim data ke view
        return view('book.index', compact('books', 'categories'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('book.create', [
            'authors' => auther::latest()->get(),
            'publishers' => publisher::latest()->get(),
            'categories' => category::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorebookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validasi data
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'auther_id' => 'required|exists:authers,id',
        'publisher_id' => 'required|exists:publishers,id',
    ]);

    // Simpan data
    $book = Book::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'auther_id' => $request->auther_id,
        'publisher_id' => $request->publisher_id,
    ]);

    dd($book);
    return redirect()->route('book.index')->with('success', 'Book added successfully!');
}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(book $book)
    {
        return view('book.edit', [
            'authors' => auther::latest()->get(),
            'publishers' => publisher::latest()->get(),
            'categories' => category::latest()->get(),
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatebookRequest  $request
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatebookRequest $request, $id)
    {
        $book = book::find($id);
        $book->name = $request->name;
        $book->auther_id = $request->author_id;
        $book->category_id = $request->category_id;
        $book->publisher_id = $request->publisher_id;
        $book->save();
        return redirect()->route('books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        book::find($id)->delete();
        return redirect()->route('books');
    }
}
