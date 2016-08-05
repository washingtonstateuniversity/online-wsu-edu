<?php

class GC_Form_Modal_Shortcode {
	public function __construct() {
		add_shortcode( 'gc_open_form', array( $this, 'display_open_modal' ) );
	}

	public function display_open_modal( $atts, $content ) {
		$default_atts = array(
			'id' => '',
			'class' => '',
		);
		$atts = shortcode_atts( $default_atts, $atts );

		$return_content = '<a href="#" class="trigger-modal ';
		$return_content .= esc_attr( $atts['class'] ) . '" data-modal="modal-form-' . absint( $atts['id'] ) . '">';
		$return_content .= esc_html( $content );
		$return_content .= '</a>';

		return $return_content;
	}
}
new GC_Form_Modal_Shortcode();
