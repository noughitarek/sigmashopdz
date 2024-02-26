<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Categories managments';
        $data["categories"] = Category::where("deleted_by", null)->orderBy('created_at', 'desc')->get();
        $data["can_create"] = Auth::user()->Has_permission("create_categories");
        $data["can_edit"] = Auth::user()->Has_permission("edit_categories");
        $data["can_delete"] = Auth::user()->Has_permission("delete_categories");
        return view("webmaster.categories.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["title"] = 'Create a category';
        return view("webmaster.categories.create")->with("data", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'name'  => $request->input('name'),
            'slug'  => $request->input('slug'),
            'description' => $request->input('description'),
            'is_active'  => $request->input('is_active'),
            'created_by' => Auth::user()['id'],
        ]);
        return redirect()->route('webmaster_categories_index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        
        $data["can_create"] = Auth::user()->Has_permission("create_categories");
        $data["can_edit"] = Auth::user()->Has_permission("edit_categories");
        $data["can_delete"] = Auth::user()->Has_permission("delete_categories");
        $data["title"] = 'Category '.$category["id"];
        $data["category"] = $category;
        return view("webmaster.categories.show")->with("data", $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $data["title"] = 'Edit category '.$category["id"];
        $data["category"] = $category;
        return view("webmaster.categories.edit")->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if($category->slug != $request->slug){
            $dep = Category::where("slug", $request->slug)->first();
            if($dep)return redirect()->back()->withInput()->withErrors(['slug' => 'The slug must be unique.']);
        }
        $category->update([
            'name'  => $request->input('name'),
            'slug'  => $request->input('slug'),
            'description' => $request->input('description'),
            'is_active'  => $request->input('is_active'),
        ]);
        return redirect()->route('webmaster_categories_index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->deleted_by = Auth::user()->id;
        $category->save();
        return redirect()->route('webmaster_categories_index')->with('success', 'Category deleted successfully');
    }
}
