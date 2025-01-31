<?php
include_once 'functions/user.php';

$userData = null;

// Check if session ID exists
if (isset($_SESSION['id_user'])) {
    // Call the function to get user data
    $userData = getUserDetails($conn, $_SESSION['id_user']);

    // Check if user data was returned
    if ($userData !== null) {
        // Access user data safely
        $userName = $userData['nama_lengkap'];
    } else {
        // Handle the case where no data was found
        $userName = 'Guest'; // Or any fallback value
    }
} else {
    // If session ID does not exist, handle accordingly
    $userName = 'Guest'; // Or any fallback value
}
?>

<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
                <li>
                    <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                        <i data-feather="align-justify"></i>
                    </a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav navbar-right">
            <!-- toggle -->
            
            
            <!-- user profile -->
            <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user" style="padding-top: 8px">
                <i data-feather="user">
                    <span class="d-sm-none d-lg-inline-block"></span>
                </i>
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
                <!-- Check if user data exists before accessing it -->
                <?php if ($userData): ?>
                        <div class="dropdown-title">Hello, <?php echo htmlspecialchars($userData['nama_lengkap']); ?></div>
                    <?php else: ?>
                        <div class="dropdown-title">Hello, Guest</div>
                    <?php endif; ?>
                <a href="profile.php" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                
                <!-- Dark Mode Toggle -->
                <div class="dropdown-item settingSidebar-body ps-container ps-theme-default">
                    <div class="selectgroup layout-color">
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                            <span class="selectgroup-button">Light</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                            <span class="selectgroup-button">Dark</span>
                        </label>
                    </div>
                </div>

                <div class="dropdown-divider"></div>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?logout=true" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
        </ul>
      </nav>