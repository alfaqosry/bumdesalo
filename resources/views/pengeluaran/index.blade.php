<x-layout>
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pengeluaran Hari Ini</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @rupiah($totalhariini->total)
                                     

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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pengeluaran</p>
                                    <h5 class="font-weight-bolder mb-0">
                                       @rupiah(  $totalpengeluaran->total)
                                        

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
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Pengeluaran</h6>
                        </div>

                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{ route('pengeluaran.create') }}"><i
                                    class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pengeluaran</a>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    <table class="table table-striped">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pengeluaran</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                            <th>Pegawai</th>
                            {{-- <th>Action</th> --}}

                            @foreach ($pengeluaran as $item)
                        </tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->nama_pengeluaran }}</td>
                        <td>Rp.{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->kuantitas_pengeluaran }}</td>
                        <td>Rp.{{ number_format($item->harga * $item->kuantitas_pengeluaran, 0, ',', '.') }} </td>
                        <td>{{ $item->pegawai->name }}</td>


                         {{-- <td class="align-middle">
                            <a href="#" class="btn btn-sm btn-success">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                           
                          </td> --}}
                        @endforeach
                    </table>
                </div>
            </div>






        </div>
    </div>
</x-layout>
