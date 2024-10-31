@extends('layouts.guest')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
      <form method="POST" action="{{ route('register') }}" class="my-5">
        @csrf
        <div class="border rounded-2 p-4 mt-5">
          <div class="login-form">
            <a href="index.html" class="mb-4 d-flex justify-content-center">
              <img src="{{ asset('assets/images/mbkm.png') }}" class="logo img-fluid" alt="Logo" />
            </a>
            <h5 class="fw-light mb-5 text-center">Buat Akun Anda</h5>

            {{-- Input NIM (untuk pengecekan saja) --}}
            <div class="mb-3">
              <label class="form-label" for="nim">NIM Anda</label>
              <input type="text" name="nim" id="nim" class="form-control" placeholder="Masukkan NIM Anda"
                value="{{ old('nim') }}" />
              @error('nim')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            {{-- Checkbox untuk menggunakan email SIAKAD --}}
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="use_siakad_email" name="use_siakad_email" value="1">
              <label class="form-check-label" for="use_siakad_email">
                Gunakan email Anda yang terdaftar di SIAKAD?
              </label>
            </div>

            {{-- Input untuk email baru, hanya muncul jika checkbox tidak dicentang --}}
            <div class="mb-3" id="new_email_input">
              <label class="form-label">Email Anda</label>
              <input type="email" name="new_email" id="new_email" class="form-control"
                placeholder="Masukkan email baru Anda" />
              @error('new_email')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>


            {{-- Input Password --}}
            <div class="mb-3">
              <label class="form-label">Kata Sandi Anda</label>
              <input type="password" name="password" id="password" class="form-control"
                placeholder="Masukkan kata sandi" />
              @error('password')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="mb-3">
              <label class="form-label">Konfirmasi Kata Sandi</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                placeholder="Ulangi kata sandi" />
            </div>

            <div class="d-flex align-items-center justify-content-between">
              <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" id="termsConditions" name="termsConditions" />
                <label class="form-check-label" for="termsConditions">
                  Saya setuju dengan <a href="#" class="text-blue text-decoration-underline">Syarat & Ketentuan</a>
                </label>
              </div>
            </div>

            <div class="d-grid py-3 mt-4">
              <button type="submit" class="btn btn-lg btn-primary">Daftar</button>
            </div>

            <div class="text-center pt-4">
              <span>Sudah punya akun?</span>
              <a href="login.html" class="text-blue text-decoration-underline ms-2">Masuk</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- JavaScript untuk menampilkan/menghilangkan input email baru --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
        const useSiakadEmailCheckbox = document.getElementById('use_siakad_email');
        const newEmailInput = document.getElementById('new_email_input');

        useSiakadEmailCheckbox.addEventListener('change', function () {
            newEmailInput.style.display = this.checked ? 'none' : 'block';
        });

        // Cek kondisi awal jika pengguna menekan tombol back pada browser
        if (useSiakadEmailCheckbox.checked) {
            newEmailInput.style.display = 'none';
        }
    });
</script>
@endsection