<header class="navbar sticky-top bg-light flex-md-nowrap p-0 shadow" style="height: 60px;" data-bs-theme="dark">
    <a href="#" class="navbar-brand bg-success col-md-3 col-lg-2 me-0 px-3 fs-4 text-white" style="height: 100%;">
    BelteiTour Manage
    </a>
    <!-- Icon mail and notification and select English and Khmer -->
    <div class="ms-auto me-3">
      <ul class="navbar-nav flex-row">
        <li class="nav-item me-3">
          <a href="#" class="nav-link text-black">
            <i class="fas fa-envelope fa-lg"></i>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-black">
            <i class="fas fa-bell fa-lg"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="dropdown me-3">
      <label for="languageSelect" class="visually-hidden">Language</label>
      <select class="form-select" id="languageSelect">

        <option value="English">English</option>
        <option value="Khmer">Khmer</option>
      </select>
    </div>
    <div class="profile-picture me-3">
    <img src="http://127.0.0.1:8000/User/profile_1.jpeg" class="rounded-circle" style="width: 40px; height: 40px;">
  </div>
    <div class="me-1"></div>
    <ul class="navbar-nav flex-row d-md-none">
      <li class="nav-item text-nowrap">
        <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
          <svg class="bi-a">
            <use xlink:href="#search"></use>
          </svg>
        </button>
      </li>
      <li class="nav-item text-nowrap">
        <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <svg class="bi-a">
            <use xlink:href="#list"></use>
          </svg>
        </button>
      </li>
    </ul>
    <div id="navbarSearch" class="navbar-search w-100 collapse">
      <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
    </div>
  </header>