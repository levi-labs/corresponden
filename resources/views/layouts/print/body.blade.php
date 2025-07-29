<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Surat Keluar/Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        /* Container Kop Surat */
        .kop-surat-container {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 50%;
            border-bottom: 3px solid black;
            padding-bottom: 15px;
            margin: auto;

        }

        /* Logo */
        .kop-surat-container img {
            margin-top: -5%;
            width: 25%;
            float: right;
            /* Ukuran logo */
            /* margin-right: -10%; */
            /* Kurangi jarak antara logo dan teks */
        }


        /* Teks Kop Surat */
        .kop-surat-text {
            margin: auto;
            flex: 1;
            /* Membuat teks mengisi ruang yang tersedia */

            text-align: left;
            /* Untuk mengatur teks di tengah */
            margin-left: 10px;
            /* background: blanchedalmond; */
        }

        .kop-surat-text h1 {
            margin: 0;
            font-size: 20px;
        }

        .kop-surat-text h2 {
            margin: 2px 0;
            font-size: 12px;
        }

        .kop-surat-text .header-row {
            width: 100%;
            display: flex;
            justify-content: center;
            /* Untuk mengatur teks di tengah */
            /* Untuk mengatur teks di tengah */
            flex-wrap: wrap;
            gap: 10px;
            /* background: cornsilk; */
        }

        .mt-2 {
            margin-top: 1%;
        }

        .kop-surat-text .header-row .col-fakultas {
            flex: 1;
            flex-direction: column;
            justify-content: center;

        }

        .kop-surat-text .header-row .col-fakultas>p {
            text-align: left;
            margin: 0;
            font-size: 10px;

        }

        .kop-surat-text .header-row li {
            list-style: none;
            margin: 0 10px;
        }


        .kop-surat-text .header-row h2 {
            display: inline-block;
            margin: 0 5px;
            font-size: 12px;
        }

        .kop-surat-text p {
            margin: 5px 0;
            font-size: 12px;
            line-height: 1.6;
        }

        .content {
            width: 50%;
            font-size: 14px;
            line-height: 1.8;
            margin: auto;
        }

        .content p {
            margin: 10px 0;
        }

        .content .ms-4 {
            margin-left: 40px;
        }

        .signature {
            float: right;
            width: 30%;
            margin-top: 30px;
            text-align: left;
        }

        .signature p {
            margin: 5px 0;
        }

        .content .text-end {
            text-align: right;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
                font-size: 10px;
                /* Ukuran font lebih kecil saat dicetak */
            }

            /* Container Kop Surat */
            .kop-surat-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                text-align: left;
                border-bottom: 3px solid black;
                padding-bottom: 15px;
                margin-bottom: 20px;
                /* background: yellow; */
            }

            /* Logo */
            .kop-surat-container img {
                margin-top: -5%;
                width: 20%;
                height: 120px;
                ;
                /* Ukuran logo */
                margin-right: 10px;
                /* Kurangi jarak antara logo dan teks */
            }

            /* Teks Kop Surat */
            .kop-surat-text {
                flex: 1;
            }

            .kop-surat-text h1 {
                margin: 0;
                font-size: 20px;
            }

            .kop-surat-text h2 {
                margin: 2px 0;
                font-size: 12px;
            }

            .kop-surat-text p {
                margin: 5px 0;
                font-size: 12px;
                line-height: 1.6;
            }

            .content {
                width: 100%;
                font-size: 14px;
                line-height: 1.8;
            }

            .content p {
                margin: 10px 0;
            }

            .signature {
                margin-top: 40px;
                text-align: right;
            }

            .signature p {
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    @include('layouts.print.header')

    @yield('content')
</body>

</html>
