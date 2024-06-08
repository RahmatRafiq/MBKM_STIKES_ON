<div class="navbar bg-base-100 flex justify-between">
  <div class="flex-1">
    <a class="btn btn-ghost text-xl">STIKES MBKM</a>
  </div>
  <div class="flex-none">
    <a href="{{ route('guest.dashboard') }}" class="btn btn-ghost">Beranda</a>
    <a href="{{ route('guest.program') }}" class="btn btn-ghost">Program</a>
    <a href="{{ route('guest.pengumuman') }}" class="btn btn-ghost">Pengumuman</a>
    @guest()
      <!-- You can open the modal using ID.showModal() method -->
      <button class="btn btn-primary rounded-full" onclick="login_modal.showModal()" id="login">Login</button>
      <dialog id="login_modal" class="modal">
        <div class="modal-box">
          <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
          </form>
          <h3 class="font-bold text-lg">Login</h3>
          <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-control">
              <label class="label">
                <span class="label-text
                    @error('email') text-error @enderror">Email</span>
              </label>
              <input type="email" name="email" placeholder="Email"
                class="input input-bordered
                @error('email') input-error @enderror">
              @error('email')
                <label class="label">
                  <span
                    class="label-text
                    @error('email') text-error @enderror">{{ $message }}</span>
                </label>
              @enderror
            </div>

            <div class="w-full">
              {{-- password --}}
              <label class="label">
                <span class="label-text
                    @error('password') text-error @enderror">Password</span>
              </label>

              {{-- <input type="password" name="password" placeholder="Password"
                class="input input-bordered
                @error('password') input-error @enderror"> --}}
              {{-- input with show and hide password --}}
              <div class="w-full flex join">
                <input type="password" name="password" id="password" placeholder="Password"
                  class="input input-bordered flex-1 join-item
                    @error('password') input-error @enderror">
                <button class="btn btn-square btn-primary join-item" type="button" id="password-toggle">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </button>

                @error('password')
                  <label class="label">
                    <span
                      class="label-text
                        @error('password') text-error @enderror">{{ $message }}</span>
                  </label>
                @enderror
              </div>
            </div>

            {{-- Tidak bisa login link --}}
            <div class="form-control mt-4">
              <a href="{{ route('guest.login-error') }}" class="text-primary">Tidak dapat login</a>
            </div>

            <div class="form-control mt-4 text-center">
              <button type="submit" class="btn btn-primary w-full max-w-80 mx-auto">Login</button>
              <span>
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary">Daftar</a>
              </span>
            </div>
          </form>
        </div>
      </dialog>
    @else
      <div class="dropdown dropdown-end">
        <div class="indicator">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
            <span class="indicator-item badge badge-success badge-xs -translate-x-2 translate-y-2"></span>
          </div>
        </div>
        <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
          <div class="card-body">
            <span class="font-bold text-lg">8 Items</span>
            <span class="text-info">Subtotal: $999</span>
            <div class="card-actions">
              <button class="btn btn-primary btn-block">View cart</button>
            </div>
          </div>
        </div>
      </div>
      <div class="hidden sm:dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img alt="Tailwind CSS Navbar component"
              src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
          </div>
        </div>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li>
          <a class="justify-between">
            Profile
            <span class="badge">New</span>
          </a>
        </li>
        <li><a>Settings</a></li>
        {{-- logout laravel --}}
        <li>
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-ghost">Logout</button>
          </form>
        </li>
      </ul>
    @endguest
  </div>
  <div class="drawer w-max drawer-end">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col items-center justify-center w-max">
      <!-- Page content here -->
      <label for="my-drawer-2" class="btn btn-ghost drawer-button lg:hidden">
        <i class="fa fa-bars fa-lg" aria-hidden="true"></i>
      </label>

    </div>
    <div class="drawer-side fixed z-50">
      <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
      <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
        {{-- close --}}
        <li class="ml-auto">
          <label for="my-drawer-2" class="btn btn-ghost drawer-button">
            <i class="fa fa-times fa-lg" aria-hidden="true"></i>
          </label>
        </li>
        <!-- Sidebar content here -->
        <li><a>Beranda</a></li>
        <li><a>Program</a></li>
        <li><a>Pengumuman</a></li>
        <li>
          <details>
            <summary class="flex justify-between">
              <div></div>
              <i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i>
            </summary>
            <ul>
              <li><a>Profil</a></li>
              <li><a>Aktifitas</a></li>
            </ul>
          </details>
        </li>
      </ul>

    </div>
  </div>
</div>
