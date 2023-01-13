@extends('layouts.dashboard')

@section('Nama')
  <h1 class="h3 mb-4 text-gray-800">Mahasiswa</h1>
@endsection

@section('konten')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Table</h6>
  </div>

  <div class="card-body">

    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

    <a href="{{ route('get.tambah.mahasiswa') }}" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
          <i class="fas fa-plus"></i>
      </span>
      <span class="text">Tambah Data</span>
    </a>

    <hr>

    <!-- Filter -->
    <ul class="nav nav-tabs" id="tabFilter" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="search-tab" data-toggle="tab" data-target="#search" type="button" role="tab" aria-controls="search" aria-selected="true">Search</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="sort-tab" data-toggle="tab" data-target="#sort" type="button" role="tab" aria-controls="sort" aria-selected="false">Sort</button>
      </li>
    </ul>

    <!-- Filter Content -->
    <form action="{{ route('get.mahasiswa') }}" method="get">

      <div class="tab-content" id="tabFilterContent">

        <!-- Search -->
        <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="search-tab">
          <div class="row">

            <div class="col-lg-2 col-md-6 col-xs-12">
              <label for="cari_nama">Nama</label>
              <input type="text" name="cari_nama" class="form-control" placeholder="nama ..." value="{{ $cari_nama }}">
            </div>

            <div class="col-lg-2 col-md-6 col-xs-12">
              <label for="cari_nama_kelas">Kelas</label>
              <input type="text" name="cari_nama_kelas" class="form-control" placeholder="kelas ..." value="{{ $cari_nama_kelas }}">
            </div>

          </div>

          <div class="row">
            <div class="col-lg-2 col-md-6 col-xs-12">
              <label for="set_pagination">Item per Page</label>

              <select name="set_pagination" class="form-control">
                <option value="5" {{ $set_pagination == "5" ? 'selected' : '' }}>5</option>
                <option value="10" {{ $set_pagination == "10" ? 'selected' : '' }}>10</option>
                <option value="50" {{ $set_pagination == "50" ? 'selected' : '' }}>50</option>
                <option value="100" {{ $set_pagination == "100" ? 'selected' : '' }}>100</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Sort -->
        <div class="tab-pane fade" id="sort" role="tabpanel" aria-labelledby="Sort-tab">
          <div class="row">
            <div class="col-lg-2 col-md-6 col-xs-12"> 
              <label for="var_sort"><i class="fa fa-arrow-down"></i> Field</label>
              <select name="var_sort" class="form-control">
                <option value="">Pilih Opsi</option>
                <option value="nama" {{ $var_sort == "nama" ? 'selected' : '' }}>nama</option>
                <option value="created_at" {{ $var_sort == "created_at" ? 'selected' : '' }}>Created at</option>
                <option value="updated_at" {{ $var_sort == "updated_at" ? 'selected' : '' }}>Updated at</option>
              </select>
            </div>

            <div class="col-lg-2 col-md-6 col-xs-12">
              <label for="tipe_sort"><i class="fa fa-arrow-up"></i> Type</label>
              <select name="tipe_sort" class="form-control">
                <option value="">Pilih Opsi</option>
                <option value="desc" {{ $tipe_sort == "desc" ? 'selected' : '' }}>Desc</option>
                <option value="asc" {{ $tipe_sort == "asc" ? 'selected' : '' }}>Asc</option>
              </select>
            </div>
          </div>
        </div>
      </div>


      <button type="submit" class="btn btn-info mt-2">
        Apply
      </button>    

      <a href="{{ route('get.mahasiswa') }}" class="btn btn-info mt-2">
        Refresh
      </a>  

    </form>
    <!-- End Filter -->
    <hr>

    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Aksi</th>
            </tr>
        </thead>
          <tbody>
            @foreach($data_mahasiswa as $mahasiswa)
              <tr>
                <td>{{ $loop->iteration + $data_mahasiswa->firstItem() - 1 }}</td>
                <td>{{ $mahasiswa->nama }}</td>
                <td>{{ $mahasiswa->kelas->nama_kelas }}</td>
                <td class="text-nowrap">
                  <!-- Detail -->
                  <a href="{{ route('get.detail.mahasiswa', $mahasiswa->id) }}" class="btn btn-success" > 
                    <i class="fa fa-eye"></i>
                  </a>

                  <!-- Ubah -->
                  <a href="{{ route('get.ubah.mahasiswa', $mahasiswa->id) }}" class="btn btn-primary" > 
                    <i class="fa fa-edit"></i>
                  </a>

                  <!-- Delete -->
                  <form hidden action="{{ route('delete.mahasiswa', $mahasiswa->id)}}" method="post" id="data-ke-{{ $mahasiswa->id }}">
                    @csrf
                    @method('DELETE')
                    &nbsp;
                  </form>

                  <button class="btn btn-danger" onclick="deleteRow( {{ $mahasiswa->id }} )">
                    <i class="fas fa-trash"></i>
                  </button>
           
                  &nbsp;

                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
  </div>

  </div>
</div>
@endsection

@push('scripts')
<!-- Add SweetAlert 2 CDN -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Delete Row -->
<script>
  function deleteRow(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#data-ke-'+id).submit()
      }
    })
  }
</script>

@endpush