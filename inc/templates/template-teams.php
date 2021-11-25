<div href="<?php the_permalink()?>" class="md-teamcard-spacer" style="background-image:url(<?php echo esc_url(get_template_directory_uri())?>/assets/img/line-bg.png)">
    <div class="md-teamcard-wrapper">
        <div class="team-avatar">
            <div class="embed-responsive embed-responsive-1by1">
                <img class="embed-responsive-item" src="<?php echo get_the_post_thumbnail_url();?>" alt="">
            </div>
        </div>
        <div class="md-teamcard-body">
            <h5 class="md-teamcard-title"><?php the_title()?></h5>
            <?php if(get_post_type() == 'teams'): ?>
            <h6 class="md-teamcard-subtitle"><em>Web Developer</em></h6>
            <?php endif;?>
            <div class="md-teamcard-text">
                <?php the_excerpt(  );?>
            </div>
        </div>

        <?php if(get_post_type() == 'teams'): ?>
        <div class="md-teamcard-footer">

            <a class="facebook-icon" href="">
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                </span>
            </a>

            <a class="instagram-icon" href="#">
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                </span>
            </a>

            <a class="twitter-icon" href="#">
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                </span>
            </a>

            <a class="youtube-icon" href="#">
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fab fa-youtube fa-stack-1x fa-inverse"></i>
                </span>
            </a>

        </div>
        <?php endif;?>
    </div>
</div>