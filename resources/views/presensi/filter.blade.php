@extends('adminlte::page')

@section('title', 'Presensi Pegawai')

@section('content_header')
<h1 class="m-0 text-dark">Presensi Pegawai</h1>
@stop

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <form action="{{ route('presensi.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <label for="import" class="my-label mr-2 mt-1">Import Presensi:</label>&nbsp;&nbsp;
                                    <input type="file" name="file" id="file" class="form-label border" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Import</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">

                            <div class="col-md-10">
                                <form action="{{ route('presensi.filterAdmin') }}" method="GET"
                                    class="form-inline mb-3">
                                    <div class="form-group mb-2">

                                        <label for="start_date" class="my-label mr-2">Tanggal
                                            Awal:&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="date" id="start_date" name="start_date" required
                                            class="form-control" value="{{request()->input('start_date')}}">&nbsp;&nbsp;
                                        <label for="end_date" class="form-label">Tanggal Akhir:</label>&nbsp;&nbsp;
                                        <input type="date" id="end_date" name="end_date" required class="form-control"
                                            value="{{request()->input('end_date')}}">&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-primary">&nbsp;Tampilkan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2 d-flex flex-column justify-content-right">
                                <button id="download-button" class="btn btn-danger">Export Data</button>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-stripped" id="example2">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Pegawai</th>
                                        <th>Kehadiran</th>
                                        <th>Terlambat</th>
                                        <th>I</th>
                                        <th>S</th>
                                        <th>CS</th>
                                        <th>CT</th>
                                        <th>CM</th>
                                        <th>DL</th>
                                        <th>A</th>
                                        <th>CB</th>
                                        <th>CH</th>
                                        <th>TB</th>
                                        <th>CAP</th>
                                        <th>Prajab</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensis as $key => $presensi)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ $presensi['user'] }}</td>
                                        <td>{{ $presensi['kehadiran'] }}</td>
                                        <td class="d-flex justify-content-between"> 
                                            <p>{{ $presensi['terlambat'] }}x </p>
                                            <p>{{ $presensi['total_waktu_terlambat'] }}</p>
                                        </td>
                                        <td>{{ $presensi['ijin'] }}</td>
                                        <td>{{ $presensi['sakit'] }}</td>
                                        <td>{{ $presensi['cutiSakit'] }}</td>
                                        <td>{{ $presensi['cutiTahunan'] }}</td>
                                        <td>{{ $presensi['cutiMelahirkan'] }}</td>
                                        <td>{{ $presensi['dinasLuar'] }}</td>
                                        <td>{{ $presensi['alpha'] }}</td>
                                        <td>{{ $presensi['cutiBersama'] }}</td>
                                        <td>{{ $presensi['cutiHaji'] }}</td>
                                        <td>{{ $presensi['tugasBelajar'] }}</td>
                                        <td>{{ $presensi['cap'] }}</td>
                                        <td>{{ $presensi['prajab'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h5>Keteragan</h5>
                        <table>
                            <tr>
                                <td>I</td>
                                <td>: Ijin</td>
                            </tr>
                            <tr>
                                <td>S</td>
                                <td>: Sakit</td>
                            </tr>
                            <tr>
                                <td>CS</td>
                                <td>: Cuti Sakit</td>
                            </tr>
                            <tr>
                                <td>CT</td>
                                <td>: Cuti Tahunan</td>
                            </tr>
                            <tr>
                                <td>CM</td>
                                <td>: Cuti Melahirkan</td>
                            </tr>
                            <tr>
                                <td>DL</td>
                                <td>: Dinas Luar</td>
                            </tr>
                            <tr>
                                <td>A</td>
                                <td>: Alpha</td>
                            </tr>
                            <tr>
                                <td>CB</td>
                                <td>: Cuti Bersama</td>
                            </tr>
                            <tr>
                                <td>CH</td>
                                <td>: Cuti Haji</td>
                            </tr>
                            <tr>
                                <td>TB</td>
                                <td>: Tugas Belajar</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const filename = `${d.getFullYear()}-${monthNames[d.getMonth()]}-${d.getDate()}`

    async function downloadExcelData(items, start_date, end_date){
        const workbook = new ExcelJS.Workbook();
        workbook.creator = "{{ Auth::user()->nama_pegawai }}";
        workbook.lastModifiedBy = "{{ Auth::user()->nama_pegawai }}";
        workbook.created = new Date();
        workbook.modified = new Date();

        // add a sheet with name the data data downloaded
        const sheet = workbook.addWorksheet(filename);

        sheet.columns = [
            { header: 'No', key: 'no', width: 10 },
            { header: 'Nama Pegawai', key: 'user', width: 32 },
            { header: 'Kehadiran', key: 'kehadiran', width: 10 },
            { header: 'Terlambat', key: 'terlambat', width: 10 },
            { header: 'Total Waktu Terlambat', key: 'total_waktu_terlambat', width: 10 },
            { header: 'Izin', key: 'izin', width: 10 },
            { header: 'Sakit', key: 'sakit', width: 10 },
            { header: 'Cuti Sakit', key: 'cutiSakit', width: 10 },
            { header: 'Cuti Tahunan', key: 'cutiTahunan', width: 10 },
            { header: 'Cuti Melahirkan', key: 'cutiMelahirkan', width: 10 },
            { header: 'Dinas Luar', key: 'dinasLuar', width: 10 },
            { header: 'Alpha', key: 'alpha', width: 10 },
            { header: 'Cuti Bersama', key: 'jacutiBersama_masuk', width: 10 },
            { header: 'Cuti Haji', key: 'cutiHaji', width: 10 },
            { header: 'Tugas Belajar', key: 'tugasBelajar', width: 10 },
            { header: 'CAP', key: 'cap', width: 10 },
            { header: 'Prajab', key: 'prajab', width: 10 },
        ];

        sheet.insertRow(1, ['Periode ' + `${start_date} s.d ${end_date}`]);
        sheet.insertRow(2, ['Data Rekap Presensi Pegawai SEAMEO QITEP in Language']);

        items.map((item, index) => {
            sheet.addRow({no: index + 1, ...item});
        });

        let values = [
            ['I', 'Izin'],
            ['S', 'Sakit'],
            ['CS', 'Cuti Sakit'],
            ['CT', 'Cuti Tahunan'],
            ['CM', 'Cuti Melahirkan'],
            ['DL', 'Dinas Luar'],
            ['A', 'Alpha'],
            ['CB', 'Cuti Bersama'],
            ['CB', 'Cuti Haji'],
            ['TB', 'Tugas Belajar'],
            ['CAP', 'CAP'],
            ['Prajab', 'Prajab'],
        ];

        sheet.insertRow(items.length + 5, ['']);
        sheet.insertRow(items.length + 6, ['']);
        sheet.insertRow(items.length + 7, ['']);

        values.forEach((element, index) => {
            sheet.insertRow((items.length + 8 + index), element);
        });
            
        return workbook.xlsx.writeBuffer();
    }

    document.getElementById('download-button').addEventListener('click', function(){
        fetch('/presensi/admin/export', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(async result => {
            let data = result.data

            let buffer = await downloadExcelData(data, result.start_date, result.end_date);
            let blob = new Blob(
                [buffer], 
                {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,"}
            );
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = 'export-rekap-presensi-pegawai-' + filename + ".xlsx";
            link.click();
        })
    });
</script>


<script>
$('#example2').DataTable({
    "responsive": true,
});
</script>
@endpush