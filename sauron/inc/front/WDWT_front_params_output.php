<?php

class WDWT_frontend
{
  public $options;

  function __construct($wdwt_options){
    $this->options = $wdwt_options;
    /*var_dump($this->options['slider_head']);
    var_dump($this->options['slider_head_href']);
    var_dump($this->options['slider_head_title']);
    var_dump($this->options['slider_head_desc']);
	*/
    
  }

  /**
  *
  * return value of parameter for post, page or index page
  * first looks for parameter in meta, then if not found there, in options
  * @param $param_name 'menu_bg_color' or '[colors][menu][bg_color]'
  */
  public function get_param($param_name, $meta_array = array(), $default =''){
    $value=false;
    $options_array = $this->options;

    preg_match_all("/\[([^\]]*)\]/", $param_name, $matches);
    /*if param name is string*/
    if(empty($matches[1])){
      if(isset($meta_array[$param_name])){
        $value = $meta_array[$param_name];
      }
      elseif(isset($options_array[$param_name])){
        $value = $options_array[$param_name];
      }
      else{
        $value = $default;
      }
      return $value;
    }
    else{/*if param name is array*/
      $in_options = false;
      $in_meta = false;
      $value = $meta_array;
      foreach($matches[1] as $subparam)
      {
        if(isset($value[$subparam])){
          /*dig into meta array*/
          $value = $value[$subparam];
          $in_meta = true;
        }
        else{
          $in_meta = false;
          break;
        }
      }
      if($in_meta){
        /*param value is found in meta*/
        return $value;
      }
      $value = $options_array;
      foreach($matches[1] as $subparam)
      {
        if(isset($value[$subparam])){
          /*dig into options array*/
          $value = $value[$subparam];
          $in_options = true;
        }
        else{
          $in_options = false;
          break;
        }
      }
      if($in_options){
        /*param value is found in options*/
        return $value;
      }
      else{
        return $default;
      }
    }
    return $default;
    
  }


  /**
  *   Prints all front end typography styles
  */
  
 public function typography(){
		echo '<style type="text/css">';
			$this->typography_fonts();
			$this->typography_headers();
			$this->typography_primary();
			$this->typography_secondary();
			$this->typography_inputs();
		echo '</style>';
	}

	protected function typography_fonts(){ ?>
		@font-face { 
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-Bold.ttf");
			font-weight:bold;
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-BoldItalic.ttf");
			font-weight:bold;
			font-style:italic;
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-ExtraBold.ttf");
			font-weight:bolder;
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-ExtraBoldItalic.ttf");
			font-weight:bolder;
			font-style:italic;  
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-Italic.ttf");
			font-style:italic;
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-Light.ttf");
			font-weight:lighter;
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-LightItalic.ttf");
			font-weight:lighter;
			font-style:italic;
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-Regular.ttf"); 
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-Semibold.ttf");
			font-weight:500;
		}
		@font-face {
			font-family: "OpenSans";
			src: url("<?php echo WDWT_URL; ?>/inc/fonts/OpenSans-SemiboldItalic.ttf");
			font-weight:500;
			font-style:italic;
		}
    <?php
	}
	protected function typography_headers(){
		$text_headers_font = $this->get_param('text_headers_font');
		$text_headers_weight = $this->get_param('text_headers_weight');
		$text_headers_kern = $this->get_param('text_headers_kern');
		$text_headers_transform = $this->get_param('text_headers_transform');
		$text_headers_variant = $this->get_param('text_headers_variant');
		$text_headers_style = $this->get_param('text_headers_style');
		 ?>
			
		h1, h2, h3, h4, h5, h6 {
			font-family: <?php echo $text_headers_font[0]; ?>;
			font-weight: <?php echo $text_headers_weight[0]; ?>;
			letter-spacing: <?php echo $text_headers_kern[0]; ?>;
			text-transform: <?php echo $text_headers_transform[0]; ?>;
			font-variant: <?php echo $text_headers_variant[0]; ?>;
			font-style: <?php echo $text_headers_style[0]; ?>;
		}
			
    <?php
	}
	protected function typography_secondary(){
		$text_secondary_font = $this->get_param('text_secondary_font');
		$text_secondary_weight = $this->get_param('text_secondary_weight');
		$text_secondary_kern = $this->get_param('text_secondary_kern');
		$text_secondary_transform = $this->get_param('text_secondary_transform');
		$text_secondary_variant = $this->get_param('text_secondary_variant');
		$text_secondary_style = $this->get_param('text_secondary_style');?>
		
		.nav, .metabar, .subtext, .subhead, .widget-title, .reply a, .editpage, #page .wp-pagenavi, .post-edit-link, #wp-calendar caption, #wp-calendar thead th, .soapbox-links a, .fancybox, .standard-form .admin-links, .ftitle small {
			font-family: <?php echo $text_secondary_font[0]; ?>;
			font-weight: <?php echo $text_secondary_weight[0]; ?>;
			letter-spacing: <?php echo $text_secondary_kern[0]; ?>;
			text-transform: <?php echo $text_secondary_transform[0]; ?>;
			font-variant: <?php echo $text_secondary_variant[0]; ?>;
			font-style: <?php echo $text_secondary_style[0]; ?>;
		}
    <?php
	}
	protected function typography_primary(){
		$text_primary_font = $this->get_param('text_primary_font');
		$text_primary_weight = $this->get_param('text_primary_weight');
		$text_primary_kern = $this->get_param('text_primary_kern');
		$text_primary_transform = $this->get_param('text_primary_transform');
		$text_primary_variant = $this->get_param('text_primary_variant');
		$text_primary_style = $this->get_param('text_primary_style');
		 ?>
		
		body {
			font-family: <?php echo $text_primary_font[0]; ?>;
			font-weight: <?php echo $text_primary_weight[0]; ?>;
			letter-spacing: <?php echo $text_primary_kern[0]; ?>;
			text-transform: <?php echo $text_primary_transform[0]; ?>;
			font-variant: <?php echo $text_primary_variant[0]; ?>;
			font-style: <?php echo $text_primary_style[0]; ?>;
		}
	<?php
	}
	protected function typography_inputs(){
		$text_inputs_font = $this->get_param('text_inputs_font');
		$text_inputs_weight = $this->get_param('text_inputs_weight');
		$text_inputs_kern = $this->get_param('text_inputs_kern');
		$text_inputs_transform = $this->get_param('text_inputs_transform');
		$text_inputs_variant = $this->get_param('text_inputs_variant');
		$text_inputs_style = $this->get_param('text_inputs_style');
		 ?>
		
		input, textarea {
			font-family: <?php echo $text_inputs_font[0]; ?>;
			font-weight: <?php echo $text_inputs_weight[0]; ?>;
			letter-spacing: <?php echo $text_inputs_kern[0]; ?>;
			text-transform: <?php echo $text_inputs_transform[0]; ?>;
			font-variant: <?php echo $text_inputs_variant[0]; ?>;
			font-style: <?php echo $text_inputs_style[0]; ?>;
		}
    <?php
	}
  
  

 
 
 /**
  *    FRONT END FAVICON HTML
  */

  public function  favicon_img(){

    if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
      $favicon_img = esc_url(trim($this->get_param('favicon_img')));
      $favicon_enable = $this->get_param('favicon_enable');

      if($favicon_enable && $favicon_img) { ?>
        <link rel="shortcut icon" href="<?php echo $favicon_img; ?>" type="image/x-icon" />
      <?php  
      }  
    }
  }
  
 /**
  * Print custom css
  */

  public function custom_css(){

    $custom_css_enable = $this->get_param('custom_css_enable');
    $custom_css_text = stripslashes($this->get_param('custom_css_text'));
    if($custom_css_enable){
      echo "<style id='wdwt_custom_css_text'>".$custom_css_text."</style>"; 
    }
  }

  
  
 /**
  *  Modify output color, 
  *  add opacity
  */
  
  protected function hex_to_rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';
    //Return default if no color provided
    if(empty($color))
      return $default; 
    //Sanitize  color if "#" is provided 
    if ($color[0] == '#' ) {
      $color = substr( $color, 1 );
    }
    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
       $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
       $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
       return $default;
    }
    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);
    //Check if opacity is set(rgba or rgb)
    if($opacity){
      if(abs($opacity) > 1)
      $opacity = 1.0;
      $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
      $output = 'rgb('.implode(",",$rgb).')';
    }
    
    //Return rgb(a) color string
    return $output;
  }


  public function hex2rgb($colour) {
    if ($colour[0] == '#') {
      $colour = substr( $colour, 1 );
    }
    if (strlen($colour) == 6) {
      list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
    }
    else if (strlen($colour) == 3) {
      list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
    }
    else {
      return FALSE;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return array('red' => $r, 'green' => $g, 'blue' => $b);
  }
  
  

 /**
  *  Modify output color, 
  *  make color darker
  */
  
  protected function darker($color,$pracent){

    $new_color=$color;
    if(!(strlen($new_color==6) || strlen($new_color)==7))
    {
      return $color;
    }
    $color_vandakanishov=strpos($new_color,'#');
    if($color_vandakanishov == false) {
      $new_color= str_replace('#','',$new_color);
    }
    $color_part_1=substr($new_color, 0, 2);
    $color_part_2=substr($new_color, 2, 2);
    $color_part_3=substr($new_color, 4, 2);
    $color_part_1=dechex( (int) (hexdec( $color_part_1 ) - (hexdec( $color_part_1 )* $pracent / 100 )));
    $color_part_2=dechex( (int) (hexdec( $color_part_2)  - (( ( hexdec( $color_part_2 ) ) ) * $pracent / 100 )));
    $color_part_3=dechex( (int) (hexdec( $color_part_3 ) - (( ( hexdec( $color_part_3 ) ) ) * $pracent / 100 )));
    if(strlen($color_part_1)<2) $color_part_1="0".$color_part_1;
    if(strlen($color_part_2)<2) $color_part_2="0".$color_part_2;
    if(strlen($color_part_3)<2) $color_part_3="0".$color_part_3;

    $new_color=$color_part_1.$color_part_2.$color_part_3;
    if($color_vandakanishov == false){
      return $new_color;
    }
    else{
      return '#'.$new_color;
    }

  }

  /**
  *  Modify output color, 
  *  make color lighter
  */

  protected function ligther($color,$pracent=15){
  
    $new_color=$color;
    if(!(strlen($new_color==6) || strlen($new_color)==7))
    {
      return $color;
    }
    $color_vandakanishov=strpos($new_color,'#');
    if($color_vandakanishov == false) {
      $new_color= str_replace('#','',$new_color);
    }
    $color_part_1=substr($new_color, 0, 2);
    $color_part_2=substr($new_color, 2, 2);
    $color_part_3=substr($new_color, 4, 2);
    $color_part_1=dechex( (int) (hexdec( $color_part_1 ) + (( 255-( hexdec( $color_part_1 ) ) ) * $pracent / 100 )));
    $color_part_2=dechex( (int) (hexdec( $color_part_2)  + (( 255-( hexdec( $color_part_2 ) ) ) * $pracent / 100 )));
    $color_part_3=dechex( (int) (hexdec( $color_part_3 ) + (( 255-( hexdec( $color_part_3 ) ) ) * $pracent / 100 )));
    $new_color=$color_part_1.$color_part_2.$color_part_3;
    if($color_vandakanishov == false){
      return $new_color;
    }
    else{
      return '#'.$new_color;
    }
  }

 /**
  * return inverted color
  */

  protected function invert($color)
  {
    
    //get red, green and blue
    $r = substr($color, 0, 2);
    $g = substr($color, 2, 2);
    $b = substr($color, 4, 2);
    
    //revert them, they are decimal now
    $r = 0xff-hexdec($r);
    $g = 0xff-hexdec($g);
    $b = 0xff-hexdec($b);
    
    //now convert them to hex and return.
    return dechex($r).dechex($g).dechex($b);

  }













 

  /**
  * Prints style for menu background image
  */

  public function footer_text(){
    $footer_text_enable = $this->get_param('footer_text_enable');
    $footer_text = stripslashes($this->get_param('footer_text'));

    if($footer_text_enable) {
      echo stripslashes($footer_text);
    }
  }



}
  
  
  