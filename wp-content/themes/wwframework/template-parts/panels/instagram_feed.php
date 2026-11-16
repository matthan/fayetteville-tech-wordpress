<div aria-label="Instagram feed" class="panel panel-instagram-feed">
    <div class="container">
        <?php
        switch (get_sub_field('instagram_account')) {
            case 'ftccathletics':
                dynamic_sidebar('instagram_ftccathletics');
                break;
            default:
                dynamic_sidebar('instagram');
        }
        ?>
    </div>
</div>