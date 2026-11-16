<div aria-label="Twitter feed" class="panel panel-twitter-feed">
    <div class="container">
        <?php
        switch (get_sub_field('twitter_account')) {
            case 'ftccathletics':
                echo do_shortcode("[twitter_profile screen_name=\"ftccathletics\" height=\"300\" limit=\"3\"]");
                break;
            default:
                echo do_shortcode("[twitter_profile screen_name=\"faytechcc\" height=\"300\" limit=\"3\"]");
        }
        ?>
    </div>
</div>