<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permohonan Riset</title>
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
            width: 10%;
            float: right;
            /* Ukuran logo */
            margin-right: -10%;
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
            margin: 5px 0;
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

            /* Container Kop Surat */
            .kop-surat-container {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                text-align: center;
                border-bottom: 3px solid black;
                padding-bottom: 15px;
                margin-bottom: 30px;
            }

            /* Logo */
            .kop-surat-container img {
                margin-top: -20%;
                width: 15%;
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
                margin: 5px 0;
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
