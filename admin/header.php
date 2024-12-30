<header>
    <div class="admin-profile">
        <img src="../admin_pic/nurse.png" alt="">
        <p><strong style="text-transform:capitalize;"><?php  echo $_SESSION['admin_position']?> | </strong> <?php echo $_SESSION['admin_name'] ?></p>
    
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-expand" id="fullscreen-btn" title="Expand"></i>
        <i class="fa-regular fa-bell"></i>
    </div>
</header>


<script>
    const fullscreenBtn = document.getElementById('fullscreen-btn');

    fullscreenBtn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            // Enter fullscreen mode
            document.documentElement.requestFullscreen().then(() => {
                fullscreenBtn.classList.remove('fa-expand');
                fullscreenBtn.classList.add('fa-compress');
                fullscreenBtn.setAttribute('title', 'Compress');
            }).catch(err => {
                console.error(`Error attempting to enable fullscreen: ${err.message}`);
            });
        } else {
            // Exit fullscreen mode
            document.exitFullscreen().then(() => {
                fullscreenBtn.classList.remove('fa-compress');
                fullscreenBtn.classList.add('fa-expand');
                fullscreenBtn.setAttribute('title', 'Expand');
            }).catch(err => {
                console.error(`Error attempting to exit fullscreen: ${err.message}`);
            });
        }
    });
</script>



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


    .icon-container{
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
        /* Position tooltip directly below the icon */
        left: 50%;
        /* Center-align tooltip horizontally */
        transform: translateX(-50%);
        /* Adjust for perfect centering */
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
    }

    .admin-profile img {
        width: 25px;
        height: 25px;
        border-radius: 50%;
    }
</style>