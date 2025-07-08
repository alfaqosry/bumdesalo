<x-layout>
    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- <div class="row">
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


        </div> --}}
        <div class="row mt-4">

            <div class="card">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Pegawai</h6>
                        </div>

                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{ route('pegawai.create') }}"><i
                                    class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pegawai</a>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    <table class="table table-striped">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            @role('pemilik')
                                <th>Penempatan</th>
                            @endrole
                            <th>Tanggal Mendaftar</th>
                            <th>Role</th>
                            <th>Action</th>


                            @role('pemilik')
                                @foreach ($pegawai as $item)
                            </tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>



                            <td>
                                @foreach ($item->cabangtokos as $penempatan)
                                    {{ $penempatan->nama_cabang }}
                                @endforeach




                            </td>

                            <td>{{ $item->created_at }}</td>
                            <td>{{ implode(', ', $item->getRoleNames()->toArray()) }}</td>


                            <td class="align-middle">
                                <a href="{{ route('pegawai.edit', $item->id) }}"
                                    class="btn btn-sm btn-success">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}">
                                    Hapus
                                </button>

                            </td>
                            @endforeach

                        @endrole

                        @role('manajer')
                            @foreach ($pegawai as $item)
                                </tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->user->email }}</td>

                                <td>{{ $item->user->created_at }}</td>
                                <td>{{ implode(', ', $item->user->getRoleNames()->toArray()) }}</td>


                                <td class="align-middle">
                                    <a href="{{ route('pegawai.edit', $item->user->id) }}"
                                        class="btn btn-sm btn-success">Edit</a>

                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-id="{{ $item->user->id }}"
                                        data-name="{{ $item->user->name }}">
                                        Hapus
                                    </button>

                                </td>
                            @endforeach
                        @endrole
                    </table>
                </div>
            </div>






        </div>
    </div>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    Apakah Anda yakin ingin menghapus <strong id="pegawaiName"></strong>?

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <!-- Form untuk Menghapus Data -->
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var pegawaiId = button.data('id');
            var pegawaiName = button.data('name');
            console.log(pegawaiName);


            var modal = $(this);
            modal.find('#pegawaiName').text(pegawaiName);


            var actionUrl = '/pegawai/delete/' + pegawaiId;
            modal.find('#deleteForm').attr('action', actionUrl);
        });
    </script>

</x-layout>
