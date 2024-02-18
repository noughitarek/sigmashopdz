<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Pages managments';
        $data["pages"] = Page::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
        $data["can_create"] = Auth::user()->Has_permission("create_pages");
        $data["can_edit"] = Auth::user()->Has_permission("edit_pages");
        $data["can_delete"] = Auth::user()->Has_permission("delete_pages");
        return view("webmaster.pages.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["title"] = 'Create a page';
        return view("webmaster.pages.create")->with("data", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        $page = Page::create([
            'title'  => $request->input('title'),
            'slug'  => $request->input('slug'),
            'position' => $request->input("position"),
            'is_active'  => $request->input('is_active'),
            'content' => $request->input('content'),
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('webmaster_pages_index')->with('success', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $data["title"] = 'Edit page '.$page->id;
        $data["page"] = $page;
        return view("webmaster.pages.edit")->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update([
            'title'  => $request->input('title'),
            'slug'  => $request->input('slug'),
            'position' => $request->input("position"),
            'is_active'  => $request->input('is_active'),
            'content' => $request->input('content'),
        ]);
        return redirect()->route('webmaster_pages_index')->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
