<x-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card">
                <div class="card-header">Tambah Pengeluaran</div>
                <div class="card-body">

                    <form action="{{ route('pengeluaran.store') }}" method="POST" novalidate>

                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="nama_pengeluaran" class="form-label ">Pengeluaran</label>
                            <input type="text" class="form-control @error('nama_pengeluaran') is-invalid @enderror"
                                id="nama_pengeluaran" name="nama_pengeluaran">
                            @error('barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    id="harga" name="harga">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kuantitas_pengeluaran" class="form-label">Kuantitas</label>
                                <input type="number" value="1"
                                    class="form-control @error('kuantitas_pengeluaran') is-invalid @enderror"
                                    id="kuantitas_pengeluaran" name="kuantitas_pengeluaran">
                                @error('kuantitas_pengeluaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
</x-layout>
