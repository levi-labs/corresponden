<?php

namespace App\services;

use App\Models\ArchiveIncomingLetter;
use App\Models\Inbox;
use App\Models\IncomingLetter;

class ArchiveIncomingService
{

    public function getAllArchiveIncomings()
    {

        return ArchiveIncomingLetter::join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
            ->select(
                'archive_incoming_letters.*',
                'letter_types.name as letter_type',
            )
            ->paginate(25);
    }

    public function search($query)
    {
        try {
            return ArchiveIncomingLetter::join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->select(
                    'archive_incoming_letters.*',
                    'letter_types.name as letter_type',
                )
                ->where(
                    'archive_incoming_letters.letter_number',
                    'like',
                    '%' . $query . '%'
                )
                ->paginate(25);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getArchiveIncomingById($id)
    {
        // dd(ArchiveIncomingLetter::find($id));
        return ArchiveIncomingLetter::join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
            ->select(
                'archive_incoming_letters.*',
                'letter_types.name as letter_type',
            )
            ->where('archive_incoming_letters.id', $id)
            ->first();
    }

    public function create($data)
    {
        try {
            ArchiveIncomingLetter::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $data)
    {
        $archiveIncomingLetter = ArchiveIncomingLetter::find($id);
        $archiveIncomingLetter->update($data);
    }

    public function delete($id)
    {
        $archiveIncomingLetter = ArchiveIncomingLetter::find($id);
        $archiveIncomingLetter->delete();
    }

    public function addToArchieve($incomingLetterId)
    {
        try {
            $incomingLetter = Inbox::where('id', $incomingLetterId)->first();
            ArchiveIncomingLetter::create([
                'incoming_letter_id' => $incomingLetter->id,
                'receiver_id' => $incomingLetter->receiver_id,
                'sender_name' => $incomingLetter->receiver_name,
                'receiver_name' => $incomingLetter->receiver_name,
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
