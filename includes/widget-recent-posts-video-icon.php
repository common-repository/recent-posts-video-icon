<?php
/**
   Plugin Name: Recent Posts Video Icon
   Description: Display video icon of your choice next to Posts tagged 'video'.
   Plugin URI: http://www.experienced.com/recent-posts-video-icon/	
   Version: 1.1
   Author: Daniel Monaghan
   Author URI: http://www.experienced.com
   License: GPLv2 or later
 */

class rpvi_widget extends WP_Widget {

/**
* Widget setup
*/
function __construct() {

$widget_ops = array(
'classname' => 'widget_recent_entries',
'description' => __( 'Display video icon of your choice next to Posts tagged &#8217;video&#8217;.', 'rpvi' )
);

$control_ops = array(
'width' => 300,
'height' => 350,
'id_base' => 'rpvi_widget'
);

parent::__construct( 'rpvi_widget', __( 'Recent Posts Video Icon', 'rpvi' ), $widget_ops, $control_ops );

}

/**
* Display widget
*/
function widget( $args, $instance ) {
extract( $args, EXTR_SKIP );

$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
$limit = (int)( $instance['limit'] );
$order = $instance['order'];
$orderby = $instance['orderby'];
$thumb_default = esc_url( $instance['thumb_default'] );
$thumb_align = sanitize_html_class( $instance['thumb_align'] );
$post_type = $instance['post_type'];
$date = $instance['date'];
$date_format = strip_tags( $instance['date_format'] );
$styles_default = $instance['styles_default'];
echo $before_widget;

/* If title not empty and title url empty then display just the title. */
echo $before_title . $title . $after_title;

global $post;

/* Set up the query arguments. */
$args = array(
'posts_per_page' => $limit,
'post_type' => $post_type,
'order' => $order,
'orderby' => $orderby
);

/* Allow developer to filter the query. */
$default_args = apply_filters( 'rpvi_default_query_arguments', $args );

/**
* The main Query
*
* @link http://codex.wordpress.org/Function_Reference/get_posts
*/
$rpviwidget = get_posts( $default_args );

?>

<div class="rpvi-block">
<ul>

<?php foreach ( $rpviwidget as $post ) : setup_postdata( $post ); ?>
<li><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'rpvi' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?>

<?php if ( $thumb_default ) { // Check if the thumbnail isn't empty. ?>
<?php if ( has_tag('video') ) { // Check If post has 'video' tag. ?>
<?php
printf( '<img src="%3$s" alt="Video" hspace=6>',
esc_url( get_permalink() ),
$thumb_align,
$thumb_default,
esc_attr( get_the_title() )
);
?>

<?php } // endif ?>
<?php } // endif ?>
</a>
<?php if ( $date == true ) { // Check if the date option enable. ?>
<span class="post-date"><?php echo esc_html( get_the_date( $date_format ) ); ?></span>
<?php } // endif ?>
</li>

<?php endforeach; wp_reset_postdata(); ?>

</ul>
</div><!-- .rpvi-block -->

<?php

echo $after_widget;

}

/**
* Update widget
*/
function update( $new_instance, $old_instance ) {

$instance = $old_instance;
$instance['title'] = strip_tags( $new_instance['title'] );
$instance['limit'] = (int)( $new_instance['limit'] );
$instance['order'] = $new_instance['order'];
$instance['orderby'] = $new_instance['orderby'];
$instance['thumb'] = $new_instance['thumb'];
$instance['thumb_default'] = esc_url_raw( $new_instance['thumb_default'] );
$instance['thumb_align'] = $new_instance['thumb_align'];
$instance['post_type'] = $new_instance['post_type'];
$instance['date'] = $new_instance['date'];
$instance['date_format'] = strip_tags( $new_instance['date_format'] );
$instance['styles_default'] = $new_instance['styles_default'];

return $instance;

}

/**
* Widget setting
*/
function form( $instance ) {

/* Set up some default widget settings. */
$defaults = array(
'title' => '',
'limit' => 5,
'order' => 'DESC',
'orderby' => 'date',
'thumb' => true,
'thumb_default' => '/wp-content/uploads/video_icon.gif',
'post_type' => '',
'date' => true,
'date_format' => 'F j, Y',
'styles_default' => true
);

$instance = wp_parse_args( (array)$instance, $defaults );
$title = strip_tags( $instance['title'] );
$limit = (int)( $instance['limit'] );
$order = $instance['order'];
$orderby = $instance['orderby'];
$thumb_default = $instance['thumb_default'];
$thumb_align = $instance['thumb_align'];
$post_type = $instance['post_type'];
$date = $instance['date'];
$date_format = strip_tags( $instance['date_format'] );
$styles_default = $instance['styles_default'];

?>

<div class="rpvi-columns-1">

<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'rpvi' ); ?></label>
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>"/>
</p>

<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Number of posts to show:', 'rpvi' ); ?></label>
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo $limit; ?>"/>
</p>

<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order:', 'rpvi' ); ?></label>
<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" style="width:100%;">
<option value="DESC" <?php selected( $order, 'DESC' ); ?>><?php _e( 'DESC', 'rpvi' ) ?></option>
<option value="ASC" <?php selected( $order, 'ASC' ); ?>><?php _e( 'ASC', 'rpvi' ) ?></option>
</select>
</p>

<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>"><?php _e( 'Video Icon:', 'rpvi' ); ?> <img src="<?php echo $thumb_default; ?>"></label>
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_default' ) ); ?>" type="text" value="<?php echo $thumb_default; ?>"/>
<small><?php _e( 'Leave blank to disable', 'rpvi' ); ?></small>
</p>

<p>
<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php _e( 'Display Date', 'rpvi' ); ?></label>
<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?> />&nbsp;
</p>

</div>

<div class="clear"></div>

<?php
}

}

/**
* Register the widget.
*
* @since 0.1
* @link http://codex.wordpress.org/Function_Reference/register_widget
*/
function rpvi_register_widget() {
register_widget( 'rpvi_widget' );
}
add_action( 'widgets_init', 'rpvi_register_widget' );

