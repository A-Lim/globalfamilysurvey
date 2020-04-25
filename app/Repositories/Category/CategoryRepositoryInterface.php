<?php
namespace App\Repositories;

use App\Category;

interface CategoryRepositoryInterface
{
    /**
     * Retrieve all categories
     *
     * @return [Category]
     */
    public function all();

    /**
     * Retrieve category by id
     *
     * @param integer $id
     * @return Category
     */
    public function find($id);


    /**
     * Create category
     *
     * @param array $data
     * @return Category
     */
    public function create($data);


    /**
     * Update category
     *
     * @param Category $category
     * @param array $data
     * @return Category $category
     */
    public function update(Category $category, $data);

    /**
     * Delete category
     *
     * @param Category $category
     * @return null
     */
    public function delete(Category $category);
}
