<nav class="navbar navbar-expand px-3 border-bottom">
    <button class="btn" id="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse navbar">
        <ul class="navbar-nav">
            <!-- <li>
                <a href="#" class="notif float-end me-3 mt-1">
                    <i class="fa-regular fa-bell"></i>
                    <span class="count">12</span>
                </a>

            </li> -->
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                    <?php
                    $avatar = session()->get('avatar') ? session()->get('avatar') : 'profil.png';
                    ?>
                    <img src="/uploads/avatars/<?= esc($avatar); ?>" class="avatar img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;" alt="avatar" />
                    <?php if (isset($nama)) : ?>
                        <span><?= esc($nama) ?></span>
                    <?php endif; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="\kelola-akun" class="dropdown-item">Kelola Akun</a>
                    <a href="\logout" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>