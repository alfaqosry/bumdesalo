<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Barang</th>
                <th>Harga</th>
                <th>Kuantitas</th>
                <th>Sisa Stok</th>
                <th>Kasir</th>
                <th>Toko</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td> @rupiah($item->harga) </td>
                <td>{{ $item->kuantitas }}</td>
                <td> @rupiah($item->harga * $item->kuantitas)
                </td>
                <td>{{ $item->sisa_stok }}</td>
                <td>{{ $item->name }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
