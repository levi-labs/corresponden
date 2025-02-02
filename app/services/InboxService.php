<?php

namespace App\Services;

use App\Models\Inbox;
use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\Sent;
use Illuminate\Support\Facades\DB;

class InboxService
{
    public function getAllIncomingLetters($unread = false, $read = false)
    {
        if ($unread) {
            $data = Inbox::join('users as receiver', 'receiver.id', '=', 'inbox.receiver_id')
                ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                ->where('receiver.role', '!==', 'student')
                ->where('inbox.status', 'unread')
                ->select(
                    'inbox.id',
                    'inbox.date',
                    'inbox.subject',
                    'letter_types.type',
                    'inbox.body',
                    'letter_types.name as letter_type',
                    'sender.name as sender_name',
                )

                ->paginate(25);
        }

        if ($read) {
            $data = Inbox::where('status', 'read')->paginate(25);
        }
        if ($unread == false && $read == false) {
            $data = Inbox::join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                ->join('users as receiver', 'receiver.id', '=', 'inbox.receiver_id')
                ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                ->select(
                    'inbox.id',
                    'inbox.date',
                    'inbox.subject',
                    'letter_types.type',
                    'inbox.body',
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
        $data = Inbox::join('users as receiver', 'receiver.id', '=', 'inbox.receiver_id')
            ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
            ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
            ->where('receiver.id', '=', auth('web')->user()->id)
            ->where('inbox.receiver_id', '=', auth('web')->user()->id)
            ->select(
                'inbox.id',
                'inbox.date',
                'inbox.subject',
                'letter_types.type',
                'inbox.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name'
            )
            ->paginate(25);

        return $data;
    }

    public function getAllIncomingLettersAsLecture()
    {
        $data = Inbox::join('users as receiver', 'receiver.id', '=', 'inbox.receiver_id')
            ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
            ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
            ->where('receiver.id', '=', auth('web')->user()->id)
            ->where('inbox.receiver_id', '=', auth('web')->user()->id)
            ->select(
                'inbox.id',
                'inbox.date',
                'inbox.subject',
                'inbox.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'receiver.username as receiver_username',
                'inbox.status',
                'inbox.attachment',
                'inbox.letter_number'
            )
            ->paginate(25);
        // dd($data);
        return $data;
    }
    public function getAllIncomingLetterAsStaff()
    {

        // $data = Inbox::where('is_staff', 0)->get();
        // dd($data);
        $data = Inbox::join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
            ->join('users as receiver', 'receiver.id', '=', 'inbox.receiver_id')
            ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
            ->select(
                'inbox.id',
                'inbox.date',
                'inbox.subject',
                'letter_types.type',
                'inbox.body',
                'letter_types.name as letter_type',
                'receiver.name as receiver_name',
                'sender.name as sender_name'
            )

            ->where('inbox.is_staff', 1)
            ->where('receiver.role', '!=', 'student')
            ->paginate(25);

        return $data;
    }

    public function getIncomingLetterById($id)
    {
        $check_role = Inbox::where('inbox.id', $id)
            ->join('users as sender', 'sender.id', '=', 'inbox.sender_id')
            ->select('inbox.*', 'sender.role')
            ->first();
        if ($check_role->role == 'student') {
            $incomingLetter = Inbox::join('users as receiver', 'inbox.receiver_id', '=', 'receiver.id')
                ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                ->join('students', 'inbox.sender_id', '=', 'students.user_id')
                ->where('inbox.id', $id)
                ->select(
                    'inbox.id',
                    'inbox.date',
                    'inbox.subject',
                    'inbox.body',
                    'letter_types.name as letter_type',
                    'sender.name as sender_name',
                    'sender.role as sender_role',
                    'sender.username as sender_username',
                    'students.student_id as student_id',
                    'students.fullname as student_name',
                    'receiver.name as receiver_name',
                    'receiver.username as receiver_username',
                    'inbox.status',
                    'inbox.attachment',
                    'inbox.letter_number'
                )
                ->first();
            return $incomingLetter;
        } elseif ($check_role->role == 'staff') {
            if (auth('web')->user()->role == 'student') {
                $incomingLetter = Inbox::join('users as receiver', 'inbox.receiver_id', '=', 'receiver.id')
                    ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                    ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                    ->join('staff', 'inbox.sender_id', '=', 'staff.user_id')
                    ->where('inbox.id', $id)
                    ->select(
                        'inbox.id',
                        'inbox.date',
                        'inbox.subject',
                        'inbox.body',
                        'letter_types.name as letter_type',
                        'sender.name as sender_name',
                        'sender.role as sender_role',
                        'sender.username as sender_username',
                        'receiver.name as receiver_name',
                        'staff.staff_id as staff_id',
                        'staff.fullname as staff_name',
                        'receiver.username as receiver_username',
                        'inbox.status',
                        'inbox.attachment',
                        'inbox.letter_number'
                    )
                    ->first();
            } else {
                $incomingLetter = Inbox::join('users as receiver', 'inbox.receiver_id', '=', 'receiver.id')
                    ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                    ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                    ->join('staff', 'inbox.sender_id', '=', 'staff.user_id')
                    ->where('inbox.id', $id)
                    ->select(
                        'inbox.id',
                        'inbox.date',
                        'inbox.subject',
                        'inbox.body',
                        'letter_types.name as letter_type',
                        'sender.name as sender_name',
                        'sender.role as sender_role',
                        'staff.staff_id as staff_id',
                        'sender.username as sender_username',
                        'receiver.name as receiver_name',
                        'receiver.username as receiver_username',
                        'inbox.status',
                        'inbox.attachment',
                        'inbox.letter_number'
                    )
                    ->first();
            }
            return $incomingLetter;
        } elseif ($check_role->role == 'lecturer') {

            $incomingLetter = Inbox::join('users as receiver', 'inbox.receiver_id', '=', 'receiver.id')
                ->join('users as sender', 'inbox.sender_id', '=', 'sender.id')
                ->join('lecturers', 'sender.id', '=', 'lecturers.user_id')
                ->join('letter_types', 'inbox.letter_type_id', '=', 'letter_types.id')
                ->where('inbox.id', $id)
                ->select(
                    'inbox.id',
                    'inbox.date',
                    'inbox.subject',
                    'inbox.body',
                    'letter_types.name as letter_type',
                    'sender.name as sender_name',
                    'sender.role as sender_role',
                    'sender.username as sender_username',
                    'receiver.name as receiver_name',
                    'receiver.username as receiver_username',
                    'lecturers.fullname as lecturer_name',
                    'lecturers.lecturer_id as lecturer_id',
                    'inbox.status',
                    'inbox.attachment',
                    'inbox.letter_number'
                )
                ->first();
            return $incomingLetter;
        }
    }

    public function updateStatus($id)
    {

        try {
            DB::transaction(function () use ($id) {
                $inbox = Inbox::where('id', $id)->first();
                $inbox->update(['status' => 'read']);
                Sent::where('id', $inbox->sent_id)->update(['status' => 'read']);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function download($id) {}
}
