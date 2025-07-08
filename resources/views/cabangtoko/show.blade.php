<x-layout>
    <div class="container-fluid py-4">
        <h4>Laporan {{$toko->nama_cabang}}</h4>
        <div class="row mb-4">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pendapatan Hari Ini</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @rupiah($penjualanhariini->total)


                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pendapatan</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @rupiah($totalpendapatan->total)


                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pengeluaran Hari Ini</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @rupiah($totalpengeluaranhariini)


                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pengeluaran Bulan Ini</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @rupiah($pengeluaranbulanini)


                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row mt-4">

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="penjualan-tab" data-bs-toggle="tab"
                                data-bs-target="#penjualan" type="button" role="tab" aria-controls="penjualan"
                                aria-selected="true">Penjualan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pengeluaran-tab" data-bs-toggle="tab"
                                data-bs-target="#pengeluaran" type="button" role="tab" aria-controls="pengeluaran"
                                aria-selected="false">Pengeluaran</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="barang-tab" data-bs-toggle="tab" data-bs-target="#barang"
                                type="button" role="tab" aria-controls="barang" aria-selected="false">Stok Barang</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rekap-tab" data-bs-toggle="tab" data-bs-target="#rekap"
                                type="button" role="tab" aria-controls="rekap" aria-selected="false">Rekap</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="penjualan" role="tabpanel"
                            aria-labelledby="penjualan-tab">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Barang</th>
                                        <th>Harga Satuan</th>
                                        <th>Kuantitas</th>
                                        <th>Total</th>
                                        <th>Sisa Stok</th>
                                        <th>Kasir</th>
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
                        </div>
                        <div class="tab-pane fade" id="pengeluaran" role="tabpanel" aria-labelledby="pengeluaran-tab">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pengeluaran</th>
                                        <th>Harga</th>
                                        <th>Kuantitas</th>
                                        <th>Total</th>

                                        <th>Pegawai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengeluaran as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->nama_pengeluaran }}</td>
                                            <td> @rupiah($item->harga) </td>
                                            <td>{{ $item->kuantitas_pengeluaran }}</td>
                                            <td> @rupiah($item->harga * $item->kuantitas_pengeluaran)
                                            </td>
                                            <td>{{ $item->pegawai->name }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                        </div>
                        <div class="tab-pane fade" id="barang" role="tabpanel" aria-labelledby="barang-tab">
                            <table class="table table-striped">
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Harga</th>
                                    <th>Kode</th>
                                    <th>Tgl Kadaluarsa</th>
                                    <th>Stok</th>
                           
        
                                    @foreach ($barang as $item)
                                </tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->harga_barang }}</td>
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->kadarluarsa_barang }}</td>
                                <td>{{ $item->stok_barang }}</td>
                              
                                @endforeach
                            </table>
                        </div>
                        <div class="tab-pane fade" id="rekap" role="tabpanel" aria-labelledby="rekap-tab">...</div>
                    </div>



                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-penjualan" role="tabpanel"
                            aria-labelledby="pills-penjualan-tab">


                        </div>
                        <div class="tab-pane fade" id="pills-pengeluaran" role="tabpanel"
                            aria-labelledby="pills-pengeluaran-tab">...</div>
                        <div class="tab-pane fade" id="pills-rekap" role="tabpanel" aria-labelledby="pills-rekap-tab">
                            ...</div>
                    </div>


                </div>
            </div>






        </div>
    </div>
    <script>
        new DataTable('#datatable');
    </script>

</x-layout>
