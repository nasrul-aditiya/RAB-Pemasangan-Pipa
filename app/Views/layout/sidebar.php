<?php
$currentPath = $_SERVER['REQUEST_URI'];

function isActive($prefix, $currentPath)
{
    return strpos($currentPath, $prefix) === 0 ? 'active' : '';
}

function isParentActive($prefixes, $currentPath)
{
    foreach ($prefixes as $prefix) {
        if (strpos($currentPath, $prefix) === 0) {
            return 'active';
        }
    }
    return '';
}
?>

<aside id="sidebar" class="js-sidebar sticky-sidebar">
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo text-center">
            <img src="/img/logo.png" alt="logo" width="100" />
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item <?php echo isActive('/dashboard', $currentPath); ?>">
                <a href="/dashboard" class="sidebar-link">
                    <i class="fa-solid fa-house pe-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item <?php echo isParentActive(['/daftar-material', '/daftar-upah', '/daftar-rab'], $currentPath); ?>">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-chart-pie pe-2"></i>
                    Data Master
                </a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse <?php echo isParentActive(['/daftar-material', '/daftar-upah', '/daftar-rab'], $currentPath) ? 'show' : ''; ?>" data-bs-parent="#sidebar">
                    <li class="sidebar-item <?php echo isActive('/daftar-material', $currentPath); ?>">
                        <a href="/daftar-material" class="sidebar-link">Daftar Material</a>
                    </li>
                    <li class="sidebar-item <?php echo isActive('/daftar-upah', $currentPath); ?>">
                        <a href="/daftar-upah" class="sidebar-link">Daftar Upah</a>
                    </li>
                    <li class="sidebar-item <?php echo isActive('/daftar-rab', $currentPath); ?>">
                        <a href="/daftar-rab" class="sidebar-link">Daftar RAB</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item <?php echo isActive('/daftar-pekerjaan', $currentPath); ?>">
                <a href="/daftar-pekerjaan" class="sidebar-link">
                    <i class="fa-solid fa-envelope pe-2"></i>
                    RAP
                </a>
            </li>
            <?php if (isset($role) && $role == "Admin") : ?>
                <li class="sidebar-item <?php echo isActive('/kelola-pengguna', $currentPath); ?>">
                    <a href="/kelola-pengguna" class="sidebar-link">
                        <i class="fa-solid fa-users-gear pe-2"></i>
                        Kelola Pengguna
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</aside>