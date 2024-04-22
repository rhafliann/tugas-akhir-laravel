@extends('adminlte::page')
@section('title', 'Data Pemagang')

@section('content_header')
<link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2\css\all.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Pemagang</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form id="addForm" action="{{ route('waktu-kerja.update', $data) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <div class="col-3">
                <label for="nama_waktu">Nama Waktu</label>
              </div>
              <div class="col-9">
                <input type="text" name="nama_waktu" id="nama_waktu" value="{{ $data->nama_waktu }}" class="form-control @error('nama_waktu') is-invalid @enderror" value="{{ old('nama_waktu') }}" required>
                @error('nama_waktu')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="col-3">
                <label for="jam_masuk">Jam Masuk</label>
              </div>
              <div class="col-9">
                <input type="time" name="jam_masuk" id="jam_masuk" value="{{ $data->jam_masuk }}" class="form-control @error('jam_masuk') is-invalid @enderror" value="{{ old('jam_masuk') }}" required>
                @error('jam_masuk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="col-3">
                <label for="jam_pulang">Jam Pulang</label>
              </div>
              <div class="col-9">
                <input type="time" name="jam_pulang" id="jam_pulang" value="{{ $data->jam_pulang }}" class="form-control @error('jam_pulang') is-invalid @enderror" value="{{ old('jam_pulang') }}" required>
                @error('jam_pulang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>


            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </form>

        </div>
      </div>
  </div>
</div>

@can('isAdmin')
@endcan

@endsection

@push('js')
<script type="text/javascript">
 $('#table-pemagang').DataTable({"responsive": true});
</script>
@endpush