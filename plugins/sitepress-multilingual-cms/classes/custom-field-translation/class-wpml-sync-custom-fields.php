<?php

class WPML_Sync_Custom_Fields {

	/** @var WPML_Translation_Element_Factory $element_factory */
	private $element_factory;

	/** @var array $fields_to_sync */
	private $fields_to_sync;

	/**
	 * WPML_Sync_Custom_Fields constructor.
	 *
	 * @param WPML_Translation_Element_Factory $element_factory
	 * @param array                            $fields_to_sync
	 */
	public function __construct( WPML_Translation_Element_Factory $element_factory, array $fields_to_sync ) {
		$this->element_factory = $element_factory;
		$this->fields_to_sync  = $fields_to_sync;
	}

	/**
	 * @param int    $post_id_from
	 * @param string $meta_key
	 */
	public function sync_to_translations( $post_id_from, $meta_key ) {
		//if ( in_array( $meta_key, $this->fields_to_sync, true ) ) {
			//$post_element = $this->element_factory->create( $post_id_from, 'post' );
			//$translations = $post_element->get_translations();

			//foreach ( $translations as $translation ) {
				//$translation_id = $translation->get_element_id();
				//if ( $translation_id !== $post_id_from ) {
					//$this->sync_custom_field( $post_id_from, $translation_id, $meta_key );
				//}
			//}
		//}
	}

	/**
	 * @param int $post_id_from
	 */
	public function sync_all_custom_fields( $post_id_from ) {
		//foreach ( $this->fields_to_sync as $meta_key ) {
			//$this->sync_to_translations( $post_id_from, $meta_key );
		//}
	}

	/**
	 * @param int    $post_id_from
	 * @param int    $post_id_to
	 * @param string $meta_key
	 */
	public function sync_custom_field( $post_id_from, $post_id_to, $meta_key ) {

	}

}
