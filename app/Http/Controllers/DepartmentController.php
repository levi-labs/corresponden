<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Services\DepartmentService;
use App\Services\FacultyService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentService;
    protected $facultyService;

    public function __construct(DepartmentService $departmentService, FacultyService $facultyService)
    {
        $this->departmentService = $departmentService;
        $this->facultyService = $facultyService;
    }

    public function index()
    {
        $departments = $this->departmentService->getAllDepartments();
        return view('pages.department.index', compact('departments'));
    }

    public function create()
    {
        $title = 'Create Department';
        $faculties = $this->facultyService->getAllFaculties();
        return view('pages.department.create', compact('title', 'faculties'));
    }

    public function store(Request $request)
    {
        try {
            $this->departmentService->create($request->all());
            return redirect()->route('departments.index')->with('success', 'Department created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(Department $department)
    {
        $title = 'Edit Department';
        $faculties = $this->facultyService->getAllFaculties();
        return view('pages.department.edit', compact('title', 'department', 'faculties'));
    }

    public function update(Department $department, Request $request)
    {
        try {
            $this->departmentService->update($department, $request->all());
            return redirect()->route('departments.index')->with('success', 'Department updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Department $department)
    {
        try {
            $this->departmentService->destroy($department);
            return redirect()->back()->with('success', 'Department deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
