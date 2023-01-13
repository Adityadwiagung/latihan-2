@extends('layouts.dashboard')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('nama')
  <h1 class="h3 mb-4 text-gray-800">Mahasiswa</h1>
@endsection

@section('konten')
<div class="card shadow mb-4">

  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit</h6>
  </div>

  <div class="card-body">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

    <form action="{{ route('post.proses-ubah.mahasiswa', $detail_mahasiswa->id) }}" method="post">
      @csrf
      @method('PATCH')

      <div class="form-group row">
        <label for="nama" class="col-sm-2 col-form-label">Nama</label>

        <div class="col-sm-10">
          <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $detail_mahasiswa->nama) }}">

          @error('nama')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        
      </div>

      <div class="form-group row">
        <label for="nim" class="col-sm-2 col-form-label">NIM</label>

        <div class="col-sm-10">
          <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim', $detail_mahasiswa->nim) }}">

          @error('nim')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        
      </div>

      <div class="form-group row">
        <label for="nim" class="col-sm-2 col-form-label">Kelas</label>

        <div class="col-sm-10">
          <select class="kelas-id form-control custom-select" name="kelas_ke">
            <option value="">Pilih Opsi</option>
            @foreach($data_kelas as $kelas)
              <option value="{{ $kelas->id }}" {{ old('kelas_id', $detail_mahasiswa->kelas_id) == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
            @endforeach
          </select>

          @error('kelas_ke')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        
      </div>


      <button type="submit" class="btn btn-success">
        Simpan
      </button>

    </form>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('.kelas-id').select2();
  });
</script>
@endpush