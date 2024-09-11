<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">

    <a class="navbar-brand" href="index.php">
      <img src="images/logo1.png" height="50" width="100" style="border-radius:10px; " alt="Logo">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about-us.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapping.php">Mapping</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact-us.php">Contact us</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-2x"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right w-100" aria-labelledby="userProfileDropdown">
            <a class="dropdown-item" href="#">Hi, <?php echo $_SESSION['user'] ?></a>
            <a class="dropdown-item" href="#">Change Password</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </div>

  </div>
</nav>