<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetter;
use App\Services\OutgoingLetterService;
use Illuminate\Http\Request;

class OutgoingLetterController extends Controller
{

    protected $outgoingLetterService;
    public function __construct(OutgoingLetterService $outgoingLetterService)
    {
        $this->outgoingLetterService = $outgoingLetterService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Outgoing Letter List';

        return view('pages.message.outgoing.index', compact('title'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingLetter $outgoingLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingLetter $outgoingLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutgoingLetter $outgoingLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingLetter $outgoingLetter)
    {
        //
    }
}
