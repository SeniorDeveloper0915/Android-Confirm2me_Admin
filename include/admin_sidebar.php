<li class="nav-item start <?php if((strpos($url, 'dashboard') != false)) echo 'active open'; ?>">
    <a href="dashboard.php" class="nav-link nav-toggle">
        <i class="icon-bar-chart"></i>
        <span class="title">Dashboard</span>
        <span class="selected"></span>
    </a>
</li>

<li class="nav-item <?php if((strpos($url, 'users') != false)) echo 'active';?> ">
    <a href="users.php" class="nav-link ">
        <i class="icon-users"></i>
        <span class="title">Users</span>
    </a>
</li>

<li class="nav-item <?php if((strpos($url, 'requests') != false)) echo 'active';?> ">
    <a href="requests.php" class="nav-link ">
        <i class="icon-check"></i>
        <span class="title">Request</span>
    </a>
</li>

<li class="nav-item <?php if((strpos($url, 'affidavits') != false)) echo 'active';?> ">
    <a href="affidavits.php" class="nav-link ">
        <i class="icon-envelope"></i>
        <span class="title">Affidavit </span>
    </a>
</li>