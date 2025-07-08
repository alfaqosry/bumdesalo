<x-layout>
    <div class="container-fluid py-4">
        <div class="row">

                
          
            <div class="col-md-12 mt-4">
                <div class="card">
                  <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Cabang Toko</h6>
                        </div>

                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{route('cabang.create')}}"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Cabang</a>
                        </div>
                    </div>
                    
                  </div>
                  <div class="card-body pt-4 p-3">
                    <ul class="list-group">

                        @foreach ($cabang as $item)
                            
                        
                      <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                          <h6 class="mb-3 text-sm">{{$item->nama_cabang}}</h6>
                          
                          <span class="mb-2 text-xs">Alamat: <span class="text-dark font-weight-bold ms-sm-2">{{$item->alamat_cabang}}</span></span>
                          <span class="mb-2 text-xs">Manajer: <span class="text-dark ms-sm-2 font-weight-bold">{{$item->name}}</span></span>
                         
                        </div>
                        <div class="ms-auto text-end">

                          <a class="btn btn-link text-success px-3 mb-0" href="{{route('cabang.show',$item->id)}}"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Lihat</a>
                          <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                          <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete</a>
                        </div>
                      </li>
                      @endforeach

                    </ul>
                  </div>
                </div>
              </div>
           

        </div>


    </div>
</x-layout>
