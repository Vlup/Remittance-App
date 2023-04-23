<nav class="navbar navbar-expand-lg bg-danger navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/">Transaction App</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav"> 
          <a class="nav-link {{ request()->segment(1) == '' ? 'active' : ''}}" href="/">Home</a>
          <a class="nav-link {{ request()->segment(1) == 'profile' ? 'active' : ''}}" href="/profile">Profile</a>
          <a class="nav-link {{ request()->segment(1) == 'voucher' ? 'active' : ''}}" href="/voucher">Voucher</a>
          <a class="nav-link {{ request()->segment(1) == 'history' ? 'active' : ''}}" href="/history">History</a>
          <form action="/logout" method="post" class="px-4">
            @csrf
            <button type="submit" class="nav-link border-0 btn btn-danger">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </nav>