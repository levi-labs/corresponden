<?php

namespace App\Services;

use App\Models\Faculty;


class FacultyService
{

    public function getAllFaculties()
    {
        return Faculty::all();
    }
    public function getById($id)
    {
        return Faculty::find($id);
    }

    public function create($data)
    {
        try {
            return Faculty::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Faculty $faculty, $data)
    {
        try {
            $faculty->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
    }
}
