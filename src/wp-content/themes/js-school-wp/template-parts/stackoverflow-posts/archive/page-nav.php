<nav class="navbar navbar-expand-lg text-bg-dark border-bottom">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img 
                src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/content/stack-exchange_logo.png"
                width="150" height="50" 
            >
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown1" aria-controls="navbarNavDropdown1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown1">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li><a href="#" class="nav-link px-3 fs-4 link-secondary"><i class="bi bi-inbox-fill"></i></a></li>
                <li><a href="#" class="nav-link px-3 fs-4 link-secondary"><i class="bi bi-bar-chart-line-fill"></i></a></li>
            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0 me-2">
                <li><a href="#" class="nav-link px-2 link-light">sign up</a></li>
                <li><a href="#" class="nav-link px-2 link-light">login</a></li>
                <li><a href="#" class="nav-link px-2 link-light">tour</a></li>
                <li><a href="#" class="nav-link px-2 link-light">help</a></li>
            </ul>

            <form class="d-flex" role="search">
                <input type="search" class="form-control me-2" placeholder="Search Q&A" aria-label="Search">
            </form>
        </div>
    </div>
</nav>
