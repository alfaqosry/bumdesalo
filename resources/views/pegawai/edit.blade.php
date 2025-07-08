<x-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card">
                <div class="card-header">Edit Pegawai {{ $user->name }}</div>
                <div class="card-body">

                    <form action="{{ route('pegawai.update', $user->id) }}" method="POST" novalidate>

                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label ">Nama Pegawai</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ $user->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ $user->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @role('pemilik')
                            <div class="mb-3">
                                <label for="penempatan">Penempatan</label>

                                <select class="form-control" id="penempatan" name="penempatan">
                                    @if (!empty($pegawaitoko->cabangtoko))
                                        <option selected value="{{ $pegawaitoko->cabangtoko->id }}">
                                            {{ $pegawaitoko->cabangtoko->nama_cabang }}</option>

                                            @else

                                            <option selected> Pilih</option>
                                    @endif
                                    @foreach ($toko as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_cabang }}</option>
                                    @endforeach

                                </select>

                            </div>
                        @endrole
                        <div class="mb-3">
                            <label for="role">Jabatan</label>
                            @role('pemilik')
                                <select class="form-control" id="role" name="role">
                                    <option selected value="{{ implode(', ', $user->getRoleNames()->toArray()) }}">
                                        {{ implode(', ', $user->getRoleNames()->toArray()) }}</option>
                                    <option value="pemilik">Pemilik</option>
                                    <option value="manajer">Manajer</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="pegawai">Pegawai</option>

                                </select>
                            @endrole
                            @role('manajer')
                                <select class="form-control" id="role" name="role">
                                    <option selected value="{{ implode(', ', $user->getRoleNames()->toArray()) }}">
                                        {{ implode(', ', $user->getRoleNames()->toArray()) }}</option>
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
