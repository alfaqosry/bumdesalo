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
                            <label for="phone_number" class="form-label ">No Telepon</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                id="phone_number" name="phone_number">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                id="tanggal_lahir" name="tanggal_lahir">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_rekrut" class="form-label ">Tanggal Rekrut</label>
                            <input type="date" class="form-control @error('tanggal_rekrut') is-invalid @enderror"
                                id="tanggal_rekrut" name="tanggal_rekrut">
                            @error('tanggal_rekrut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <label for="alamat" class="form-label ">Alamat</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat" name="alamat">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
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
