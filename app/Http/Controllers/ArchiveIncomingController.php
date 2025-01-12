<?php

namespace App\Http\Controllers;

use App\Models\ArchiveIncomingLetter;
use Illuminate\Http\Request;

class ArchiveIncomingController extends Controller
{
    public function index()
    {
        $title = 'Archive Incoming Letters';

        return view('pages.message.incoming.archive', compact('title'));
    }

    public function show(ArchiveIncomingLetter $archiveIncomingLetter)
    {
        $title = 'Letter Details';
        return view('pages.message.incoming.detail', compact('title'));
    }
    public function create()
    {
        $title = 'Create Incoming Letter';
        return view('pages.message.incoming.create');
    }

    public function store()
    {
        $title = 'Create Incoming Letter';
        return redirect()->back()->with('success', 'Archive Incoming Letter Created successfully');
    }

    public function edit()
    {
        $title = 'Edit Incoming Letter';
        return view('pages.message.incoming.edit');
    }
    public function update()
    {
        $title = 'Edit Incoming Letter';
        return redirect()->back()->with('success', 'Archive Incoming Letter Updated successfully');
    }

    public function destroy()
    {

        return redirect()->back()->with('success', 'Archive Incoming Letter Deleted successfully');
    }
}
