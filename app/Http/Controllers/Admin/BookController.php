<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use FileUploadTrait;

    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.books.index', ['books' => $this->bookService->getAll()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request) : RedirectResponse
    {
        // Получаем файл обложки, если он есть
        $coverImage = $request->file('cover_image');

        // Валидация данных уже выполнена в StoreBookRequest
        $this->bookService->create($request->validated(), $coverImage);

        return redirect()->route('books.index')->with('success', 'Successfully created!');
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
        $book = $this->bookService->getById($id);
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBookRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id) : RedirectResponse
    {
        $book = $this->bookService->getById($id);

        // Получаем файл обложки, если он есть
        $coverImage = $request->file('cover_image');

        // Валидация данных уже выполнена в UpdateBookRequest
        $this->bookService->update($book, $request->validated(), $coverImage);

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
            $book = $this->bookService->getById($id);
            $this->bookService->delete($book);
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }

    // Смена статуса книги
    public function changeStatus(Request $request, $id)
    {
        $book = $this->bookService->getById($id);

        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', BookService::$statuses),
        ]);

        try {
            $book = $this->bookService->changeStatus($book, $validated['status']);
            return response()->json($book);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
