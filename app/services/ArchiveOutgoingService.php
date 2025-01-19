<?php

namespace App\services;

use App\Models\ArchiveOutgoingLetter;

class ArchiveOutgoingService
{

    public function getAllOutGoingLetter()
    {

        return ArchiveOutgoingLetter::join('letter_types', 'archive_outgoing_letters.letter_type_id', '=', 'letter_types.id')
            ->select(
                'archive_outgoing_letters.*',
                'letter_types.name as letter_type',
            )
            ->paginate(25);
    }

    public function getOutGoingLetterById($id)
    {
        return ArchiveOutgoingLetter::join('letter_types', 'archive_outgoing_letters.letter_type_id', '=', 'letter_types.id')
            ->select(
                'archive_outgoing_letters.*',
                'letter_types.name as letter_type',
            )
            ->where('archive_outgoing_letters.id', $id)
            ->first();
    }

    public function create($data)
    {
        try {
            return ArchiveOutgoingLetter::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $data)
    {
        try {
            $archiveOutgoingLetter = ArchiveOutgoingLetter::where('id', $id)->first();
            $archiveOutgoingLetter->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete($id)
    {
        $archiveOutgoingLetter = ArchiveOutgoingLetter::find($id);
        $archiveOutgoingLetter->delete();
    }
}
