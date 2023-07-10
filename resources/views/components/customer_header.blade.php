<nav class="navbar navbar-expand-lg bg-light px-4">
    <div class="container-fluid mb-2 mt-2">
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarTogglerDemo03"
        aria-controls="navbarTogglerDemo03"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="/">Gami</a>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mx-auto ">
          <li class="nav-item mx-auto">
            <a class="nav-link active" aria-current="page" href="/barang?sex%5B%5D=Laki-laki">Laki-laki</a>
          </li>
          <li class="nav-item mx-auto">
            <a class="nav-link active" aria-current="page" href="/barang?sex%5B%5D=Perempuan">Perempuan</a>
          </li>
          <li class="nav-item mx-auto">
            <a class="nav-link active" aria-current="page" href="/barang?sex%5B%5D=Unisex">Unisex</a>
          </li>
          <li class="nav-item mx-auto">
            <a class="nav-link active" aria-current="page" href="/chatbot">Chatbox</a>
          </li>
        </ul>
     
        <a href="/cart" class="cart-link me-3">
            <i class="fa" style="font-size:24px">&#xf07a;</i>
            <span class='badge badge-warning' id='lblCartCount'> {{session('cart_items') == null ? 0 : count(session('cart_items'))}} </span>
        </a>
        @if(Auth::check())
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#"
                  data-bs-toggle="dropdown"
                  class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                  <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                  <a href="/user/profile"
                      class="dropdown-item has-icon">
                      <i class="far fa-user"></i> Profile
                  </a>
                  <a href="/user/invoices"
                      class="dropdown-item has-icon">
                      <i class="fas fa-bolt"></i> Activities
                  </a>
                  <a href="features-settings.html"
                      class="dropdown-item has-icon">
                      <i class="fas fa-cog"></i> Settings
                  </a>
                  <div class="dropdown-divider"></div>
                  {{-- <a href="#"
                      class="dropdown-item has-icon text-danger">
                       Logout
                  </a> --}}
                  <form class="m-0 p-0" method="POST" action="{{ route('logout') }}">
                      @csrf
                      <x-dropdown-link class="dropdown-item has-icon text-danger" :href="route('logout')" onclick="event.preventDefault();
                                          this.closest('form').submit();">
                          <i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}
                      </x-dropdown-link>
                  </form>
              </div>
          </li>
      </ul>
      @else
        <a href="/login" class=" d-flex btn btn-outline-dark" >
            Login
        </a>
      @endif
    </div>
  </nav>