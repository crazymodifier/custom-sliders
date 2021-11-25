<?php
/**
 * Custom Sliders Widget Functions
 *
 * Widget related functions and widget registration.
 *
 * @package AIOS\Functions
 * @version 1.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include widget classes.

// class CustomSliders_Posts extends Custom_Sliders_Widget
// {

//     /**
// 	 * Constructor.
// 	 */
// 	public function __construct() {
        
// 		$this->widget_cssclass    = 'custom-sliders widget-custom-posts';
// 		$this->widget_description = __( "A slider for your custom posts.", 'custom-sliders' );
// 		$this->widget_id          = 'custom-slider-custom-posts';
// 		$this->widget_name        = __( 'Custom Slider For Post Type', 'custom-sliders' );
// 		$this->settings           = array(
// 			'title'       => array(
// 				'type'  => 'text',
// 				'std'   => __( 'Custom Slider Post', 'woocommerce' ),
// 				'label' => __( 'Title', 'woocommerce' ),
// 			)
//         );
// 		parent::__construct();
// 	}
    
// }


class CustomSliders_Posts extends WP_Widget {
 
    /**
	 * CSS class.
	 *
	 * @var string
	 */
	public $widget_cssclass;

	/**
	 * Widget description.
	 *
	 * @var string
	 */
	public $widget_description;

	/**
	 * Widget ID.
	 *
	 * @var string
	 */
	public $widget_id;

	/**
	 * Widget name.
	 *
	 * @var string
	 */
	public $widget_name;
 
    /**
	 * Constructor.
	 */
	function __construct() {
 
		$this->widget_cssclass    = 'custom-sliders widget-custom-posts';
		$this->widget_description = __( "A slider for your custom posts.", 'custom-sliders' );
		$this->widget_id          = 'custom-slider-custom-posts';
		$this->widget_name        = __( 'Custom Slider For Post Type', 'custom-sliders' );
		
        $widget_ops = array(
			'classname'                   => $this->widget_cssclass,
			'description'                 => $this->widget_description,
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,
		);
		parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
 
        add_action( 'widgets_init', function() {
            register_widget( 'CustomSliders_Posts' );
        });
 
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
 
        echo $args['before_widget'];
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        $post_type = ! empty($instance['post_type'])?$instance['post_type']:'post';
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => 3
        );
        $slides_to_show = ! empty($instance['slides_to_show']) ? $instance['slides_to_show']: '3';
        $slides_to_scroll = ! empty($instance['slide_to_scroll']) ? $instance['slide_to_scroll']: '1';

        $slides_to_show_1024 = ! empty($instance['slides_to_show_1024']) ? $instance['slides_to_show_1024']: '3';
        $slides_to_scroll_1024 = ! empty($instance['slide_to_scroll_1024']) ? $instance['slide_to_scroll_1024']: '1';

        $slides_to_show_768 = ! empty($instance['slides_to_show_768']) ? $instance['slides_to_show_768']: '2';
        $slides_to_scroll_768 = ! empty($instance['slide_to_scroll_768']) ? $instance['slide_to_scroll_768']: '1';

        $slides_to_show_480 = ! empty($instance['slides_to_show_480']) ? $instance['slides_to_show_480']: '1';
        $slides_to_scroll_480 = ! empty($instance['slide_to_scroll_480']) ? $instance['slide_to_scroll_480']: '1';

        
        
        
        $arrows = ($instance['arrowsss'])? 'true':'false';
        $dots = ($instance['dots'])? 'true':'false';
        $autoplay = ($instance['autoplay'])? 'true':'false';
        $infinite = ($instance['infinite'])? 'true':'false';

        query_posts( $args );

        if(have_posts(  )):

            $sliderSettings = '{

                "slidesToShow": '.$slides_to_show.', 
                "slidesToScroll": '.$slides_to_scroll.',
                "arrows": '.$arrows.',
                "dots": '.$dots.',
                "infinite": '.$infinite.',
                "speed": 300,
                "autoplay" : '.$autoplay.',
                "responsive": [
                    {
                        "breakpoint": 1024,
                        "settings": {
                          "arrows": '.$arrows.',
                          "slidesToScroll": '.$slides_to_scroll_1024.',
                          "slidesToShow": '.$slides_to_show_1024.'
                        }
                    },
                    {
                        "breakpoint": 768,
                        "settings": {
                            "arrows": false,
                            "slidesToScroll": '.$slides_to_scroll_768.',
                            "slidesToShow": '.$slides_to_show_768.'
                        }
                    },
                    {
                        "breakpoint": 480,
                        "settings": {
                            "arrows": false,
                            "slidesToScroll": '.$slides_to_scroll_480.',
                            "slidesToShow": '.$slides_to_show_480.'
                        }
                    }
                ]
            }';

            echo "<div class='custom-slider' data-slick='$sliderSettings'>";

            while(have_posts(  )):
                
                the_post();
                require("templates/template-{$post_type}.php");
                // require('templates/template-v2.php');
                // require('templates/template-v2.php');
                // get_template_part( 'templates/content',$post_type  );
                // get_template_part( 'templates/content',$post_type  );
            endwhile;

            echo '</div>';

        endif;


        echo $args['after_widget'];
        
        wp_reset_query();
    }
 
    public function form( $instance ) {
        
        // Title ///////////////////////////

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <div class="row">
            <div class="col-4">
                adsf
            </div>
            <div class="col-4">
                asdf
            </div>
            <div class="col-4">
                asdfasdf
            </div>
        </div>

        <?php

        // Post Type ////////////////////////
        $post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : esc_html__( 'post', 'custom-sliders' );

        $args = array(
            'public'   => true
        );
        
        
        $post_types = get_post_types( $args);

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php echo esc_html__( 'Post type:', 'custom-sliders' ); ?></label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>">
                <?php 
                
                foreach ($post_types  as $key => $value) {

                    $selected = ($post_type == $key) ? 'selected' : '';

                    echo '<option value="'.$key.'" '.$selected.'>'.ucwords($value).'</option>';

                }
                ?>
                
            </select>
        </p>
        <?php


        // Slides to show ///////////////////////
        $slides_to_show = ! empty( $instance['slides_to_show'] ) ? $instance['slides_to_show'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_show' ) ); ?>"><?php echo esc_html__( 'Slides to show:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_show' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_show' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_show ); ?>">
        </p>

        <?php

        // Slides to scroll ///////////////////////
        $slides_to_scroll = ! empty( $instance['slides_to_scroll'] ) ? $instance['slides_to_scroll'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll' ) ); ?>"><?php echo esc_html__( 'Slides to scroll:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_scroll' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_scroll ); ?>">
        </p>

        <?php

        // Dots ///////////////////////
        $dots = ( $instance['dots'] ) ? $instance['dots'] : 0;
        $active = ( $instance['dots'] ) ? 'active' : '';
        ?>
        <p style="display: flex;align-items: center;justify-content: space-between;">
            <span><?php echo esc_html__( 'Dots:', 'custom-sliders' ); ?></span>
            <label class="checkbox-switch <?php echo $active?>" for="<?php echo esc_attr( $this->get_field_id( 'dots' ) ); ?>"></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dots' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dots' ) ); ?>" type="hidden" value="<?php echo esc_attr( $dots ); ?>">

        </p>

        <?php

        // Infinite Scrolls ///////////////////////
        $infinite = ( $instance['infinite'] ) ? $instance['infinite']: 0;
        $active = ( $instance['infinite'] ) ? 'active' : '';
        ?>
        <p style="display: flex;align-items: center;justify-content: space-between;">
            <span><?php echo esc_html__( 'Infinite Scroll:', 'custom-sliders' ); ?></span>
            <label class="checkbox-switch <?php echo $active?>" for="<?php echo esc_attr( $this->get_field_id( 'infinite' ) ); ?>"></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'infinite' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'infinite' ) ); ?>" type="hidden" value="<?php echo esc_attr( $infinite ); ?>">

        </p>
        <?php
    
        // Arrows ///////////////////////
        $arrowsss = ( $instance['arrowsss'] ) ? $instance['arrowsss'] : 0;
        $active = ( $instance['arrowsss'] ) ? 'active' : '';
        ?>
        <p style="display: flex;align-items: center;justify-content: space-between;">
            <span><?php echo esc_html__( 'Arrows:', 'custom-sliders' ); ?></span>
            <label class="checkbox-switch <?php echo $active?>" for="<?php echo esc_attr( $this->get_field_id( 'arrowsss' ) ); ?>"></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'arrowsss' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'arrowsss' ) ); ?>" type="hidden" value="<?php echo esc_attr( $arrowsss ); ?>">

        </p>
        <?php

        // Autoplay ///////////////////////
        $autoplay = ( $instance['autoplay'] ) ? $instance['autoplay'] : 0;
        $active = ( $instance['autoplay'] ) ? 'active' : '';
        ?>
        <p style="display: flex;align-items: center;justify-content: space-between;">
            <span><?php echo esc_html__( 'Autoplay:', 'custom-sliders' ); ?></span>
            <label class="checkbox-switch <?php echo $active?>" for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" type="hidden" value="<?php echo esc_attr( $autoplay ); ?>">

        </p>

        
        <script>
                jQuery(document).on('click', '.checkbox-switch', function(){
                    var id = jQuery(this).attr('for');
                    if(jQuery(this).hasClass('active')){
                        jQuery(this).removeClass('active');
                        jQuery('#'+id).val(0).change();
                    }
                    else{
                        jQuery(this).addClass('active');
                        jQuery('#'+id).val(1).change()
                    }
                })
            </script>

        <style>


            /**
            * Simple HTML/CSS switch
            */
            .checkbox-switch {
                display: inline-block;
                position: relative;
                width: 50px;
                height: 25px;
                border-radius: 20px;
                background: #dfd9ea;
                transition: background 0.28s cubic-bezier(0.4, 0, 0.2, 1);
                vertical-align: middle;
                cursor: pointer;
            }
            .checkbox-switch::before {
                content: '';
                position: absolute;
                top: 1px;
                left: 2px;
                width: 22px;
                height: 22px;
                background: #fafafa;
                border-radius: 50%;
                transition: left 0.28s cubic-bezier(0.4, 0, 0.2, 1), background 0.28s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .checkbox-switch:active::before {
                box-shadow: 0 2px 8px rgba(0,0,0,0.28), 0 0 0 20px rgba(128,128,128,0.1);
            }
            .checkbox-switch.active {
                background: #72da67;
            }
            .checkbox-switch.active::before {
                left: 27px;
                background: #fff;
            }
            .checkbox-switch.active:active::before {
                box-shadow: 0 2px 8px rgba(0,0,0,0.28), 0 0 0 20px rgba(0,150,136,0.2);
            }
        </style>

        <!-- Responsive 1024px -->

        <hr><br>
        <h2>1024px Wide Devices</h2>
        <?php

                
        // Slides to show ///////////////////////
        $slides_to_show_1024 = ! empty( $instance['slides_to_show_1024'] ) ? $instance['slides_to_show_1024'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_show_1024' ) ); ?>"><?php echo esc_html__( 'Slides to show:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_show_1024' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_show_1024' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_show_1024 ); ?>">
        </p>

        <?php

        // Slides to scroll ///////////////////////
        $slides_to_scroll_1024 = ! empty( $instance['slides_to_scroll_1024'] ) ? $instance['slides_to_scroll_1024'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll_1024' ) ); ?>"><?php echo esc_html__( 'Slides to scroll:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll_1024' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_scroll_1024' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_scroll_1024 ); ?>">
        </p>
        

        <hr><br>
        <h2>768px Wide Devices</h2>
        <?php

                
        // Slides to show ///////////////////////
        $slides_to_show_768 = ! empty( $instance['slides_to_show_768'] ) ? $instance['slides_to_show_768'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_show_768' ) ); ?>"><?php echo esc_html__( 'Slides to show:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_show_768' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_show_768' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_show_768 ); ?>">
        </p>

        <?php

        // Slides to scroll ///////////////////////
        $slides_to_scroll_768 = ! empty( $instance['slides_to_scroll_768'] ) ? $instance['slides_to_scroll_768'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll_768' ) ); ?>"><?php echo esc_html__( 'Slides to scroll:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll_768' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_scroll_768' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_scroll_768 ); ?>">
        </p>

        <hr><br>
        <h2>480px Wide Devices</h2>
        <?php

                
        // Slides to show ///////////////////////
        $slides_to_show_480 = ! empty( $instance['slides_to_show_480'] ) ? $instance['slides_to_show_480'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_show_480' ) ); ?>"><?php echo esc_html__( 'Slides to show:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_show_480' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_show_480' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_show_480 ); ?>">
        </p>

        <?php

        // Slides to scroll ///////////////////////
        $slides_to_scroll_480 = ! empty( $instance['slides_to_scroll_480'] ) ? $instance['slides_to_scroll_480'] : esc_html__( '', 'custom-sliders' );

        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll_480' ) ); ?>"><?php echo esc_html__( 'Slides to scroll:', 'custom-sliders' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slides_to_scroll_480' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slides_to_scroll_480' ) ); ?>" type="number" value="<?php echo esc_attr( $slides_to_scroll_480 ); ?>">
        </p>

        <?php
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['post_type'] = ( !empty( $new_instance['post_type'] ) ) ? $new_instance['post_type'] : '';
        $instance['slides_to_show'] = ( !empty( $new_instance['slides_to_show'] ) ) ? $new_instance['slides_to_show'] : '';
        $instance['slides_to_scroll'] = ( !empty( $new_instance['slides_to_scroll'] ) ) ? $new_instance['slides_to_scroll'] : '';
        $instance['dots'] = (( $new_instance['dots'] ) ) ? $new_instance['dots'] : '0';
        // $instance['dots'] = ( !empty( $new_instance['dots'] ) ) ? $new_instance['dots'] : '';
        $instance['infinite'] = (( $new_instance['infinite'] ) ) ? $new_instance['infinite'] : '0';
        $instance['autoplay'] = (( $new_instance['autoplay'] ) ) ? $new_instance['autoplay'] : '0';
        $instance['arrowsss'] = (( $new_instance['arrowsss'] ) ) ? $new_instance['arrowsss'] : '0';

        $instance['slides_to_show_1024'] = (( $new_instance['slides_to_show_1024'] ) ) ? $new_instance['slides_to_show_1024'] : '0';
        $instance['slides_to_scroll_1024'] = (( $new_instance['slides_to_scroll_1024'] ) ) ? $new_instance['slides_to_scroll_1024'] : '0';

        $instance['slides_to_show_768'] = (( $new_instance['slides_to_show_768'] ) ) ? $new_instance['slides_to_show_768'] : '0';
        $instance['slides_to_scroll_768'] = (( $new_instance['slides_to_scroll_768'] ) ) ? $new_instance['slides_to_scroll_768'] : '0';

        $instance['slides_to_show_480'] = (( $new_instance['slides_to_show_480'] ) ) ? $new_instance['slides_to_show_480'] : '0';
        $instance['slides_to_scroll_480'] = (( $new_instance['slides_to_scroll_480'] ) ) ? $new_instance['slides_to_scroll_480'] : '0';
 
        return $instance;
    }
}
$my_widget = new CustomSliders_Posts();


