<?php


namespace App\Services;


use App\Models\Department;


class DepartmentService
{

    public function getAllDepartments()
    {
        return Department::all();
    }

    public function getById($id)
    {
        return Department::find($id);
    }

    public function create($data)
    {
        try {
            return Department::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Department $department, $data)
    {
        try {
            $department->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Department $department)
    {
        $department->delete();
    }
}
