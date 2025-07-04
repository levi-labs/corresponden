<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutgoingLetterRequest;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\OutgoingLetter;
use App\Models\Sent;
use App\Models\User;
use App\services\LetterTypeService;
use App\Services\OutgoingLetterService;
use App\Services\SentService;
use Illuminate\Http\Request;

class SentController extends Controller
{

    protected $outgoingLetterService;
    protected $letterTypeService;
    public function __construct(SentService $outgoingLetterService, LetterTypeService $letterTypeService)
    {
        $this->outgoingLetterService = $outgoingLetterService;
        $this->letterTypeService = $letterTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Surat Keluar';
        $data = $this->outgoingLetterService->getAllOutgoingLettersByUser();
        return view('pages.message.outgoing.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Pengajuan Surat';
        $letterTypes = $this->letterTypeService->getLetterTypeAsRole();
        $faculties = Faculty::all();
        $lectures = User::where('role', 'lecturer')->get();
        return view('pages.message.outgoing.create', compact('title', 'letterTypes', 'lectures', 'faculties'));
    }

    public function getFaculties($id)
    {
        $jurusan = Department::where('faculty_id', $id)->get();
        return response()->json($jurusan, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OutgoingLetterRequest $request)
    {
        $data = $request->validated();
        try {
            $sender = auth('web')->user()->id;
            $auth = auth('web')->user()->role;

            $receiver = User::where('role', 'staff')->first();

            $letter_number = date('Y') . '/' . 'USNI' . '/' . str_pad($sender, 3, '0', STR_PAD_LEFT) . rand(0, 999);
            $data = [
                'subject' => $data['subject'],
                'body' => $data['body'],
                'letter_type_id' => $data['letter_type'],
                'sender_id' => auth('web')->user()->id,
                'receiver_id' => $receiver->id,
                'letter_number' => $letter_number,
                'date' => date('Y-m-d'),
                'faculty_id' => $request->faculty_id,
                'department_id' => $request->department_id,
                'status' => 'unread',
            ];
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('outgoing_letters', $name, 'public');
                $data['attachment'] = $path;
            }


            $this->outgoingLetterService->create($data);
            return redirect()->route('outgoing-letter.index')->with('success', 'Sent letter successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sent $outgoingLetter)
    {
        $title = 'Detail Surat Keluar';
        $outgoingLetter = $this->outgoingLetterService->getOutgoingLetterById($outgoingLetter->id);
        return view('pages.message.outgoing.detail', compact('title', 'outgoingLetter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sent $outgoingLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sent $outgoingLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sent $outgoingLetter)
    {
        try {
            $outgoingLetter->delete();
            return redirect()->back()->with('success', 'Message deleted successfully');
        } catch (\Throwable $th) {
            if ($th->getCode() == 23000) {
                return redirect()->back()->with('info', 'Surat tidak dapat dihapus karena sudah diproses');
            }
            if ($th->getCode() == 500) {
                return redirect()->back()->with('error', 'Surat tidak dapat dihapus karena sudah memiliki data terkait');
            }
            if ($th->getCode() == 404) {
                return redirect()->back()->with('error', 'Surat tidak ditemukan');
            }
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
