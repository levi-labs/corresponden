<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\IncomingLetter;
use App\Models\Notification;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\InboxService;
use App\Services\IncomingLetterService;
use App\Services\ReplyService;
use App\Services\RecentActivityService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Matcher\Not;

class InboxController extends Controller
{
    protected $incomingLetterService;
    protected $replyService;
    protected $recentActivityService;
    public function __construct(
        InboxService $incomingLetterService,
        ReplyService $replyService,
        RecentActivityService $recentActivityService
    ) {

        $this->incomingLetterService = $incomingLetterService;
        $this->replyService = $replyService;
        $this->recentActivityService = $recentActivityService;
    }
    public function index()
    {
        $title = 'Pesan Masuk';
        $checkRole = auth('web')->user()->role;
        if ($checkRole == 'student') {
            $data = $this->incomingLetterService->getAllIncomingLettersAsStudent();
        } elseif ($checkRole == 'lecturer') {
            $data = $this->incomingLetterService->getAllIncomingLettersAsLecture();
        } else {
            $data = $this->incomingLetterService->getAllIncomingLetterAsStaff();
        }

        return view('pages.message.incoming.index', compact('title', 'data'));
    }

    public function show(Inbox $incomingLetter)
    {

        $title = 'Detail Pesan Masuk';
        $notif = Notification::where('inbox_id', $incomingLetter->id)->update(['status' => 'read']);

        $this->incomingLetterService->updateStatus($incomingLetter->id);
        $incomingLetter = $this->incomingLetterService->getIncomingLetterById($incomingLetter->id);

        return view('pages.message.incoming.detail', compact('title', 'incomingLetter'));
    }

    public function approve(Request $request)
    {
        $title = 'Approve Pesan Masuk';

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

    public function destroy(Inbox $incomingLetter)
    {
        try {
            $incomingLetter->delete();
            return redirect()->back()->with('success', 'Message deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
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
    public function downloadFileInbox($id)
    {
        try {
            $file =  Inbox::where('id', $id)->first();
            if (!$file) {
                return response()->json(['error' => 'File not found'], 404);
            }
            $file_path = storage_path('app/' . $file->attachment);

            if (file_exists($file_path)) {
                $headers = [
                    'Content-Disposition' => sprintf('attachment; filename="%s"', $file->attachment),
                    'Content-Length' => filesize($file_path),
                    'Content-Type' => mime_content_type($file_path),
                ];
                $safeFilename = str_replace(['/', '\\'], '_', $file->attachment);
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
        $IdReplu = Reply::find($idReply)->id_letter;
        $checkRole = Inbox::where('inbox.id', $idReply)
            ->join('users as receiver', 'receiver.id', '=', 'inbox.receiver_id')
            ->select('receiver.role')
            ->first();
        // dd($checkRole);
        try {
            $title = 'Preview Balasan';
            // $reply = Reply::find($idReply);
            if ($checkRole->role == 'student') {
                // dd($checkRole);
                $reply = Reply::join('inbox', 'inbox.id', '=', 'replies.id_letter')
                    ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                    ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                    ->join('users as receiver', 'inbox.receiver_id', '=', 'receiver.id')
                    ->join('students', 'inbox.receiver_id', '=', 'students.user_id')
                    ->select(
                        'replies.*',
                        'inbox.letter_number as letter_number',
                        'letter_types.name as letter_type',
                        'sender.role as sender_role',
                        'sender.name as sender_name',
                        'receiver.name as receiver_name',
                        'students.fullname as student_name',
                        'students.student_id'
                    )
                    ->where('replies.id', $idReply)
                    ->first();
                // dd($reply);
            } elseif ($checkRole->role == 'lecturer') {
                $reply = Reply::join('inbox', 'inbox.id', '=', 'replies.id_letter')
                    ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                    ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                    ->join('users as receiver', 'inbox.receiver_id', '=', 'receiver.id')
                    ->join('students', 'inbox.sender_id', '=', 'students.user_id')
                    ->select(
                        'replies.*',
                        'inbox.letter_number as letter_number',
                        'letter_types.name as letter_type',
                        'sender.role as sender_role',
                        'sender.name as sender_name',
                        'receiver.name as receiver_name',
                        'students.fullname as student_name',
                        'students.student_id as student_id'
                        // 'lecturers.fullname as student_name',
                        // 'lecturers.lecturer_id as student_id'
                    )
                    ->where('replies.id', $idReply)
                    ->first();

                // dd($reply);
            }

            // dd($reply);
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
