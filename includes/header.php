<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<nav class="navbar navbar-expand-lg custom-navbar shadow-sm py-3">
  <div class="container">
    <div class="header-logo">
        <a href="index.php" class="navbar-brand"><i class='fa fa-wheelchair custom-wheelchair blue-icon'></i>PWDIS</a>   
    </div>

    <!-- Toggler for mobile view -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">&#9776;</span>
    </button>

    <!-- Navbar links and Search Form -->
    <div class="collapse navbar-collapse" id="navbarResponsive">
       <!-- Search Form (appears on mobile within the collapsible menu) -->
      <form class="form-inline d-lg-none mt-3" name="search" action="search.php" method="post">
          <div class="input-group w-100">
            <input type="text" name="searchtitle" class="form-control" placeholder="Search for..." required>
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit">Go!</button>
            </div>
          </div>
      </form>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">
            <i class="fas fa-home"></i> Home <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="top_rated_places.php">
            <i class="fas fa-map-marked-alt"></i> Popular Places
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapping.php">
            <i class="fas fa-map-marked-alt"></i> Map Accessibility
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about-us.php">
            <i class="fas fa-info-circle"></i> About
          </a>
        </li>
        <li class="nav-item">
          <a href="messages.php" class="nav-link"> <i class="fa fa-comments"></i> Chats</a>
        </li>

        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
              $avatarUrl = isset($_SESSION['avatar_url']) && !empty($_SESSION['avatar_url']) 
                          ? $_SESSION['avatar_url'] 
                          : 'path/to/default/avatar.png';
          ?>
          <img src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="User Avatar" class="user-avatar rounded-circle" width="30" height="30">
          </a>
          <div class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userProfileDropdown">
            <a class="dropdown-item text-center font-weight-bold" href="#">Hi, <?php echo $_SESSION['name'] . " " . $_SESSION['lname'] ?></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="profile.php">View Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>

    
    </div>
  </div>
</nav>
