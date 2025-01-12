<?php

namespace App\Http\Controllers;

use App\Models\ArchiveIncomingLetter;
use App\services\ArchiveIncomingService;
use Illuminate\Http\Request;

class ArchiveIncomingController extends Controller
{
    protected $archiveIncomingLetter;

    public function __construct(ArchiveIncomingService $archiveIncomingLetter)
    {
        $this->archiveIncomingLetter = $archiveIncomingLetter;
    }
    public function index()
    {
        $title = 'Archive Incoming Letters';
        $data = $this->archiveIncomingLetter->getAllArchiveIncomings();

        return view('pages.message.incoming.archive', compact('title', 'data'));
    }

    public function show(ArchiveIncomingLetter $archiveIncomingLetter)
    {
        $title = 'Letter Details';
        $data = $this->archiveIncomingLetter->getArchiveIncomingById($archiveIncomingLetter->id);
        return view('pages.message.incoming.detail', compact('title', 'data'));
    }
    public function create()
    {
        $title = 'Create Incoming Letter';

        return view('pages.message.incoming.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'incoming_letter_id' => 'required',
            'archive_date' => 'required',
            'sender_name' => 'required',
            'receiver_name' => 'required',
            'subject' => 'required',
            'body' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10240', // Maksimal 10MB
            'date' => 'required',
            'letter_number' => 'required',
        ]);

        $data = $request->all();
        $this->archiveIncomingLetter->create($data);
        return redirect()->back()->with('success', 'Archive Incoming Letter Created successfully');
    }

    public function edit($id)
    {
        $title = 'Edit Incoming Letter';
        $data = $this->archiveIncomingLetter->getArchiveIncomingById($id);
        return view('pages.message.incoming.edit', compact('title', 'data'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'incoming_letter_id' => 'required',
            'archive_date' => 'required',
            'sender_name' => 'required',
            'receiver_name' => 'required',
            'subject' => 'required',
            'body' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10240', // Maksimal 10MB
            'date' => 'required',
            'letter_number' => 'required',
        ]);
        $data = $request->all();
        $this->archiveIncomingLetter->update($id, $data);
        return redirect()->back()->with('success', 'Archive Incoming Letter Updated successfully');
    }

    public function destroy($id)
    {
        $this->archiveIncomingLetter->delete($id);
        return redirect()->back()->with('success', 'Archive Incoming Letter Deleted successfully');
    }
}
