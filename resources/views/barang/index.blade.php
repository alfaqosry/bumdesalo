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
        <div class="row">


            <div class="card">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Barang</h6>
                        </div>
                        @role('pegawai')
                            <div class="col-6 text-end">
                                <a class="btn bg-gradient-dark mb-0" href="{{ route('barang.create') }}"><i
                                        class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Barang</a>
                            </div>
                        @endrole
                    </div>

                </div>
                <div class="card-body">

                    <table class="table table-striped" id="datatable">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Kode</th>
                                <th>Tgl Kadaluarsa</th>
                                <th>Stok</th>
                                @role('pegawai')
                                    <th>Action</th>
                                @endrole

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->harga_barang }}</td>
                                    <td>{{ $item->kode_barang }}</td>
                                    <td>{{ $item->kadarluarsa_barang }}</td>
                                    <td>{{ $item->stok_barang }}</td>
                                    @role('pegawai')
                                        <td class="align-middle">
                                            <a href="{{ route('barang.edit', $item->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $item->id }}"
                                                data-name="{{ $item->nama_barang }}">
                                                Hapus
                                            </button>

                                        </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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

                    Apakah Anda yakin ingin menghapus <strong id="barangName"></strong>?

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
            var barangId = button.data('id');
            var barangName = button.data('name');
            console.log(barangName);


            var modal = $(this);
            modal.find('#barangName').text(barangName);


            var actionUrl = '/barang/delete/' + barangId;
            modal.find('#deleteForm').attr('action', actionUrl);
        });
    </script>
    <script>
        new DataTable('#datatable');
    </script>
</x-layout>
