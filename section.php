<?php
/*
	Section: County
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://county.ahansson.com
	Version: 1.2
	Description: County is a countdown section that can count down to any date into the future. Use as Coming Soon Page or as countdown for your birtday - or whatever you need a countdown for!
	Class Name: County
	Workswith: templates, main, sidebar1, sidebar2, sidebar_wrap, header, footer, morefoot
	Cloning:true
*/

class County extends PageLinesSection {

	function section_persistent(){

	/*
		add_filter( 'pless_vars', array(&$this, 'pl_counter_less') );

		function pl_beefy_less( $constants ){

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
	}

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

	function section_head() {

		$clone_id = $this->oset['clone_id'];

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

	function section_template() {

		$clone_id = $this->oset['clone_id'];

		$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';

		$field1 = ploption('countdown-description-header', $this->tset) ? ploption('countdown-description-header', $this->tset) : 'Time to launch . . .';
		$field2 = ploption('countdown-description-subhead', $this->tset) ? ploption('countdown-description-subhead', $this->tset) : 'We are launching our site in . . .';
		$field3 = ploption('countdown-description-below', $this->tset) ? ploption('countdown-description-below', $this->tset) : 'This is default for County! Go to PageLines Page Options for your settings.';
		$field4 = ploption('countdown-description-shortcode', $this->tset) ? ploption('countdown-description-shortcode', $this->tset) : '';


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
				'title'     =>  __('Select the color options', 'County'),
				'selectvalues'   => array(
					'countdown-text-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County text color', 'County'),
						'inputlabel'  =>  __('Choose text color for your countdown.', 'County'),
					),
					'countdown-label-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County label color', 'County'),
						'inputlabel'  =>  __('Choose text color for your labels that is below the numbers.', 'County'),
					),
					'countdown-background-color' =>  array(
						'default'   =>  '',
						'type'    =>  'colorpicker',
						'title'   =>  __('County background color', 'County'),
						'inputlabel'  =>  __('Choose base color for your countdown.', 'County'),
					)
				)
			),
*/

			'countdown-description'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Your text options', 'County'),
				'shortexp'   =>  __('Type in your text for the countdown.', 'County'),
				'selectvalues'   => array(
					'countdown-description-header' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom countdown header text', 'County'),
						'inputlabel'  =>  __('Your custom countdown header text', 'County'),
						'shortexp'   =>  __('For example: "The offer is ending in:" or "Site is launching in:"', 'County'),
					),
					'countdown-description-subhead' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom subheading text above the counter', 'County'),
						'inputlabel'  =>  __('Your custom text above the counter', 'County'),
						'shortexp'   =>  __('For example: "Hurry up and go to the store!" or "We are building something amazing"', 'County'),
					),
					'countdown-description-below' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Custom subheading text below the counter', 'County'),
						'inputlabel'  =>  __('Your custom text below the counter', 'County'),
						'shortexp'   =>  __('For example: "Click here to go to the store:" or "If you want to get in touch, please call us at +1 1234 123 123"', 'County'),
					),
					'countdown-description-shortcode' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Shortcode input', 'County'),
						'inputlabel'  =>  __('Add a shortcode for yout timer', 'County'),
						'shortexp'   =>  __('For example: "An email capture form."', 'County'),
					)
				)
			),
			'countdown-terms'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Your terms for time', 'County'),
				'shortexp'   =>  __('You can type in your own custom terms of time.', 'County'),
				'selectvalues'   => array(
					'countdown-terms-days' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "days"', 'County'),
						'inputlabel'  =>  __('Your custom "days"', 'County'),
						'shortexp'   =>  __('For example: In your language.', 'County'),
					),
					'countdown-terms-hours' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "hours"', 'County'),
						'inputlabel'  =>  __('Your custom "hours"', 'County'),
						'shortexp'   =>  __('For example: In your language.', 'County'),
					),
					'countdown-terms-minutes' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "minutes"', 'County'),
						'inputlabel'  =>  __('Your custom "minutes"', 'County'),
						'shortexp'   =>  __('For example: In your language.', 'County'),
					),
					'countdown-terms-seconds' =>  array(
						'default'   =>  '',
						'type'    =>  'text',
						'title'   =>  __('Your terms of "seconds"', 'County'),
						'inputlabel'  =>  __('Your custom "seconds"', 'County'),
						'shortexp'   =>  __('For example: In your language.', 'County'),
					))),
			'countdown-timestamp'   => array(
				'default'    => '',
				'type'     => 'multi_option',
				'title'     =>  __('Select the date you are counting down for.', 'County'),
				'shortexp'   =>  __('Please make a selection in all selectors.', 'County'),
				'selectvalues'   => array(
					'countdown-timestamp-date' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'1' => array( 'name' => __( '1st'   , 'County' )),
							'2' => array( 'name' => __( '2nd'   , 'County' )),
							'3' => array( 'name' => __( '3rd'    , 'County' )),
							'4' => array( 'name' => __( '4th'    , 'County' )),
							'5' => array( 'name' => __( '5th'    , 'County' )),
							'6' => array( 'name' => __( '6th'    , 'County' )),
							'7' => array( 'name' => __( '7th'    , 'County' )),
							'8' => array( 'name' => __( '8th'  , 'County' )),
							'9' => array( 'name' => __( '9th'    , 'County' )),
							'10' => array( 'name' => __( '10th'    , 'County' )),
							'11' => array( 'name' => __( '11th'    , 'County' )),
							'12' => array( 'name' => __( '12th'    , 'County' )),
							'13' => array( 'name' => __( '13th'     , 'County' )),
							'14' => array( 'name' => __( '14th'   , 'County' )),
							'15' => array( 'name' => __( '15th'    , 'County' )),
							'16' => array( 'name' => __( '16th'    , 'County' )),
							'17' => array( 'name' => __( '17th'    , 'County' )),
							'18' => array( 'name' => __( '18th'    , 'County' )),
							'19' => array( 'name' => __( '19th'    , 'County' )),
							'20' => array( 'name' => __( '20th'  , 'County' )),
							'21' => array( 'name' => __( '21st'  , 'County' )),
							'22' => array( 'name' => __( '22nd'  , 'County' )),
							'23' => array( 'name' => __( '23rd'    , 'County' )),
							'24' => array( 'name' => __( '24th'     , 'County' )),
							'25' => array( 'name' => __( '25th'    , 'County' )),
							'26' => array( 'name' => __( '26th'     , 'County' )),
							'27' => array( 'name' => __( '27th' , 'County' )),
							'28' => array( 'name' => __( '28th'  , 'County' )),
							'29' => array( 'name' => __( '29th' , 'County' )),
							'30' => array( 'name' => __( '30th'    , 'County' )),
							'31' => array( 'name' => __( '31st'    , 'County' ))
						),
						'title'   =>  __('Select date', 'County'),
					),
					'countdown-timestamp-month' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( 'January'   , 'County' )),
							'1' => array( 'name' => __( 'February'   , 'County' )),
							'2' => array( 'name' => __( 'March'   , 'County' )),
							'3' => array( 'name' => __( 'April'    , 'County' )),
							'4' => array( 'name' => __( 'May'    , 'County' )),
							'5' => array( 'name' => __( 'June'    , 'County' )),
							'6' => array( 'name' => __( 'July'    , 'County' )),
							'7' => array( 'name' => __( 'August'    , 'County' )),
							'8' => array( 'name' => __( 'September'  , 'County' )),
							'9' => array( 'name' => __( 'October'    , 'County' )),
							'10' => array( 'name' => __( 'November'    , 'County' )),
							'11' => array( 'name' => __( 'December'    , 'County' ))
						),
						'title'   =>  __('Select month', 'County'),
					),
					'countdown-timestamp-year' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'2013' => array( 'name' => __( '2013'   , 'County' )),
							'2014' => array( 'name' => __( '2014'   , 'County' )),
							'2015' => array( 'name' => __( '2015'    , 'County' )),
							'2016' => array( 'name' => __( '2016'    , 'County' )),
							'2017' => array( 'name' => __( '2017'    , 'County' )),
							'2018' => array( 'name' => __( '2018'    , 'County' )),
							'2019' => array( 'name' => __( '2019'    , 'County' )),
							'2020' => array( 'name' => __( '2020'  , 'County' )),
							'2021' => array( 'name' => __( '2021'    , 'County' )),
							'2022' => array( 'name' => __( '2022'    , 'County' )),
							'2023' => array( 'name' => __( '2023'    , 'County' ))
						),
						'title'   =>  __('Select year', 'County'),
					),
					'countdown-timestamp-hour' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'County' )),
							'1' => array( 'name' => __( '1'   , 'County' )),
							'2' => array( 'name' => __( '2'   , 'County' )),
							'3' => array( 'name' => __( '3'    , 'County' )),
							'4' => array( 'name' => __( '4'    , 'County' )),
							'5' => array( 'name' => __( '5'    , 'County' )),
							'6' => array( 'name' => __( '6'    , 'County' )),
							'7' => array( 'name' => __( '7'    , 'County' )),
							'8' => array( 'name' => __( '8'  , 'County' )),
							'9' => array( 'name' => __( '9'    , 'County' )),
							'10' => array( 'name' => __( '10'    , 'County' )),
							'11' => array( 'name' => __( '11'    , 'County' )),
							'12' => array( 'name' => __( '12'    , 'County' )),
							'13' => array( 'name' => __( '13'     , 'County' )),
							'14' => array( 'name' => __( '14'   , 'County' )),
							'15' => array( 'name' => __( '15'    , 'County' )),
							'16' => array( 'name' => __( '16'    , 'County' )),
							'17' => array( 'name' => __( '17'    , 'County' )),
							'18' => array( 'name' => __( '18'    , 'County' )),
							'19' => array( 'name' => __( '19'    , 'County' )),
							'20' => array( 'name' => __( '20'  , 'County' )),
							'21' => array( 'name' => __( '21'  , 'County' )),
							'22' => array( 'name' => __( '22'  , 'County' )),
							'23' => array( 'name' => __( '23'    , 'County' ))
						),
						'title'   =>  __('Select hour', 'County'),
					),
					'countdown-timestamp-minute' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'County' )),
							'1' => array( 'name' => __( '1'   , 'County' )),
							'2' => array( 'name' => __( '2'   , 'County' )),
							'3' => array( 'name' => __( '3'    , 'County' )),
							'4' => array( 'name' => __( '4'    , 'County' )),
							'5' => array( 'name' => __( '5'    , 'County' )),
							'6' => array( 'name' => __( '6'    , 'County' )),
							'7' => array( 'name' => __( '7'    , 'County' )),
							'8' => array( 'name' => __( '8'  , 'County' )),
							'9' => array( 'name' => __( '9'    , 'County' )),
							'10' => array( 'name' => __( '10'    , 'County' )),
							'11' => array( 'name' => __( '11'    , 'County' )),
							'12' => array( 'name' => __( '12'    , 'County' )),
							'13' => array( 'name' => __( '13'     , 'County' )),
							'14' => array( 'name' => __( '14'   , 'County' )),
							'15' => array( 'name' => __( '15'    , 'County' )),
							'16' => array( 'name' => __( '16'    , 'County' )),
							'17' => array( 'name' => __( '17'    , 'County' )),
							'18' => array( 'name' => __( '18'    , 'County' )),
							'19' => array( 'name' => __( '19'    , 'County' )),
							'20' => array( 'name' => __( '20'  , 'County' )),
							'21' => array( 'name' => __( '21'  , 'County' )),
							'22' => array( 'name' => __( '22'  , 'County' )),
							'23' => array( 'name' => __( '23'    , 'County' )),
							'24' => array( 'name' => __( '24'     , 'County' )),
							'25' => array( 'name' => __( '25'    , 'County' )),
							'26' => array( 'name' => __( '26'     , 'County' )),
							'27' => array( 'name' => __( '27' , 'County' )),
							'28' => array( 'name' => __( '28'  , 'County' )),
							'29' => array( 'name' => __( '29' , 'County' )),
							'30' => array( 'name' => __( '30'    , 'County' )),
							'31' => array( 'name' => __( '31'    , 'County' )),
							'32' => array( 'name' => __( '32'   , 'County' )),
							'33' => array( 'name' => __( '33'    , 'County' )),
							'34' => array( 'name' => __( '34'    , 'County' )),
							'35' => array( 'name' => __( '35'    , 'County' )),
							'36' => array( 'name' => __( '36'    , 'County' )),
							'37' => array( 'name' => __( '37'    , 'County' )),
							'38' => array( 'name' => __( '38'  , 'County' )),
							'39' => array( 'name' => __( '39'    , 'County' )),
							'40' => array( 'name' => __( '40'    , 'County' )),
							'41' => array( 'name' => __( '41'    , 'County' )),
							'42' => array( 'name' => __( '42'    , 'County' )),
							'43' => array( 'name' => __( '43'     , 'County' )),
							'44' => array( 'name' => __( '44'   , 'County' )),
							'45' => array( 'name' => __( '45'    , 'County' )),
							'46' => array( 'name' => __( '46'    , 'County' )),
							'47' => array( 'name' => __( '47'    , 'County' )),
							'48' => array( 'name' => __( '48'    , 'County' )),
							'49' => array( 'name' => __( '49'    , 'County' )),
							'50' => array( 'name' => __( '50'  , 'County' )),
							'51' => array( 'name' => __( '51'  , 'County' )),
							'52' => array( 'name' => __( '52'  , 'County' )),
							'53' => array( 'name' => __( '53'    , 'County' )),
							'54' => array( 'name' => __( '54'     , 'County' )),
							'55' => array( 'name' => __( '55'    , 'County' )),
							'56' => array( 'name' => __( '56'     , 'County' )),
							'57' => array( 'name' => __( '57' , 'County' )),
							'58' => array( 'name' => __( '58'  , 'County' )),
							'59' => array( 'name' => __( '59' , 'County' ))
						),
						'title'   =>  __('Select minute', 'County'),
					),
					'countdown-timestamp-second' =>  array(
						'default'   =>  '',
						'type'    =>  'select',
						'selectvalues'     => array(
							'0' => array( 'name' => __( '0'   , 'County' )),
							'1' => array( 'name' => __( '1'   , 'County' )),
							'2' => array( 'name' => __( '2'   , 'County' )),
							'3' => array( 'name' => __( '3'    , 'County' )),
							'4' => array( 'name' => __( '4'    , 'County' )),
							'5' => array( 'name' => __( '5'    , 'County' )),
							'6' => array( 'name' => __( '6'    , 'County' )),
							'7' => array( 'name' => __( '7'    , 'County' )),
							'8' => array( 'name' => __( '8'  , 'County' )),
							'9' => array( 'name' => __( '9'    , 'County' )),
							'10' => array( 'name' => __( '10'    , 'County' )),
							'11' => array( 'name' => __( '11'    , 'County' )),
							'12' => array( 'name' => __( '12'    , 'County' )),
							'13' => array( 'name' => __( '13'     , 'County' )),
							'14' => array( 'name' => __( '14'   , 'County' )),
							'15' => array( 'name' => __( '15'    , 'County' )),
							'16' => array( 'name' => __( '16'    , 'County' )),
							'17' => array( 'name' => __( '17'    , 'County' )),
							'18' => array( 'name' => __( '18'    , 'County' )),
							'19' => array( 'name' => __( '19'    , 'County' )),
							'20' => array( 'name' => __( '20'  , 'County' )),
							'21' => array( 'name' => __( '21'  , 'County' )),
							'22' => array( 'name' => __( '22'  , 'County' )),
							'23' => array( 'name' => __( '23'    , 'County' )),
							'24' => array( 'name' => __( '24'     , 'County' )),
							'25' => array( 'name' => __( '25'    , 'County' )),
							'26' => array( 'name' => __( '26'     , 'County' )),
							'27' => array( 'name' => __( '27' , 'County' )),
							'28' => array( 'name' => __( '28'  , 'County' )),
							'29' => array( 'name' => __( '29' , 'County' )),
							'30' => array( 'name' => __( '30'    , 'County' )),
							'31' => array( 'name' => __( '31'    , 'County' )),
							'32' => array( 'name' => __( '32'   , 'County' )),
							'33' => array( 'name' => __( '33'    , 'County' )),
							'34' => array( 'name' => __( '34'    , 'County' )),
							'35' => array( 'name' => __( '35'    , 'County' )),
							'36' => array( 'name' => __( '36'    , 'County' )),
							'37' => array( 'name' => __( '37'    , 'County' )),
							'38' => array( 'name' => __( '38'  , 'County' )),
							'39' => array( 'name' => __( '39'    , 'County' )),
							'40' => array( 'name' => __( '40'    , 'County' )),
							'41' => array( 'name' => __( '41'    , 'County' )),
							'42' => array( 'name' => __( '42'    , 'County' )),
							'43' => array( 'name' => __( '43'     , 'County' )),
							'44' => array( 'name' => __( '44'   , 'County' )),
							'45' => array( 'name' => __( '45'    , 'County' )),
							'46' => array( 'name' => __( '46'    , 'County' )),
							'47' => array( 'name' => __( '47'    , 'County' )),
							'48' => array( 'name' => __( '48'    , 'County' )),
							'49' => array( 'name' => __( '49'    , 'County' )),
							'50' => array( 'name' => __( '50'  , 'County' )),
							'51' => array( 'name' => __( '51'  , 'County' )),
							'52' => array( 'name' => __( '52'  , 'County' )),
							'53' => array( 'name' => __( '53'    , 'County' )),
							'54' => array( 'name' => __( '54'     , 'County' )),
							'55' => array( 'name' => __( '55'    , 'County' )),
							'56' => array( 'name' => __( '56'     , 'County' )),
							'57' => array( 'name' => __( '57' , 'County' )),
							'58' => array( 'name' => __( '58'  , 'County' )),
							'59' => array( 'name' => __( '59' , 'County' ))
						),
						'title'   =>  __('Select seconds', 'County'),
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