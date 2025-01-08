<?php

namespace App\Services;

use App\Events\OutgoingLetterCreated;
use App\Models\OutgoingLetter;
use Illuminate\Support\Facades\DB;

class OutgoingLetterService
{
    public function getAllOutgoingLetters()
    {
        $data = OutgoingLetter::join('letter_types', 'outgoing_letters.letter_type_id', '=', 'letter_types.id')
            ->join('users as sender', 'outgoing_letters.sender_id', '=', 'sender.id')
            ->join('users as receiver', 'outgoing_letters.receiver_id', '=', 'receiver.id')
            ->select(
                'outgoing_letters.id',
                'outgoing_letters.date',
                'outgoing_letters.subject',
                'outgoing_letters.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'outgoing_letters.status',
                'outgoing_letters.attachment',
                'outgoing_letters.letter_number'
            )
            ->paginate(25);
        return $data;
    }

    public function getAllOutgoingLettersByUser()
    {
        $data = OutgoingLetter::join('users as sender', 'outgoing_letters.sender_id', '=', 'sender.id')
            ->join('letter_types', 'outgoing_letters.letter_type_id', '=', 'letter_types.id')
            ->join('users as receiver', 'outgoing_letters.receiver_id', '=', 'receiver.id')
            ->where('sender.id', '=', auth('web')->user()->id)
            ->select(
                'outgoing_letters.id',
                'outgoing_letters.date',
                'outgoing_letters.subject',
                'outgoing_letters.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'receiver.username as receiver_username',
                'outgoing_letters.status',
                'outgoing_letters.attachment',
                'outgoing_letters.letter_number'
            )
            ->paginate(25);
        return $data;
    }

    public function getAllOutgoingLetterByRole() {}

    public function searchOutgoingLetter($search) {}

    public function getOutgoingLetterById($id)
    {
        $outgoingLetter = OutgoingLetter::join('users as receiver', 'outgoing_letters.receiver_id', '=', 'receiver.id')
            ->join('users as sender', 'outgoing_letters.sender_id', '=', 'sender.id')
            ->join('letter_types', 'outgoing_letters.letter_type_id', '=', 'letter_types.id')
            ->where('outgoing_letters.id', $id)
            ->select(
                'outgoing_letters.id',
                'outgoing_letters.date',
                'outgoing_letters.subject',
                'outgoing_letters.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'receiver.username as receiver_username',
                'outgoing_letters.status',
                'outgoing_letters.attachment',
                'outgoing_letters.letter_number'
            )
            ->first();
        return $outgoingLetter;
    }

    public function create($data)
    {
        // dd($data);
        try {
            DB::transaction(function () use ($data) {
                $outgoingLetter = OutgoingLetter::create($data);
                event(new OutgoingLetterCreated($outgoingLetter));
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(OutgoingLetter $outgoingLetter, $data) {}

    public function destroy(OutgoingLetter $outgoingLetter) {}
}
