<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests\Categories\CreateRequest;
use App\Http\Requests\Categories\UpdateRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\QuestionRepositoryInterface;

class CategoriesController extends Controller {

    private $categoryRepository;
    private $questionRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface,
        QuestionRepositoryInterface $questionRepositoryInterface) {
        $this->middleware('auth');
        $this->categoryRepository = $categoryRepositoryInterface;
        $this->questionRepository = $questionRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Category::class);
        $categories = $this->categoryRepository->all();
        return view('categories.index', compact('categories'));
    }

    public function create() {
        $this->authorize('create', Category::class);
        $questions = $this->questionRepository->members();
        return view('categories.create', compact('questions'));
    }

    public function store(CreateRequest $request) {
        $this->authorize('create', Category::class);
        $category = $this->categoryRepository->create($request->all());

        session()->flash('success', 'Category successfully created.');
        return redirect('categories');
    }

    public function edit(Category $category) {
        $this->authorize('update', Category::class);
        $questions = $this->questionRepository->members();
        return view('categories.edit', compact('category', 'questions'));
    }

    public function update(UpdateRequest $request, Category $category) {
        $this->authorize('update', Category::class);
        $this->categoryRepository->update($category, $request->all());

        session()->flash('success', 'Category successfully updated.');
        return redirect('categories');
    }

    public function destroy(Category $category) {
        $this->authorize('delete', Category::class);
        $this->categoryRepository->delete($category);
        session()->flash('success', 'Category successfully deleted');
        return back();
    }
}
