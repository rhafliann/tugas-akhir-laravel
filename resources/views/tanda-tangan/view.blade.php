@extends('adminlte::page')

@section('title', 'Detail User - Tanda Tangan')

@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark"> Profile : {{$user->nama_pegawai}}</h1>
@stop

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body">
      <h4>Tanda tangan</h4>

      <div class="row">
        <div class="col-6 mx-auto">
          <canvas width="400" height="400" id="signature-profile"></canvas>
        </div>
      </div>
      <button type="button" id="clear-button" class="btn btn-danger">Hapus</button>

      <button type="button" id="save-button" class="btn btn-primary"  data-editmode=<?= $tandaTangan ? 'true': 'false' ?>>
        <?= $tandaTangan ? 'Ubah': 'Simpan' ?>
      </button>

    </div>
  </div>
</div>
@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script type="text/javascript" defer>  
  function canvasToImage(data, filename, mime){
    return fetch(data)
    .then(res => res.arrayBuffer())
    .then(buffer => new File([buffer], filename, { type: mime }))
  }

  document.addEventListener('DOMContentLoaded', (event) => {
    const canvasSignature = document.getElementById('signature-profile');
    const clearButton = document.getElementById('clear-button');
    const saveButton  = document.getElementById('save-button');
    let signatureImage = "{{$tandaTangan ? $tandaTangan->image  :''}}";
    const route = signatureImage != '' ?   
    "{{ route('tanda-tangan.update', $user->id_users)  }}":
    "{{ route('tanda-tangan.store', $user->id_users) }}";

    let signaturePad  = new SignaturePad(canvasSignature);
    const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;
    
    if(signatureImage != ''){
      fetch(signatureImage)
      .then(res => res.blob())
      .then(blob => {
        signaturePad.clear();
        signaturePad.fromDataURL(URL.createObjectURL(blob));
      }).catch(err => {
        console.error('error fetching signature', JSON.stringify(err, null, 2));
      })
    }

    saveButton.addEventListener('click', () => {
      canvasToImage(
        signaturePad.toDataURL('image/png'), 
        "{{Date::now()->format('Ymdhis')}}.png", 
        "image/png"
      ).then(file => {
        
        let form = new FormData();
        form.append('image', file);
        form.append('id_users', "{{$user->id_users}}");

        for (const iterator of form.entries()) {
          console.log(iterator[0], iterator[1]);
        }

        fetch(route, {  
          method: 'POST',
          body: form,
          headers: {
              "X-Requested-With": "XMLHttpRequest",
              "X-CSRF-Token": csrfToken,
          },
          credentials: "same-origin"
        })
        .then(res => res.json())
        .then(json => {
          Swal.fire({
            icon: json?.type || "error",
            title: json?.message || "Error",
            text: json?.message
          });
        })
      })
    })

    clearButton.addEventListener('click', () => {
      signaturePad.clear();
    });

    window.addEventListener('resize', () => {
      const ratio =  Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext("2d").scale(ratio, ratio);
      signaturePad.clear();
    });
  });
</script>
@endpush