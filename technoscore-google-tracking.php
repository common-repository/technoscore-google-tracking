<?php
/*
Plugin Name: Technoscore Google Tracking
Plugin URI: http://nddw.com/demo3/sws-res-slider/google-tracking-demo/
Description: This plugin adds Google AdWords  Conversion tracking , Remarketing Tag  and Google Analytics  to header/footer part of Selected webpages.
Version:  1.0.1
Author: Technoscore
Author URI: http://www.technoscore.com/
Text Domain: techno_
*/

add_action('admin_menu', 'techno_google_tracking');

function techno_google_tracking() {

	//create new top-level menu
	add_menu_page('Google Tracking', 'Google Tracking', 'administrator', __FILE__, 'techno_google_tracking_page');
	
		//call register settings function
	add_action( 'admin_init', 'techno_google_tracking_register_settings' );
}


function techno_google_tracking_register_settings() {
	//register our settings
	register_setting( 'techno-settings-group', 'techno_google_analytics_key' );
	register_setting( 'techno-settings-group', 'techno_google_analytics_page_id' );
	register_setting( 'techno-settings-group1', 'techno_google_remarketing_key' );
	register_setting( 'techno-settings-group1', 'techno_google_remarketing_page_id' );	
	register_setting( 'techno-settings-group2', 'google_conversion_id' );
	
}

function techno_show_google_analytics(){
global $post;
$techno_google_analytics_page_id = explode(',',get_option('techno_google_analytics_page_id'));

if(count($techno_google_analytics_page_id)>0){
if(in_array($post->ID,$techno_google_analytics_page_id)){
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo esc_attr(get_option('techno_google_analytics_key')); ?>', 'auto');
  ga('send', 'pageview');

</script>
<?php
}
}
}
add_action('wp_head','techno_show_google_analytics',10);

function techno_google_tracking_page() {

?>
<div class="wrap">
<h1>Google Analytics Integration</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'techno-settings-group' ); ?>
    <?php do_settings_sections( 'techno-settings-group' ); ?>
    <table class="form-table">
      
        <tr valign="top">
        <th scope="row">Google Analytics Key</th>
        <td>
		<input type="text" name="techno_google_analytics_key" value="<?php echo esc_attr( get_option('techno_google_analytics_key') ); ?>" />&nbsp; ex: UA-35622607-1</td>
        </tr>
        <tr valign="top">
        <th scope="row">List Of Page Ids</th>
        <td><input type="text" name="techno_google_analytics_page_id" value="<?php echo esc_attr( get_option('techno_google_analytics_page_id') ); ?>" />&nbsp; ex: 2,3,139,101</td>
        </tr>  

		
    </table>
    <?php submit_button(); ?>
</form>
</div>


---------------------------------------------------------------------------

<div class="wrap">
<h1>Google Remarketing Tag Integration</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'techno-settings-group1' ); ?>
    <?php do_settings_sections( 'techno-settings-group1' ); ?>
    <table class="form-table">
      
        <tr valign="top">
        <th scope="row">Google Remarketing Key</th>
        <td><input type="text" name="techno_google_remarketing_key" value="<?php echo esc_attr( get_option('techno_google_remarketing_key') ); ?>" />&nbsp; ex: 881976835</td>
        </tr>
        <tr valign="top">
        <th scope="row">List Of Page Ids</th>
        <td><input type="text" name="techno_google_remarketing_page_id" value="<?php echo esc_attr( get_option('techno_google_remarketing_page_id') ); ?>" />&nbsp; ex: 2,3,139,101	</td>
        </tr>  
		
    </table>
    <?php 	submit_button(); ?>
</form>
</div>
<?php } 



function techno_show_google_remarketing(){
global $post;
$techno_google_remarketing_page_id = explode(',',get_option('techno_google_remarketing_page_id'));

if(count($techno_google_remarketing_page_id)>0){
if(in_array($post->ID,$techno_google_remarketing_page_id)){
?>

<script type="text/javascript">
 
/* <![CDATA[ */
 
var google_conversion_id = <?php echo esc_attr(get_option('techno_google_remarketing_key')); ?>;
 
var google_custom_params = window.google_tag_params;
 
var google_remarketing_only = true;
 
/* ]]> */
 
</script> 
 <?  //wp_enqueue_script( 'conversion1',plugin_dir_url( __FILE__ ).'assets/js/pagead/conversion.js'); ?>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
 
<div style="display:inline;">
 
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php echo esc_attr(get_option('techno_google_remarketing_key')); ?>/?value=0&amp;guid=ON&amp;script=0"/>
 
</div>
 
</noscript>
<!-- Google Code for Remarketing Tag ends-->
 
<?php
}
}

}
add_action('wp_footer','techno_show_google_remarketing',999);




function techno_front_google_conversion(){


$args = array(
	'posts_per_page'   => -1,
	'offset'           => 0,
	'meta_key'         => 'google_conversion_label',
	'post_type'        => array( 'page', 'post'),
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
/* $posts_array = get_posts( $args );  */
if(count(get_posts( $args ))>0){
	foreach(get_posts( $args ) as $val2){
		$google_conversion[] = $val2->ID;
	}
}


global $post;
if(count($google_conversion)>0){
if(in_array($post->ID,$google_conversion)){
?>

 <!-- Google Code for Conversion 1.24.2017 Conversion Page -->

<script type="text/javascript">
/*<![CDATA[*/
var google_conversion_id = <?php echo esc_attr(get_option('google_conversion_id')) ?>;

var google_conversion_language = "en";

var google_conversion_format = "3";

var google_conversion_color = "ffffff";

var google_conversion_label = "<?php echo esc_attr(get_post_meta( $val2->ID, 'google_conversion_label')[0]); ?>";

var google_remarketing_only = false;

/* ]]> */

</script>

 <?  //wp_enqueue_script( 'conversion2', plugin_dir_url( __FILE__ ).'assets/js/pagead/conversion.js'); ?>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/<?php echo esc_attr(get_option('google_conversion_id')); ?>/?label=<?php echo esc_attr(get_post_meta( $val2->ID, 'google_conversion_label')[0]); ?>&guid=ON&script=0"/>

</div>

</noscript>
 
<?php
}
}

}
add_action('wp_footer','techno_front_google_conversion',999);
?>
<?

 
if($_GET['page'] == 'technoscore-google-tracking/technoscore-google-tracking.php'){

	add_action( 'admin_footer', 'techno_show_google_conversion' );
}

 function techno_show_google_conversion(){ 
 ?>
<div class="conversion_line"> -------------------------------------------------------------------------</div>
<?  wp_enqueue_style('admin_main', plugin_dir_url( __FILE__ ).'assets/css/admin_main.css'); ?>
<div class="dataTable_wrap_outer">
<div class="wrap">
<h1>Google Conversion Integration</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'techno-settings-group2' ); ?>
    <?php do_settings_sections( 'techno-settings-group2' ); ?>
    <table class="form-table">
      
        <tr valign="top">
        <th scope="row">Google Conversion Id</th>
        <td><input type="text" name="google_conversion_id" value="<?php echo esc_attr( get_option('google_conversion_id') ); ?>" />&nbsp; ex: 881976835</td>
        </tr> 
		
    </table>
    <?php submit_button(); ?>
</form>
</div>
<? //	wp_enqueue_script('JQUERY'); //wp_enqueue_script( 'jsforall', plugin_dir_url( __FILE__ ).'assets/js/jquery.min.js'); ?>
<script type="text/javascript">
function techno_addNew(){
jQuery("#dataTable").show();
jQuery("select#page_title").val("Select Page Title");
//techno_page_id_hide();
}

function techno_addNew_hide(){
jQuery("#dataTable").hide();
}

function techno_page_id_hide(){
jQuery("#page_id").hide();
}

function techno_SelectElement()
{    
var e = document.getElementById("page_title");
var strUser = e.options[e.selectedIndex].value;
var element = document.getElementById('page_id');
element.value = strUser;
}

function techno_hide_form(){
	jQuery('#Cancel').click(function(){
		jQuery("#dataTable").hide();
	});
}

jQuery(window).resize(checkWidth);

 jQuery('.dataTable_wrap_outer').addClass('conversion');
 jQuery('#wpfooter').hide();
function checkWidth() {
    if (jQuery(window).width() < 514) {
        jQuery('.dataTable_wrap_outer').removeClass('conversion');
    }else {
 jQuery('.dataTable_wrap_outer').addClass('conversion');
       // $('#asd').removeClass('mobile');
    }
}

</script>
<div class="dataTable_wrap">
	<TABLE id="dataTable" width="300px" border="1" style="display:none">
		<div id = "techno_err" class="techno_err"></div>
		<TR>
		<form class="techno_form" id="send_form" name="send_form" method="post">
			<!--<TD><INPUT type="checkbox" name="chk"/></TD>
			<TD><INPUT type="text" name="google_conversion_id" id="google_conversion_id" class="google_conversion_id"   placeholder="Enter Google Conversion Id"/></TD>-->

			<TD><select  name="page_title" id="page_title" onChange = "techno_SelectElement();">
				 <option>Select Page Title</option>
				<?php $args = array(
					'posts_per_page'   => -1,
					'offset'           => 0,
					'post_type' =>  array( 'page', 'post'),
					'post_status'      => 'publish',
					'suppress_filters' => true 
				);
				//$posts_array = get_posts( $args );
				//echo'<pre>';print_r(get_posts( $args ));echo'</pre>';			
				if(count(get_posts( $args ))>0){ 	
				foreach(get_posts( $args ) as $val){ ?>
				 <option value="<? echo  $val->ID; ?>"><? echo  $val->post_title; ?></option>
					<? } } ?>
	
			</select></TD>
			
			<INPUT type="hidden" name="page_id" id="page_id" class="page_id" placeholder="Page Id"/>
			<TD><INPUT type="text" name="google_conversion_label" id="google_conversion_label" class="google_conversion_label"  placeholder="Google Conversion Label"/></TD>
			<!--TD><INPUT type="submit" name="save" id="save" class="save" value="save"/></TD-->
			<TD><button type="submit" id="target">Save</button></TD>
			<TD><button type="button" id="Cancel">Cancel</button></TD>
			</form>
		</TR>
		

		<div id = "techno_addNew" class="techno_addNew">
			<INPUT type="button" value="Add New" onclick="techno_addNew()" />
		</div>
	

	</TABLE>
</div>	
	<div id="techno_table_ajax">
		<?php $args = array(
	'offset'           => 0,
	'meta_key'         => 'google_conversion_label',
	'post_type'        => array('page','post'),
	'post_status'      => 'publish',
	'suppress_filters' => true ,
	'posts_per_page'=> -1
);
if(count(get_posts( $args ))>0){ ?>
		<TABLE id="dataTable_other" width="300px" border="2px">
		
		<TR>
		<TH>Page Title</TH>
		<TH>Google Conversion Label</TH>
		<TH>Action</TH>
		</TR>
		

	<?
foreach(get_posts( $args ) as $val){

?>
		<TR>
			<TD><? echo  $val->post_title; ?></TD>
			<TD><? echo  get_post_meta( $val->ID, 'google_conversion_label')[0]; ?></TD>

			<!--TD><INPUT type="submit" name="save" id="save" class="save" value="save"/></TD-->
			<TD><button type="submit" class="target_delete" data-page_id="<? echo  $val->ID;  ?>" >Delete</button></TD>
		</TR>
<?  } ?>
	</TABLE>
<? }else{
echo  "<div class='empty_msg'><b>No Page to show!!!</b></div>";
}  ?>

	</div>
</div>	
 <?
 wp_enqueue_script( 'validate',  plugin_dir_url( __FILE__ ).'assets/js/validate/jquery.validate.js'); 
 wp_enqueue_script( 'validate_min', plugin_dir_url( __FILE__ ).'assets/js/validate/jquery.validate.min.js'); 

 ?>

<script type="text/javascript">		
del_google_conversion();
techno_hide_form();

function  del_google_conversion(){
	jQuery(".target_delete").click(function(e){
	 e.preventDefault();
 /* alert('clicked');  */
	var del_google_conversion_label = jQuery(this).attr('data-page_id');
	  /* alert('del_google_conversion_label:- '+del_google_conversion_label);  */
	 
	 var se_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
			  var final_link3 = se_ajax_url + "?action=techno_google_conversion_del_pageid";
			  jQuery.ajax({
					url: final_link3, // our PHP handler file
					type: 'POST',
					data: {del_google_conversion_label:del_google_conversion_label},
					success: function (response,textStatus, jqXHR) { 
						 if(response){
						  var data = JSON.parse(response);  					  
						  
						  	console.log(data);
							
					  	   jQuery('.techno_err').html(data.message); 
					  	   jQuery('.techno_err').addClass('sucess_msg'); 
					  	   jQuery('#techno_table_ajax').html(data.html); 
						   jQuery('.techno_err').addClass(data.class); 
							  // jQuery('#page_id').val('');
							  // jQuery('#google_conversion_label').val('');				
							  setTimeout(function(){
										 if(jQuery('#techno_err').hasClass('error') ){
											jQuery('#techno_err').removeClass('error');
											jQuery('#techno_err').empty('');
										}
										if(jQuery('#techno_err').hasClass('sucess')){
										jQuery('#techno_err').removeClass('sucess');
										jQuery('#techno_err').empty('');
										}
								},5000);  
								del_google_conversion();
								techno_addNew_hide();
								techno_hide_form();
							 
					 }else{
						 return false;
					  }
					}
					
	 });
	 });
}


		jQuery("#target").click(function(e){

		 e.preventDefault();
		 
               // var $form = $(this);
				 var $form = jQuery("#send_form");
				
				//-
				//  $("#form").validate({
				  jQuery($form).validate({
                    rules: {
					
					 "page_id": {
                            required: true,
                          // lettersonly: true,
						    },
					"google_conversion_label": {
                            required: true,
                          // lettersonly: true,
						    }, 
					
						
                    },
                  
                });
//-
                // check if the input is valid
                if(! $form.valid()) return false;
		
			else{
					
					console.log(jQuery('.techno_form').serialize());
					
					
			var se_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
			  var final_link2 = se_ajax_url + "?action=techno_google_conversion";
			  jQuery.ajax({
					url: final_link2, // our PHP handler file
					type: 'POST',
					data: jQuery('.techno_form').serialize(),
					success: function (response,textStatus, jqXHR) { 
						 if(response){
						   var data = JSON.parse(response);  
										  
						  
						  	/* console.log(data); */
							
					  	  jQuery('.techno_err').html(data.message); 
					  	  jQuery('#techno_table_ajax').html(data.html); 
						  jQuery('.techno_err').addClass(data.class); 
							  jQuery('#page_id').val('');
							  jQuery('#google_conversion_label').val('');
								
								jQuery("select#page_title").val("Select Page Title");
								jQuery("#dataTable").show();
							  setTimeout(function(){
										 if(jQuery('#techno_err').hasClass('error') ){
											jQuery('#techno_err').removeClass('error');
											jQuery('#techno_err').empty('');
											
											
										}
										
								},5000);  
								
								if(jQuery('#techno_err').hasClass('sucess')){
									setTimeout(function(){
										jQuery('#techno_err').removeClass('sucess');
										jQuery('#techno_err').empty('');
										},5000); 
										
										 techno_addNew_hide();
										 
										}
										
									del_google_conversion();
									//techno_addNew_hide();
									techno_hide_form();
							 
					 }else{
						 return false;
					  }
					}

		  })
		  }
		  }); 

</script>
	

<? } 


add_action('wp_ajax_techno_google_conversion','techno_google_conversion_ajax');
add_action('wp_ajax_nopriv_techno_google_conversion','techno_google_conversion_ajax');
function techno_google_conversion_ajax(){
if(isset($_POST['page_id']) && !empty($_POST['page_id']) && isset($_POST['google_conversion_label']) && !empty($_POST['google_conversion_label'])  ){
$techno_google_conversion_res = techno_post_exists(sanitize_text_field($_POST['page_id']));
if(!$techno_google_conversion_res){
$techno_google_conversion_msg = '<div class="empty_msg"><b>Post not exists!!!</b></div>';
}else{
update_post_meta( sanitize_text_field($_POST['page_id']), 'google_conversion_label' , sanitize_text_field($_POST['google_conversion_label'] ));
$techno_google_conversion_msg = '<div class="sucess_msg"><b>Google Conversion Label added sucessfully!!!</b></div>';
 $html .=" <div id='techno_table_ajax'>";
  		$args = array(
	'offset'           => 0,
	'meta_key'         => 'google_conversion_label',
	'post_type'        => array('page','post'),
	'post_status'      => 'publish',
	'suppress_filters' => true,
	'posts_per_page'=> -1	
	);
	if(count(get_posts( $args ))>0){ 
	//$posts_array = get_posts( $args ); 
	$html .="<TABLE id='dataTable_other' width='300px'  border='2px'>
		
		<TR>
		<TH>Page Title</TH>
		<TH>Google Conversion Label</TH>
		<TH>Action</TH>
		</TR>
		";

foreach(get_posts( $args ) as $val){

?>
			<? $html .="<TR>"; ?>
			<? $html .="<TD>".$val->post_title."</TD>"; ?>
			<? $html .="<TD>".get_post_meta( $val->ID, 'google_conversion_label')[0]."</TD>";?>
			<? $html .="<TD><button type='submit' class='target_delete' data-page_id=".$val->ID.">Delete</button></TD>"; ?> 
			<? $html .="</form>";?>
		<? $html .="</TR>"; ?>
<?  }  ?>
	<? $html .="</TABLE>"; ?>
	<?  }else{
	$html = "<div class='empty_msg'><b>No Page to show!!!</b></div>";
}  ?>
	<? $html .="</div>"; ?>
	<?
	        $techno_google_conversion_response["html"] = $html;
			 $techno_google_conversion_response["class"] = "sucess";
}

		}else{
		            $techno_google_conversion_msg = "Please fill all fields";
				   $techno_google_conversion_response["class"] = "error";
		
		}		
      
        $techno_google_conversion_response["message"] = $techno_google_conversion_msg;


	echo json_encode($techno_google_conversion_response);
    wp_die();
}

add_action('wp_ajax_techno_google_conversion_del_pageid','techno_google_conversion_del_pageid_ajax');
add_action('wp_ajax_nopriv_techno_google_conversion_del_pageid','techno_google_conversion_del_pageid_ajax');
function techno_google_conversion_del_pageid_ajax(){

if(isset($_POST['del_google_conversion_label']) && !empty($_POST['del_google_conversion_label'])  ){

delete_post_meta(sanitize_text_field($_POST['del_google_conversion_label']), 'google_conversion_label'); 
  $techno_google_conversion_msg = "<b>Google Conversion Label deleted sucessfully!!!</b>";
  $html .=" <div id='techno_table_ajax'>";
  		$args = array(
	'offset'           => 0,
	'meta_key'         => 'google_conversion_label',
	'post_type'        => array('page','post'),
	'post_status'      => 'publish',
	'suppress_filters' => true,
	'posts_per_page'=> -1	
	);
	if(count(get_posts( $args ))>0){ 
	//$posts_array = get_posts( $args ); 
	$html .="<TABLE id='dataTable_other' border='2px' width='300px' >
		
		<TR>
		<TH>Page Title</TH>
		<TH>Google Conversion Label</TH>
		<TH>Action</TH>
		</TR>
		";

foreach(get_posts( $args ) as $val){

?>
			<? $html .="<TR>"; ?>
			<? $html .="<TD>".$val->post_title."</TD>"; ?>
			<? $html .="<TD>".get_post_meta( $val->ID, 'google_conversion_label')[0]."</TD>";?>
			<? $html .="<TD><button type='submit' class='target_delete' data-page_id=".$val->ID.">Delete</button></TD>"; ?> 
			<? $html .="</form>";?>
		<? $html .="</TR>"; ?>
<?  }  ?>
	<? $html .="</TABLE>"; ?>
	<?  }else{
		$html .="<div class='empty_msg'><b>No Page to show!!!</b></div>";
}  ?>
	<? $html .="</div>"; ?>
	<?
	        $techno_google_conversion_response["html"] = $html;
			$techno_google_conversion_response["class"] = "sucess";
}

      
        $techno_google_conversion_response["message"] = $techno_google_conversion_msg;


	echo json_encode($techno_google_conversion_response);
    wp_die();
}

/**
 * Determines if a post, identified by the specified ID, exist
 * within the WordPress database.
 * 
 * Note that this function uses the 'acme_' prefix to serve as an
 * example for how to use the function within a theme. If this were
 * to be within a class, then the prefix would not be necessary.
 *
 * @param    int    $id    The ID of the post to check
 * @return   bool          True if the post exists; otherwise, false.
 * @since    1.0.0
 */
function techno_post_exists( $id ) {
  return is_string( get_post_status( $id ) );
}
?>