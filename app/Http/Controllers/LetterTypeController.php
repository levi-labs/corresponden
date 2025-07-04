<?php

namespace App\Http\Controllers;

use App\Http\Requests\LetterTypeRequest;
use App\Models\LetterType;
use Illuminate\Http\Request;
use App\services\LetterTypeService;
use App\Services\RecentActivityService;

class LetterTypeController extends Controller
{
    protected $LetterTypeService;

    public function __construct(LetterTypeService $LetterTypeService)
    {
        $this->LetterTypeService = $LetterTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Jenis Surat';
        $data = $this->LetterTypeService->getAllLetterTypes();
        return view('pages.letter-type.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Jenis Surat';

        return view('pages.letter-type.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LetterTypeRequest $request)
    {
        try {
            $this->LetterTypeService->create($request->all());
            return redirect()->route('letter-type.index')->with('success', 'Letter Type Created Successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LetterType $letterType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterType $letterType)
    {
        $title = 'Edit Jenis Surat';
        return view('pages.letter-type.edit', compact('letterType', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LetterTypeRequest $request, LetterType $letterType)
    {

        $this->LetterTypeService->update($letterType, $request->all());
        return redirect()->route('letter-type.index')->with('success', 'Letter Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterType $letterType)
    {
        try {
            $this->LetterTypeService->destroy($letterType);
            return redirect()->route('letter-type.index')->with('success', 'Letter Type Deleted Successfully');
        } catch (\Throwable $th) {

            if ($th->getCode() == 23000) {
                return redirect()->back()->with('info', 'Fakultas tidak dapat dihapus karena sudah memiliki data terkait');
            }
            if ($th->getCode() == 500) {
                return redirect()->back()->with('error', 'Fakultas tidak dapat dihapus karena sudah memiliki data terkait');
            }
            if ($th->getCode() == 404) {
                return redirect()->back()->with('error', 'Fakultas tidak ditemukan');
            }
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
