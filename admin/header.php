<header>
    <div class="admin-profile">
        <i class="fa-solid fa-left-right" id="toggle-sidebar-btn" title="Toggle Sidebar"></i>
        <img src="../admin_pic/<?php echo $_SESSION['admin_pic']; ?>" alt="">
        <p><strong style="text-transform:capitalize;"><?php echo $_SESSION['admin_position'] ?> | </strong><?php echo $_SESSION['admin_name'] ?></p>
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-circle-half-stroke" id="dark-mode-btn" title="Change mode"></i>
        <i class="fa-solid fa-expand" id="fullscreen-btn" title="Expand"></i>
    </div>
</header>


<script>
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const darkModeBtn = document.getElementById('dark-mode-btn');
    const toggleSidebarBtn = document.getElementById('toggle-sidebar-btn');
    const sidebar = document.getElementById('sidebar');

    fullscreenBtn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().then(() => {
                fullscreenBtn.classList.remove('fa-expand');
                fullscreenBtn.classList.add('fa-compress');
                fullscreenBtn.setAttribute('title', 'Compress');
                localStorage.setItem('fullscreen', 'enabled');
            }).catch(err => {
                console.error(`Error attempting to enable fullscreen: ${err.message}`);
            });
        } else {
            document.exitFullscreen().then(() => {
                fullscreenBtn.classList.remove('fa-compress');
                fullscreenBtn.classList.add('fa-expand');
                fullscreenBtn.setAttribute('title', 'Expand');
                localStorage.setItem('fullscreen', 'disabled');
            }).catch(err => {
                console.error(`Error attempting to exit fullscreen: ${err.message}`);
            });
        }
    });

    darkModeBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
    });

    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
    }

    toggleSidebarBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebarState', sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded');
    });

    if (localStorage.getItem('sidebarState') === 'collapsed') {
        sidebar.classList.add('collapsed');
    }

    if (localStorage.getItem('fullscreen') === 'enabled') {
        document.documentElement.requestFullscreen();
        fullscreenBtn.classList.remove('fa-expand');
        fullscreenBtn.classList.add('fa-compress');
        fullscreenBtn.setAttribute('title', 'Compress');
    }
</script>

<style>
    .collapsed {
        width: 55px;
        overflow: hidden;
        transition: ease-in-out 0.3s;
    }
</style>

<style>
    header {
        display: flex;
        padding: 10px;
        background-color: var(--color4);
        justify-content: space-between;
        font-size: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        align-items: center;
    }

    .icon-container {
        display: flex;
        gap: 20px;
        margin-right: 20px;
    }

    header i {
        position: relative;
        cursor: pointer;
    }

    header i:hover::after {
        content: attr(title);
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--color4);
        color: var(--text-color2);
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        white-space: nowrap;
        z-index: 10;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .admin-profile {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 0;
        color: var(--text-color)
    }

    .admin-profile img {
        width: 25px;
        height: 25px;
        border-radius: 50%;
    }

    .icon-container i {
        color: var(--text-color);
    }
</style>