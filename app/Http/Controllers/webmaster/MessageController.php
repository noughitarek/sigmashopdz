<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Messages managments';
        $data["messages"] = Message::where('deleted_by', null)->orderBy('created_at', 'desc')->get();
        $data["can_delete"] = Auth::user()->Has_permission("delete_messages");
        return view("webmaster.messages.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->deleted_by = Auth::user()->id;
        $message->save();
        return redirect()->route('webmaster_messages_index')->with('success', 'Message deleted successfully');
    }
}
