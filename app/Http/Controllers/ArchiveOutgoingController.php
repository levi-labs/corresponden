<?php

namespace App\Http\Controllers;

use App\Models\ArchiveOutgoingLetter;
use App\services\ArchiveOutgoingService;
use App\services\LetterTypeService;
use Illuminate\Http\Request;

class ArchiveOutgoingController extends Controller
{

    protected $archiveOutgoingService;
    protected $letterTypeService;

    public function __construct(
        ArchiveOutgoingService $archiveOutgoingService,
        LetterTypeService $letterTypeService
    ) {
        $this->archiveOutgoingService = $archiveOutgoingService;
        $this->letterTypeService = $letterTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Arsip Surat Keluar';
        $search = request()->search;

        if ($search !== null && $search !== '') {

            $data = $this->archiveOutgoingService->search($search);
            return view('pages.archive.outgoing-letter.index', compact('title', 'data'));
        } else {
            $data = $this->archiveOutgoingService->getAllOutGoingLetter();
            return view('pages.archive.outgoing-letter.index', compact('title', 'data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Surat Keluar';
        $letter_number = date('Y') . '/' . 'USNI' . '/' . str_pad(rand(0, 99), 3, '0', STR_PAD_LEFT) . rand(0, 999);
        $letterTypes = $this->letterTypeService->getAllLetterTypes();

        return view('pages.archive.outgoing-letter.create', compact('title', 'letterTypes', 'letter_number'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'from' => 'required',
            'letter_number' => 'required',
            'letter_type' => 'required',
            'source_letter' => 'required',
            'to' => 'required',
            'subject' => 'required',
            'attachment' => 'nullable|max:10240', // Maksimal 10MB
        ]);
        try {
            $path = null;
            if ($request->has('attachment')) {
                $file = $request->file('attachment');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('archive-outgoing', $filename, 'public');
            }
            $data = [
                'letter_number' => $request->letter_number,
                'date' => $request->date,
                'sender' => $request->from,
                'receiver' => $request->to,
                'letter_type_id' => $request->letter_type,
                'source_letter' => $request->source_letter,
                'subject' => $request->subject,
                'body' => $request->description,
                'attachment' => $path ?? null,
            ];

            $this->archiveOutgoingService->create($data);
            return redirect()->route('archive-outgoing-letter.index')->with('success', 'Archive Outgoing Letter Created Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Detail Surat Keluar';
        $data = $this->archiveOutgoingService->getOutgoingLetterById($id);
        return view('pages.archive.outgoing-letter.detail', compact('title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit Surat Keluar';
        $letterTypes = $this->letterTypeService->getAllLetterTypes();
        $data = ArchiveOutgoingLetter::find($id);
        return view('pages.archive.outgoing-letter.edit', compact(
            'title',
            'data',
            'letterTypes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required',
            'from' => 'required',
            'letter_number' => 'required',
            'letter_type' => 'required',
            'source_letter' => 'required',
            'to' => 'required',
            'subject' => 'required',
            'attachment' => 'nullable|max:10240', // Maksimal 10MB
        ]);

        try {
            $check = ArchiveOutgoingLetter::find($id);
            $path = null;
            if ($request->has('attachment')) {
                $file = $request->file('attachment');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('archive-outgoing', $filename, 'public');
            }
            $data = [
                'letter_number' => $request->letter_number,
                'date' => $request->date,
                'sender' => $request->from,
                'receiver' => $request->to,
                'letter_type_id' => $request->letter_type,
                'source_letter' => $request->source_letter,
                'subject' => $request->subject,
                'body' => $request->description,
                'attachment' => $request->attachment === null ? $check->attachment : $path,
            ];
            $this->archiveOutgoingService->update($id, $data);
            return redirect()->route('archive-outgoing-letter.index')->with('success', 'Archive Outgoing Letter Updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->archiveOutgoingService->delete($id);
        return redirect()->back()->with('success', 'Archive Outgoing Letter Deleted successfully');
    }
}
