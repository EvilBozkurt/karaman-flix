<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryFormRequest;
use App\Http\Requests\UpdateCategoryFormRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Categories/Index', [
            'categories' => CategoryResource::collection(Category::latest()->simplePaginate(10)),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Categories/Create', [
            'edit' => false,
            'category' => (object) []
        ]);
    }

    public function store(StoreCategoryFormRequest $request)
    {
//        $data = $request->validate([
//            'name' => ['required', 'string', 'max:255'],
//            'slug' => ['required', 'string', Rule::unique(Category::class)]
//        ]);


        $data = $request->validated();
        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category saved successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Create', [
            'edit' => true,
            'category' => new CategoryResource($category),
        ]);
    }

    public function update(UpdateCategoryFormRequest $request, Category $category)
    {
        $data = $request->validated();

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
