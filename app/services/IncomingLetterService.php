<?php

namespace App\Services;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use Illuminate\Support\Facades\DB;

class IncomingLetterService
{
    public function getAllIncomingLetters($unread = false, $read = false)
    {
        if ($unread) {
            $data = IncomingLetter::join('users as receiver', 'receiver.id', '=', 'incoming_letters.receiver_id')
                ->join('users as sender', 'incoming_letters.sender_id', '=', 'sender.id')
                ->join('letter_types', 'incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->where('receiver.role', '!==', 'student')
                ->where('incoming_letters.status', 'unread')
                ->select(
                    'incoming_letters.id',
                    'incoming_letters.date',
                    'incoming_letters.subject',
                    'letter_types.type',
                    'incoming_letters.body',
                    'letter_types.name as letter_type',
                    'sender.name as sender_name',
                )

                ->paginate(25);
        }

        if ($read) {
            $data = IncomingLetter::where('status', 'read')->paginate(25);
        }
        if ($unread == false && $read == false) {
            $data = IncomingLetter::join('letter_types', 'incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->join('users as receiver', 'receiver.id', '=', 'incoming_letters.receiver_id')
                ->join('users as sender', 'incoming_letters.sender_id', '=', 'sender.id')
                ->select(
                    'incoming_letters.id',
                    'incoming_letters.date',
                    'incoming_letters.subject',
                    'letter_types.type',
                    'incoming_letters.body',
                    'letter_types.name as letter_type',
                    'receiver.name as receiver_name',
                    'sender.name as sender_name'
                )
                ->where('receiver.role', '!=', 'student')
                ->paginate(25);
        }

        return $data;
    }

    public function getAllIncomingLettersAsStudent()
    {
        $data = IncomingLetter::join('users as receiver', 'receiver.id', '=', 'incoming_letters.receiver_id')
            ->where('receiver.id', '=', auth('web')->user()->id)
            ->where('incoming_letters.receiver_id', '=', auth('web')->user()->id)
            ->paginate(25);

        return $data;
    }

    public function getAllIncomingLettersAsLecture()
    {
        $data = IncomingLetter::join('users as receiver', 'receiver.id', '=', 'incoming_letters.receiver_id')
            ->join('users as sender', 'incoming_letters.sender_id', '=', 'sender.id')
            ->join('letter_types', 'incoming_letters.letter_type_id', '=', 'letter_types.id')
            ->where('receiver.id', '=', auth('web')->user()->id)
            ->where('incoming_letters.receiver_id', '=', auth('web')->user()->id)
            ->select(
                'incoming_letters.id',
                'incoming_letters.date',
                'incoming_letters.subject',
                'incoming_letters.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'receiver.username as receiver_username',
                'incoming_letters.status',
                'incoming_letters.attachment',
                'incoming_letters.letter_number'
            )
            ->paginate(25);
        // dd($data);
        return $data;
    }

    public function getIncomingLetterById($id)
    {
        $incomingLetter = IncomingLetter::join('users as receiver', 'incoming_letters.receiver_id', '=', 'receiver.id')
            ->join('users as sender', 'incoming_letters.sender_id', '=', 'sender.id')
            ->join('letter_types', 'incoming_letters.letter_type_id', '=', 'letter_types.id')
            ->join('students', 'incoming_letters.sender_id', '=', 'students.user_id')
            ->where('incoming_letters.id', $id)
            ->select(
                'incoming_letters.id',
                'incoming_letters.date',
                'incoming_letters.subject',
                'incoming_letters.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'sender.username as sender_username',
                'students.student_id as student_id',
                'students.fullname as student_name',
                'receiver.name as receiver_name',
                'receiver.username as receiver_username',
                'incoming_letters.status',
                'incoming_letters.attachment',
                'incoming_letters.letter_number'
            )
            ->first();
        return $incomingLetter;
    }

    public function updateStatus($id)
    {
        try {
            DB::transaction(function () use ($id) {
                IncomingLetter::where('id', $id)->update(['status' => 'read']);
                OutgoingLetter::where('incoming_letter_id', $id)->update(['status' => 'read']);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
