@extends('adminlte::page')
@section('title', 'Daftar Perizinan')
@section('content_header')
<h1 class="m-0 text-dark"> Daftar Perizinan
    <!-- @if ($jatahCuti)
    (Sisa Cuti: {{ $jatahCuti->jatah_cuti}} Hari)
    @else
    (Sisa Cuti: -)
    @endif -->
</h1>
@stop
@section('content')

@php
$kodeJenisPerizinan = [
'A' => 'Alpha',
'CAP' => 'CAP',
'CB' => 'Cuti Bersama',
'CH' => 'Cuti Haji',
'CM' => 'Cuti Melahirkan',
'CS' => 'Cuti Sakit',
'CT' => 'Cuti Tahunan',
'DL' => 'Dinas Luar',
'I' => 'Izin',
'Prajab' => 'Prajab',
'S' => 'Sakit',
'TB' => 'Tugas Belajar'
];
@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Ajuan</th>
                                <th>Tanggal Ajuan</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Keterangan</th>
                                <th>Lampiran</th>
                                <th>Jml Hari</th>
                                <th>Persetujuan Atasan</th>
                                <th>Persetujuan PPK</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perizinan as $key => $p)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                <td id={{$key+1}}>{{$p->jenis_perizinan}}</td>
                                <td id={{$key+1}}> {{ \Carbon\Carbon::parse($p->tgl_ajuan)->format('d M Y') }}</td>
                                <td id={{$key+1}}> {{ \Carbon\Carbon::parse($p->tgl_absen_awal)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($p->tgl_absen_akhir)->format('d M Y') }}</td>
                                <td id={{$key+1}}>{{$p->keterangan}}</td>
                                <td id={{$key+1}} style="text-align: center; vertical-align: middle;">
                                    @if($p->file_perizinan)
                                    <a href="{{ asset('/storage/file_perizinan/'. $p->file_perizinan) }}"
                                        target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td id={{$key+1}}>{{$p->jumlah_hari_pengajuan}}</td>
                                <td id={{$key+1}}>
                                    @if($p->status_izin_atasan == '0')
                                    Ditolak
                                    @elseif($p->status_izin_atasan == '1')
                                    Disetujui
                                    @else
                                    Menunggu Persetujuan
                                    @endif
                                </td>
                                <td id={{$key+1}}>
                                    @if($p->status_izin_ppk == '0')
                                    Ditolak
                                    @elseif($p->status_izin_ppk == '1')
                                    Disetujui
                                    @elseif($p->jenis_perizinan == 'I')
                                    @else
                                    Menunggu Persetujuan
                                    @endif
                                </td>
                                <td>
                                    @if($p->status_izin_atasan == '1' && $p->status_izin_ppk == '1' )
                                    Disetujui
                                    @elseif($p->jenis_perizinan == 'I' && $p->status_izin_atasan == '1' )
                                    Disetujui
                                    @else
                                    @include('components.action-buttons', ['id' => $p->id_perizinan, 'key' => $key,
                                    'route' => 'perizinan'])
                                    @endif
                                </td>
                            </tr>
                            <!-- Edit -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($perizinan as $key => $p):
<div class="modal fade" id="editModal{{$p->id_perizinan}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Perizinan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('perizinan.update', $p->id_perizinan) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">

                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col form-group">
                                    <label for="tgl_absen_awal" class='form-label'>Tanggal
                                        Awal Izin</label>
                                    <div class="form-input">
                                        <input type="date" class="form-control"
                                            class="form-control @error('tgl_absen_awal') is-invalid @enderror"
                                            id="tgl_absen_awal" placeholder="Nama Diklat" name="tgl_absen_awal"
                                            value="{{$p -> tgl_absen_awal ?? old('tgl_absen_awal')}}" required>
                                        @error('tgl_absen_awal') <span class="textdanger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col form-group">
                                    <label for="tgl_absen_akhir" class='form-label'>Tanggal
                                        Akhir Izin</label>
                                    <div class="form-input">
                                        <input type="date" class="form-control"
                                            class="form-control @error('tgl_absen_akhir') is-invalid @enderror"
                                            id="tgl_absen_akhir" placeholder="Nama Diklat" name="tgl_absen_akhir"
                                            value="{{$p -> tgl_absen_akhir ?? old('tgl_absen_akhir')}}" required>
                                        @error('tgl_absen_akhir') <span class="textdanger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="jumlah_hari_pengajuan" class="form-label">Jumlah Hari Pengajuan</label>
                                    <input type="number"
                                        class="form-control @error('jumlah_hari_pengajuan') is-invalid @enderror"
                                        id="jumlah_hari_pengajuan" name="jumlah_hari_pengajuan"
                                        value="{{$p -> jumlah_hari_pengajuan ?? old('jumlah_hari_pengajuan') }}"
                                        min="0">
                                    @error('jumlah_hari_pengajuan') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col form-group">
                                    <label for="jenis_perizinan">Jenis Perizinan</label>
                                    <select class="form-control  @error('jenis_perizinan') is-invalid @enderror"
                                        id="jenis_perizinan" name="jenis_perizinan">

                                        @foreach($kodeJenisPerizinan as $key => $item)
                                        <option value="{{ $key }}" @if($p->jenis_perizinan == $key ||
                                            old('jenis_perizinan') == $key ) selected @endif>
                                            {{$item}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea rows="5" class="form-control" id="keterangan" name="keterangan"
                                    required>{{$p -> keterangan ?? old('keterangan')}}</textarea>
                            </div>
                            @if(auth()->user()->id_jabatan != '7')
                            <div class="form-group">
                                <label class="id_atasan" for="id_atasan">Atasan
                                    Langsung</label>
                                <select id="id_atasan" name="id_atasan"
                                    class="form-control @error('id_atasan') is-invalid @enderror">
                                    @foreach ($users as $us)
                                    <option value="{{ $us->id_users }}" @if( $p->
                                        id_atasan == old('id_atasan', $us->id_users) )
                                        selected @endif>
                                        {{ $us->nama_pegawai }}
                                    </option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                            <div class="form-group">
                                @foreach ($settingperizinan as $ps)
                                @if ($ps->setting && $ps->setting->status == '1')
                                <label for="id">PPK</label>
                                <input type="text" class="form-control @error('') is-invalid @enderror" id="id" name=""
                                    value="{{ $ps->nama_pegawai}}" readonly>
                                @error('') <span class="text-danger">{{$message}}</span>
                                @enderror
                                @endif
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="file_perizinan">Unggah Lampiran</label>

                                <input type="file" class="form-control @error('file_perizinan') is-invalid @enderror"
                                    id="file_perizinan_edit" name="file_perizinan"
                                    onchange="validateFile(this, 'fileErrorEdit')">
                                <div class="invalid-feedback" id="fileErrorEdit" style="display: none;">Tipe file tidak
                                    valid. Harap
                                    unggah file dengan ekstensi yang diizinkan.</div>
                                @error('file_perizinan')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Allow file
                                    extensions: .jpeg .jpg .png .pdf .docx</small>
                                @if ($p->file_perizinan)
                                <p>Previous File: <a href="{{ asset('/storage/file_perizinan/' . $p->file_perizinan) }}"
                                        target="_blank">{{ $p->file_perizinan }}</a></p>
                                @endif

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- Modal -->
<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Perizinan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('perizinan.pengajuan') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <div class="form-row">
                                <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                                <div class="col-6 form-group">
                                    <label for="tgl_absen_awal-store" class="form-label">Tanggal Awal Izin </label>
                                    <div class="form-input">
                                        <input type="date"
                                            class="form-control @error('tgl_absen_awal') is-invalid @enderror"
                                            id="tgl_absen_awal-store" name="tgl_absen_awal" value="{{ old('tgl_absen_awal')}}"
                                            required>
                                        @error('tgl_absen_awal') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="tgl_absen_akhir-store" class="form-label">Tanggal Akhir Izin</label>
                                    <div class="form-input">
                                        <input type="date"
                                            class="form-control @error('tgl_absen_akhir') is-invalid @enderror"
                                            id="tgl_absen_akhir-store" name="tgl_absen_akhir"
                                            value="{{ old('tgl_absen_akhir')}}" required>
                                        @error('tgl_absen_akhir') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="jumlah_hari_pengajuan-store" class="form-label">Jumlah Hari Pengajuan</label>
                                    <input type="number"
                                        class="form-control @error('jumlah_hari_pengajuan') is-invalid @enderror"
                                        id="jumlah_hari_pengajuan-store" name="jumlah_hari_pengajuan"
                                        value="{{  old('jumlah_hari_pengajuan') }}" min="0">
                                    @error('jumlah_hari_pengajuan') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6 form-group">
                                    <label for="jenis_perizinan">Jenis Ajuan</label>
                                    <select class="form-control  @error('jenis_perizinan') is-invalid @enderror"
                                        id="jenis_perizinan" name="jenis_perizinan">
                                        <option value="A">Alpha</option>
                                        <option value="CAP">CAP</option>
                                        <option value="CB">Cuti Bersama</option>
                                        <option value="CH">Cuti Haji</option>
                                        <option value="CM">Cuti Melahirkan</option>
                                        <option value="CS">Cuti Sakit</option>
                                        <option value="CT">Cuti Tahunan</option>
                                        <option value="DL">Dinas Luar</option>
                                        <option value="I">Izin</option>
                                        <option value="Prajab">Prajab</option>
                                        <option value="S">Sakit</option>
                                        <option value="TB">Tugas Belajar</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                @if(auth()->user()->id_jabatan != '7')
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_atasan">Atasan Langsung</label>
                                    <select id="id_atasan" name="id_atasan"
                                        class="form-control @error('id_atasan') is-invalid @enderror">
                                        @foreach ($users as $us)
                                        <option value="{{ $us->id_users }}" @if( old('id_users')==$us->id_users )
                                            selected @endif">
                                            {{ $us->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea rows="4" class="form-control @error('keterangan') is-invalid @enderror"
                                        id="keterangan" name="keterangan" required>{{old('keterangan')}}</textarea>
                                    @error('keterangan') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group">
                                    @foreach ($settingperizinan as $ps)
                                    @if ($ps->setting && $ps->setting->status == '1')
                                    <label for="id">PPK</label>
                                    <input type="text" class="form-control @error('') is-invalid @enderror" id="id"
                                        name="" value="{{ $ps->nama_pegawai}}" readonly>
                                    @error('')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    @endif
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="file_perizinan">Unggah Lampiran</label>
                                    <input type="file"
                                        class="form-control @error('file_perizinan') is-invalid @enderror"
                                        id="file_perizinan" name="file_perizinan"
                                        onchange="validateFile(this, 'fileErrorCreate')">
                                    <small class="form-text text-muted">Allow file extensions: .jpeg .jpg .png .pdf
                                        .docx</small>
                                    <div class="invalid-feedback" id="fileErrorCreate" style="display: none;">Tipe file
                                        tidak valid. Harap unggah file dengan ekstensi yang diizinkan.</div>
                                    @error('file_perizinan')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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



@stop
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
    $('#example2').DataTable({
    "responsive": true,
});

function notificationBeforeDelete(event, el) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data ? ')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Get the current date and time
    var currentDate = new Date();
    var formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' ');

    // Populate the hidden input field with the current date and time
    document.getElementById('tgl_ajuan').value = formattedDate;
});
</script>

<script>
    function validateFile(input, errorElementId) {
    const allowedExtensions = ['.jpeg', '.jpg', '.png', '.pdf', '.docx'];
    const fileInput = input.files[0];
    const fileErrorElement = document.getElementById(errorElementId);

    if (fileInput) {
        const fileName = fileInput.name;
        const fileExtension = '.' + fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            fileErrorElement.style.display = 'block';
            input.classList.add('is-invalid');
            input.value = ''; // Clear the input
        } else {
            fileErrorElement.style.display = 'none';
            input.classList.remove('is-invalid');
        }
    }
}
</script>


<script type="text/javascript">
const getBusinessDatesCount = (startDate, endDate) => {
        let count = 0;
        let curDate = +startDate;
        while (curDate <= +endDate) {
            const dayOfWeek = new Date(curDate).getDay();
            const isWeekend = (dayOfWeek === 6) || (dayOfWeek === 0);
            if (!isWeekend) count++;

            curDate = curDate + 24 * 60 * 60 * 1000
        }
        return count;
    }

    const changeHariPengajuan = (tgl_absen_awal, tgl_absen_akhir, target) => {
        let startDate = new Date(tgl_absen_awal.value);
        let endDate = new Date(tgl_absen_akhir.value);

        if(!startDate){
            window.alert("Harap input tanggal awal");
        }

        if(!endDate){
            window.alert("Harap input tanggal akhir");
        }

        if(+startDate > +endDate){
            window.alert("Harap masukan periode tanggal yang sesuai");
            tgl_absen_awal_store.value = '';
            tgl_absen_akhir_store.value = '';
        }

        target.value = getBusinessDatesCount(startDate, endDate);
    }

    const tgl_absen_awal_store = document.getElementById('tgl_absen_awal-store');
    const tgl_absen_akhir_store = document.getElementById('tgl_absen_akhir-store');
    const hari_pengajuan = document.getElementById('jumlah_hari_pengajuan-store');

    document.getElementById('tgl_absen_akhir-store')
    .addEventListener('change', (e) => changeHariPengajuan(tgl_absen_awal_store, tgl_absen_akhir_store, hari_pengajuan));
</script>

@endpush