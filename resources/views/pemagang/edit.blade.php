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
          <form id="addForm" action="{{ route('pemagang.update', $pemagang) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <div class="col-3">
                <label for="nik">NIK Pemagang</label>
              </div>
              <div class="col-9">
                <input type="text" name="nik" id="nik" value="{{$pemagang->nik}}" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required>
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
                <input type="text" name="nama" id="nama" value="{{$pemagang->nama}}" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
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
                <input type="text" name="institusi" id="institusi" value="{{$pemagang->institusi}}" class="form-control @error('institusi') is-invalid @enderror" value="{{ old('institusi') }}" required>
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
                <input type="text" name="divisi" id="divisi" value="{{$pemagang->divisi}}" class="form-control @error('divisi') is-invalid @enderror" value="{{ old('divisi') }}" required>
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

@can('isAdmin')
@endcan

@endsection

@push('js')
<script type="text/javascript">
 $('#table-pemagang').DataTable({"responsive": true});
</script>
@endpush