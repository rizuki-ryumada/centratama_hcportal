<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #0984e3">

    <!-- Sidebar - Brand -->
    <!-- Sidebar - Brand -->
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
			<!-- <div class="sidebar-brand-icon rotate-n-15">
				<i class="fab fa-contao"></i>
			</div> -->
			<div class="sidebar-brand-icon">
				<img src="<?= base_url('assets'); ?>/img/logo3.png" alt="" width="40px">
			</div>
			<div class="sidebar-brand-text mt-2 ml-1"><img src="<?= base_url('assets'); ?>/img/logo2.png" alt="" width="130px"> </div>
		</a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php
    $role_id = $this->session->userdata('role_id');
    $queryMenu = "SELECT `user_menu`.`id`,`menu`,`target`, `icon`
                    FROM `user_menu` JOIN `user_access_menu` 
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                    WHERE `user_access_menu`.`role_id` = $role_id 
                    ORDER BY `user_access_menu`.`menu_id` ASC
                    ";
    $menu = $this->db->query($queryMenu)->result_array();
    ?>

    <!-- Looping Menu -->
    <?php foreach ($menu as $m) : ?>
    <li class="nav-item">
        <!-- <div class="sidebar-heading">

        </div> -->
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="<?= $m['target']; ?>"
            aria-expanded="true" aria-controls="<?= preg_replace("/[^a-zA-Z]/", "", $m['target']); ?>">
            <i class="fas <?= $m['icon']; ?>"></i>
            <span><?= $m['menu']; ?></span>
        </a>
        <div id="<?= preg_replace("/[^a-zA-Z]/", "", $m['target']); ?>" class="collapse <?= $this->uri->segment(1) == strtolower($m['menu'])? 'show' : '';?>" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- Sisipkan Submenu -->
            <?php
                $menuId = $m['id'];
                $querySubMenu = "SELECT *
                        FROM `user_sub_menu` JOIN `user_menu`
                        ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                        WHERE `user_sub_menu`.`menu_id` = $menuId
                        AND `user_sub_menu`.`is_active` = 1
                        ";
                $subMenu = $this->db->query($querySubMenu)->result_array();
            ?>

                <!-- Nav Item - Dashboard -->
                <?php foreach ($subMenu as $sm) : ?>
                <?php if ($title == $sm['title']) : ?>
                <a class="collapse-item active" href="<?= base_url($sm['url']); ?>">
                    <?php else : ?>
                    <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                        <?php endif; ?>
                        <?= $sm['title']; ?>
                    </a>

    <?php endforeach; ?>
            </div>
        </div>

    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider mb-n2 mt-n2"> -->

    <?php endforeach; ?>
    <li class="nav-item">
        <a class="nav-link logout" href="<?= base_url('auth/logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->