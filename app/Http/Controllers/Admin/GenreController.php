<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGenreRequest;
use App\Http\Requests\Admin\UpdateGenreRequest;
use App\Models\Book;
use App\Services\GenreService;
use Illuminate\Http\RedirectResponse;

class GenreController extends Controller
{
    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.genres.index', ['genres' => $this->genreService->getAll()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::all();

        return view('admin.genres.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreGenreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenreRequest $request) : RedirectResponse
    {
        // Валидация данных уже выполнена в StoreBookRequest
        $this->genreService->create($request->validated());

        return redirect()->route('genres.index')->with('success', 'Successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genre = $this->genreService->getById($id);
        $books = Book::all();
        $selectedBooks = $genre->books->pluck('id')->toArray();

        return view('admin.genres.edit', compact('genre', 'books', 'selectedBooks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateGenreRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenreRequest $request, $id) : RedirectResponse
    {
        $genre = $this->genreService->getById($id);
        // Валидация данных уже выполнена в UpdateBookRequest
        $this->genreService->update($genre, $request->validated());

        return redirect()->route('genres.index')->with('success', 'Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $genre = $this->genreService->getById($id);
            $this->genreService->delete($genre);
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
