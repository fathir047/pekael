<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking Ruangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Laporan Data Booking Ruangan</h2>

    <table>
        <thead> 
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $i => $booking)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $booking->user->name ?? '-' }}</td>
                    <td>{{ $booking->ruangan->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $booking->jam_mulai }}</td>
                    <td>{{ $booking->jam_selesai }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>