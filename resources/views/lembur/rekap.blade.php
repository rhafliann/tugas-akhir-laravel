@extends('adminlte::page')
@section('title', 'Data Rekap Lembur')
@section('content_header')
<h1 class="m-0 text-dark">Data Rekap Lembur</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <form
                            action="{{ route('lembur.filter', ['start_date' => request()->input('start_date'), 'end_date' => request()->input('end_date')]) }}"
                            method="GET" class="form-inline mb-3">
                            <div class="form-group mb-2">
                                <label for="start_date" class="my-label mr-2">Tanggal
                                    Awal:&nbsp;
                                </label>
                                <input type="date" id="start_date" name="start_date" required class="form-control"
                                    value="{{ request()->input('start_date') }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="end_date" class="form-label">Tanggal Akhir:</label>&nbsp;&nbsp;
                                <input type="date" id="end_date" name="end_date" required class="form-control"
                                    value="{{ request()->input('end_date') }}">&nbsp;&nbsp;
                                <button type="submit" class="btn btn-primary">&nbsp;Tampilkan</button>&nbsp;&nbsp;
                                <button id="download-button" type="button" class="btn btn-primary">Unduh Excel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pegawai</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Waktu Lembur</th>
                                <th>Uraian Tugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lembur as $key => $lr)
                            @if ($lr->status_izin_atasan === '1')
                            <tr>
                                <td id={{ $key + 1 }}>{{ $key + 1 }}</td>
                                <td id={{ $key + 1 }}>{{ $lr->user->nama_pegawai }}</td>
                                <td id={{ $key + 1 }}>
                                    {{ date_format(new DateTime($lr->tanggal), 'd F Y') }}</td>
                                <td id={{ $key + 1 }}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_mulai)->format('H:i') }}
                                </td>
                                <td id={{ $key + 1 }}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_selesai)->format('H:i') }}
                                </td>
                                <td id={{ $key + 1 }}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_lembur)->format('H:i') }}
                                </td>
                                <td id={{ $key + 1 }}>{{ $lr->tugas }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('js')

<!-- used for exporting data to excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"
    integrity="sha512-dlPw+ytv/6JyepmelABrgeYgHI0O+frEwgfnPdXDTOIZz+eDgfW07QXG02/O8COfivBdGNINy+Vex+lYmJ5rxw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- exporting data to excel -->
<script type="text/javascript">

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
            { header: 'Nama Pegawai', key: 'nama_pegawai', width: 32 },
            { header: 'Nama Jabatan', key: 'nama_jabatan', width: 10 },
            { header: 'Terlambat', key: 'tanggal', width: 10 },
            { header: 'Jam Mulai', key: 'jam_mulai', width: 10 },
            { header: 'Jam Selesai', key: 'jam_selesai', width: 10 },
            { header: 'Jam Lembur', key: 'jam_lembur', width: 10 },
            { header: 'Tugas', key: 'tugas', width: 10 },
        ];

        sheet.insertRow(1, ['Data Rekap Lembur Pegawai SEAMEO QITEP in Language']);
        sheet.insertRow(2, ['Periode ' + `${start_date} s.d ${end_date}`]);

        items.map((item, index) => {
            sheet.addRow({no: index + 1, ...item});
        });
            
        return workbook.xlsx.writeBuffer();
    }

    document.getElementById('download-button').addEventListener('click', function(){
        fetch('/lembur/export', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(async result => {
            let data = result.data.map((item) => {
                let lembur =  item;
                lembur.nama_pegawai = item.user.nama_pegawai;
                lembur.nama_jabatan = item.user.jabatan.nama_jabatan;
                delete(lembur.user);
                return lembur;
            })

            console.log(data);

            let buffer = await downloadExcelData(data, result.start_date, result.end_date);
            let blob = new Blob(
                [buffer], 
                {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,"}
            );
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = 'export-rekap-lembur-pegawai-' + filename + ".xlsx";
            link.click();
        })
    });
</script>

<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>

<script>
    $('#example2').DataTable({
        "responsive": true,
    });
</script>
@endpush