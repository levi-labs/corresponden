<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Services\FacultyService;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    protected $facultyService;
    public function __construct(FacultyService $facultyService)
    {
        $this->facultyService = $facultyService;
    }

    public function index()
    {

        $title =  'Daftar Fakultas';
        $data = $this->facultyService->getAllFaculties();
        return view('pages.faculty.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = 'Tambah';
        return view('pages.faculty.create', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            $this->facultyService->create($request->all());
            return redirect()->route('faculties.index')->with('success', 'Fakultas created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(Faculty $faculty)
    {
        $title = 'Edit Fakultas';
        $data = $this->facultyService->getById($faculty->id);
        return view('pages.faculty.edit', compact('title', 'data'));
    }

    public function update(Faculty $faculty, Request $request)
    {
        try {
            $this->facultyService->update($faculty, $request->all());
            return redirect()->route('faculties.index')->with('success', 'Fakultas updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Faculty $faculty)
    {
        try {
            $this->facultyService->destroy($faculty);
            return redirect()->back()->with('success', 'Fakultas deleted successfully');
        } catch (\Throwable $th) {
            if ($th->getCode() == 23000) {
                return redirect()->back()->with('info', 'Fakultas tidak dapat dihapus karena sudah memiliki data terkait');
            }
            if ($th->getCode() == 500) {
                return redirect()->back()->with('error', 'Fakultas tidak dapat dihapus karena sudah memiliki data terkait');
            }
            if ($th->getCode() == 404) {
                return redirect()->back()->with('error', 'Fakultas tidak ditemukan');
            }
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
