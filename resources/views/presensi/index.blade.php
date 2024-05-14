@extends('adminlte::page')
@section('title', 'Presensi Pegawai')
@section('content_header')
@if(auth()->user()->level === 'admin')
<h1 class="m-0 text-dark">Presensi Pegawai</h1>
@else
<h1 class="m-0 text-dark">&nbsp; Data Presensi</h1>
@endif
@stop
@section('content')
{{-- <div class="container"> --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                @if(auth()->user()->level === 'admin')
                    <form method="get" action="{{route('presensi.index')}}" class="row">
                        <div class="col-md-3 form-group mb-2">
                            <label for="tanggal">Tanggal Awal :</label> &nbsp;&nbsp;
                            <input type="date"
                                class="form-control border-primary @error('tanggal_awal') is-invalid @enderror" id="tanggal_awal"
                                name="tanggal_awal" value="{{request()->input('tanggal_awal')}}"> &nbsp; &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 form-group mb-2">
                            <label for="tanggal">Tanggal Akhir :</label> &nbsp;&nbsp;
                            <input type="date"
                                class="form-control border-primary @error('tanggal_akhir') is-invalid @enderror"
                                id="tanggal_akhir" name="tanggal_akhir" value="{{request()->input('tanggal_akhir')}}"> &nbsp;
                            &nbsp;                            
                          </div>
                          <div class="col-md-3 form-group mb-2">
                            <label for="nik">Pilih Pegawai</label>
                            <select class="form-control border-primary mr-2" name="id_users" id="id_users">
                              <option value="">Pilih Pegawai</option>
                              @foreach($users as $key => $item)
                              <option value="{{ $item->id_users }}">{{ $item->nama_pegawai }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <br>
                              <button type="submit" class="btn btn-primary mt-2">&nbsp;Tampilkan</button>
                              <a class="btn btn-danger mt-2" id="download-button">&nbsp;Export</a>
                            </div>
                          </div>
                          
                    </form>
                    @endif

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
                                @if(auth()->user()->level === 'admin')
                                <th>Nama Pegawai</th>
                                @endif
                                <th >Tanggal</th>
                                {{-- <th>Jam Masuk</th>
                                <th>Jam Pulang</th> --}}
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
                                @if(auth()->user()->level === 'admin')
                                <td>{{ optional(optional($pn->profile_user)->user)->nama_pegawai }}</td>
                                @endif
                                <td> {{ \Carbon\Carbon::parse($pn->tanggal)->format('d M Y') }}</td>
                                {{-- <td>{{$pn->jam_masuk}}</td>
                                <td>{{$pn->jam_pulang}}</td> --}}
                                <td>{{$pn->scan_masuk}}</td>
                                <td>{{$pn->scan_pulang}}</td>
                                <td>{{$pn->terlambat}}</td>
                                <td>{{$pn->pulang_cepat}}</td>
                                <td>{{$pn->kehadiran}}</td>
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

<!-- used for exporting data to excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js" integrity="sha512-dlPw+ytv/6JyepmelABrgeYgHI0O+frEwgfnPdXDTOIZz+eDgfW07QXG02/O8COfivBdGNINy+Vex+lYmJ5rxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- exporting data to excel -->
<script type="text/javascript">

    // let data = JSON.parse('{!! json_encode($presensi) !!}')
    // data = data.map((item) => {
    //     item.nama_pegawai = item.profile_user.user.nama_pegawai;
    //     delete item.profile_user;
    //     return item;
    // })
    
    const d = new Date();
    const filename = `${d.getFullYear()}-${d.getMonth()}-${d.getDate()}`

    async function downloadExcelData(items){
        const workbook = new ExcelJS.Workbook();
        workbook.creator = "{{ Auth::user()->nama_pegawai }}";
        workbook.lastModifiedBy = "{{ Auth::user()->nama_pegawai }}";
        workbook.created = new Date();
        workbook.modified = new Date();

        // add a sheet with name the data data downloaded
        const sheet = workbook.addWorksheet(filename);

        sheet.columns = [
            { header: 'No', key: 'no', width: 10 },
            { header: 'Nama Pegawai', key: 'nama_pegawai', width: 32 },
            { header: 'Tanggal', key: 'tanggal', width: 10 },
            { header: 'Jam Masuk', key: 'jam_masuk', width: 10 },
            { header: 'Jam Pulang', key: 'jam_pulang', width: 10 },
            { header: 'Scan Masuk', key: 'scan_masuk', width: 10 },
            { header: 'Scan Pulang', key: 'scan_pulang', width: 10 },
            { header: 'Terlambat', key: 'terlambat', width: 10 },
            { header: 'Pulang Cepat', key: 'pulang_cepat', width: 10 },
            { header: 'Total Kehadiran', key: 'kehadiran', width: 10 },
        ];

        items.map((item, index) => {
            sheet.addRow({no: index + 1, ...item});
        });
        return workbook.xlsx.writeBuffer();
    }

    document.getElementById('download-button').addEventListener('click', function(){
        fetch(window.location.href, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(async result => {
            let data = result.data.map((item) => {
                item.nama_pegawai = item.profile_user.user.nama_pegawai;
                delete item.profile_user;
                return item;
            })

            let buffer = await downloadExcelData(data);
            let blob = new Blob(
                [buffer], 
                {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,"}
            );
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = 'export-presensi-pegawai-' + filename + ".xlsx";
            link.click();
        })
    });
</script>

<!-- datatable -->
<script type="text/javascript">
$('#example2').DataTable({"responsive": true});
</script>
@endpush