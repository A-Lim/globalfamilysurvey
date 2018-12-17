<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $this->authorize('view', Category::class);
        $categories = Category::orderBy('sequence')->get();
        return view('categories.index', compact('categories'));
    }

    public function create() {
        $this->authorize('create', Category::class);
        $questions = Question::whereHas('survey', function($query) {
            $query->where('type', 'member');
        })->orderBy('sequence')->get();
        return view('categories.create', compact('questions'));
    }

    public function store(CategoryRequest $request) {
        $this->authorize('create', Category::class);
        $request->save();
        session()->flash('success', 'Category successfully created.');
        return redirect('categories');
    }

    public function edit(Category $category) {
        $questions = Question::whereHas('survey', function($query) {
            $query->where('type', 'member');
        })->orderBy('sequence')->get();

        return view('categories.edit', compact('category', 'questions'));
    }

    public function update(CategoryRequest $request, Category $category) {
        $this->authorize('update', Category::class);
        $request->save();
        session()->flash('success', 'Category successfully updated.');
        return redirect('categories');
    }

    public function destroy(Category $category) {
        $this->authorize('delete', Category::class);
        $category->delete();
        session()->flash('success', 'Category successfully deleted');
        return back();
    }
}
