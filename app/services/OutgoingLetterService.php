<?php

namespace App\Services;

use App\Models\OutgoingLetter;

class OutgoingLetterService
{

    public function getAllOutgoingLettersByUser() {}

    public function getAllOutgoingLetterByRole() {}

    public function searchOutgoingLetter($search) {}

    public function getOutgoingLetterById($id) {}

    public function create($data) {}

    public function update(OutgoingLetter $outgoingLetter, $data) {}

    public function destroy(OutgoingLetter $outgoingLetter) {}
}
