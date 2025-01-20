<?php

namespace App\Http\Controllers;

use App\Models\ArchiveIncomingLetter;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function archiveIncomingForm()
    {
        $title = 'Report Surat Masuk';
        return view('pages.report.archive-incoming', compact('title'));
    }

    public function archiveOutgoingForm()
    {
        $title = 'Report Surat Keluar';
        return view('pages.report.archive-outgoing', compact('title'));
    }

    public function incomingPrint(Request $request)
    {
        $title = 'Report Surat Masuk';
        $from = $request->dari;
        $to = $request->sampai;

        if ($from !== null && $from !== '') {
            $data = ArchiveIncomingLetter::where('date', '>=', $from)
                ->join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->get();
            return view('pages.report.print-incoming', compact('title', 'data', 'from', 'to'));
        } elseif ($to !== null && $to !== '') {
            $data = ArchiveIncomingLetter::where('date', '<=', $to)
                ->join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->get();
            return view('pages.report.print-incoming', compact('title', 'data', 'from', 'to'));
        } elseif ($from !== null && $from !== '' && $to !== null && $to !== '') {
            $data = ArchiveIncomingLetter::whereBetween('date', [$from, $to])
                ->join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->get();
            return view('pages.report.print-incoming', compact('title', 'data', 'from', 'to'));
        }

        // $report = new ArsipNotaris();
        // $data = $report->getReport($from, $to);


    }

    public function outgoingPrint(Request $request)
    {
        $title = 'Report Surat Keluar';
        $from = $request->dari;
        $to = $request->sampai;

        if ($from !== null && $from !== '') {
            $data = ArchiveIncomingLetter::where('date', '>=', $from)
                ->join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->get();
            return view('pages.report.print-outgoing', compact('title', 'data', 'from', 'to'));
        } elseif ($to !== null && $to !== '') {
            $data = ArchiveIncomingLetter::where('date', '<=', $to)
                ->join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->get();
            return view('pages.report.print-outgoing', compact('title', 'data', 'from', 'to'));
        } elseif ($from !== null && $from !== '' && $to !== null && $to !== '') {
            $data = ArchiveIncomingLetter::whereBetween('date', [$from, $to])
                ->join('letter_types', 'archive_incoming_letters.letter_type_id', '=', 'letter_types.id')
                ->get();
            return view('pages.report.print-outgoing', compact('title', 'data', 'from', 'to'));
        }



        // return view('pages.report-notaris.cetak', compact('title', 'data', 'from', 'to'));
    }
}
