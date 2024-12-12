<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">

          <ul class="nav col-12 col-lg-auto col-md-auto col-sm-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
          </ul>

          <div class="d-flex align-items-center">
            @auth
              {{ auth()->user()->first_name }}
              <div class="pl-2 text-end">
                <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
              </div>
            @endauth

            @guest
              <div class="text-end">
                <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
              </div>
            @endguest
          </div>
        </div>
      </div>
  </header>
