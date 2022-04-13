<?php
$where = array(
    'id_user' => $this->session->userdata('id_user'),
);

$session = $this->db->get_where('tbl_user', $where)->row();
?>

<div class="wrapper">
    <header class="main-header">
        <a href="" class="logo">
            <span class="logo-mini"><b>CA</b></span>
            <span class="logo-lg"><b>C-Archive</b></span>
        </a>

        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu" align="center">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div style="font-size: 18px; font-family: arial; color:#FFF;" id="jam"> </div>
                        </a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url(); ?><?php echo $session->file_gambar; ?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?php echo $session->nama; ?></span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-header">
                                <img src="<?php echo base_url(); ?><?php echo $session->file_gambar; ?>" class="img-circle" alt="User Image">

                                <p>
                                    <?php echo $session->nama; ?>
                                </p>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo base_url('menu/SettingsProfile') ?>" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url('Auth/logout') ?>" class="btn btn-default btn-flat logout">Log out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown notifications-menu" align="center">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ico"></i>
                            <span class="hidden-xs"><i class="ping">&nbsp;</i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Speed Test Internet</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <br>
                                    <li>
                                        <p align="center" style="font-size:20px;">
                                            <i class="ic"></i> <i class="ping">&nbsp;</i>
                                        </p>
                                    </li>
                                    <br>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>