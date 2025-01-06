<?php

namespace App\services;

use App\Models\LetterType;

class LetterTypeService
{

    public function getAllLetterTypes()
    {
        return LetterType::all();
    }
    public function getLetterTypeAsRole()
    {
        if (auth('web')->user()->role == 'student') {
            return LetterType::where('type', 'student')->get();
        } elseif (auth('web')->user()->role == 'lecture') {
            return LetterType::where('type', 'lecture')->get();
        } else {
            return LetterType::all();
        }
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
