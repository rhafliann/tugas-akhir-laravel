@extends('adminlte::page')
@section('title', 'Presensi Pegawai')

@section('content_header')
<h1 class="m-0 text-dark">Presensi Pemagang</h1>
@endsection

@section('content')
{{-- <div class="container"> --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <form method="get" action="{{route('pemagang.presensi')}}" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="tanggal">Tanggal Awal :</label> &nbsp;&nbsp;
                            <input type="date"
                                class="form-control border-primary @error('tanggal_awal') is-invalid @enderror" id="tanggal_awal"
                                name="tanggal_awal" value="{{request()->input('tanggal_awal')}}" required> &nbsp; &nbsp;&nbsp;
                            <label for="tanggal">Tanggal Akhir :</label> &nbsp;&nbsp;
                            <input type="date"
                                class="form-control border-primary @error('tanggal_akhir') is-invalid @enderror"
                                id="tanggal_akhir" name="tanggal_akhir" value="{{request()->input('tanggal_akhir')}}" required> &nbsp;
                            &nbsp;
                            <button type="submit" class="btn btn-primary">&nbsp;Tampilkan</button>
                        </div>
                    </form>

                    <div>
                       <ul>
                            <li>Jam Masuk: {{ $waktuKerja->jam_masuk }}</li>
                            <li>Jam Pulang: {{ $waktuKerja->jam_pulang }}</li>
                        </ul> 
                    </div>

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pemagang</th>
                                <th >Tanggal</th>
                                <th>Scan Masuk</th>
                                <th>Scan Pulang</th>
                                <th>Terlambat</th>
                                <th>Pulang Cepat</th>
                                <th>Total Kehadiran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presensi as $key => $pn)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $pn->profile_pemagang->nama  }}</td>
                                <td> {{ \Carbon\Carbon::parse($pn->tanggal)->format('d M Y') }}</td>
                                <td>{{$pn->scan_masuk}}</td>
                                <td>{{$pn->scan_pulang}}</td>
                                <td>{{$pn->terlambat}}</td>
                                <td>{{$pn->kehadiran}}</td>
                                <td>{{$pn->pulang_cepat}}</td>
                                <td>{{$pn->jenis_perizinan}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- </div> --}}
</section>
@stop
@push('js')
<script>
$('#example2').DataTable({
    "responsive": true,
});
</script>
@endpush