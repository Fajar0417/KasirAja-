<!DOCTYPE html>
<html>
<head>
    <title>Pendapatan Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Pendapatan</h1>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_tanggal as $index => $tanggal)
                <tr>
                    <td>{{ $tanggal }}</td>
                    <td>{{ number_format($data_pendapatan[$index], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
