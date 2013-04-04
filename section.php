<?php
/*
	Section: County
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://county.ahansson.com
	Version: 1.1
	Description: County is a countdown section that can count down to any date into the future. Use as Coming Soon Page or as countdown for your birtday - or whatever you need a countdown for!
	Class Name: PageLinesCounty
	Workswith: templates, main, sidebar1, sidebar2, sidebar_wrap, header, footer, morefoot
	Cloning:true
*/

/**
 * PageLines County Section
 *
 * @package PageLines Framework
 * @author Aleksander Hansson
 */

/* Commented out because PL is not providing a per page LESS option

add_filter( 'pless_vars', 'pl_counter_less');

function pl_counter_less( $constants ){
	
	$countdown_background_color = (ploption('countdown-background-color')) ? ploption('countdown-background-color') : '#1568AD';
	$countdown_label_color = (ploption('countdown-label-color')) ? ploption('countdown-label-color') : '#000000';
	$countdown_text_color = (ploption('countdown-text-color')) ? ploption('countdown-text-color') : '#ffffff';


	$newvars = array(
	
		'countdownbackgroundcolor' => $countdown_background_color ,
		'countdownlabelcolor' => $countdown_label_color ,
		'countdowntextcolor' => $countdown_text_color

	);

	$lessvars = array_merge($newvars, $constants);
	return $lessvars;
}
*/

class PageLinesCounty extends PageLinesSection {
	
	function section_styles(){
		
		// $this->base_url
		
		$countdown_terms_days = ploption( 'countdown-terms-days' ) ? ploption( 'countdown-terms-days' ) : 'Days';
		$countdown_terms_hours = ploption( 'countdown-terms-hours' ) ? ploption( 'countdown-terms-hours' ) : 'Hours';
		$countdown_terms_minutes = ploption( 'countdown-terms-minutes' ) ? ploption( 'countdown-terms-minutes' ) : 'Minutes';
		$countdown_terms_seconds = ploption( 'countdown-terms-seconds' ) ? ploption( 'countdown-terms-seconds' ) : 'Seconds';
		
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('pl-countdown-script', $this->base_url.'/js/jquery.countdown.js');
		
		wp_localize_script( 'pl-countdown-script', 'pl_countdown_settings', array(

			'countdown_terms_days'	  => $countdown_terms_days ,
			'countdown_terms_hours'	=> $countdown_terms_hours ,
			'countdown_terms_minutes'	 => $countdown_terms_minutes ,
			'countdown_terms_seconds'	   => $countdown_terms_seconds

		));
		
	}
	
	function section_head( $clone_id ) {
	
	$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';
	
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var count<?php $prefix ?> = new Date();
			count<?php $prefix ?> = new Date(<?php echo ploption('countdown-timestamp-year', $this->tset) ? ploption('countdown-timestamp-year', $this->tset) : 'count.getFullYear() + 1'; ?>, <?php echo ploption('countdown-timestamp-month', $this->tset) ? ploption('countdown-timestamp-month', $this->tset) : '0'; ?>, <?php echo ploption('countdown-timestamp-date', $this->tset) ? ploption('countdown-timestamp-date', $this->tset) : '1'; ?>, <?php echo ploption('countdown-timestamp-hour', $this->tset) ? ploption('countdown-timestamp-hour', $this->tset) : '0'; ?>, <?php echo ploption('countdown-timestamp-minute', $this->tset) ? ploption('countdown-timestamp-minute', $this->tset) : '0'; ?>, <?php echo ploption('countdown-timestamp-seconds', $this->tset) ? ploption('countdown-timestamp-seconds', $this->tset) : '0'; ?>);
			jQuery('#defaultCountdown<?php echo $prefix;?>').countdown({until: count<?php $prefix ?>, format: 'DHMS', layout: '<div class="row center"><div class="span6 zmb"><div class="row">{d<}<div class="span6 pl-countdown-days pl-countdown-numbers zmb">{dn}<div class="row pl-countdown-labels">{dl}</div></div>{d>}{h<}<div class="span6 pl-countdown-hours pl-countdown-numbers zmb">{hn}<div class="row pl-countdown-labels">{hl}</div></div>{h>}</div></div><div class="span6 zmb"><div class="row">{m<}<div class="span6 pl-countdown-minutes pl-countdown-numbers zmb">{mn}<div class="row pl-countdown-labels">{ml}</div></div>{m>}{s<}<div class="span6 pl-countdown-seconds pl-countdown-numbers zmb">{sn}<div class="row pl-countdown-labels">{sl}</div></div>{s>}</div></div></div>'});
			jQuery('#year').text(count<?php $prefix ?>.getFullYear());
		});
	</script>
	<?php
	
	}
	
	function section_template( $clone_id ) {
	
	$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';
	
	$field1 = ploption('countdown-description-header', $this->tset) ? ploption('countdown-description-header', $this->tset) : 'Time to launch . . .';
	$field2 = ploption('countdown-description-subhead', $this->tset) ? ploption('countdown-description-subhead', $this->tset) : 'We are launching our site in . . .';
	$field3 = ploption('countdown-description-below', $this->tset) ? ploption('countdown-description-below', $this->tset) : 'This is default for County! Go to PageLines Page Options for your settings.';
	$field4 = ploption('countdown-description-shortcode', $this->tset) ? ploption('countdown-description-shortcode', $this->tset) : 'This is default for County! Go to PageLines Page Options for your settings.';


	?>
	<div class="pl-countdown-container">
		
		<div class="pl-countdown-header center"><?php echo do_shortcode( $field1 ); ?></div>
		
		<div class="pl-countdown-subhead center"><?php echo do_shortcode( $field2 );  ?></div>
	
		<?php echo sprintf ('<div id="defaultCountdown%s"></div>', $prefix); ?>
		
		<div class="pl-countdown-below center"><?php echo do_shortcode( $field3 ); ?></div>

		<div class="pl-countdown-shortcode center"><?php echo do_shortcode( $field4 ); ?></div>

	
	</div>
	<?php
	
	}
	
	function section_optionator( $settings ){

		$settings = wp_parse_args($settings, $this->optionator_default);

		$options = array(

/* Commented out because PL is not providing a per page LESS option
			//Color options
			'countdown-colors'   => array(
				'default'    => '',
				'type'     => 'color_multi',
				'title'     =>  __('Select the color options', 'PageLinesCounty'),
				'selectvalues'   => array(
					'countdown-text-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County text color', 'PageLinesCounty'),
						'inputlabel'  =>  __('Choose text color for your countdown.', 'PageLinesCounty'),
					),
					'countdown-label-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County label color', 'PageLinesCounty'),
						'inputlabel'  =>  __('Choose text color for your labels that is below the numbers.', 'PageLinesCounty'),
					),
					'countdown-background-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County background color', 'PageLinesCounty'),
						'inputlabel'  =>  __('Choose base color for your countdown.', 'PageLinesCounty'),
					)
				)
			),
*/

			'countdown-description'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Your text options', 'PageLinesCounty'),
				'shortexp'   =>  __('Type in your text for the countdown.', 'PageLinesCounty'),
				'selectvalues'   => array(
					'countdown-description-header' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom countdown header text', 'PageLinesCounty'),
						'inputlabel'  =>  __('Your custom countdown header text', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: "The offer is ending in:" or "Site is launching in:"', 'PageLinesCounty'),
					),
					'countdown-description-subhead' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom subheading text above the counter', 'PageLinesCounty'),
						'inputlabel'  =>  __('Your custom text above the counter', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: "Hurry up and go to the store!" or "We are building something amazing"', 'PageLinesCounty'),
					),
					'countdown-description-below' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom subheading text below the counter', 'PageLinesCounty'),
						'inputlabel'  =>  __('Your custom text below the counter', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: "Click here to go to the store:" or "If you want to get in touch, please call us at +1 1234 123 123"', 'PageLinesCounty'),
					),
					'countdown-description-shortcode' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Shortcode input', 'PageLinesCounty'),
						'inputlabel'  =>  __('Add a shortcode for yout timer', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: "An email capture form."', 'PageLinesCounty'),
					)
				)
			),
			'countdown-terms'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Your terms for time', 'PageLinesCounty'),
				'shortexp'   =>  __('You can type in your own custom terms of time.', 'PageLinesCounty'),
				'selectvalues'   => array(
					'countdown-terms-days' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "days"', 'PageLinesCounty'),
						'inputlabel'  =>  __('Your custom "days"', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: In your language.', 'PageLinesCounty'),
					),
					'countdown-terms-hours' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "hours"', 'PageLinesCounty'),
						'inputlabel'  =>  __('Your custom "hours"', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: In your language.', 'PageLinesCounty'),
					),
					'countdown-terms-minutes' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "minutes"', 'PageLinesCounty'),
						'inputlabel'  =>  __('Your custom "minutes"', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: In your language.', 'PageLinesCounty'),
					),
					'countdown-terms-seconds' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "seconds"', 'PageLinesCounty'),
						'inputlabel'  =>  __('Your custom "seconds"', 'PageLinesCounty'),
						'shortexp'   =>  __('For example: In your language.', 'PageLinesCounty'),
					))),
			'countdown-timestamp'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Select the date you are counting down for.', 'PageLinesCounty'),
				'shortexp'   =>  __('Please make a selection in all selectors.', 'PageLinesCounty'),
				'selectvalues'   => array(
					'countdown-timestamp-date' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'1' => array( 'name' => __( '1st'   , 'PageLinesCounty' )),
							'2' => array( 'name' => __( '2nd'   , 'PageLinesCounty' )),
							'3' => array( 'name' => __( '3rd'    , 'PageLinesCounty' )),
							'4' => array( 'name' => __( '4th'    , 'PageLinesCounty' )),
							'5' => array( 'name' => __( '5th'    , 'PageLinesCounty' )),
							'6' => array( 'name' => __( '6th'    , 'PageLinesCounty' )),
							'7' => array( 'name' => __( '7th'    , 'PageLinesCounty' )),
							'8' => array( 'name' => __( '8th'  , 'PageLinesCounty' )),
							'9' => array( 'name' => __( '9th'    , 'PageLinesCounty' )),
							'10' => array( 'name' => __( '10th'    , 'PageLinesCounty' )),
							'11' => array( 'name' => __( '11th'    , 'PageLinesCounty' )),
							'12' => array( 'name' => __( '12th'    , 'PageLinesCounty' )),
							'13' => array( 'name' => __( '13th'     , 'PageLinesCounty' )),
							'14' => array( 'name' => __( '14th'   , 'PageLinesCounty' )),
							'15' => array( 'name' => __( '15th'    , 'PageLinesCounty' )),
							'16' => array( 'name' => __( '16th'    , 'PageLinesCounty' )),
							'17' => array( 'name' => __( '17th'    , 'PageLinesCounty' )),
							'18' => array( 'name' => __( '18th'    , 'PageLinesCounty' )),
							'19' => array( 'name' => __( '19th'    , 'PageLinesCounty' )),
							'20' => array( 'name' => __( '20th'  , 'PageLinesCounty' )),
							'21' => array( 'name' => __( '21st'  , 'PageLinesCounty' )),
							'22' => array( 'name' => __( '22nd'  , 'PageLinesCounty' )),
							'23' => array( 'name' => __( '23rd'    , 'PageLinesCounty' )),
							'24' => array( 'name' => __( '24th'     , 'PageLinesCounty' )),
							'25' => array( 'name' => __( '25th'    , 'PageLinesCounty' )),
							'26' => array( 'name' => __( '26th'     , 'PageLinesCounty' )),
							'27' => array( 'name' => __( '27th' , 'PageLinesCounty' )),
							'28' => array( 'name' => __( '28th'  , 'PageLinesCounty' )),
							'29' => array( 'name' => __( '29th' , 'PageLinesCounty' )),
							'30' => array( 'name' => __( '30th'    , 'PageLinesCounty' )),
							'31' => array( 'name' => __( '31st'    , 'PageLinesCounty' ))
						),
						'title'   =>  __('Select date', 'PageLinesCounty'),
					),
					'countdown-timestamp-month' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( 'January'   , 'PageLinesCounty' )),
							'1' => array( 'name' => __( 'February'   , 'PageLinesCounty' )),
							'2' => array( 'name' => __( 'March'   , 'PageLinesCounty' )),
							'3' => array( 'name' => __( 'April'    , 'PageLinesCounty' )),
							'4' => array( 'name' => __( 'May'    , 'PageLinesCounty' )),
							'5' => array( 'name' => __( 'June'    , 'PageLinesCounty' )),
							'6' => array( 'name' => __( 'July'    , 'PageLinesCounty' )),
							'7' => array( 'name' => __( 'August'    , 'PageLinesCounty' )),
							'8' => array( 'name' => __( 'September'  , 'PageLinesCounty' )),
							'9' => array( 'name' => __( 'October'    , 'PageLinesCounty' )),
							'10' => array( 'name' => __( 'November'    , 'PageLinesCounty' )),
							'11' => array( 'name' => __( 'December'    , 'PageLinesCounty' ))
						),
						'title'   =>  __('Select month', 'PageLinesCounty'),
					),
					'countdown-timestamp-year' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'2013' => array( 'name' => __( '2013'   , 'PageLinesCounty' )),
							'2014' => array( 'name' => __( '2014'   , 'PageLinesCounty' )),
							'2015' => array( 'name' => __( '2015'    , 'PageLinesCounty' )),
							'2016' => array( 'name' => __( '2016'    , 'PageLinesCounty' )),
							'2017' => array( 'name' => __( '2017'    , 'PageLinesCounty' )),
							'2018' => array( 'name' => __( '2018'    , 'PageLinesCounty' )),
							'2019' => array( 'name' => __( '2019'    , 'PageLinesCounty' )),
							'2020' => array( 'name' => __( '2020'  , 'PageLinesCounty' )),
							'2021' => array( 'name' => __( '2021'    , 'PageLinesCounty' )),
							'2022' => array( 'name' => __( '2022'    , 'PageLinesCounty' )),
							'2023' => array( 'name' => __( '2023'    , 'PageLinesCounty' ))
						),
						'title'   =>  __('Select year', 'PageLinesCounty'),
					),
					'countdown-timestamp-hour' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'PageLinesCounty' )),
							'1' => array( 'name' => __( '1'   , 'PageLinesCounty' )),
							'2' => array( 'name' => __( '2'   , 'PageLinesCounty' )),
							'3' => array( 'name' => __( '3'    , 'PageLinesCounty' )),
							'4' => array( 'name' => __( '4'    , 'PageLinesCounty' )),
							'5' => array( 'name' => __( '5'    , 'PageLinesCounty' )),
							'6' => array( 'name' => __( '6'    , 'PageLinesCounty' )),
							'7' => array( 'name' => __( '7'    , 'PageLinesCounty' )),
							'8' => array( 'name' => __( '8'  , 'PageLinesCounty' )),
							'9' => array( 'name' => __( '9'    , 'PageLinesCounty' )),
							'10' => array( 'name' => __( '10'    , 'PageLinesCounty' )),
							'11' => array( 'name' => __( '11'    , 'PageLinesCounty' )),
							'12' => array( 'name' => __( '12'    , 'PageLinesCounty' )),
							'13' => array( 'name' => __( '13'     , 'PageLinesCounty' )),
							'14' => array( 'name' => __( '14'   , 'PageLinesCounty' )),
							'15' => array( 'name' => __( '15'    , 'PageLinesCounty' )),
							'16' => array( 'name' => __( '16'    , 'PageLinesCounty' )),
							'17' => array( 'name' => __( '17'    , 'PageLinesCounty' )),
							'18' => array( 'name' => __( '18'    , 'PageLinesCounty' )),
							'19' => array( 'name' => __( '19'    , 'PageLinesCounty' )),
							'20' => array( 'name' => __( '20'  , 'PageLinesCounty' )),
							'21' => array( 'name' => __( '21'  , 'PageLinesCounty' )),
							'22' => array( 'name' => __( '22'  , 'PageLinesCounty' )),
							'23' => array( 'name' => __( '23'    , 'PageLinesCounty' ))
						),
						'title'   =>  __('Select hour', 'PageLinesCounty'),
					),
					'countdown-timestamp-minute' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'PageLinesCounty' )),
							'1' => array( 'name' => __( '1'   , 'PageLinesCounty' )),
							'2' => array( 'name' => __( '2'   , 'PageLinesCounty' )),
							'3' => array( 'name' => __( '3'    , 'PageLinesCounty' )),
							'4' => array( 'name' => __( '4'    , 'PageLinesCounty' )),
							'5' => array( 'name' => __( '5'    , 'PageLinesCounty' )),
							'6' => array( 'name' => __( '6'    , 'PageLinesCounty' )),
							'7' => array( 'name' => __( '7'    , 'PageLinesCounty' )),
							'8' => array( 'name' => __( '8'  , 'PageLinesCounty' )),
							'9' => array( 'name' => __( '9'    , 'PageLinesCounty' )),
							'10' => array( 'name' => __( '10'    , 'PageLinesCounty' )),
							'11' => array( 'name' => __( '11'    , 'PageLinesCounty' )),
							'12' => array( 'name' => __( '12'    , 'PageLinesCounty' )),
							'13' => array( 'name' => __( '13'     , 'PageLinesCounty' )),
							'14' => array( 'name' => __( '14'   , 'PageLinesCounty' )),
							'15' => array( 'name' => __( '15'    , 'PageLinesCounty' )),
							'16' => array( 'name' => __( '16'    , 'PageLinesCounty' )),
							'17' => array( 'name' => __( '17'    , 'PageLinesCounty' )),
							'18' => array( 'name' => __( '18'    , 'PageLinesCounty' )),
							'19' => array( 'name' => __( '19'    , 'PageLinesCounty' )),
							'20' => array( 'name' => __( '20'  , 'PageLinesCounty' )),
							'21' => array( 'name' => __( '21'  , 'PageLinesCounty' )),
							'22' => array( 'name' => __( '22'  , 'PageLinesCounty' )),
							'23' => array( 'name' => __( '23'    , 'PageLinesCounty' )),
							'24' => array( 'name' => __( '24'     , 'PageLinesCounty' )),
							'25' => array( 'name' => __( '25'    , 'PageLinesCounty' )),
							'26' => array( 'name' => __( '26'     , 'PageLinesCounty' )),
							'27' => array( 'name' => __( '27' , 'PageLinesCounty' )),
							'28' => array( 'name' => __( '28'  , 'PageLinesCounty' )),
							'29' => array( 'name' => __( '29' , 'PageLinesCounty' )),
							'30' => array( 'name' => __( '30'    , 'PageLinesCounty' )),
							'31' => array( 'name' => __( '31'    , 'PageLinesCounty' )),
							'32' => array( 'name' => __( '32'   , 'PageLinesCounty' )),
							'33' => array( 'name' => __( '33'    , 'PageLinesCounty' )),
							'34' => array( 'name' => __( '34'    , 'PageLinesCounty' )),
							'35' => array( 'name' => __( '35'    , 'PageLinesCounty' )),
							'36' => array( 'name' => __( '36'    , 'PageLinesCounty' )),
							'37' => array( 'name' => __( '37'    , 'PageLinesCounty' )),
							'38' => array( 'name' => __( '38'  , 'PageLinesCounty' )),
							'39' => array( 'name' => __( '39'    , 'PageLinesCounty' )),
							'40' => array( 'name' => __( '40'    , 'PageLinesCounty' )),
							'41' => array( 'name' => __( '41'    , 'PageLinesCounty' )),
							'42' => array( 'name' => __( '42'    , 'PageLinesCounty' )),
							'43' => array( 'name' => __( '43'     , 'PageLinesCounty' )),
							'44' => array( 'name' => __( '44'   , 'PageLinesCounty' )),
							'45' => array( 'name' => __( '45'    , 'PageLinesCounty' )),
							'46' => array( 'name' => __( '46'    , 'PageLinesCounty' )),
							'47' => array( 'name' => __( '47'    , 'PageLinesCounty' )),
							'48' => array( 'name' => __( '48'    , 'PageLinesCounty' )),
							'49' => array( 'name' => __( '49'    , 'PageLinesCounty' )),
							'50' => array( 'name' => __( '50'  , 'PageLinesCounty' )),
							'51' => array( 'name' => __( '51'  , 'PageLinesCounty' )),
							'52' => array( 'name' => __( '52'  , 'PageLinesCounty' )),
							'53' => array( 'name' => __( '53'    , 'PageLinesCounty' )),
							'54' => array( 'name' => __( '54'     , 'PageLinesCounty' )),
							'55' => array( 'name' => __( '55'    , 'PageLinesCounty' )),
							'56' => array( 'name' => __( '56'     , 'PageLinesCounty' )),
							'57' => array( 'name' => __( '57' , 'PageLinesCounty' )),
							'58' => array( 'name' => __( '58'  , 'PageLinesCounty' )),
							'59' => array( 'name' => __( '59' , 'PageLinesCounty' ))
						),
						'title'   =>  __('Select minute', 'PageLinesCounty'),
					),
					'countdown-timestamp-second' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'PageLinesCounty' )),
							'1' => array( 'name' => __( '1'   , 'PageLinesCounty' )),
							'2' => array( 'name' => __( '2'   , 'PageLinesCounty' )),
							'3' => array( 'name' => __( '3'    , 'PageLinesCounty' )),
							'4' => array( 'name' => __( '4'    , 'PageLinesCounty' )),
							'5' => array( 'name' => __( '5'    , 'PageLinesCounty' )),
							'6' => array( 'name' => __( '6'    , 'PageLinesCounty' )),
							'7' => array( 'name' => __( '7'    , 'PageLinesCounty' )),
							'8' => array( 'name' => __( '8'  , 'PageLinesCounty' )),
							'9' => array( 'name' => __( '9'    , 'PageLinesCounty' )),
							'10' => array( 'name' => __( '10'    , 'PageLinesCounty' )),
							'11' => array( 'name' => __( '11'    , 'PageLinesCounty' )),
							'12' => array( 'name' => __( '12'    , 'PageLinesCounty' )),
							'13' => array( 'name' => __( '13'     , 'PageLinesCounty' )),
							'14' => array( 'name' => __( '14'   , 'PageLinesCounty' )),
							'15' => array( 'name' => __( '15'    , 'PageLinesCounty' )),
							'16' => array( 'name' => __( '16'    , 'PageLinesCounty' )),
							'17' => array( 'name' => __( '17'    , 'PageLinesCounty' )),
							'18' => array( 'name' => __( '18'    , 'PageLinesCounty' )),
							'19' => array( 'name' => __( '19'    , 'PageLinesCounty' )),
							'20' => array( 'name' => __( '20'  , 'PageLinesCounty' )),
							'21' => array( 'name' => __( '21'  , 'PageLinesCounty' )),
							'22' => array( 'name' => __( '22'  , 'PageLinesCounty' )),
							'23' => array( 'name' => __( '23'    , 'PageLinesCounty' )),
							'24' => array( 'name' => __( '24'     , 'PageLinesCounty' )),
							'25' => array( 'name' => __( '25'    , 'PageLinesCounty' )),
							'26' => array( 'name' => __( '26'     , 'PageLinesCounty' )),
							'27' => array( 'name' => __( '27' , 'PageLinesCounty' )),
							'28' => array( 'name' => __( '28'  , 'PageLinesCounty' )),
							'29' => array( 'name' => __( '29' , 'PageLinesCounty' )),
							'30' => array( 'name' => __( '30'    , 'PageLinesCounty' )),
							'31' => array( 'name' => __( '31'    , 'PageLinesCounty' )),
							'32' => array( 'name' => __( '32'   , 'PageLinesCounty' )),
							'33' => array( 'name' => __( '33'    , 'PageLinesCounty' )),
							'34' => array( 'name' => __( '34'    , 'PageLinesCounty' )),
							'35' => array( 'name' => __( '35'    , 'PageLinesCounty' )),
							'36' => array( 'name' => __( '36'    , 'PageLinesCounty' )),
							'37' => array( 'name' => __( '37'    , 'PageLinesCounty' )),
							'38' => array( 'name' => __( '38'  , 'PageLinesCounty' )),
							'39' => array( 'name' => __( '39'    , 'PageLinesCounty' )),
							'40' => array( 'name' => __( '40'    , 'PageLinesCounty' )),
							'41' => array( 'name' => __( '41'    , 'PageLinesCounty' )),
							'42' => array( 'name' => __( '42'    , 'PageLinesCounty' )),
							'43' => array( 'name' => __( '43'     , 'PageLinesCounty' )),
							'44' => array( 'name' => __( '44'   , 'PageLinesCounty' )),
							'45' => array( 'name' => __( '45'    , 'PageLinesCounty' )),
							'46' => array( 'name' => __( '46'    , 'PageLinesCounty' )),
							'47' => array( 'name' => __( '47'    , 'PageLinesCounty' )),
							'48' => array( 'name' => __( '48'    , 'PageLinesCounty' )),
							'49' => array( 'name' => __( '49'    , 'PageLinesCounty' )),
							'50' => array( 'name' => __( '50'  , 'PageLinesCounty' )),
							'51' => array( 'name' => __( '51'  , 'PageLinesCounty' )),
							'52' => array( 'name' => __( '52'  , 'PageLinesCounty' )),
							'53' => array( 'name' => __( '53'    , 'PageLinesCounty' )),
							'54' => array( 'name' => __( '54'     , 'PageLinesCounty' )),
							'55' => array( 'name' => __( '55'    , 'PageLinesCounty' )),
							'56' => array( 'name' => __( '56'     , 'PageLinesCounty' )),
							'57' => array( 'name' => __( '57' , 'PageLinesCounty' )),
							'58' => array( 'name' => __( '58'  , 'PageLinesCounty' )),
							'59' => array( 'name' => __( '59' , 'PageLinesCounty' ))
						),
						'title'   =>  __('Select seconds', 'PageLinesCounty'),
					)
				)
			),
		);

		$tab_settings = array(

			'id'  => 'countdown_options',
			'name'  => 'County',
			'icon'  => $this->icon,
			'clone_id' => $settings['clone_id'],
			'active' => $settings['active']
		);

		register_metatab($tab_settings, $options, $this->class_name);

	}

}