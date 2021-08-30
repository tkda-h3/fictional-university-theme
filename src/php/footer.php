<footer class="site-footer">
    <div class="site-footer__inner container container--narrow">

        <div class="group">

            <div class="site-footer__col-one">
                <h1 class="school-logo-text school-logo-text--alt-color"><a href="<?php echo site_url(); ?>"><strong>教養大学</strong> </a></h1>
                <p><a class="site-footer__link" href="#">555.555.5555</a></p>
            </div>

            <div class="site-footer__col-two-three-group">
                <div class="site-footer__col-two">
                    <h3 class="headline headline--small">コンテンツ</h3>
                    <nav class="nav-list">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footerLocationTwo',
                        ));
                        ?>
                    </nav>
                </div>

                <div class="site-footer__col-three">
                    <h3 class="headline headline--small">その他</h3>
                    <nav class="nav-list">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footerLocationOne',
                        ));
                        ?>
                    </nav>
                </div>
            </div>

            <div class="site-footer__col-four">
                <h3 class="headline headline--small">SNS</h3>
                <nav>
                    <ul class="min-list social-icons-list group">
                        <li><a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>