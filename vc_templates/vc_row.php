<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = '';
$disable_element = '';
$output = $after_output = '';



/**** ThemeMount custom changes START ****/
$tm_textcolor = $tm_bgcolor = '';
/**** ThemeMount custom changes END ****/






$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );





wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$css_classes = array(
	//'vc_row',  // removed by ThemeMount
	'tm-row',  // added by ThemeMount. This is common class so we can design all rows.
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if ( vc_shortcode_custom_css_has_property( $css, array(
		'border',
		'background',
	) ) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_row-has-fill';
}



/**** ThemeMount custom changes START ****/
if( !empty($break_in_responsive) ){
	$css_classes[] = 'break-' . esc_attr($break_in_responsive) . '-colum';
}
/**** ThemeMount custom changes END ******/

/*
if( !empty($border_screw) ){
	$css_classes[] = '' . esc_attr($border_screw) . '-row';
}
*/

/**** ThemeMount custom changes START ****/
// Add container in Default condition
$tm_container_div_open  = '';
$tm_container_div_close = '';
$tm_container_class     = array('vc_row');


if( $full_width=='' ){  // Row Stretch: Default
	$css_classes[] = 'vc_row';
	$css_classes[] = 'container';
	foreach( array_keys($tm_container_class, 'vc_row') as $key ){
		unset($tm_container_class[$key]);
	}
}

if( $full_width=='stretch_row' ){  // Row Stretch: Stretch Row
	$tm_container_div_open  = '<div class="container"><!-- ThemeMount custom DIV added -->';
	$tm_container_div_close = '</div><!-- ThemeMount custom DIV added -->';
	$tm_container_class[] = 'container';
}
/**** ThemeMount custom changes END ****/





/**** ThemeMount custom changes START ****/


if( !empty($tm_textcolor) ){
	$css_classes[] = 'tm-textcolor-'.$tm_textcolor;
}
if( !empty($tm_bgcolor) ){
	$css_classes[] = 'tm-bgcolor-'.$tm_bgcolor;
}
if( !empty($tm_bgimage_position) ){
	$css_classes[] = 'tm-bgimage-position-'.$tm_bgimage_position;
}

/**** ThemeMount custom changes END ****/



if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	//$css_classes[] = 'vc_column-gap-'.$atts['gap'];  // removed by ThemeMount
	$tm_container_class[] = 'vc_column-gap-'.$atts['gap'];  // added by ThemeMount
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row';  // removed by ThemeMount
		
		// added by ThemeMount START
		foreach( array_keys($tm_container_class, 'vc_row') as $key ){
			unset($tm_container_class[$key]);
		}
		
		if (!empty($atts['gap'])) {
			foreach( array_keys($tm_container_class, 'vc_column-gap-'.$atts['gap'] ) as $key ){
				unset($tm_container_class[$key]);
			}
			$css_classes[] = 'vc_column-gap-'.$atts['gap'];  // added by ThemeMount
		}
		// added by ThemeMount END
		
		
		
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		//$css_classes[] = 'vc_row-no-padding';
		$tm_container_class[] = 'vc_row-no-padding'; // added by ThemeMount
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$tm_container_class[] = 'vc_row-o-equal-height';  // addd by ThemeMount
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$tm_container_class[] = 'vc_row-flex';  // addd by ThemeMount  
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[] = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}


/**** ThemeMount custom changes START ****/
$tm_bgimage = false;
if( !empty( $parallax_image ) || strpos($css, 'url(') !== false || $has_video_bg==true ){
	$tm_bgimage 	= true;
	$css_classes[]  = 'tm-bg';
	$css_classes[]  = 'tm-bgimage-yes';
}
/**** ThemeMount custom changes END ****/


if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

?>




<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

	<?php if ( $tm_bgimage == true || $has_video_bg==true ) { // ThemeMount custom changes START  ?>
		<div class="tm-row-wrapper-bg-layer tm-bg-layer"></div><!-- ThemeMount custom DIV added -->
	<?php } // ThemeMount custom changes END ?>
	
	<?php if( !empty($tm_container_class) ): // ThemeMount custom changes START ?> <div class="<?php echo implode( ' ', $tm_container_class ); ?>"> <?php endif; // ThemeMount custom changes END ?>
	
		<?php echo wpb_js_remove_wpautop( $content ); ?>
		
	<?php if( !empty($tm_container_class) ): // ThemeMount custom changes START ?> </div> <?php endif; // ThemeMount custom changes END ?>
</div>


<?php
echo wp_kses( /* HTML Filter */
	$after_output,
	array(
		'div'    => array(
			'class' => array(),
		),
		'span'    => array(
			'class' => array(),
		),
		'p'    => array(
			'class' => array(),
		),
		'img' => array(
			'class'  => array(),
			'src'    => array(),
			'alt'    => array(),
			'title'  => array(),
			'width'  => array(),
			'height' => array(),
		),
	)
);
?>





<?php
/* Added by ThemeMount - code start */

$css_code = '.bimal{padding-top:0px;}';
wp_add_inline_style( 'fixology-last-checkpoint', $css_code );


$customStyle = '';
if(trim($css)!= ''){
	$new_bgimage_element = vc_shortcode_custom_css_class( $css, '' ). ' > .tm-row-wrapper-bg-layer';
	$newCSS   			 = str_replace( vc_shortcode_custom_css_class( $css, '' ),$new_bgimage_element,$css );
	$customStyle  		.= $newCSS;
	
	// Inline CSS global variable
	global $thememount_inline_css;
	if( empty($thememount_inline_css) ){
		$thememount_inline_css = '';
	}
	$thememount_inline_css .= trim($newCSS);
	$thememount_inline_css .= '.' . vc_shortcode_custom_css_class( $css, '' ) . ' > .tm-row-wrapper-bg-layer{background-image: none !important;}';


}

/* Added by ThemeMount - code end */
