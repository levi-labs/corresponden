<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\IncomingLetterService;
use App\Services\ReplyService;
use Illuminate\Support\Facades\Validator;

class IncomingLetterController extends Controller
{
    protected $incomingLetterService;
    protected $replyService;
    public function __construct(
        IncomingLetterService $incomingLetterService,
        ReplyService $replyService
    ) {

        $this->incomingLetterService = $incomingLetterService;
        $this->replyService = $replyService;
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
        return view('pages.message.incoming.detail', compact('title', 'incomingLetter'));
    }

    public function approve(Request $request)
    {
        $title = 'Letter Details';

        $choice_source = $request->source;
        return response()->json($request->all());
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
            return response()->json($data);
        }
        if ($choice_source === 'from_computer') {
            return response()->json($request->all());
            $validator = Validator::make($request->all(), [
                'attachment' => 'required|file|mimes:doc,docx,pdf|max:5048',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->toArray()], 422);
            }

            return response()->json($request->all());
        }
        // $incomingLetter = $this->incomingLetterService->getIncomingLetterById($incomingLetter->id);

        // return view('pages.message.incoming.detail', compact('title', 'incomingLetter'));
    }
}
