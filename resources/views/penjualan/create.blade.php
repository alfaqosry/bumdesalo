<x-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('penjualan.store') }}" method="POST" novalidate>

                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="barang" class="form-label ">Nama Barang</label>
                            <select class="form-select select-field @error('barang_id') is-invalid @enderror" name="barang_id" id="barang">
                                <option selected>Choose...</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{$barang->id}}">{{$barang->nama_barang}}</option>
                                @endforeach
                            </select>
                            @error('barang_id')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror


                        <div class="mb-3">
                            <label for="kuantitas" class="form-label">Kuantitas</label>
                            <input type="number" value="1" class="form-control @error('kuantitas') is-invalid @enderror" id="kuantitas" name="kuantitas">
                            @error('kuantitas')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
</x-layout>
