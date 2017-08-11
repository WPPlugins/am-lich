<?php
/*
Plugin Name: Am lich
Plugin URI: http://amlich.com/
Description: Widget Âm lịch by amlich.com
Version: 1.0
Author: Quang Nguyen
Author URI: http://amlich.com/
License: GPLv2 or later
*/

function register_am_lich_widget() {
    register_widget( 'Am_Lich_Widget' );
}
add_action( 'widgets_init', 'register_am_lich_widget' );

class Am_Lich_Widget extends WP_Widget {


	   
	public function __construct() {
		parent::__construct(
			'am_lich_widget', // Base ID
			'Âm Lịch', // Name
			 array( 'description' =>'Âm Lịch by amlich.com') // Args
		);
		
	}

	public function widget( $args, $instance ) {
		
     	echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		$date= (($instance['date'])?1:0);
		$month= (($instance['month'])?1:0)*2;
		$menu= (($instance['menu'])?1:0)*4;
		
		$type=$menu + $date + $month ;
		if($type==0)$type=5;
		$height=$instance['height'];
		if($height<=0)$height=300;
		$background=$instance['background'];
		$color=$instance['color'];
		echo "<iframe style='padding:0;border:none;overflow:hidden; width: 100%;height:".$height."px' src='//amlich.com/#type=".$type.($background>0?("&bg=".$background):"").($color>0?("&color=".$color):"")."'></iframe>";
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['date'] = !empty($new_instance['date']) ? 1 : 0; 
		$instance['month']= !empty($new_instance['month']) ? 1 : 0; 
		$instance['menu'] = !empty($new_instance['menu']) ? 1 : 0; 
		$instance['height'] = strip_tags($new_instance['height']) ; 
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['background'] = strip_tags($new_instance['background']);
		$instance['color'] = strip_tags($new_instance['color']);
		return $instance;
	}

	public function form( $instance ) {
		
		
		
		$instance = wp_parse_args( (array) $instance, array('title'=>'Âm Lịch', 'date'=>1,'month'=>0,'menu'=>1,'height'=>300,'background'=>'0','color'=>'1') );
		$title = $instance['title'] ;
		$color = $instance['color'] ;
		$background = $instance['background'] ;
		
		
	?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<input  id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" <?php checked( $instance['date'] ); ?> class="checkbox" type="checkbox">
			<label for="<?php echo $this->get_field_id( 'date' ); ?>"> Ngày </label>
		</p>
		
		<p>
			<input  id="<?php echo $this->get_field_id( 'month' ); ?>" name="<?php echo $this->get_field_name( 'month' ); ?>" <?php checked( $instance['month'] ); ?> class="checkbox" type="checkbox">
			<label for="<?php echo $this->get_field_id( 'month' ); ?>"> Tháng </label>
		</p>
		
		<p>
			<input  id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>" <?php checked( $instance['menu'] ); ?> class="checkbox" type="checkbox">
			<label for="<?php echo $this->get_field_id( 'menu' ); ?>"> Menu </label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"> Height </label>
			<input  id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value='<?php echo esc_attr( $instance['height']); ?>' class="checkbox" type="number">
		</p>
		

		<p>
		   <table width='100%'>
				<tr>
					<td>
						<select   name="<?php echo $this->get_field_name('background'); ?>" id="<?php echo $this->get_field_id( 'background' ); ?>">
				
								<?php for ($bg=1;$bg<=6;$bg++) {  
									echo "<option ".($background==$bg?'selected':'' )." value='$bg'>Hình $bg  </option>";
								} ?>
								<option value='0' >không chọn</option>
						</select>
					</td>
					<td>
						<select name="<?php echo $this->get_field_name('color'); ?>" id="<?php echo $this->get_field_id( 'color' ); ?>">
				
				<?php for ($cl=1;$cl<=6;$cl++) {  
					echo "<option ".($color==$cl?'selected':'' )." value='$cl'>Màu $cl  </option>";
				} ?>
		</select>
					</td>
				</tr>
		   </table>
		</p>
		
		<p>
		</p>
		<?php 
	}
}