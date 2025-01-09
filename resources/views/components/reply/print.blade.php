@extends('layouts.print.body')

@section('content')
    <!-- Isi Surat -->
    <div class="content">
        <p class="text-end">
            <strong>{{ \Carbon\Carbon::parse($reply->created_at)->locale('id')->translatedFormat('d F Y') }}</strong>
        </p>

        <p>No: {{ $reply->letter_number }}<br>
            Lampiran: -<br>
            Perihal: <strong>{{ $reply->letter_type }}</strong></p>
        {{-- 
        <p>Kepada Yth;<br>
            XXX<br>
            XXX<br>
            XXX</p>
        <p> --}}
        {!! $reply->greeting !!}
        </p>

        <p class="ms-4">
            @php
                // dd($reply->student_name);
            @endphp

            <td>Nama</td>
            <td>:</td>
            <td>{{ $reply->student_name }}</td>
        </p>
        <p class="ms-4">
            <td>NIM</td>
            <td>:</td>
            <td>{{ $reply->student_id }}</td>
        </p>

        <p>
            Mengenai waktu pelaksanaan Riset tersebut kami serahkan pada kebijaksanaan Bapak/Ibu.
        </p>

        <p>
            Atas perhatian dan bantuan Bapak/Ibu kami ucapkan terima kasih.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p>Mengetahui,</p>
        <p>Koordinator Kampus {{ $reply->campus ?? '-' }}</p>
        <br><br><br>
        <p><strong>{{ $reply->receiver_name }}</strong></p>
    </div>

    <script>
        window.print();
    </script>
@endsection
