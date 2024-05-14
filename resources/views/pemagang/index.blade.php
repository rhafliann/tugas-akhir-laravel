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
          <div class="row">
            <div class="col-md-6">
              @can('isAdmin')
              <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addModal">Tambah</button>
              @endcan
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-stripped" id="table-pemagang">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NIK</th>
                  <th>Institusi</th>
                  <th>divisi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $item):
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->nik }}</td>
                  <td>{{ $item->institusi }}</td>
                  <td>{{ $item->divisi }}</td>
                  <td class="d-flex">
                    <a class="btn btn-warning mx-2" href="{{route('pemagang.edit', $item)}}">Edit</a>
                    <form action="{{ route('pemagang.destroy', $item) }}" method="POST">
                      @csrf
                      @method("DELETE")
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
                <form id="addForm" action="{{ route('pemagang.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                      <div class="col-3">
                        <label for="nik">NIK Pemagang</label>
                      </div>
                      <div class="col-9">
                        <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required>
                        @error('nik')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-3">
                        <label for="nama">Nama Pemagang</label>
                      </div>
                      <div class="col-9">
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-3">
                        <label for="institusi">Institusi Asal Pemagang</label>
                      </div>
                      <div class="col-9">
                        <input type="text" name="institusi" id="institusi" class="form-control @error('institusi') is-invalid @enderror" value="{{ old('institusi') }}" required>
                        @error('institusi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-3">
                        <label for="institusi">Divisi Pemagang</label>
                      </div>
                      <div class="col-9">
                        <input type="text" name="divisi" id="divisi" class="form-control @error('divisi') is-invalid @enderror" value="{{ old('divisi') }}" required>
                        @error('divisi')
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
 $('#table-pemagang').DataTable({"responsive": true});
</script>
@endpush