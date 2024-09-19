<nav class="navbar navbar-expand-lg custom-navbar shadow-sm py-3">
  <div class="container">
    <div class="header-logo">
        <a href="index.php" class="navbar-brand"><i class='fa fa-wheelchair'></i><span>PWD<span>IS</span></span></a>   
     </div>


    <!-- Toggler for mobile view -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">
            <i class="fas fa-home"></i> Home <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about-us.php">
            <i class="fas fa-info-circle"></i> About
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapping.php">
            <i class="fas fa-map-marked-alt"></i> Map Accessibility
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact-us.php">
            <i class="fas fa-envelope"></i> Contact Us
          </a>
        </li>
        <li class="nav-item">
          <a href="messages.php" class="nav-link"> <i class="fa fa-comments"></i> Chats</a>
        </li>
        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="uploads/default_avatar.jpg" class="rounded-circle" alt="Profile Picture" width="30" height="30">
          </a>

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