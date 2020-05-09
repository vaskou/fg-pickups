<?php

abstract class FG_Pickups_Post_Type_Fields {

	protected $name;
	protected $metabox_title;
	protected $group_title;
	protected $fields;

	public function getFields() {
		return $this->fields;
	}

	abstract public function add_metaboxes( $post_type );

	protected function _add_metabox( $post_type ) {
		return new_cmb2_box( array(
			'id'           => 'fg_pickups_' . $this->name,
			'title'        => $this->metabox_title,
			'object_types' => array( $post_type ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		) );
	}

	/**
	 * @param $metabox CMB2
	 */
	protected function _add_metabox_fields( $metabox ) {
		if ( empty( $metabox ) ) {
			return;
		}

		foreach ( $this->fields as $id => $values ) {
			$metabox->add_field( array(
				'id'         => 'fgp_' . $this->name . '_' . $id,
				'name'       => $values['label'],
				'type'       => $values['type'],
				'repeatable' => ! empty( $values['repeatable'] ) ? $values['repeatable'] : false,
			) );
		}
	}

	/**
	 * @param $metabox CMB2
	 */
	protected function _add_metabox_group_field( $metabox ) {
		if ( empty( $metabox ) ) {
			return;
		}

		$group_id = $metabox->add_field( array(
			'id'      => 'fgp_' . $this->name . '_group',
			'type'    => 'group',
			'options' => array(
				'group_title'   => $this->group_title . ' {#}',
				'add_button'    => sprintf( __( 'Add Another %s', 'cmb2' ), $this->group_title ),
				'remove_button' => sprintf( __( 'Remove %s', 'cmb2' ), $this->group_title ),
				'sortable'      => true,
				// 'closed'         => true, // true to have the groups closed by default
				// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
			),
		) );

		$this->_add_metabox_group_fields( $metabox, $group_id );
	}

	/**
	 * @param $metabox CMB2
	 * @param $group_id integer
	 */
	protected function _add_metabox_group_fields( $metabox, $group_id ) {
		if ( empty( $metabox ) ) {
			return;
		}

		foreach ( $this->fields as $id => $values ) {
			$metabox->add_group_field( $group_id, array(
				'id'   => 'fgp_' . $this->name . '_' . $id,
				'name' => $values['label'],
				'type' => $values['type'],
			) );
		}

	}


}