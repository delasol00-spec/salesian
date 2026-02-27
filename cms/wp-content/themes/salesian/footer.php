<!-- =======================================
     FOOTER
     静的HTML受領後にここに <footer> コードを移植する
     ======================================= -->
<footer id="site-footer">
    <nav>
        <?php
        wp_nav_menu( [
            'theme_location' => 'footer',
            'container'      => false,
            'fallback_cb'    => false,
        ] );
        ?>
    </nav>
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>
</footer>
<!-- /FOOTER -->

<?php wp_footer(); ?>
</body>
</html>
