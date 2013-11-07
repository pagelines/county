<?php
/*
	Section: County
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://county.ahansson.com
	Class Name: County
	Cloning:true
	V3: true
	Filter: full-width
*/

class County extends PageLinesSection {

	function section_styles(){

		// $this->base_url

		$countdown_terms_days = $this->opt( 'countdown-terms-days' ) ? $this->opt( 'countdown-terms-days' ) : 'Days';
		$countdown_terms_hours = $this->opt( 'countdown-terms-hours' ) ? $this->opt( 'countdown-terms-hours' ) : 'Hours';
		$countdown_terms_minutes = $this->opt( 'countdown-terms-minutes' ) ? $this->opt( 'countdown-terms-minutes' ) : 'Minutes';
		$countdown_terms_seconds = $this->opt( 'countdown-terms-seconds' ) ? $this->opt( 'countdown-terms-seconds' ) : 'Seconds';

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

		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';

		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					var count<?php $prefix ?> = new Date();
					count<?php $prefix ?> = new Date(<?php echo $this->opt('countdown-timestamp-year') ? $this->opt('countdown-timestamp-year') : 'count.getFullYear() + 1'; ?>, <?php echo $this->opt('countdown-timestamp-month') ? $this->opt('countdown-timestamp-month') : '0'; ?>, <?php echo $this->opt('countdown-timestamp-date') ? $this->opt('countdown-timestamp-date') : '1'; ?>, <?php echo $this->opt('countdown-timestamp-hour') ? $this->opt('countdown-timestamp-hour') : '0'; ?>, <?php echo $this->opt('countdown-timestamp-minute') ? $this->opt('countdown-timestamp-minute') : '0'; ?>, <?php echo $this->opt('countdown-timestamp-seconds') ? $this->opt('countdown-timestamp-seconds') : '0'; ?>);
					jQuery('#defaultCountdown<?php echo $prefix;?>').countdown({until: count<?php $prefix ?>, format: 'DHMS', layout: '<div class="row center"><div class="span6 zmb"><div class="row">{d<}<div class="span6 pl-countdown-days pl-countdown-numbers zmb">{dn}<div class="row pl-countdown-labels">{dl}</div></div>{d>}{h<}<div class="span6 pl-countdown-hours pl-countdown-numbers zmb">{hn}<div class="row pl-countdown-labels">{hl}</div></div>{h>}</div></div><div class="span6 zmb"><div class="row">{m<}<div class="span6 pl-countdown-minutes pl-countdown-numbers zmb">{mn}<div class="row pl-countdown-labels">{ml}</div></div>{m>}{s<}<div class="span6 pl-countdown-seconds pl-countdown-numbers zmb">{sn}<div class="row pl-countdown-labels">{sl}</div></div>{s>}</div></div></div>'});
					jQuery('#year').text(count<?php $prefix ?>.getFullYear());
				});
			</script>
		<?php

	}

	function section_template() {

		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';

		$field1 = $this->opt('countdown-description-header') ? $this->opt('countdown-description-header') : 'Time to launch . . .';
		$field2 = $this->opt('countdown-description-subhead') ? $this->opt('countdown-description-subhead') : 'We are launching our site in . . .';
		$field3 = $this->opt('countdown-description-below') ? $this->opt('countdown-description-below') : 'This is default for County! Go to PageLines Page Options for your settings.';
		$field4 = $this->opt('countdown-description-shortcode') ? $this->opt('countdown-description-shortcode') : '';


		?>
			<div class="pl-countdown-container">

				<div class="pl-countdown-header center" data-sync="countdown-description-header"><?php echo do_shortcode( $field1 ); ?></div>

				<div class="pl-countdown-subhead center" data-sync="countdown-description-subhead"><?php echo do_shortcode( $field2 );  ?></div>

				<?php echo sprintf ('<div id="defaultCountdown%s"></div>', $prefix); ?>

				<div class="pl-countdown-below center" data-sync="countdown-description-below"><?php echo do_shortcode( $field3 ); ?></div>

				<div class="pl-countdown-shortcode center" data-sync="countdown-description-shortcode"><?php echo do_shortcode( $field4 ); ?></div>


			</div>
		<?php

	}

	function section_opts() {

		$options = array();

		$how_to_use = __( '
		<strong>Read the instructions below before asking for additional help:</strong>
		</br></br>
		<strong>1.</strong> In the frontend editor, drag the County section to a template of your choice.
		</br></br>
		<strong>2.</strong> Edit text, terms of time and set your time stamp.
		</br></br>
		<strong>3.</strong> When you are done, hit "Publish" and refresh to see changes.
		</br></br>
		<div class="row zmb">
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://forum.pagelines.com/71-products-by-aleksander-hansson/" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-ambulance"></i>          Forum</a>
				</div>
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://betterdms.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-align-justify"></i>          Better DMS</a>
				</div>
			</div>
			<div class="row zmb" style="margin-top:4px;">
				<div class="span12 tac zmb">
					<a class="btn btn-success" href="http://shop.ahansson.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-shopping-cart" ></i>          My Shop</a>
				</div>
			</div>
		', 'county' );

		$options[] = array(
			'key' => 'countdown_help',
			'type'     => 'template',
			'template'      => do_shortcode( $how_to_use ),
			'title' =>__( 'How to use:', 'county' ) ,
		);

		$options[] = array(
			'key'				=> 'countdown-description',
			'title'     		=>  __('Text Settings', 'post-slider'),
			'type'     			=> 'multi',
			'opts'   			=> array(
				array(
					'key'	=>	'countdown-description-header',
					'type'    =>  'text',
					'label'  =>  __('Custom countdown header text', 'county'),
					'help'   =>  __('For example: "The offer is ending in:" or "Site is launching in:"', 'county'),
				),
				array(
					'key'	=>	'countdown-description-subhead',
					'type'    =>  'text',
					'label'  =>  __('Custom subheading text above the counter', 'county'),
					'help'   =>  __('For example: "Hurry up and go to the store!" or "We are building something amazing"', 'county'),
				),
				array(
					'key'	=>	'countdown-description-below',
					'type'    =>  'text',
					'label'  =>  __('Custom subheading text below the counter', 'county'),
					'help'   =>  __('For example: "Click here to go to the store:" or "If you want to get in touch, please call us at +1 1234 123 123"', 'county'),
				),
				array(
					'key'	=>	'countdown-description-shortcode',
					'type'    =>  'text',
					'label'  =>  __('Shortcode input', 'county'),
					'help'   =>  __('For example: "An email capture form."', 'county'),
				)
			)
		);

		$options[] = array(
			'key'				=> 'countdown-terms',
			'title'     		=>  __('Terms of time', 'post-slider'),
			'type'     			=> 'multi',
			'opts'   			=> array(
				array(
					'key'	=>	'countdown-terms-days',
					'type'    =>  'text',
					'label'  =>  __('Terms of "days"', 'county'),
					'help'   =>  __('For example: In your language.', 'county'),
				),
				array(
					'key'	=>	'countdown-terms-hours',
					'type'    =>  'text',
					'label'  =>  __('Terms of "hours"', 'county'),
					'help'   =>  __('For example: In your language.', 'county'),
				),
				array(
					'key'	=>		'countdown-terms-minutes',
					'type'    =>  'text',
					'label'  =>  __('Terms of "minutes"', 'county'),
					'help'   =>  __('For example: In your language.', 'county'),
				),
				array(
					'key'	=>	'countdown-terms-seconds',
					'type'    =>  'text',
					'label'  =>  __('Terms of "seconds"', 'county'),
					'help'   =>  __('For example: In your language.', 'county'),
				)
			)
		);

		$options[] = array(
			'key'				=> 'countdown-timestamp',
			'title'     		=>  __('Time Stamp', 'post-slider'),
			'type'     			=> 'multi',
			'opts'   			=> array(
				array(
					'key'	=>	'countdown-timestamp-date',
					'type'    =>  'select',
					'label'   =>  __('Select date', 'county'),
					'opts'     => array(
						'1' => array( 'name' => __( '1st'   , 'county' )),
						'2' => array( 'name' => __( '2nd'   , 'county' )),
						'3' => array( 'name' => __( '3rd'    , 'county' )),
						'4' => array( 'name' => __( '4th'    , 'county' )),
						'5' => array( 'name' => __( '5th'    , 'county' )),
						'6' => array( 'name' => __( '6th'    , 'county' )),
						'7' => array( 'name' => __( '7th'    , 'county' )),
						'8' => array( 'name' => __( '8th'  , 'county' )),
						'9' => array( 'name' => __( '9th'    , 'county' )),
						'10' => array( 'name' => __( '10th'    , 'county' )),
						'11' => array( 'name' => __( '11th'    , 'county' )),
						'12' => array( 'name' => __( '12th'    , 'county' )),
						'13' => array( 'name' => __( '13th'     , 'county' )),
						'14' => array( 'name' => __( '14th'   , 'county' )),
						'15' => array( 'name' => __( '15th'    , 'county' )),
						'16' => array( 'name' => __( '16th'    , 'county' )),
						'17' => array( 'name' => __( '17th'    , 'county' )),
						'18' => array( 'name' => __( '18th'    , 'county' )),
						'19' => array( 'name' => __( '19th'    , 'county' )),
						'20' => array( 'name' => __( '20th'  , 'county' )),
						'21' => array( 'name' => __( '21st'  , 'county' )),
						'22' => array( 'name' => __( '22nd'  , 'county' )),
						'23' => array( 'name' => __( '23rd'    , 'county' )),
						'24' => array( 'name' => __( '24th'     , 'county' )),
						'25' => array( 'name' => __( '25th'    , 'county' )),
						'26' => array( 'name' => __( '26th'     , 'county' )),
						'27' => array( 'name' => __( '27th' , 'county' )),
						'28' => array( 'name' => __( '28th'  , 'county' )),
						'29' => array( 'name' => __( '29th' , 'county' )),
						'30' => array( 'name' => __( '30th'    , 'county' )),
						'31' => array( 'name' => __( '31st'    , 'county' ))
					),
				),
				array(
					'key'	=>	'countdown-timestamp-month',
					'type'    =>  'select',
					'label'   =>  __('Select month', 'county'),
					'opts'     => array(
						'0' => array( 'name' => __( 'January'   , 'county' )),
						'1' => array( 'name' => __( 'February'   , 'county' )),
						'2' => array( 'name' => __( 'March'   , 'county' )),
						'3' => array( 'name' => __( 'April'    , 'county' )),
						'4' => array( 'name' => __( 'May'    , 'county' )),
						'5' => array( 'name' => __( 'June'    , 'county' )),
						'6' => array( 'name' => __( 'July'    , 'county' )),
						'7' => array( 'name' => __( 'August'    , 'county' )),
						'8' => array( 'name' => __( 'September'  , 'county' )),
						'9' => array( 'name' => __( 'October'    , 'county' )),
						'10' => array( 'name' => __( 'November'    , 'county' )),
						'11' => array( 'name' => __( 'December'    , 'county' ))
					),
				),
				array(
					'key'	=>	'countdown-timestamp-year',
					'type'    =>  'select',
					'label'   =>  __('Select year', 'county'),
					'opts'     => array(
						'2013' => array( 'name' => __( '2013'   , 'county' )),
						'2014' => array( 'name' => __( '2014'   , 'county' )),
						'2015' => array( 'name' => __( '2015'    , 'county' )),
						'2016' => array( 'name' => __( '2016'    , 'county' )),
						'2017' => array( 'name' => __( '2017'    , 'county' )),
						'2018' => array( 'name' => __( '2018'    , 'county' )),
						'2019' => array( 'name' => __( '2019'    , 'county' )),
						'2020' => array( 'name' => __( '2020'  , 'county' )),
						'2021' => array( 'name' => __( '2021'    , 'county' )),
						'2022' => array( 'name' => __( '2022'    , 'county' )),
						'2023' => array( 'name' => __( '2023'    , 'county' ))
					),
				),
				array(
					'key'	=>		'countdown-timestamp-hour',
					'type'    =>  'select',
					'label'   =>  __('Select hour', 'county'),
					'opts'     => array(
						'0' => array( 'name' => __( '0'   , 'county' )),
						'1' => array( 'name' => __( '1'   , 'county' )),
						'2' => array( 'name' => __( '2'   , 'county' )),
						'3' => array( 'name' => __( '3'    , 'county' )),
						'4' => array( 'name' => __( '4'    , 'county' )),
						'5' => array( 'name' => __( '5'    , 'county' )),
						'6' => array( 'name' => __( '6'    , 'county' )),
						'7' => array( 'name' => __( '7'    , 'county' )),
						'8' => array( 'name' => __( '8'  , 'county' )),
						'9' => array( 'name' => __( '9'    , 'county' )),
						'10' => array( 'name' => __( '10'    , 'county' )),
						'11' => array( 'name' => __( '11'    , 'county' )),
						'12' => array( 'name' => __( '12'    , 'county' )),
						'13' => array( 'name' => __( '13'     , 'county' )),
						'14' => array( 'name' => __( '14'   , 'county' )),
						'15' => array( 'name' => __( '15'    , 'county' )),
						'16' => array( 'name' => __( '16'    , 'county' )),
						'17' => array( 'name' => __( '17'    , 'county' )),
						'18' => array( 'name' => __( '18'    , 'county' )),
						'19' => array( 'name' => __( '19'    , 'county' )),
						'20' => array( 'name' => __( '20'  , 'county' )),
						'21' => array( 'name' => __( '21'  , 'county' )),
						'22' => array( 'name' => __( '22'  , 'county' )),
						'23' => array( 'name' => __( '23'    , 'county' ))
					),
				),
				array(
					'key'	=>		'countdown-timestamp-minute',
					'type'    =>  'select',
					'label'   =>  __('Select minute', 'county'),
					'opts'     => array(
						'0' => array( 'name' => __( '0'   , 'county' )),
						'1' => array( 'name' => __( '1'   , 'county' )),
						'2' => array( 'name' => __( '2'   , 'county' )),
						'3' => array( 'name' => __( '3'    , 'county' )),
						'4' => array( 'name' => __( '4'    , 'county' )),
						'5' => array( 'name' => __( '5'    , 'county' )),
						'6' => array( 'name' => __( '6'    , 'county' )),
						'7' => array( 'name' => __( '7'    , 'county' )),
						'8' => array( 'name' => __( '8'  , 'county' )),
						'9' => array( 'name' => __( '9'    , 'county' )),
						'10' => array( 'name' => __( '10'    , 'county' )),
						'11' => array( 'name' => __( '11'    , 'county' )),
						'12' => array( 'name' => __( '12'    , 'county' )),
						'13' => array( 'name' => __( '13'     , 'county' )),
						'14' => array( 'name' => __( '14'   , 'county' )),
						'15' => array( 'name' => __( '15'    , 'county' )),
						'16' => array( 'name' => __( '16'    , 'county' )),
						'17' => array( 'name' => __( '17'    , 'county' )),
						'18' => array( 'name' => __( '18'    , 'county' )),
						'19' => array( 'name' => __( '19'    , 'county' )),
						'20' => array( 'name' => __( '20'  , 'county' )),
						'21' => array( 'name' => __( '21'  , 'county' )),
						'22' => array( 'name' => __( '22'  , 'county' )),
						'23' => array( 'name' => __( '23'    , 'county' )),
						'24' => array( 'name' => __( '24'     , 'county' )),
						'25' => array( 'name' => __( '25'    , 'county' )),
						'26' => array( 'name' => __( '26'     , 'county' )),
						'27' => array( 'name' => __( '27' , 'county' )),
						'28' => array( 'name' => __( '28'  , 'county' )),
						'29' => array( 'name' => __( '29' , 'county' )),
						'30' => array( 'name' => __( '30'    , 'county' )),
						'31' => array( 'name' => __( '31'    , 'county' )),
						'32' => array( 'name' => __( '32'   , 'county' )),
						'33' => array( 'name' => __( '33'    , 'county' )),
						'34' => array( 'name' => __( '34'    , 'county' )),
						'35' => array( 'name' => __( '35'    , 'county' )),
						'36' => array( 'name' => __( '36'    , 'county' )),
						'37' => array( 'name' => __( '37'    , 'county' )),
						'38' => array( 'name' => __( '38'  , 'county' )),
						'39' => array( 'name' => __( '39'    , 'county' )),
						'40' => array( 'name' => __( '40'    , 'county' )),
						'41' => array( 'name' => __( '41'    , 'county' )),
						'42' => array( 'name' => __( '42'    , 'county' )),
						'43' => array( 'name' => __( '43'     , 'county' )),
						'44' => array( 'name' => __( '44'   , 'county' )),
						'45' => array( 'name' => __( '45'    , 'county' )),
						'46' => array( 'name' => __( '46'    , 'county' )),
						'47' => array( 'name' => __( '47'    , 'county' )),
						'48' => array( 'name' => __( '48'    , 'county' )),
						'49' => array( 'name' => __( '49'    , 'county' )),
						'50' => array( 'name' => __( '50'  , 'county' )),
						'51' => array( 'name' => __( '51'  , 'county' )),
						'52' => array( 'name' => __( '52'  , 'county' )),
						'53' => array( 'name' => __( '53'    , 'county' )),
						'54' => array( 'name' => __( '54'     , 'county' )),
						'55' => array( 'name' => __( '55'    , 'county' )),
						'56' => array( 'name' => __( '56'     , 'county' )),
						'57' => array( 'name' => __( '57' , 'county' )),
						'58' => array( 'name' => __( '58'  , 'county' )),
						'59' => array( 'name' => __( '59' , 'county' ))
					),
				),
				array(
					'key'	=>		'countdown-timestamp-second',
					'type'    =>  'select',
					'label'   =>  __('Select seconds', 'county'),
					'opts'     => array(
						'0' => array( 'name' => __( '0'   , 'county' )),
						'1' => array( 'name' => __( '1'   , 'county' )),
						'2' => array( 'name' => __( '2'   , 'county' )),
						'3' => array( 'name' => __( '3'    , 'county' )),
						'4' => array( 'name' => __( '4'    , 'county' )),
						'5' => array( 'name' => __( '5'    , 'county' )),
						'6' => array( 'name' => __( '6'    , 'county' )),
						'7' => array( 'name' => __( '7'    , 'county' )),
						'8' => array( 'name' => __( '8'  , 'county' )),
						'9' => array( 'name' => __( '9'    , 'county' )),
						'10' => array( 'name' => __( '10'    , 'county' )),
						'11' => array( 'name' => __( '11'    , 'county' )),
						'12' => array( 'name' => __( '12'    , 'county' )),
						'13' => array( 'name' => __( '13'     , 'county' )),
						'14' => array( 'name' => __( '14'   , 'county' )),
						'15' => array( 'name' => __( '15'    , 'county' )),
						'16' => array( 'name' => __( '16'    , 'county' )),
						'17' => array( 'name' => __( '17'    , 'county' )),
						'18' => array( 'name' => __( '18'    , 'county' )),
						'19' => array( 'name' => __( '19'    , 'county' )),
						'20' => array( 'name' => __( '20'  , 'county' )),
						'21' => array( 'name' => __( '21'  , 'county' )),
						'22' => array( 'name' => __( '22'  , 'county' )),
						'23' => array( 'name' => __( '23'    , 'county' )),
						'24' => array( 'name' => __( '24'     , 'county' )),
						'25' => array( 'name' => __( '25'    , 'county' )),
						'26' => array( 'name' => __( '26'     , 'county' )),
						'27' => array( 'name' => __( '27' , 'county' )),
						'28' => array( 'name' => __( '28'  , 'county' )),
						'29' => array( 'name' => __( '29' , 'county' )),
						'30' => array( 'name' => __( '30'    , 'county' )),
						'31' => array( 'name' => __( '31'    , 'county' )),
						'32' => array( 'name' => __( '32'   , 'county' )),
						'33' => array( 'name' => __( '33'    , 'county' )),
						'34' => array( 'name' => __( '34'    , 'county' )),
						'35' => array( 'name' => __( '35'    , 'county' )),
						'36' => array( 'name' => __( '36'    , 'county' )),
						'37' => array( 'name' => __( '37'    , 'county' )),
						'38' => array( 'name' => __( '38'  , 'county' )),
						'39' => array( 'name' => __( '39'    , 'county' )),
						'40' => array( 'name' => __( '40'    , 'county' )),
						'41' => array( 'name' => __( '41'    , 'county' )),
						'42' => array( 'name' => __( '42'    , 'county' )),
						'43' => array( 'name' => __( '43'     , 'county' )),
						'44' => array( 'name' => __( '44'   , 'county' )),
						'45' => array( 'name' => __( '45'    , 'county' )),
						'46' => array( 'name' => __( '46'    , 'county' )),
						'47' => array( 'name' => __( '47'    , 'county' )),
						'48' => array( 'name' => __( '48'    , 'county' )),
						'49' => array( 'name' => __( '49'    , 'county' )),
						'50' => array( 'name' => __( '50'  , 'county' )),
						'51' => array( 'name' => __( '51'  , 'county' )),
						'52' => array( 'name' => __( '52'  , 'county' )),
						'53' => array( 'name' => __( '53'    , 'county' )),
						'54' => array( 'name' => __( '54'     , 'county' )),
						'55' => array( 'name' => __( '55'    , 'county' )),
						'56' => array( 'name' => __( '56'     , 'county' )),
						'57' => array( 'name' => __( '57' , 'county' )),
						'58' => array( 'name' => __( '58'  , 'county' )),
						'59' => array( 'name' => __( '59' , 'county' ))
					),
				)
			)
		);
		
		return $options;
	}

}