<?php

namespace App\Http\Controllers;

use App\Models\ArchiveIncomingLetter;
use App\services\ArchiveIncomingService;
use App\services\LetterTypeService;
use Illuminate\Http\Request;

class ArchiveIncomingController extends Controller
{
    protected $archiveIncomingLetter;
    protected $letterTypeService;

    public function __construct(ArchiveIncomingService $archiveIncomingLetter, LetterTypeService $letterTypeService)
    {
        $this->archiveIncomingLetter = $archiveIncomingLetter;
        $this->letterTypeService = $letterTypeService;
    }
    public function index()
    {
        $title = 'Arsip Surat Masuk';
        $serach = request()->search;

        if ($serach !== null && $serach !== '') {
            $data = $this->archiveIncomingLetter->search($serach);
            return view('pages.archive.incoming-letter.index', compact('title', 'data'));
        } else {
            $data = $this->archiveIncomingLetter->getAllArchiveIncomings();

            return view('pages.archive.incoming-letter.index', compact('title', 'data'));
        }
    }

    public function show(ArchiveIncomingLetter $archiveIncomingLetter)
    {
        $title = 'Detail Surat Masuk';
        $data = $this->archiveIncomingLetter->getArchiveIncomingById($archiveIncomingLetter->id);
        return view('pages.archive.incoming-letter.detail', compact('title', 'data'));
    }
    public function create()
    {
        $title = 'Form Surat Masuk';
        $letter_number = date('Y') . '/' . 'USNI' . '/' . str_pad(rand(0, 99), 3, '0', STR_PAD_LEFT) . rand(0, 999);
        $letterTypes = $this->letterTypeService->getAllLetterTypes();

        return view('pages.archive.incoming-letter.create', compact('title', 'letterTypes', 'letter_number'));
    }

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
            'attachment' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10240', // Maksimal 10MB
        ]);

        try {
            $path = null;
            if ($request->has('attachment')) {
                $file = $request->file('attachment');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('archive-incoming', $filename, 'public');
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

            $this->archiveIncomingLetter->create($data);
            return redirect()->route('archive-incoming-letter.index')->with('success', 'Archive Incoming Letter Created Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $title = 'Edit Surat Masuk';
        $letterTypes = $this->letterTypeService->getAllLetterTypes();
        $data = ArchiveIncomingLetter::find($id);
        return view('pages.archive.incoming-letter.edit', compact('title', 'data', 'letterTypes'));
    }
    public function update(Request $request, $id)
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
            $check = ArchiveIncomingLetter::find($id);
            $path = null;
            if ($request->has('attachment')) {
                $file = $request->file('attachment');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('archive-incoming', $filename, 'public');
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
            $this->archiveIncomingLetter->update($id, $data);
            return redirect()->route('archive-incoming-letter.index')->with('success', 'Archive Incoming Letter Updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->archiveIncomingLetter->delete($id);
        return redirect()->back()->with('success', 'Archive Incoming Letter Deleted successfully');
    }
}
