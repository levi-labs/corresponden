<?php

namespace App\services;

use App\Models\LetterType;

class LetterTypeService
{

    public function getAllLetterTypes()
    {
        return LetterType::all();
    }

    public function create($data)
    {
        LetterType::create($data);
    }

    public function update(LetterType $letterType, $data)
    {
        $letterType->update($data);
    }

    public function destroy(LetterType $letterType)
    {
        $letterType->delete();
    }
}
