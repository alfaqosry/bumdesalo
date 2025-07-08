<x-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('barang.update', $barang->id) }}" method="POST" novalidate>

                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="namabarang" class="form-label ">Nama Barang</label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                id="namabarang" name="nama_barang" value="{{$barang->nama_barang}}">
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control @error('harga_barang') is-invalid @enderror"
                                id="harga" name="harga_barang" value="{{$barang->harga_barang}}">
                            @error('harga_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kodebarang" class="form-label">Kode</label>
                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror"
                                id="kodebarang" name="kode_barang" value="{{$barang->kode_barang}}">
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stok_barang') is-invalid @enderror"
                                id="stok" name="stok_barang" value="{{$barang->stok_barang}}">
                            @error('stok_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kadarluarsa" class="form-label">Kadarluasa</label>
                            <input type="date" class="form-control @error('kadarluarsa_barang') is-invalid @enderror"
                                id="kadarluarsa" name="kadarluarsa_barang" value="{{$barang->kadarluarsa_barang}}">
                            @error('kadarluarsa_barang')
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
