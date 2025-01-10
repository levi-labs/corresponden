<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\IncomingLetterService;
use App\Services\ReplyService;
use App\Services\RecentActivityService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IncomingLetterController extends Controller
{
    protected $incomingLetterService;
    protected $replyService;
    protected $recentActivityService;
    public function __construct(
        IncomingLetterService $incomingLetterService,
        ReplyService $replyService,
        RecentActivityService $recentActivityService
    ) {

        $this->incomingLetterService = $incomingLetterService;
        $this->replyService = $replyService;
        $this->recentActivityService = $recentActivityService;
    }
    public function index()
    {
        $title = 'Inbox';
        $checkRole = auth('web')->user()->role;
        if ($checkRole == 'student') {
            $data = $this->incomingLetterService->getAllIncomingLettersAsStudent();
        } elseif ($checkRole == 'lecturer') {
            $data = $this->incomingLetterService->getAllIncomingLettersAsLecture();
        } else {
            $data = $this->incomingLetterService->getAllIncomingLetters();
        }

        return view('pages.message.incoming.index', compact('title', 'data'));
    }

    public function show(IncomingLetter $incomingLetter)
    {
        $title = 'Letter Details';
        $incomingLetter = $this->incomingLetterService->getIncomingLetterById($incomingLetter->id);
        $updateStatus = $this->incomingLetterService->updateStatus($incomingLetter->id);
        return view('pages.message.incoming.detail', compact('title', 'incomingLetter'));
    }

    public function approve(Request $request)
    {
        $title = 'Letter Details';

        $choice_source = $request->source;
        // return response()->json($request->all());
        // dd($choice_source);
        if ($choice_source === 'create') {
            $validator = Validator::make($request->all(), [
                'greeting' => 'required',
                'closing' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->toArray()], 422);
            }
            $data = $request->all();
            DB::beginTransaction();
            try {
                $this->replyService->approve($data);
                $this->recentActivityService->create(auth('web')->user()->id, 'reply-message');
                DB::commit();
                session()->flash('success', 'Letter approved successfully');
                return response()->json([
                    'success' => true,
                    'message' => 'Letter approved successfully',
                ], 201);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['error' => $th->getMessage()], 500);
            }
        }
        if ($choice_source === 'from_computer') {

            $validator = Validator::make($request->all(), [
                'attachment' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->toArray()], 422);
            }
            $file = $request->hasFile('attachment');
            if ($file) {
                DB::transaction(function () use ($request) {
                    $this->replyService->approve($request->all(), $request->file('attachment'));
                    $this->recentActivityService->create(auth('web')->user()->id, 'reply-message');
                });
                session()->flash('success', 'Letter approved successfully');
                return response()->json(['success' => true, 'message' => 'Letter approved successfully'], 202);
            }

            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function downloadReply($IdLetter, Request $request)
    {
        try {
            $file =  Reply::where('id_letter', $IdLetter)->where('file', '!=', '')->first();
            if (!$file) {
                return response()->json(['error' => 'File not found'], 404);
            }
            $file_path = storage_path('app/' . $file->file);
            return response()->json($file_path);
            if (file_exists($file_path)) {
                $headers = [

                    'Content-Disposition' => sprintf('attachment; filename="%s"', $file->file),
                    'Content-Length' => filesize($file_path),
                    'Content-Type' => mime_content_type($file_path),
                ];
                $safeFilename = str_replace(['/', '\\'], '_', $file->file);
                $saveFilename = explode('_', $safeFilename);
                $namedownloaded = array_shift($saveFilename);

                $downloadname = implode('_', $saveFilename);



                return response()->download($file_path, $downloadname, $headers);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function destroyReply($idReply)
    {
        try {
            $reply = Reply::find($idReply);
            if ($reply) {
                if ($reply->file != null) {

                    $file_path = storage_path('app/public/' . $reply->file);
                    if (file_exists($file_path)) {

                        unlink($file_path);
                    }
                }
                $reply->delete();

                return redirect()->back()->with('success', 'Reply deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Reply not found');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function previewReply($idReply)
    {
        try {
            $title = 'Reply Details';
            // $reply = Reply::find($idReply);
            $reply = Reply::join('incoming_letters', 'incoming_letters.id', '=', 'replies.id_letter')
                ->join('letter_types', 'incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->join('users as sender', 'incoming_letters.sender_id', '=', 'sender.id')
                ->join('users as receiver', 'incoming_letters.receiver_id', '=', 'receiver.id')
                ->join('students', 'incoming_letters.sender_id', '=', 'students.user_id')
                ->select(
                    'replies.*',
                    'incoming_letters.letter_number as letter_number',
                    'letter_types.name as letter_type',
                    'sender.name as sender_name',
                    'receiver.name as receiver_name',
                    'students.fullname as student_name',
                    'students.student_id'
                )
                ->where('replies.id', $idReply)
                ->first();

            if ($reply) {
                return view('components.reply.print', compact('reply', 'title'));
            } else {
                return redirect()->back()->with('error', 'Reply not found');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
