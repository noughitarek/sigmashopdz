<?php

namespace App\Http\Controllers\webmaster;

use Carbon\Carbon;
use App\Models\Campaign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorecampaignRequest;
use App\Http\Requests\UpdatecampaignRequest;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Campaigns managments';
        $data["campaigns"] = Campaign::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
        $data["can_create"] = Auth::user()->Has_permission("create_campaigns");
        $data["can_edit"] = Auth::user()->Has_permission("edit_campaigns");
        $data["can_delete"] = Auth::user()->Has_permission("delete_campaigns");
        return view("webmaster.campaigns.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["title"] = 'Create a campaign';
        return view("webmaster.campaigns.create")->with("data", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecampaignRequest $request)
    {
        $data = array(
            "name" => $request->input("name"),
            "slug" => $request->input("slug"),
            "daily_budget" => (float)str_replace("$", "", $request->input("daily_budget")),
            "total_budget" => (float)str_replace("$", "", $request->input("total_budget")),
            "is_active" => $request->input("is_active"),
            "changed_at" => now(),
            "started_at" => $request->input("start_date")!=""?Carbon::createFromFormat('d/m/Y', $request->input("start_date"))->format('Y-m-d'):null,
            "ended_at" => $request->input("end_date")!=""?Carbon::createFromFormat('d/m/Y', $request->input("end_date"))->format('Y-m-d'):null,
            "created_by" => Auth::user()->id
        );
        Campaign::create($data);
        return redirect()->route('webmaster_campaigns_index')->with('success', 'Campaign created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(campaign $campaign)
    {
        $data["title"] = 'Edit campaign '.$campaign->id;
        $data["campaign"] = $campaign;
        $data["campaign"]->started_at = $data["campaign"]->started_at!=null?Carbon::createFromFormat('Y-m-d', $data["campaign"]->started_at)->format('d/m/Y'):"";
        $data["campaign"]->ended_at = $data["campaign"]->ended_at!=null?Carbon::createFromFormat('Y-m-d', $data["campaign"]->ended_at)->format('d/m/Y'):"";
        return view("webmaster.campaigns.edit")->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecampaignRequest $request, campaign $campaign)
    {
        $data = array(
            "name" => $request->input("name"),
            "slug" => $request->input("slug"),
            "daily_budget" => (float)str_replace("$", "", $request->input("daily_budget")),
            "total_budget" => (float)str_replace("$", "", $request->input("total_budget")),
            "is_active" => $request->input("is_active"),
            "changed_at" => now(),
            "started_at" => $request->input("start_date")!=""?Carbon::createFromFormat('d/m/Y', $request->input("start_date"))->format('Y-m-d'):null,
            "ended_at" => $request->input("end_date")!=""?Carbon::createFromFormat('d/m/Y', $request->input("end_date"))->format('Y-m-d'):null,
            "created_by" => Auth::user()->id
        );
        $campaign->update($data);
        return redirect()->route('webmaster_campaigns_index')->with('success', 'Campaign updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(campaign $campaign)
    {
        //
    }
}
