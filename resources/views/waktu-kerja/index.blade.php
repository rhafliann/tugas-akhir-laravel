@extends('adminlte::page')
@section('title', 'Data Pemagang')

@section('content_header')
<link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2\css\all.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Waktu Kerja</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              @can('isAdmin')
              <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addModal">Tambah</button>
              @endcan
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-stripped" id="table-01">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Waktu</th>
                  <th>Jam Masuk</th>
                  <th>Jam Pulang</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $item):
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $item->nama_waktu }}</td>
                  <td>{{ $item->jam_masuk }}</td>
                  <td>{{ $item->jam_pulang }}</td>
                  <td class="d-flex">
                    <a class="btn btn-warning mx-2" href="{{route('waktu-kerja.edit', $item)}}">Edit</a>
                    <form action="{{ route('waktu-kerja.destroy', $item) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

@can('isAdmin')
<!-- Modal Tambah Pegawai -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{ route('waktu-kerja.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                      <div class="col-3">
                        <label for="nama_waktu">Nama Waktu</label>
                      </div>
                      <div class="col-9">
                        <input type="text" name="nama_waktu" id="nama_waktu" class="form-control @error('nama_waktu') is-invalid @enderror" value="{{ old('nama_waktu') }}" required>
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
                        <input type="time" name="jam_masuk" id="jam_masuk" class="form-control @error('jam_masuk') is-invalid @enderror" value="{{ old('jam_masuk') }}" required>
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
                        <input type="time" name="jam_pulang" id="jam_pulang" class="form-control @error('jam_pulang') is-invalid @enderror" value="{{ old('jam_pulang') }}" required>
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
@endcan

@endsection

@push('js')
<script type="text/javascript">
 $('#table-01').DataTable({"responsive": true});
</script>
@endpush