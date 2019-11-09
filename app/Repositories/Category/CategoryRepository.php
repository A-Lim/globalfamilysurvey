<?php
namespace App\Repositories;

use App\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return \Cache::rememberForEver(Category::CACHE_KEY, function() {
            return Category::orderBy('sequence')->get();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Category::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create($data) {
        \Cache::forget(Category::CACHE_KEY);
        $category = Category::create($data);

        // link questions with categories
        $category->questions()->sync($data['question_ids']);
        return $category;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Category $category, $data) {
        \Cache::forget(Category::CACHE_KEY);
        $category->update($data);
        // link questions with categories
        $category->questions()->sync($data['question_ids']);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Category $category) {
        $category->delete();
        \Cache::forget(Category::CACHE_KEY);
    }
}
