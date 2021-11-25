<article <?php post_class('md-simple-card')?>>
    <div class="card-img">
        <?php if(has_post_thumbnail( )):?>
        <a href="<?php the_permalink()?>"><?php the_post_thumbnail('full')?></a>
        <?php else: ?>
            <a href="<?php the_permalink()?>"><img class="attachment-full size-full wp-post-image" src="<?php echo esc_url(get_template_directory_uri())?>/assets/img/img-placeholder.jpeg" alt=""></a>
        <?php endif;?>
    </div>
    <div class="card-body">
        <?php if(get_post_type() == 'post') :?>
        <span class="kdw-author-icon"><?php echo get_avatar('',20); ?></span>
        <header class="mt-1">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h5 class="kdw-author-name"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a></h5>
                </div>
                <div class="col-auto">
                    <span class="kdw-postmeta">
                        <i class="far fa-comments"></i> 
                        <span><?php _e(get_comments_number())?></span>
                    </span>

                </div>
            </div>
        </header>
        <hr>
        <?php endif;?>
        <?php do_action('before_post_content')?>

        <div>

            <?php do_action('before_post_title')?>

            <h5 class="card-title"><a href="<?php the_permalink()?>"><?php the_title()?></a></h5>
            
            <?php do_action('after_post_title')?>

            <div class="card-text"><?php the_excerpt();?></div>

        </div>

        <?php do_action('after_post_content')?>
    </div>
    <?php if(get_post_type() == 'post') :?>
    <div class="card-footer">
        <footer class="d-flex justify-content-between">
            <span><?php echo  get_the_date('F d, Y') ?></span>

            <a class="kdw-read-more" href="<?php the_permalink( )?>"><i class="fa fa-angle-right"></i></a>
        </footer>
    </div>
    <?php endif;?>
</article>
