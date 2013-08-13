<?php
/**
 * Overrides theme_more_link().
 * - Changed the text from "More" to "Show me More"
 * - Changed the class from "more-link" to "more"
 */

function dgd7_more_link($variables) {
    return '<div class="more">' . l(t('Show me More'), $variables['url'], array('attributes'
                => array('title' => $variables['title']))) . '</div>';
}

/**
* Implements template_preprocess_region().
*/

function dgd7_preprocess_region(&$variables){
	$region = $variables["region"];
	if(in_array($region, array('sidebar_first', 'sidebar_second', 'content'))){
		$variables["class_array"][] = "main";
	}

	//add a "clearfix" class to certain regions to clear floated elements inside theme.
	if(in_array($region, array('footer', 'help', 'hightlight'))){
		$variables["class_array"][]= "clearfix";
	}

	//Add an "outer" class to the darker regions
	if(in_array($region, array("header", "footer", "sidebar_first", "sidebar_second"))){
		$variables['class_array'][] = 'outer';
	}
}

/**
* Implements template_preprocess_node().
*/
function dgd7_preprocess_node(&$variables) {

	// dpm($variables);
	//Give the <h2> containing the teaser node title a better class
	$variables["title_attributes_array"]['class'][] = 'node-title';

	//Remove the "Add new comment" link when the form it below it
	if(!empty($variables['content']['comments']['comment_form'])){
		hide($variables['content']['links']['comment']);
	}

	//Make something change in teaser mode
	if($variables['teaser']){
		//Don't display author or date information
		$variables['display_submitted'] = FALSE;

		//Trim the node title and append an ellipsis.
		$variables['title'] = truncate_utf8($variables['title'], 70, TRUE, TRUE);
	}

}

/**
* Implements template_preprocess_user_picture().
* - Add "change picture" link to be placed underneath the user image.
*/

function dgd7_preprocess_user_picture(&$vars) {
	
	//Create a variable with a empty string to prevent PHP notices when attemping to print variable
	$vars['edit_picture'] = '';

	//The account object contain information of the user whose photo being processe. Compare that to the user id of
	// the user object which represents the currently logged in user.
	if($vars['account']->uid == $vars['user']->uid)
	{
		// Create a variable containg a link to user profile, with a class
		// "change-user-picutre" to style against with CSS.
		$vars['edit_picture'] = l('Change picture', 'user/'.$vars['account']->uid.'/edit', array(
			'fragment' => 'edit-picture',
			'attributes' => array('class' => array('change-user-picutre')),
		));
	}
}

/**
* Implements hook_page_alter().
* - Reside shidebar_first and sidebar_second
*/
function dgd7_page_alter(&$page) {
	// Check that you are viewing a full page node
	if(node_is_page(menu_get_object())){

		//Assign the contents of sidebar_first to sidebar_second
		$page['sidebar_second'] = $page['sidebar_first'];

		//Unset sidebar_first
		unset($page['sidebar_first']);
	}

	//Add The breadcrumbs to the footer region.
	$page['footer']['breadcrumbs'] = array(
		'#type' => 'container',
		'#attributes' => array('class' => array('breadcrumb-wrapper', 'clearfix')),
		'#weight' => 10,
	);
	$page['footer']['breadcrumbs']['breadcrumb'] = array(
		'#theme' => 'breadcrumb',
		'#breadcrumb' => drupal_get_breadcrumb(),
	);
	// Trigger the contents of the region to be restored
	$page['footer']['#sorted'] = FALSE;

	$page['drupalBehaviour'] = '
		<!-- accordion -->
		<div class="accordion">
		<h3><a href="#">Header 1</a></h3>
		<div><p>Lorem Ipsum dolor sit amet. Lorem Ipsum dolor sit amet</p></div>
		<h3><a href="#">Header 2</a></h3>
		<div><p>Lorem Ipsum dolor sit amet. Lorem Ipsum dolor sit amet</p></div>
		<h3><a href="#">Header 3</a></h3>
		<div><p>Lorem Ipsum dolor sit amet. Lorem Ipsum dolor sit amet</p></div>
		</div>

		<!-- datetimepicker -->
		<p><label for="custom-datepicker">Date:</label> <input id="custom-datepicker" class="datepicker" type="text"></p>

		<!-- dialog -->
		
	';
        
        $page['drupalBehaviour'] .= '<div class="dialog" title="Basic dialog">
			<p>This is the default dialog which is useful for displaying information. The dialog window
			can be moved, resized and closed with the x icon.</p>
		</div>'; 
        
        $page['drupalBehaviour'] .= ' <div class="draggable ui-widget-content"> <p>Drag me around</p> </div> ';
        $page['drupalBehaviour'] .= ' <div class="droppable ui-widget-content"> <p>Drag me around</p> </div> ';
        $page['drupalBehaviour'] .= '<div class="progressbar"></div>';
        $page['drupalBehaviour'] .= '
<div class="resizable ui-widget-content">
<h3 class="ui-widget-header">Resizable</h3>
</div>
            
';
        /* Select item */
        $page['drupalBehaviour'] .= '<ol class="selectable">
<li class="ui-widget-content">Item
<li class="ui-widget-content">Item
<li class="ui-widget-content">Item
<li class="ui-widget-content">Item
<li class="ui-widget-content">Item
<li class="ui-widget-content">Item
<li class="ui-widget-content">Item
</ol>
';
        /* Slider */
        $page['drupalBehaviour'] .= '<div class="slider"></div>';
        
        /*sortable*/
        $page['drupalBehaviour'] .= '
        <ol class="sortable">
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s" ></span>            Item1 </li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>             Item2 </li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"> </span>            Item3 </li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"> </span>            Item4 </li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"> </span>            Item5  </li>

        </ol>            
';
        $page['drupalBehaviour'] .= '
            <div class="tabs">
<ol>
<li><a href="#tabs-1">Nunc tincidunt</a></li>
<li><a href="#tabs-2">Proin dolor</a></li>
<li><a href="#tabs-3">Aenean lacinia</a></li>
</ol>
<div id="tabs-1">
<p>Lorem Ipsum Dolor Sit Amet...</p>
</div>
<div id="tabs-2">
<p>Lorem Ipsum Dolor Sit Amet...</p>
</div>
<div id="tabs-3">
<p>Lorem Ipsum Dolor Sit Amet...</p>
</div>
</div>

        ';
	dpm($page);

}

/**
* Implements hook_menu_local_tasks_alter().
* - Change Tab Names on User Profile Pages
*/
function dgd7_menu_local_tasks_alter(&$data, $router_item, $root_path) {
	if($root_path == 'user/%'){
		//Change the first title from 'View' to 'Profile'
		if($data['tabs'][0]['output'][0]['#link']['title'] == t('View')){
			$data['tabs'][0]['output'][0]['#link']['title'] = t('Profile');
		}

		//Chnage the second tab from 'Edit'  to 'Edit profile'.
		if($data['tabs'][0]['output'][1]['#link']['title'] == t('Edit')){
			$data['tabs'][0]['output'][1]['#link']['title'] = t('Edit Profile');
		}
	}
}

/**
* Implements hook_form_alter().
*/
function dgd7_form_alter(&$form, &$form_state, $form_id){
	//Change made in here affect All forms
	if(!empty($form['title']) && $form['title']['#type'] == 'textfield'){
		$form['title']['#size'] = 20;
		
	}
}

/**
* Implements hook_form_FORM_ID_alter().
*/
function dgd7_form_contact_site_form_alter(&$form, &$form_state)
{
	$form['note']['#markup'] = t("We'd love hear from you. Expect to hear back from us in 1-2 business days.");
	$form['note']['#weight'] = -1;

	// Change labels for the 'mail' and 'name' elements.
	$form['name']['#title'] = t('Name');
	$form['mail']['#title'] = t('E-mail');

	// Hide the subject field and give it a standard subject for value.
	$form['subject']['#type'] = 'hidden';
	$form['subject']['#value'] = t('Contact Form Submission');

}

/**
* Implements preprocess_html
*/
function dgd7_preprocess_html(&$variables){

	//Add conditional stylesheet that targets Internet Explorer 8 and below
	drupal_add_css(path_to_theme().'/css/ie.css', array(
		'weight' => CSS_THEME, 
		'browsers' => array('IE' => 'lte IE 8'),
		'preprocess' => FALSE,
		));
	//Add a stylesheet to homepage
	if($variables['is_front']){
		drupal_add_css(path_to_theme().'/css/homepage.css', array('weight' => CSS_THEME));
	}


}

/**
* Remove the node.css file
*/
function dgd7_css_alter(&$css){
	//Remove the node.css file
	if(isset($css['modules/node.css'])){
		unset($css['modules/node.css']);
	}
}

/* add js libraries */
drupal_add_library('system', 'ui.accordion');

/* add datetimepicker library */
drupal_add_library('system', 'ui.datepicker');

// add behaviour theme
drupal_add_library('system', 'ui.dialog');

drupal_add_library('system', 'ui.progressbar');

drupal_add_library('system', 'ui.resizable');

drupal_add_library('system', 'ui.selectable');

drupal_add_library('system', 'ui.slider');

drupal_add_library('system', 'ui.sortable');

drupal_add_library('system', 'ui.tabs');

// drupal_add_library('hello', 'my-first-library', TRUE);
drupal_add_js(drupal_get_path('theme','dgd7').'/js/behaviour.js');
