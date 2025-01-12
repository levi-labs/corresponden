<?php

namespace App\services;

use App\Models\ArchiveIncomingLetter;

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
}
