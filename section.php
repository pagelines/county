<?php
/*
	Section: County
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://county.ahansson.com
	Version: 1.0
	Description: County is your countdown section for PageLines. County can countdown to any date and any time into the future. Do you need a beautiful landing page while you are developing your site and want to let your customers know when you are up and running? Well County can do that for you. You can even tell your friends on your personal blog that your birthday is coming up. Oh... did I tell County is cloneable? You can have as many countdowns as you want anywhere on your PageLines site. What are you waiting for? Click the buy button! :)
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
			count<?php $prefix ?> = new Date(<?php echo ploption('countdown-timestamp-year', $this->oset) ? ploption('countdown-timestamp-year', $this->oset) : 'count.getFullYear() + 1'; ?>, <?php echo ploption('countdown-timestamp-month', $this->oset) ? ploption('countdown-timestamp-month', $this->oset) : '0'; ?>, <?php echo ploption('countdown-timestamp-date', $this->oset) ? ploption('countdown-timestamp-date', $this->oset) : '1'; ?>, <?php echo ploption('countdown-timestamp-hour', $this->oset) ? ploption('countdown-timestamp-hour', $this->oset) : '0'; ?>, <?php echo ploption('countdown-timestamp-minute', $this->oset) ? ploption('countdown-timestamp-minute', $this->oset) : '0'; ?>, <?php echo ploption('countdown-timestamp-seconds', $this->oset) ? ploption('countdown-timestamp-seconds', $this->oset) : '0'; ?>);
			jQuery('#defaultCountdown<?php echo $prefix;?>').countdown({until: count<?php $prefix ?>, format: 'DHMS', layout: '<div class="row center"><div class="span6 zmb"><div class="row">{d<}<div class="span6 pl-countdown-days pl-countdown-numbers zmb">{dn}<div class="row pl-countdown-labels">{dl}</div></div>{d>}{h<}<div class="span6 pl-countdown-hours pl-countdown-numbers zmb">{hn}<div class="row pl-countdown-labels">{hl}</div></div>{h>}</div></div><div class="span6 zmb"><div class="row">{m<}<div class="span6 pl-countdown-minutes pl-countdown-numbers zmb">{mn}<div class="row pl-countdown-labels">{ml}</div></div>{m>}{s<}<div class="span6 pl-countdown-seconds pl-countdown-numbers zmb">{sn}<div class="row pl-countdown-labels">{sl}</div></div>{s>}</div></div></div>'});
			jQuery('#year').text(count<?php $prefix ?>.getFullYear());
		});
	</script>
	<?php
	
	}
	
	function section_template( $clone_id ) {
	
	$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';
	
	?>
	<div class="pl-countdown-container">
		
		<div class="pl-countdown-header center"><?php echo ploption('countdown-description-header', $this->oset) ? ploption('countdown-description-header', $this->oset) : 'Time until New Year!!!'; ?></div>
		
		<div class="pl-countdown-subhead center"><?php echo ploption('countdown-description-subhead', $this->oset) ? ploption('countdown-description-subhead', $this->oset) : 'Get ready with the champagne...'; ?></div>
	
		<?php echo sprintf ('<div id="defaultCountdown%s"></div>', $prefix); ?>
		
		<div class="pl-countdown-below center"><?php echo ploption('countdown-description-below', $this->oset) ? ploption('countdown-description-below', $this->oset) : 'This is default for County! Go to PageLines Page Options for your settings.'; ?></div>
	
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
				'title'     =>  __('Select the color options', 'pagelines'),
				'selectvalues'   => array(
					'countdown-text-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County text color', 'pagelines'),
						'inputlabel'  =>  __('Choose text color for your countdown.', 'pagelines'),
					),
					'countdown-label-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County label color', 'pagelines'),
						'inputlabel'  =>  __('Choose text color for your labels that is below the numbers.', 'pagelines'),
					),
					'countdown-background-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County background color', 'pagelines'),
						'inputlabel'  =>  __('Choose base color for your countdown.', 'pagelines'),
					)
				)
			),
*/

			'countdown-description'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Your text options', 'pagelines'),
				'shortexp'   =>  __('Type in your text for the countdown.', 'pagelines'),
				'selectvalues'   => array(
					'countdown-description-header' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom countdown header text', 'pagelines'),
						'inputlabel'  =>  __('Your custom countdown header text', 'pagelines'),
						'shortexp'   =>  __('For example: "The offer is ending in:" or "Site is launching in:"', 'pagelines'),
					),
					'countdown-description-subhead' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom subheading text above the counter', 'pagelines'),
						'inputlabel'  =>  __('Your custom text above the counter', 'pagelines'),
						'shortexp'   =>  __('For example: "Hurry up and go to the store!" or "We are building something amazing"', 'pagelines'),
					),
					'countdown-description-below' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom subheading text below the counter', 'pagelines'),
						'inputlabel'  =>  __('Your custom text below the counter', 'pagelines'),
						'shortexp'   =>  __('For example: "Click here to go to the store:" or "If you want to get in touch, please call us at +1 1234 123 123"', 'pagelines'),
					))),
			'countdown-terms'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Your terms for time', 'pagelines'),
				'shortexp'   =>  __('You can type in your own custom terms of time.', 'pagelines'),
				'selectvalues'   => array(
					'countdown-terms-days' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "days"', 'pagelines'),
						'inputlabel'  =>  __('Your custom "days"', 'pagelines'),
						'shortexp'   =>  __('For example: In your language.', 'pagelines'),
					),
					'countdown-terms-hours' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "hours"', 'pagelines'),
						'inputlabel'  =>  __('Your custom "hours"', 'pagelines'),
						'shortexp'   =>  __('For example: In your language.', 'pagelines'),
					),
					'countdown-terms-minutes' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "minutes"', 'pagelines'),
						'inputlabel'  =>  __('Your custom "minutes"', 'pagelines'),
						'shortexp'   =>  __('For example: In your language.', 'pagelines'),
					),
					'countdown-terms-seconds' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "seconds"', 'pagelines'),
						'inputlabel'  =>  __('Your custom "seconds"', 'pagelines'),
						'shortexp'   =>  __('For example: In your language.', 'pagelines'),
					))),
			'countdown-timestamp'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Select the date you are counting down for.', 'pagelines'),
				'shortexp'   =>  __('Please make a selection in all selectors.', 'pagelines'),
				'selectvalues'   => array(
					'countdown-timestamp-date' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'1' => array( 'name' => __( '1st'   , 'pagelines' )),
							'2' => array( 'name' => __( '2nd'   , 'pagelines' )),
							'3' => array( 'name' => __( '3rd'    , 'pagelines' )),
							'4' => array( 'name' => __( '4th'    , 'pagelines' )),
							'5' => array( 'name' => __( '5th'    , 'pagelines' )),
							'6' => array( 'name' => __( '6th'    , 'pagelines' )),
							'7' => array( 'name' => __( '7th'    , 'pagelines' )),
							'8' => array( 'name' => __( '8th'  , 'pagelines' )),
							'9' => array( 'name' => __( '9th'    , 'pagelines' )),
							'10' => array( 'name' => __( '10th'    , 'pagelines' )),
							'11' => array( 'name' => __( '11th'    , 'pagelines' )),
							'12' => array( 'name' => __( '12th'    , 'pagelines' )),
							'13' => array( 'name' => __( '13th'     , 'pagelines' )),
							'14' => array( 'name' => __( '14th'   , 'pagelines' )),
							'15' => array( 'name' => __( '15th'    , 'pagelines' )),
							'16' => array( 'name' => __( '16th'    , 'pagelines' )),
							'17' => array( 'name' => __( '17th'    , 'pagelines' )),
							'18' => array( 'name' => __( '18th'    , 'pagelines' )),
							'19' => array( 'name' => __( '19th'    , 'pagelines' )),
							'20' => array( 'name' => __( '20th'  , 'pagelines' )),
							'21' => array( 'name' => __( '21st'  , 'pagelines' )),
							'22' => array( 'name' => __( '22nd'  , 'pagelines' )),
							'23' => array( 'name' => __( '23rd'    , 'pagelines' )),
							'24' => array( 'name' => __( '24th'     , 'pagelines' )),
							'25' => array( 'name' => __( '25th'    , 'pagelines' )),
							'26' => array( 'name' => __( '26th'     , 'pagelines' )),
							'27' => array( 'name' => __( '27th' , 'pagelines' )),
							'28' => array( 'name' => __( '28th'  , 'pagelines' )),
							'29' => array( 'name' => __( '29th' , 'pagelines' )),
							'30' => array( 'name' => __( '30th'    , 'pagelines' )),
							'31' => array( 'name' => __( '31st'    , 'pagelines' ))
						),
						'title'   =>  __('Select date', 'pagelines'),
					),
					'countdown-timestamp-month' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( 'January'   , 'pagelines' )),
							'1' => array( 'name' => __( 'February'   , 'pagelines' )),
							'2' => array( 'name' => __( 'March'   , 'pagelines' )),
							'3' => array( 'name' => __( 'April'    , 'pagelines' )),
							'4' => array( 'name' => __( 'May'    , 'pagelines' )),
							'5' => array( 'name' => __( 'June'    , 'pagelines' )),
							'6' => array( 'name' => __( 'July'    , 'pagelines' )),
							'7' => array( 'name' => __( 'August'    , 'pagelines' )),
							'8' => array( 'name' => __( 'September'  , 'pagelines' )),
							'9' => array( 'name' => __( 'October'    , 'pagelines' )),
							'10' => array( 'name' => __( 'November'    , 'pagelines' )),
							'11' => array( 'name' => __( 'December'    , 'pagelines' ))
						),
						'title'   =>  __('Select month', 'pagelines'),
					),
					'countdown-timestamp-year' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'2013' => array( 'name' => __( '2013'   , 'pagelines' )),
							'2014' => array( 'name' => __( '2014'   , 'pagelines' )),
							'2015' => array( 'name' => __( '2015'    , 'pagelines' )),
							'2016' => array( 'name' => __( '2016'    , 'pagelines' )),
							'2017' => array( 'name' => __( '2017'    , 'pagelines' )),
							'2018' => array( 'name' => __( '2018'    , 'pagelines' )),
							'2019' => array( 'name' => __( '2019'    , 'pagelines' )),
							'2020' => array( 'name' => __( '2020'  , 'pagelines' )),
							'2021' => array( 'name' => __( '2021'    , 'pagelines' )),
							'2022' => array( 'name' => __( '2022'    , 'pagelines' )),
							'2023' => array( 'name' => __( '2023'    , 'pagelines' ))
						),
						'title'   =>  __('Select year', 'pagelines'),
					),
					'countdown-timestamp-hour' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'pagelines' )),
							'1' => array( 'name' => __( '1'   , 'pagelines' )),
							'2' => array( 'name' => __( '2'   , 'pagelines' )),
							'3' => array( 'name' => __( '3'    , 'pagelines' )),
							'4' => array( 'name' => __( '4'    , 'pagelines' )),
							'5' => array( 'name' => __( '5'    , 'pagelines' )),
							'6' => array( 'name' => __( '6'    , 'pagelines' )),
							'7' => array( 'name' => __( '7'    , 'pagelines' )),
							'8' => array( 'name' => __( '8'  , 'pagelines' )),
							'9' => array( 'name' => __( '9'    , 'pagelines' )),
							'10' => array( 'name' => __( '10'    , 'pagelines' )),
							'11' => array( 'name' => __( '11'    , 'pagelines' )),
							'12' => array( 'name' => __( '12'    , 'pagelines' )),
							'13' => array( 'name' => __( '13'     , 'pagelines' )),
							'14' => array( 'name' => __( '14'   , 'pagelines' )),
							'15' => array( 'name' => __( '15'    , 'pagelines' )),
							'16' => array( 'name' => __( '16'    , 'pagelines' )),
							'17' => array( 'name' => __( '17'    , 'pagelines' )),
							'18' => array( 'name' => __( '18'    , 'pagelines' )),
							'19' => array( 'name' => __( '19'    , 'pagelines' )),
							'20' => array( 'name' => __( '20'  , 'pagelines' )),
							'21' => array( 'name' => __( '21'  , 'pagelines' )),
							'22' => array( 'name' => __( '22'  , 'pagelines' )),
							'23' => array( 'name' => __( '23'    , 'pagelines' ))
						),
						'title'   =>  __('Select hour', 'pagelines'),
					),
					'countdown-timestamp-minute' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'pagelines' )),
							'1' => array( 'name' => __( '1'   , 'pagelines' )),
							'2' => array( 'name' => __( '2'   , 'pagelines' )),
							'3' => array( 'name' => __( '3'    , 'pagelines' )),
							'4' => array( 'name' => __( '4'    , 'pagelines' )),
							'5' => array( 'name' => __( '5'    , 'pagelines' )),
							'6' => array( 'name' => __( '6'    , 'pagelines' )),
							'7' => array( 'name' => __( '7'    , 'pagelines' )),
							'8' => array( 'name' => __( '8'  , 'pagelines' )),
							'9' => array( 'name' => __( '9'    , 'pagelines' )),
							'10' => array( 'name' => __( '10'    , 'pagelines' )),
							'11' => array( 'name' => __( '11'    , 'pagelines' )),
							'12' => array( 'name' => __( '12'    , 'pagelines' )),
							'13' => array( 'name' => __( '13'     , 'pagelines' )),
							'14' => array( 'name' => __( '14'   , 'pagelines' )),
							'15' => array( 'name' => __( '15'    , 'pagelines' )),
							'16' => array( 'name' => __( '16'    , 'pagelines' )),
							'17' => array( 'name' => __( '17'    , 'pagelines' )),
							'18' => array( 'name' => __( '18'    , 'pagelines' )),
							'19' => array( 'name' => __( '19'    , 'pagelines' )),
							'20' => array( 'name' => __( '20'  , 'pagelines' )),
							'21' => array( 'name' => __( '21'  , 'pagelines' )),
							'22' => array( 'name' => __( '22'  , 'pagelines' )),
							'23' => array( 'name' => __( '23'    , 'pagelines' )),
							'24' => array( 'name' => __( '24'     , 'pagelines' )),
							'25' => array( 'name' => __( '25'    , 'pagelines' )),
							'26' => array( 'name' => __( '26'     , 'pagelines' )),
							'27' => array( 'name' => __( '27' , 'pagelines' )),
							'28' => array( 'name' => __( '28'  , 'pagelines' )),
							'29' => array( 'name' => __( '29' , 'pagelines' )),
							'30' => array( 'name' => __( '30'    , 'pagelines' )),
							'31' => array( 'name' => __( '31'    , 'pagelines' )),
							'32' => array( 'name' => __( '32'   , 'pagelines' )),
							'33' => array( 'name' => __( '33'    , 'pagelines' )),
							'34' => array( 'name' => __( '34'    , 'pagelines' )),
							'35' => array( 'name' => __( '35'    , 'pagelines' )),
							'36' => array( 'name' => __( '36'    , 'pagelines' )),
							'37' => array( 'name' => __( '37'    , 'pagelines' )),
							'38' => array( 'name' => __( '38'  , 'pagelines' )),
							'39' => array( 'name' => __( '39'    , 'pagelines' )),
							'40' => array( 'name' => __( '40'    , 'pagelines' )),
							'41' => array( 'name' => __( '41'    , 'pagelines' )),
							'42' => array( 'name' => __( '42'    , 'pagelines' )),
							'43' => array( 'name' => __( '43'     , 'pagelines' )),
							'44' => array( 'name' => __( '44'   , 'pagelines' )),
							'45' => array( 'name' => __( '45'    , 'pagelines' )),
							'46' => array( 'name' => __( '46'    , 'pagelines' )),
							'47' => array( 'name' => __( '47'    , 'pagelines' )),
							'48' => array( 'name' => __( '48'    , 'pagelines' )),
							'49' => array( 'name' => __( '49'    , 'pagelines' )),
							'50' => array( 'name' => __( '50'  , 'pagelines' )),
							'51' => array( 'name' => __( '51'  , 'pagelines' )),
							'52' => array( 'name' => __( '52'  , 'pagelines' )),
							'53' => array( 'name' => __( '53'    , 'pagelines' )),
							'54' => array( 'name' => __( '54'     , 'pagelines' )),
							'55' => array( 'name' => __( '55'    , 'pagelines' )),
							'56' => array( 'name' => __( '56'     , 'pagelines' )),
							'57' => array( 'name' => __( '57' , 'pagelines' )),
							'58' => array( 'name' => __( '58'  , 'pagelines' )),
							'59' => array( 'name' => __( '59' , 'pagelines' ))
						),
						'title'   =>  __('Select minute', 'pagelines'),
					),
					'countdown-timestamp-second' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'pagelines' )),
							'1' => array( 'name' => __( '1'   , 'pagelines' )),
							'2' => array( 'name' => __( '2'   , 'pagelines' )),
							'3' => array( 'name' => __( '3'    , 'pagelines' )),
							'4' => array( 'name' => __( '4'    , 'pagelines' )),
							'5' => array( 'name' => __( '5'    , 'pagelines' )),
							'6' => array( 'name' => __( '6'    , 'pagelines' )),
							'7' => array( 'name' => __( '7'    , 'pagelines' )),
							'8' => array( 'name' => __( '8'  , 'pagelines' )),
							'9' => array( 'name' => __( '9'    , 'pagelines' )),
							'10' => array( 'name' => __( '10'    , 'pagelines' )),
							'11' => array( 'name' => __( '11'    , 'pagelines' )),
							'12' => array( 'name' => __( '12'    , 'pagelines' )),
							'13' => array( 'name' => __( '13'     , 'pagelines' )),
							'14' => array( 'name' => __( '14'   , 'pagelines' )),
							'15' => array( 'name' => __( '15'    , 'pagelines' )),
							'16' => array( 'name' => __( '16'    , 'pagelines' )),
							'17' => array( 'name' => __( '17'    , 'pagelines' )),
							'18' => array( 'name' => __( '18'    , 'pagelines' )),
							'19' => array( 'name' => __( '19'    , 'pagelines' )),
							'20' => array( 'name' => __( '20'  , 'pagelines' )),
							'21' => array( 'name' => __( '21'  , 'pagelines' )),
							'22' => array( 'name' => __( '22'  , 'pagelines' )),
							'23' => array( 'name' => __( '23'    , 'pagelines' )),
							'24' => array( 'name' => __( '24'     , 'pagelines' )),
							'25' => array( 'name' => __( '25'    , 'pagelines' )),
							'26' => array( 'name' => __( '26'     , 'pagelines' )),
							'27' => array( 'name' => __( '27' , 'pagelines' )),
							'28' => array( 'name' => __( '28'  , 'pagelines' )),
							'29' => array( 'name' => __( '29' , 'pagelines' )),
							'30' => array( 'name' => __( '30'    , 'pagelines' )),
							'31' => array( 'name' => __( '31'    , 'pagelines' )),
							'32' => array( 'name' => __( '32'   , 'pagelines' )),
							'33' => array( 'name' => __( '33'    , 'pagelines' )),
							'34' => array( 'name' => __( '34'    , 'pagelines' )),
							'35' => array( 'name' => __( '35'    , 'pagelines' )),
							'36' => array( 'name' => __( '36'    , 'pagelines' )),
							'37' => array( 'name' => __( '37'    , 'pagelines' )),
							'38' => array( 'name' => __( '38'  , 'pagelines' )),
							'39' => array( 'name' => __( '39'    , 'pagelines' )),
							'40' => array( 'name' => __( '40'    , 'pagelines' )),
							'41' => array( 'name' => __( '41'    , 'pagelines' )),
							'42' => array( 'name' => __( '42'    , 'pagelines' )),
							'43' => array( 'name' => __( '43'     , 'pagelines' )),
							'44' => array( 'name' => __( '44'   , 'pagelines' )),
							'45' => array( 'name' => __( '45'    , 'pagelines' )),
							'46' => array( 'name' => __( '46'    , 'pagelines' )),
							'47' => array( 'name' => __( '47'    , 'pagelines' )),
							'48' => array( 'name' => __( '48'    , 'pagelines' )),
							'49' => array( 'name' => __( '49'    , 'pagelines' )),
							'50' => array( 'name' => __( '50'  , 'pagelines' )),
							'51' => array( 'name' => __( '51'  , 'pagelines' )),
							'52' => array( 'name' => __( '52'  , 'pagelines' )),
							'53' => array( 'name' => __( '53'    , 'pagelines' )),
							'54' => array( 'name' => __( '54'     , 'pagelines' )),
							'55' => array( 'name' => __( '55'    , 'pagelines' )),
							'56' => array( 'name' => __( '56'     , 'pagelines' )),
							'57' => array( 'name' => __( '57' , 'pagelines' )),
							'58' => array( 'name' => __( '58'  , 'pagelines' )),
							'59' => array( 'name' => __( '59' , 'pagelines' ))
						),
						'title'   =>  __('Select seconds', 'pagelines'),
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