<?php
    //global $options;
    //$options['global'] = get_fields(g'options');
?>

<footer id="footer" aria-label="footer">
    <div class="footer-top container-lg">
        <div class="footer-logos">
            <?php $fayetteville_tech_seal = get_field( 'fayetteville_tech_seal', 'option' ); ?>
            <?php if ( $fayetteville_tech_seal ) { ?>
                <img class="fayettevilletech-seal" src="<?php echo $fayetteville_tech_seal['url']; ?>" alt="<?php echo $fayetteville_tech_seal['alt']; ?>" />
            <?php } ?>
        </div>
        <div class="footer-menus">
            <div class="footer-menu">
                <div class="footer-menu-heading">Resources</div>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'resources',
                    'depth' => 1,
                    'container' => '',
                    'menu_class' => 'nav-footer'
                ));
                ?>
            </div>
            <div class="footer-menu">
                <div class="footer-menu-heading">Campus Maps</div>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'campus-maps',
                    'depth' => 1,
                    'container' => '',
                    'menu_class' => 'nav-footer'
                ));
                ?>
            </div>
            <div class="footer-menu">
                <div class="footer-menu-heading">Other</div>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'other',
                    'depth' => 1,
                    'container' => '',
                    'menu_class' => 'nav-footer'
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="footer-bottom container-full">
        <div class="container-lg">
            <div class="copyright" role="contentinfo">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</div>
            <div class="footer-social-links">
                <ul class="social">
                    <?php if( get_field('facebook_url', 'option') ) : ?>
                        <li class="facebook">
                            <a href="<?php the_field('facebook_url', 'option'); ?>" title="Find us on Facebook" aria-label="Find us on Facebook"><span class="icon-facebook" aria-hidden="true"></span></a>
                        </li>
                    <?php endif; ?>
                    <?php if( get_field('instagram_url', 'option') ) : ?>
                        <li class="instagram">
                            <a href="<?php the_field('instagram_url', 'option'); ?>" title="Find us on Instagram" aria-label="Find us on Instagram"><span class="icon-instagram" aria-hidden="true"></span></a>
                        </li>
                    <?php endif; ?>
                    <?php if( get_field('twitter_url', 'option') ) : ?>
                        <li class="twitter">
                            <a href="<?php the_field('twitter_url', 'option'); ?>" title="Find us on Twitter" aria-label="Find us on Twitter"><span class="icon-twitter" aria-hidden="true"></span></a>
                        </li>
                    <?php endif; ?>
                    <?php if( get_field('youtube_url', 'option') ) : ?>
                        <li class="youtube">
                            <a href="<?php the_field('youtube_url', 'option'); ?>" title="Find us on Youtube" aria-label="Find us on Youtube"><span class="icon-youtube" aria-hidden="true"></span></a>
                        </li>
                    <?php endif; ?>
                    <?php if( get_field('linkedin_url', 'option') ) : ?>
                        <li class="linkedin">
                            <a href="<?php the_field('linkedin_url', 'option'); ?>" title="Find us on Linkedin" aria-label="Find us on Linkedin"><span class="icon-linkedin" aria-hidden="true"></span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>

</div><!-- /#wrapper -->

<div class="back-to-top" aria-label="Back to Top"><a href="#top"><span class="icon icon-arrow-up" aria-hidden="true"></span><span class="text">Back to Top</span></a></div>

<?php wp_footer(); ?>
	
<script type="text/javascript">
	/*<![CDATA[*/
	(function() {
	var sz = document.createElement('script'); sz.type = 'text/javascript'; sz.async = true;
	sz.src = '//siteimproveanalytics.com/js/siteanalyze_41155.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sz, s);
	})();
	/*]]>*/
</script>

</body>
</html>
