<?php

class WSU_GC_Theme {
	/**
	 * Setup the hooks used in the theme.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'wsuwp_people_item_html', array( $this, 'people_html' ), 10, 2 );
		add_filter( 'wsuwp_people_sort_items', array( $this, 'people_sort' ), 10, 1 );
	}

	/**
	 *
	 * @param string $name Name of the IP site being checked.
	 *
	 * @return bool
	 */
	public function is_gc_site( $name ) {
		$site = get_blog_details();

		$home_domain = apply_filters( 'gc_home_domain', 'online.wsu.edu' );
		$home_path = apply_filters( 'gc_home_path', '/' );


		if ( 'gc-home' === $name && $home_domain === $site->domain && $home_path === $site->path ) {
			return true;
		}

		return false;
	}



	/**
	 * Enqueue custom scripts for Global Campus. */

	public function enqueue_scripts() {

		wp_enqueue_script( 'gc-home_js', get_stylesheet_directory_uri() . '/js/gc-home.js', array( 'jquery' ), spine_get_script_version(), true );

	}



	/**
	 * Provide a custom HTML template for use with syndicated people.
	 *
	 * @param string   $html   The HTML to output for an individual person.
	 * @param stdClass $person Object representing a person received from people.wsu.edu.
	 *
	 * @return string The HTML to output for a person.
	 */
	public function people_html( $html, $person ) {
		if ( isset( $person->working_titles[0] ) ) {
			$title = $person->working_titles[0];
		} else {
			$title = ucwords( strtolower( $person->position_title ) );
		}

		if ( ! empty( $person->email_alt ) ) {
			$email = $person->email_alt;
		} else {
			$email = $person->email;
		}

		if ( ! empty( $person->office_alt ) ) {
			$office = $person->office_alt;
		} else {
			$office = $person->office;
		}

		if ( ! empty( $person->phone_alt ) ) {
			$phone = $person->phone_alt;
		} else {
			$phone = $person->phone;
		}

		ob_start();

		if ( isset( $person->profile_photo ) && $person->profile_photo ) {
			?>
			<div class="wsuwp-person-container">
				<figure class="wsuwp-person-photo">
					<img src="<?php echo esc_url( $person->profile_photo ); ?>" />
				</figure>
			<?php
		} else {
			?><div class="wsuwp-person-container person-no-photo"><?php
		}
		?>
			<div class="wsuwp-person-info-container">
				<div class="wsuwp-person-name"><?php echo esc_html( $person->title->rendered ); ?></div>
				<div class="wsuwp-person-position"><?php echo esc_html( $title ); ?></div>
				<div class="wsuwp-person-office"><?php echo esc_html( $office ); ?></div>
				<div class="wsuwp-person-email"><a href="mailto:<?php echo esc_html( $email ); ?>"><?php echo esc_html( $email ); ?></a></div>
				<div class="wsuwp-person-phone"><a href="tel:<?php echo esc_html( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></div>
			</div>
			    <div class="wsuwp-person-profile-container">
				<?php echo wp_kses_post( $person->bio_department ); ?>
			</div>
		</div>
		<?php
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	/*
	 * Use the provided Content Syndicate filter to sort people results before displaying.
	 */
	public function people_sort( $people ) {
		usort( $people, array( $this, 'sort_alpha' ) );

		if ( 1 === ( count( $people ) % 2 ) ) {
			$person = new stdClass();
			$person->title = '';
			$person->office = '';
			$person->position_title = '';
			$person->email = '';
			$person->phone = '';
	  	    $person->bio_department = '';
			$people[] = $person;
		}

		return $people;
	}

	/**
	 * Sort people alphabetically by their last name.
	 *
	 * @param stdClass $a Object representing a person.
	 * @param stdClass $b Object representing a person.
	 *
	 * @return int Whether person a's last name is alphabetically smaller or greater than person b's.
	 */
	public function sort_alpha( $a, $b ) {
		return strcasecmp( $a->last_name, $b->last_name );
	}
}
new WSU_GC_Theme();
