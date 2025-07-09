


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Penjualan</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      margin: 40px;
    }

    .kop {
      text-align: center;
      border-bottom: 3px solid black;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .kop h2, .kop h4 {
      margin: 0;
    }

    .judul {
      text-align: center;
      margin-top: 30px;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    table th, table td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }

    .ttd {
      width: 100%;
      margin-top: 50px;
    }

    .ttd .kanan {
      float: right;
      text-align: center;
    }

    .ttd .kiri {
      float: left;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="kop">
    <h2>BUMNDES SALO</h2>
    <h4>Jl. Prof. M. Yamin SH, Kecamatan Salo</h4>
    <h4>Telp: -</h4>
  </div>

  <div class="judul">
    <h3><u>LAPORAN PENJUALAN</u></h3>
    <p>Periode: {{ $periode }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($penjualan as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->tanggal }}</td>
        <td>{{ $item->nama_barang }}</td>
        <td>{{ $item->kuantitas }}</td>
        <td>@rupiah($item->harga) </td>
        <td>@rupiah($item->harga * $item->kuantitas)</td>
      </tr>
      @endforeach
      <!-- Tambah baris lain sesuai kebutuhan -->
    </tbody>
    <tfoot>
      <tr>
        <th colspan="5">Total Penjualan</th>
        <th>@rupiah($totalPenjualan)</th>
      </tr>
    </tfoot>
  </table>

  <div class="ttd">
    {{-- <div class="kiri">
      <p>Mengetahui,</p>
      <p>Kepala Desa</p>
      <br><br><br>
      <p><u><b>Ahmad Sutrisno</b></u></p>
    </div> --}}

    <div class="kanan">
      <p>Salo, {{ $tanggalSekarang }}</p>
      <p>Kepala Desa</p>
      <br><br><br>
      <p><u><b>{{$kepaladesa->name}}</b></u></p>
    </div>
  </div>

</body>
</html>