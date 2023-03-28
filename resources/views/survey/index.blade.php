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
        <div class="mb-4">
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
        <div class="mb-3">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="card" id="captcha-container">
                        <!-- <img src="{{asset('assets/texture1.jpg')}}" id="image-captcha" height="50px" class="card-img-top" alt="..."> -->
                        <div class="card-body text-center">
                            <input type="captcha" class="form-control mb-1" id="captcha" placeholder="masukkan capthca">
                            <button class="btn btn-outline-primary btn-sm" id="tombol-refresh-captcha"> refresh </button>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
        <div class="text-center">
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
        <div id="toastNamaEmail" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Maaf, gagal</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Nama dan Email harus diisi !
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 end-0 p-3">
        <div id="toastCaptchaValid" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Maaf, gagal</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Captcha Salah, silahkan ulangi lagi  / refresh captcha !
            </div>
        </div>
    </div>
    
    @vite(['node_modules/bootstrap/dist/js/bootstrap.min.js'])
     <script type="text/javascript">
   
        const url           = window.location.href
        const urlCaptcha    = window.location.origin+'/get-captcha'
        const btnSimpan     = document.querySelector('#simpan-hasil')
        const btnRefresh    = document.querySelector('#tombol-refresh-captcha')

        let image           = null

        document.onreadystatechange = () => {
            if (document.readyState === "complete") {
                getCaptcha(urlCaptcha)
            }
        }


        btnSimpan.addEventListener('click', ()=>{
            if(document.querySelector('#nama').value == '' || document.querySelector('#email').value == ''){
                const toastNamaEmail = document.getElementById('toastNamaEmail')
                const toastNE = new bootstrap.Toast(toastNamaEmail)
                toastNE.show()
            }
            if(document.querySelector('#nama').value !== '' && document.querySelector('#email').value !== ''){
                sendAjax(url, { 
                    kebersihan  : document.querySelector('#kebersihan').value,
                    variasi_menu: document.querySelector('#variasi-menu').value,
                    promo       : document.querySelector('#promo').value,
                    kecepatan   : document.querySelector('#kecepatan').value,
                    nama        : document.querySelector('#nama').value,
                    email       : document.querySelector('#email').value,
                    file_name   : image,
                    captcha_value   : document.querySelector('#captcha').value
                })
            }
        })

        btnRefresh.addEventListener('click', ()=>{
            document.querySelector('#image-captcha').remove()
            getCaptcha(urlCaptcha)
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
                return response.json()
            }).then( res => {
                if(res.captcha_valid == 'False'){
                    const toastCaptcha = document.getElementById('toastCaptchaValid')
                    const toastCP = new bootstrap.Toast(toastCaptcha)
                    toastCP.show()
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

            document.querySelector('#kebersihan').value     = null
            document.querySelector('#variasi-menu').value   = null
            document.querySelector('#promo').value          = null
            document.querySelector('#kecepatan').value      = null
            document.querySelector('#nama').value           = null
            document.querySelector('#email').value          = null
            // return response
        }

        async function getCaptcha(url = '') {
            const response = await fetch(url, {
                method  : 'GET'
            })
            .then(response => {
                return response.json()
            })
            // .then(response => response.json())
            .then(res => {
                image = res.data

                let child = document.createElement("img")
                child.setAttribute("src", `{{asset('storage/captcha/${image}')}}`)
                child.setAttribute("id", "image-captcha")
                child.setAttribute("class", "card-img-top")
                document.querySelector('#captcha-container').prepend(child)
            })
        }
    </script>
</body>
</html>