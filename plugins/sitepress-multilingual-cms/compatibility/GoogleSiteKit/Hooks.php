<?php

namespace WPML\Compatibility\GoogleSiteKit;

class Hooks implements \IWPML_Backend_Action {

	public function add_hooks() {
		add_filter( 'googlesitekit_canonical_home_url', [ $this, 'getCanonicalHomeUrl' ] );
	}

	/**
	 * @param string $homeUrl
	 *
	 * @return string
	 */
	public function getCanonicalHomeUrl( $homeUrl ) {
		$filteredHomeUrl = apply_filters( 'wpml_permalink', $homeUrl, apply_filters( 'wpml_default_language', '' ) );
		$filteredHomeUrl = trim( filter_var( $filteredHomeUrl, FILTER_SANITIZE_STRING ) );

		return $filteredHomeUrl ?: $homeUrl;
	}
}
