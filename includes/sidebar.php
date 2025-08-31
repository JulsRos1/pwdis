<div id="mySidebar" class="sidebar">
    <div class="logo">
        <a href="dashboard.php">
            <img src="images/pwdislogo.png" alt="pwdislogo">
        </a>
    </div>
    <a href="dashboard.php"><i class='fa fa-home'></i> Dashboard</a>
    <a href="mapping.php"><i class="fas fa-map-marked-alt"></i> Map Accessibility</a>
    <a href="top_rated_places.php"><i class="fa-solid fa-ranking-star"></i> Top Rated Places</a>
    <a href="view_laws_rights.php"><i class="fa-solid fa-file"></i> Disability Laws and Rights</a>
    <a href="hotlines.php"> <i class="fa-solid fa-phone"></i> Emergency Hotlines</a>
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