<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @vite(['resources/css/survey.css', 'resources/js/app.js'])
</head>
<body class="position-relative">
    <div class="survey">
        <h3 class="text-center">Survey Kepuasan Pelanggan.</h3>
        <h5 class="text-center">Restaurant X</h5>
        <br><br>
        <div class="mb-4">
            <label for="kebersihan" class="form-label">Bagaimana pendapat anda tentang kebsersihan di restaurant X ?</label>
            <textarea class="form-control" id="kebersihan" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label for="variasi-menu" class="form-label">Bagaimana pendapat anda tentang variasi menu di restaurant X ?</label>
            <textarea class="form-control" id="variasi-menu" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label for="promo" class="form-label">Promo apa yang paling menarik menurut anda di restaurant X ?</label>
            <textarea class="form-control" id="promo" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label for="kecepatan" class="form-label">Seberapa cepat pelayanan / serving di restaurant X ?</label>
            <textarea class="form-control" id="kecepatan" rows="3"></textarea>
        </div>
        <div class="mb-5">
            <div class="row">
                <div class="col">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="nama lengkap anda">
                </div>
                <div class="col">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="email">
                </div>
            </div>
        </div>
        <div class="text-center" id="notifikasi">
            <button class="btn btn-primary btn-lg" id="simpan-hasil">Simpan</button>
        </div>
    </div>
    <div class="position-absolute bottom-0 end-0 p-3">
        <div id="toastBerhasil" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Terima kasih</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Pendapat anda sangat berharga.
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 end-0 p-3">
        <div id="toastGagal" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Maaf, gagal</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Sedang terjadi kendala jaringan, coba lagi nanti !
            </div>
        </div>
    </div>
    
    @vite(['node_modules/bootstrap/dist/js/bootstrap.min.js'])
     <script type="text/javascript">
   
        const url = window.location.href
        const btnSimpan = document.querySelector('#simpan-hasil')
        const notifikasi = document.querySelector('#notifikasi')

        btnSimpan.addEventListener('click', ()=>{
            sendAjax(url, { 
                kebersihan  : document.querySelector('#kebersihan').value,
                variasi_menu: document.querySelector('#variasi-menu').value,
                promo       : document.querySelector('#promo').value,
                kecepatan   : document.querySelector('#kecepatan').value,
                nama        : document.querySelector('#nama').value,
                email       : document.querySelector('#email').value
		    })
        })

        async function sendAjax(url = '', data = {}) {
            const response = await fetch(url, {
                method  : 'POST',
                headers : {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector(`meta[name="csrf-token"]`).content
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    resetForm()
                    const toastLiveGagal = document.getElementById('toastGagal')
                    
                    const toastGagal = new bootstrap.Toast(toastLiveGagal)
                    toastGagal.show()
                    throw new Error('Sedang terjadi kendala jaringan, coba lagi nanti !')
                    
                }else{
                    resetForm()
                    const toastLiveBerhasil = document.getElementById('toastBerhasil')
                    
                    const toastBerhasil = new bootstrap.Toast(toastLiveBerhasil)
                    toastBerhasil.show()
                }
            })
        }

        const resetForm = ()=>{
            btnSimpan.disabled = true
    
            setTimeout(()=>{        
                btnSimpan.disabled = false
            }, '5500') // because 5000 is default of toast, it should greater than 5000

            toastBerhasil.addEventListener('hidden.bs.toast', () => {
                btnSimpan.disabled = false
            })
            toastGagal.addEventListener('hidden.bs.toast', () => {
                btnSimpan.disabled = false
            })

            document.querySelector('#kebersihan').value     = null
            document.querySelector('#variasi-menu').value   = null
            document.querySelector('#promo').value          = null
            document.querySelector('#kecepatan').value      = null
            document.querySelector('#nama').value           = null
            document.querySelector('#email').value          = null
            // return response
        }
    </script>
</body>
</html>