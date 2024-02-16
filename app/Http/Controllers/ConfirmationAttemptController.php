<?php

namespace App\Http\Controllers;

use App\Models\confirmation_attempt;
use App\Http\Requests\Storeconfirmation_attemptRequest;
use App\Http\Requests\Updateconfirmation_attemptRequest;

class ConfirmationAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Storeconfirmation_attemptRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(confirmation_attempt $confirmation_attempt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(confirmation_attempt $confirmation_attempt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateconfirmation_attemptRequest $request, confirmation_attempt $confirmation_attempt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(confirmation_attempt $confirmation_attempt)
    {
        //
    }
}
