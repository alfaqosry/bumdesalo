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

        <div class="row mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Pegawai</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{ route('pegawai.create') }}">
                                <i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pegawai
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Tanggal Lahir</th>
                                <th>Tanggal Rekrut</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone_number ?? '-' }}</td>
                                    <td>{{ $item->tanggal_lahir ?? '-' }}</td>
                                    <td>{{ $item->tanggal_rekrut ?? '-' }}</td>
                                    <td>{{ $item->alamat ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-sm btn-success">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus <strong id="pegawaiName"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var pegawaiId = button.data('id');
            var pegawaiName = button.data('name');

            var modal = $(this);
            modal.find('#pegawaiName').text(pegawaiName);

            var actionUrl = '/pegawai/' + pegawaiId;
            modal.find('#deleteForm').attr('action', actionUrl);
        });
    </script>
</x-layout>
