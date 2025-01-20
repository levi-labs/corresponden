@extends('layouts.print.body')
<style>
    /* Umum - tampilkan tabel dengan border dan padding yang lebih baik */
    table {
        margin-top: 10%;
        width: 100%;
        border-collapse: collapse;
        /* Menghilangkan spasi antara border */
        font-family: Arial, sans-serif;
        /* Font yang mudah dibaca */
        font-size: 14px;
    }

    th,
    td {
        padding: 10px;
        /* Jarak antara teks dan border */
        border: 1px solid #ddd;
        /* Border ringan */
        text-align: left;
        /* Teks rata kiri */
    }

    th {
        background-color: #2a3ea5;
        /* Warna latar belakang untuk header */
        color: white;
        /* Warna teks header */
        font-weight: bold;
        /* Membuat teks header lebih tebal */
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
        /* Warna latar belakang untuk baris genap */
    }

    tr:hover {
        background-color: #ddd;
        /* Efek hover pada baris */
    }

    .my-button {
        margin-top: 5%;
    }

    /* Style untuk cetak */
    @media print {
        body {
            font-size: 12px;
            /* Ukuran font lebih kecil saat dicetak */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            /* Mengurangi padding untuk print */
            border: 1px solid black;
            /* Menambahkan border yang lebih tegas untuk print */
        }

        th {
            background-color: #2844d0;
            color: white;
            font-weight: bold;
        }

        /* Menghilangkan elemen-elemen yang tidak perlu saat dicetak */
        .no-print {
            display: none;
        }

        /* Mencegah halaman terpotong ketika tabel terlalu panjang */
        table,
        th,
        td {
            page-break-inside: avoid;
        }
    }
</style>


@section('content')
    <div class="content">
        <button class="my-button no-print" onclick="window.print()">Print</button>
        <table cellspacing="2" cellpadding="2" border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis Surat</th>
                    <th>Nomor Surat</th>
                    <th>Pengirim</th>
                    <th>Penerima</th>
                    <th>Perihal</th>
                    <th>Tanggal Surat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->letter_number }}</td>
                        <td>{{ $item->sender }}</td>
                        <td>{{ $item->receiver }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.print();
        })
    </script>
@endsection
