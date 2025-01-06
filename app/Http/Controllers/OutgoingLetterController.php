<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetter;
use App\Models\User;
use App\services\LetterTypeService;
use App\Services\OutgoingLetterService;
use Illuminate\Http\Request;

class OutgoingLetterController extends Controller
{

    protected $outgoingLetterService;
    protected $letterTypeService;
    public function __construct(OutgoingLetterService $outgoingLetterService, LetterTypeService $letterTypeService)
    {
        $this->outgoingLetterService = $outgoingLetterService;
        $this->letterTypeService = $letterTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Outgoing Letter List';
        $data = $this->outgoingLetterService->getAllOutgoingLetters();
        return view('pages.message.outgoing.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Outgoing Letter';
        $letterTypes = $this->letterTypeService->getLetterTypeAsRole();
        $lectures = User::where('role', 'lecturer')->get();
        return view('pages.message.outgoing.create', compact('title', 'letterTypes', 'lectures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
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
