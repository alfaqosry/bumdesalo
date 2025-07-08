<x-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card">
                <div class="card-header">Tambah Pegawai</div>
                <div class="card-body">

                    <form action="{{ route('pegawai.store') }}" method="POST" novalidate>

                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label ">Nama Pegawai</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <label for="role">Jabatan</label>
                            @role('pemilik')
                                <select class="form-control" id="role" name="role">
                                    <!-- <option value="pemilik">Pemilik</option> -->
                                    <!-- <option value="manajer">Manajer</option> -->
                                    <option value="kasir">Kasir</option>
                                    <option value="pegawai">Pegawai</option>

                                </select>
                            @endrole
                            @role('manajer')
                                <select class="form-control" id="role" name="role">

                                    <option value="kasir">Kasir</option>
                                    <option value="pegawai">Pegawai</option>

                                </select>
                            @endrole

                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
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
