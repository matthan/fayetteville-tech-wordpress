<?php $uniquePanelName =  generateRandomString(); ?>
<?php $navcolor = get_sub_field('style'); ?>

<div class="panel panel-tabbed-basic-content">
    <div class="container">
        <div id="<?php echo $uniquePanelName; ?>" class="row-flex tabbed-content <?php the_sub_field('layout'); ?>">
            <?php if ( have_rows( 'tabbed_content' ) ) : ?>
                <div class="col-30">
                    <ul class="nav nav-tabs nav-<?php echo $navcolor; ?>" role="tablist">
                        <?php $count = 0; while ( have_rows( 'tabbed_content' ) ) : the_row(); $count++; ?>
                            <?php
                            $badchars = array( '&', '(', ')', '?', '!', '\'', '\"', '/', '<', '>', '.', ',', ':', ';' );
                            $tabname = strtolower(get_sub_field('tab_title'));
                            $tabname = str_replace(' ','-',$tabname);
                            $tabname = str_replace($badchars,'',$tabname);
                            ?>
                            <li class="tab<?php if($count==1) : ?> active<?php endif; ?>">
                                <a id="tab-<?php echo $tabname; ?>" href="#<?php echo $tabname; ?>" role="tab" aria-controls="<?php echo $tabname; ?>" aria-selected="true" data-toggle="tab" tabindex="<?php echo ($count==1) ? '0' : '-1'; ?>"><?php the_sub_field( 'tab_title' ); ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <div class="col-70">
                    <div class="tab-content" aria-live="polite">
                        <?php $count = 0; while ( have_rows( 'tabbed_content' ) ) : the_row(); $count++; ?>
                            <?php
                            $badchars = array( '&', '(', ')', '?', '!', '\'', '\"', '/', '<', '>', '.', ',', ':', ';' );
                            $tabname = strtolower(get_sub_field('tab_title'));
                            $tabname = str_replace(' ','-',$tabname);
                            $tabname = str_replace($badchars,'',$tabname);
                            ?>
                            <div class="tab-pane fade<?php if($count==1) : ?> in active<?php endif; ?>" id="<?php echo $tabname; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $tabname; ?>" aria-hidden="<?php echo ($count==1) ? 'false' : 'true'; ?>" tabindex="0">
                                <?php if(get_sub_field('tab_title')) : ?><h3 class="alt"><?php the_sub_field( 'tab_title' ); ?></h3><?php endif; ?>
                                <?php the_sub_field( 'content' ); ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>