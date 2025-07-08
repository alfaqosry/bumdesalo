<x-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('cabang.store') }}" method="POST">

                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="namacabang" class="form-label">Nama Cabang</label>
                            <input type="text" class="form-control" id="namacabang" name="nama_cabang">

                        </div>
                        <div class="mb-3">
                            <label for="alamatcabang" class="form-label">Alamat Cabang</label>
                            <input type="text" class="form-control" id="alamatcabang" name="alamat_cabang">
                        </div>


                        {{-- <div class="mb-3">
                            <label for="manajer" class="form-label">Manajer</label>
                            <select class="form-select" id="manajer" name="manajer">
                                <option selected>Choose...</option>
                                @foreach ($users as $user ) 
                              
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
</x-layout>
