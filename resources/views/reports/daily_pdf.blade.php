<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Absensi' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px
        }

        .kelas {
            margin-bottom: 18px
        }

        .kelas h4 {
            margin: 0 0 8px 0
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left
        }

        th {
            background: #f3f3f3
        }
    </style>
</head>

<body>
    <h2 style="text-align:center">{{ $title ?? 'Laporan Absensi' }}</h2>
    <p style="text-align:center">Tanggal: {{ $date }}</p>

    @foreach ($kelas as $k)
        <div class="kelas">
            <h4>{{ $k->nama_kelas }}</h4>
            <table>
                <thead>
                    <tr>
                        <th style="width:6%">No</th>
                        <th>Nama Siswa</th>
                        <th style="width:20%">No. HP Ortu</th>
                        <th style="width:20%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($k->siswa as $idx => $s)
                        @php $a = $s->absensi->first(); @endphp
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ $s->no_hp_orang_tua ?? '-' }}</td>
                            <td>{{ $a->status ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

</body>

</html>
