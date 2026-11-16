<div aria-label="<?php the_sub_field('heading'); ?>" class="panel panel-office-contact-info">
	<div class="container">
        <?php if( get_sub_field('heading') ) : ?>
            <div class="row-flex">
                <div class="col-100">
                    <h3 class="alt underlined"><?php the_sub_field( 'heading' ); ?></h3>
                </div>
            </div>
        <?php endif; ?>
        <div class="row-flex">
            <div class="col-o">
                <div class="contact-info">
                    <span class="icon icon-office"></span>
                    <div><strong><?php the_sub_field( 'title' ); ?></strong></div>
                    <div><?php the_sub_field( 'address' ); ?></div>
                </div>
            </div>
            <?php if( get_sub_field('phone_number') ) : ?>
                <div class="col-o">
                    <div class="contact-info">
                        <span class="icon icon-phone"></span>
                        <div><strong>Phone Number</strong></div>
                        <div><a href="tel:<?php the_sub_field( 'phone_number' ); ?>"><?php the_sub_field( 'phone_number' ); ?></a></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if( get_sub_field('fax_number') ) : ?>
                <div class="col-o">
                    <div class="contact-info">
                        <span class="icon icon-fax"></span>
                        <div><strong>Fax Number</strong></div>
                        <div><?php the_sub_field( 'fax_number' ); ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if( get_sub_field('office_days') || get_sub_field('office_hours') ) : ?>
                <div class="col-o">
                    <div class="contact-info">
                        <span class="icon icon-office-hours"></span>
                        <div><strong>Office Hours <?php the_sub_field( 'office_days' ); ?></strong></div>
                        <div><?php the_sub_field( 'office_hours' ); ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if( get_sub_field('email') ) : ?>
                <div class="col-o">
                    <div class="contact-info">
                        <div class="icon icon-email"></div>
                        <div><strong>Email</strong></div>
                        <div><?php the_sub_field( 'contact_name' ); ?></div>
                        <div><a href="mailto:<?php the_sub_field( 'email' ); ?>"><?php the_sub_field( 'email' ); ?></a></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ( have_rows( 'custom_blocks' ) ) : ?>
                <?php while ( have_rows( 'custom_blocks' ) ) : the_row(); ?>
                    <div class="col-o">
                        <?php $icon = get_sub_field( 'icon' ); ?>
                        <?php if ( $icon ) : ?>
                            <a href="<?php the_sub_field( 'link_url' ); ?>">
                                <img class="icon-img" src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>" />
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
	</div>
</div>