<?php $args = array(
    'theme_location'    => 'primary',
    'menu_class'        => 'navbar-nav',
    'container'      => false,
); ?>
<header class="site-header">
    <nav class="navbar">
        <?php wp_nav_menu( $args ); ?>
    </nav>
</header>
