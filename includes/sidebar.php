<div id="mySidebar" class="sidebar">
    <div class="logo">
        <a href="index.php"><i class='fa fa-wheelchair'></i><span>PWD<span>IS</span></span></a>
    </div>
    <a href="index.php"><i class='fa fa-home'></i> Home</a>
    <a href="view_uploaded_files.php"><i class="fa-solid fa-file"></i> Materials</a>
    <a href="top_rated_places.php"><i class="fas fa-map-marked-alt"></i> Popular Places</a>
    <a href="mapping.php"><i class="fas fa-map-marked-alt"></i> Map Accessibility</a>
    <a href="hotlines.php"> <i class="fa-solid fa-phone"></i> Emergency Hotlines</a>
    <a href="about-us.php"><i class="fas fa-info-circle"></i> About</a>
    <a href="messages.php"><i class="fa fa-comments"></i> Chats</a>

    <!-- User Profile Dropdown -->
    <div class="dropdown">
        <?php
        $avatarUrl = isset($_SESSION['avatar_url']) && !empty($_SESSION['avatar_url'])
            ? $_SESSION['avatar_url']
            : 'path/to/default/avatar.png';
        ?>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="User Avatar" class="user-avatar rounded-circle" width="30" height="30"> Profile
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">View Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
    </div>
</div>