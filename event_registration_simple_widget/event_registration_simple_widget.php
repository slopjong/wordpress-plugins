<?php

/*
Plugin Name: Event Registration Simple Widget
Plugin URI: http://github.com/slopjong/wordpress-widgets
Description: Shows the next event created with the Event Registration plugin. The day after an event the widget will show the next event or the class 'noevent' will be assigned to it. With CSS it can then be hidden but this is the users responsibility. The event category will be used as the title or 'Next event' if it has no category. <strong>Requirements:</strong> This plugin needs the <a href="http://www.wpeventregister.com/" target="_blank">Event Registration</a> plugin to be installed <strong>and</strong> activated.
Version: 0.1
Author: Romain Schmitz
Author URI: http://slopjong.de
*/

class Event_Registration_Simple_Widget extends WP_Widget
{
    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
	parent::__construct(
	    'event_registration_simple_widget', // Base ID
	    "My next event", // Name
	    array( 'description' => __( // Args
		'Lists the next event created with the Event Registration plugin.',
		'text_domain'
	    ), )
	);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance )
    {
	global $wpdb;
	
	extract( $args );

	// -------------------------------------
	// get the event name and type
	
	$today = date("Y-m-d");
	$query = "
	    SELECT event_name, category_id
	    FROM " . get_option('evr_event') . "
	    WHERE end_date>='". $today ."'
	    ORDER BY end_date ASC LIMIT 1
	    ";
	
	// in [0] get_var is recommended
	$rows = $wpdb->get_results($query);
	
	// fetch the name and type if there's an upcoming event
	if(count($rows)>0)
	{
	    $event_name = $rows[0]->event_name;
	    $category_id = $rows[0]->category_id;
	    
	    // The field category_id has a value which looks like
	    //
	    //   a:1:{i:0;s:1:"1";}
	    //
	    // The number between the quotes is the actual
	    // category ID used in wp_evr_category
	    
	    $regex = "/\"(\d+)\";}/";
	    preg_match( $regex, $category_id, $match);
	    $category_id = $match[1];
	    
	    $rows = $wpdb->get_results("
		SELECT category_name
		FROM " . get_option('evr_category') . "
		WHERE id='". $category_id ."'
		");
	    
	    $event_type = $rows[0]->category_name;
	    
	    if($event_type == "")
		$event_type = "Next event";
	}
	else
	{
	    // no events? add a class to hide the widget via css
	    $before_widget = str_replace('class="', 'style="display:none;" class="noevent' . ' ', $before_widget);
	    
	    $event_name = "";
	    $event_type = "";
	}

	
	// -------------------------------------
	// render the widget
	
	echo $before_widget;
	echo $before_title . $event_type . $after_title;
	echo '<a href="' . evr_permalink_prefix() . '">';
	echo __( $event_name, 'text_domain' );
	echo '</a>';
	echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance )
    {
	$instance = array();
	$instance['title'] = strip_tags( $new_instance['title'] );

	return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance )
    {
    }
}

add_action( 'widgets_init', create_function( '', 'register_widget( "event_registration_simple_widget" );' ) );


/*************************************************************************************
 * References
 * ==========
 * 
 * [0] http://wordpress.stackexchange.com/questions/10073/using-wpdb-object-in-a-widget
 
 */