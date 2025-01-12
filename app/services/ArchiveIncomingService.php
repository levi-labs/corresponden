<?php

namespace App\services;

use App\Models\ArchiveIncomingLetter;
use App\Models\IncomingLetter;

class ArchiveIncomingService
{

    public function getAllArchiveIncomings()
    {

        return ArchiveIncomingLetter::all();
    }

    public function getArchiveIncomingById($id)
    {
        return ArchiveIncomingLetter::find($id);
    }

    public function create($data)
    {

        ArchiveIncomingLetter::create($data);
    }

    public function update(ArchiveIncomingLetter $archiveIncomingLetter, $data)
    {

        $archiveIncomingLetter->update($data);
    }

    public function delete(ArchiveIncomingLetter $archiveIncomingLetter)
    {
        $archiveIncomingLetter->delete();
    }

    public function addToArchieve($incomingLetterId)
    {
        try {
            $incomingLetter = IncomingLetter::where('id', $incomingLetterId)->first();
            ArchiveIncomingLetter::create([
                'incoming_letter_id' => $incomingLetter->id,
                'receiver_id' => $incomingLetter->receiver_id,
                'sender_id' => $incomingLetter->sender_id,
                'sender_name' => $incomingLetter->sender_name,
                'receiver_name' => $incomingLetter->receiver_name,
                'subject' => $incomingLetter->subject,
                'body' => $incomingLetter->body,
                'date' => $incomingLetter->date,
                'letter_number' => $incomingLetter->letter_number,
                'attachment' => $incomingLetter->attachment
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
