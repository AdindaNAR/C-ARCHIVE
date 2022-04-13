<?php
$where = array(
    'id_user' => $this->session->userdata('id_user'),
);

$session = $this->db->get_where('tbl_user', $where)->row();
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <?php
            $id_role = $session->id_role;
            $queryMenu = "SELECT tbl_menu.id_menu, nama_menu
                    FROM tbl_menu
                    JOIN tbl_user_access_menu
                    ON tbl_menu.id_menu = tbl_user_access_menu.id_menu
                    WHERE tbl_user_access_menu.id_role = $id_role
                    ORDER BY tbl_user_access_menu.id_menu ASC
                ";
            $menu = $this->db->query($queryMenu)->result_array();

            ?>

            <?php foreach ($menu as $m) : ?>
                <li class="header">
                    <?php echo $m['nama_menu'] ?>
                </li>

                <!-- Siapkan Sub Menu sesuai Menu -->
                <?php
                $menuId = $m['id_menu'];
                $querySubMenu = "SELECT *
                    FROM tbl_sub_menu
                    JOIN tbl_menu
                    ON  tbl_sub_menu.id_menu = tbl_menu.id_menu
                    WHERE tbl_sub_menu.id_menu = $menuId
                    AND tbl_sub_menu.status = 1
                    ";

                $subMenu = $this->db->query($querySubMenu)->result_array();
                ?>

                <?php foreach ($subMenu as $sm) : ?>
                    <li>
                        <a href="<?php echo base_url($sm['url']); ?>">
                            <i class="<?php echo $sm['icon']; ?>"></i> <span><?php echo $sm['nama']; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>

            <?php endforeach; ?>

        </ul>
    </section>
</aside>