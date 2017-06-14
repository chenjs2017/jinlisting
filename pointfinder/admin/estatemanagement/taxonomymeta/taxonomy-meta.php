<?php
class Pointfinder_Taxonomy_Meta {
	protected $_meta;
	protected $_taxonomies;
	protected $_fields;
	
	/**
	 * Store all CSS of fields
	 * @var string
	 */
	public $css = '';

	/**
	 * Store all JS of fields
	 * @var string
	 */
	public $js = '';

	function __construct( $meta ) {
		if ( !is_admin() )
			return;

		$this->_meta = $meta;
		$this->normalize();

		add_action( 'admin_init', array( $this, 'add' ), 100 );
		add_action( 'edit_term', array( $this, 'save' ), 10, 2 );
		add_action( 'delete_term', array( $this, 'delete' ), 10, 2 );
		add_action( 'load-edit-tags.php', array( $this, 'load_edit_page' ) );
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	function load_edit_page()
	{
		global $wp_version;


		$screen = get_current_screen();
		/*('edit-tags' != $screen->base || empty( $_GET['action'] ) || 'edit' != $_GET['action'])
			|| */
		if (
			!in_array( $screen->taxonomy, $this->_taxonomies )
		)
		{
			return;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_head', array( $this, 'output_css' ) );
		add_action( 'admin_footer', array( $this, 'output_js' ), 100 );
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	function admin_enqueue_scripts()
	{
		wp_enqueue_script( 'jquery' );

		wp_deregister_script( 'underscore' );
		wp_dequeue_script('underscore');

		wp_register_script('underscore', get_template_directory_uri() . '/admin/estatemanagement/taxonomymeta/underscore-min.js', array('jquery'), '1.6.0');
		wp_enqueue_script('underscore');

		wp_deregister_script( 'backbone' );
		wp_dequeue_script('backbone');

		wp_register_script('backbone', get_template_directory_uri() . '/admin/estatemanagement/taxonomymeta/backbone-min.js', array('jquery'), '1.1.2');
		wp_enqueue_script('backbone');

		wp_register_script('pointfindertaxonomyjs', get_template_directory_uri() . '/admin/estatemanagement/taxonomymeta/pftaxonomy.js', array('jquery'), '1.0');
		wp_enqueue_script('pointfindertaxonomyjs');

		wp_enqueue_style(
            'pointfindertaxonomycss',
            get_template_directory_uri().'/admin/estatemanagement/taxonomymeta/pftaxonomycustom.css',
            '1.0',
            false
        );      


		$this->check_field_upload();
		$this->check_field_date();
		$this->check_field_color();
		$this->check_field_time();
		$this->check_field_iconselector();
		$this->check_field_configcreator();
	}

	/**
	 * Output CSS into header
	 *
	 * @return void
	 */
	function output_css()
	{
		echo $this->css ? '<style>' . $this->css . '</style>' : '';
	}

	/**
	 * Output JS into footer
	 *
	 * @return void
	 */
	function output_js()
	{	
		
		echo $this->js ? '<script type="text/javascript">jQuery(function($){' . $this->js . '});</script>' : '';
	}

	
	/******************** BEGIN FIELDS **********************/

	// Check field upload and add needed actions
	function check_field_upload() {
		if ( !$this->has_field( 'image' ) && $this->has_field( 'file' ) )
			return;

		$this->css .= '
			.rwtm-uploaded {overflow: hidden; margin: 0 0 10px}
			.rwtm-files {padding-left: 20px}
			.rwtm-images li {margin: 0 10px 10px 0; float: left; width: 150px; height: 100px; text-align: center; border: 3px solid #ccc; position: relative}
			.rwtm-images img {max-width: 150px; max-height: 100px}
			.rwtm-images a {position: absolute; bottom: 0; right: 0; color: #fff; background: #000; font-weight: bold; padding: 5px}
		';

		// Add enctype
		$this->js .= '
			$("#edittag").attr("enctype", "multipart/form-data");
		';

		// Delete file
		$this->js .= '
			$("body").on("click", ".rwtm-delete-file", function(){
				$(this).parent().remove();
				return false;
			});
		';

		// File upload
		if ( $this->has_field( 'file' ) ) {
			$this->js .= "
			\$('body').on('click', '.rwtm-file-upload', function(){
				var id = \$(this).data('field');

				var template = '<# _.each(attachments, function(attachment) { #>';
				template += '<li>';
				template += '<a href=\"{{{ attachment.url }}}\">{{{ attachment.filename }}}</a>';
				template += ' (<a class=\"rwtm-delete-file\" href=\"#\">" . esc_html__( 'Delete', 'pointfindert2d' ) . "</a>)';
				template += '<input type=\"hidden\" name=\"' + id + '[]\" value=\"{{{ attachment.id }}}\">';
				template += '</li>';
				template += '<# }); #>';

				var \$uploaded = \$(this).siblings('.rwtm-uploaded');

				var frame = wp.media({
					multiple : true,
					title    : \"" . esc_html__( 'Select File', 'pointfindert2d' ) . "\"
				});
				frame.on('select', function()
				{
					var selection = frame.state().get('selection').toJSON();

					\$uploaded.append(_.template(template, { attachments: selection }, {
						evaluate:    /<#([\s\S]+?)#>/g,
						interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
						escape:      /\{\{([^\}]+?)\}\}(?!\})/g
					}));
				});
				frame.open();

				return false;
			});
			";
		}

		if ( !$this->has_field( 'image' ) )
			return;

		wp_enqueue_media();

		// Image upload	
	}

	// Check field color
	function check_field_color() {
		if ( !$this->has_field( 'color' ) )
			return;
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		$this->js .= '$(".color").wpColorPicker();';
	}

	// Check field date
	function check_field_date() {
		if ( !$this->has_field( 'date' ) )
			return;

		wp_enqueue_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css' );
		wp_enqueue_script( 'jquery-ui-datepicker' );

		// CSS
		$this->css .= '#ui-datepicker-div {display: none}';

		// JS
		$dates = array();
		foreach ( $this->_fields as $field ) {
			if ( 'date' == $field['type'] ) {
				$dates[$field['id']] = $field['format'];
			}
		}
		foreach ( $dates as $id => $format ) {
			$this->js .= "$('#$id').datepicker({
				dateFormat: '$format',
				showButtonPanel: true
			});";
		}
	}

	// Check field time
	function check_field_time() {
		if ( !$this->has_field( 'time' ) )
			return;

		wp_enqueue_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css' );
		wp_enqueue_style( 'jquery-ui-timepicker', 'http://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.3/jquery-ui-timepicker-addon.css' );
		wp_enqueue_script( 'jquery-ui-timepicker', 'http://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.3/jquery-ui-timepicker-addon.min.js', array( 'jquery-ui-datepicker', 'jquery-ui-slider' ) );

		// CSS
		$this->css .= '#ui-datepicker-div {display: none}';

		// JS
		$times = array();
		foreach ( $this->_fields as $field ) {
			if ( 'time' == $field['type'] ) {
				$times[$field['id']] = $field['format'];
			}
		}
		foreach ( $times as $id => $format ) {
			$this->js .= "$('#$id').timepicker({showSecond: true, timeFormat: '$format'})";
		}
	}

	// Check field iconselector
	function check_field_iconselector() {
		if ( !$this->has_field( 'iconselector' ) )
			return;

		wp_register_style('extension_flaticons', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0', 'all');
        wp_enqueue_style( 'extension_flaticons' );

        wp_enqueue_style('extension_custom_icon',get_template_directory_uri().'/admin/options/extensions/custom_icon/extension_custom_icon.css','1.0',true);
	}

	// Check field configcreator
	function check_field_configcreator() {
		if ( !$this->has_field( 'configcreator' ) )
			return;

		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-accordion');
		
        wp_enqueue_script (
            'redux2-field-itempage-js', 
            get_template_directory_uri().'/admin/estatemanagement/taxonomymeta/field_itempage.js', 
            array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion'), 
            time(), 
            true
        );

        wp_enqueue_style(
            'redux2-field-itempage-css',
            get_template_directory_uri().'/admin/estatemanagement/taxonomymeta/field_itempage.css',
            time(),
            false
        );      

	}

	/******************** BEGIN META BOX PAGE **********************/

	// Add meta fields for taxonomies
	function add() {
		//foreach (get_taxonomies(array('show_ui' => true)) as $tax_name) {
		foreach ( get_taxonomies() as $tax_name ) {
			if ( in_array( $tax_name, $this->_taxonomies ) ) {
				add_action( $tax_name . '_edit_form', array( $this, 'show' ), 9, 2 );
			}
		}
	}

	// Show meta fields
	function show( $tag, $taxonomy ) {
		$meta_status = 'show';

		// get meta fields from option table
		if (isset($this->_meta['parentonly'])) {
			if ($this->_meta['parentonly'] == true) {

				if ($tag->parent != 0) {
					$meta_status = 'hide';
				}

			}
		}
		if ($meta_status == 'show') {

			$metas = get_option( $this->_meta['id'] );
			if ( empty( $metas ) ) $metas = array();
			if ( !is_array( $metas ) ) $metas = (array) $metas;

			// get meta fields for current term
			$metas = isset( $metas[$tag->term_id] ) ? $metas[$tag->term_id] : array();

			wp_nonce_field( basename( __FILE__ ), 'Pointfinder_Taxonomy_Meta_nonce' );
			echo "<div id='{$this->_meta['id']}' class='pointfinder-tax-header'><h3>{$this->_meta['title']}</h3> <span class='dashicons dashicons-arrow-up-alt2'></span></div>
				<div class='pointfinder-tax-header-body'><div class='pointfinder-tax-header-body-inside'><table class='form-table'>";

			foreach ( $this->_fields as $field ) {
				echo '<tr>';

				$meta = !empty( $metas[$field['id']] ) ? $metas[$field['id']] : $field['std'];
				if ($field['id'] == 'pflt_configuration') {
					$meta = is_array( $meta ) ? PFCleanArrayAttr('PFCleanFilters',$meta) : esc_attr( $meta );
				}else{
					$meta = is_array( $meta ) ? array_map( 'esc_attr', $meta ) : esc_attr( $meta );
				}
				call_user_func( array( $this, 'show_field_' . $field['type'] ), $field, $meta );

				echo '</tr>';
			}

			echo '</table></div></div>';
		}
	}

	/******************** BEGIN META BOX FIELDS **********************/

		function show_field_begin( $field, $meta ) {
			echo "<th scope='row' valign='top'><label for='{$field['id']}'>{$field['name']}</label></th><td>";
		}

		function show_field_end( $field, $meta ) {
			echo $field['desc'] ? "<br><small>{$field['desc']}</small></td>" : '</td>';
		}

		function show_field_text( $field, $meta ) {
			$this->show_field_begin( $field, $meta );
			echo "<input type='text' name='{$field['id']}' id='{$field['id']}' value='$meta' style='{$field['style']}'>";
			$this->show_field_end( $field, $meta );
		}

		function show_field_textarea( $field, $meta ) {
			$this->show_field_begin( $field, $meta );
			echo "<textarea name='{$field['id']}' cols='60' rows='15' style='{$field['style']}'>$meta</textarea>";
			$this->show_field_end( $field, $meta );
		}

		function show_field_select( $field, $meta ) {
			if ( !is_array( $meta ) ) $meta = (array) $meta;
			$this->show_field_begin( $field, $meta );
			echo "<select style='{$field['style']}' name='{$field['id']}" . ( $field['multiple'] ? "[]' multiple='multiple'" : "'" ) . ">";
			foreach ( $field['options'] as $key => $value ) {
				if ( $field['optgroups'] && is_array( $value ) ) {
					echo "<optgroup label=\"{$value['label']}\">";
					foreach ( $value['options'] as $option_key => $option_value ) {
						echo "<option value='$option_key'" . selected( in_array( $option_key, $meta ), true, false ) . ">$option_value</option>";
					}
					echo '</optgroup>';
				} else {
					echo "<option value='$key'" . selected( in_array( $key, $meta ), true, false ) . ">$value</option>";
				}
			}
			echo "</select>";
			$this->show_field_end( $field, $meta );
		}

		function show_field_radio( $field, $meta ) {
			$this->show_field_begin( $field, $meta );
			$html = array();
			foreach ( $field['options'] as $key => $value ) {
				$html[] .= "<label><input type='radio' name='{$field['id']}' value='$key'" . checked( $meta, $key, false ) . "> $value</label>";
			}
			echo implode( ' ', $html );
			$this->show_field_end( $field, $meta );
		}

		function show_field_checkbox( $field, $meta ) {
			$this->show_field_begin( $field, $meta );
			echo "<label><input type='checkbox' name='{$field['id']}' value='1'" . checked( !empty( $meta ), true, false ) . "></label>";
			$this->show_field_end( $field, $meta );
		}

		function show_field_wysiwyg( $field, $meta ) {
			$this->show_field_begin( $field, $meta );
			wp_editor( $meta, $field['id'], array(
				'textarea_name' => $field['id'],
				'editor_class'  => $field['id'].' theEditor',
			) );
			$this->show_field_end( $field, $meta );
		}

		function show_field_file( $field, $meta ) {
			if ( !is_array( $meta ) )
				$meta = (array) $meta;

			$this->show_field_begin( $field, $meta );
			if ( $field['desc'] )
				echo "{$field['desc']}<br>";

			echo '<ol class="rwtm-files rwtm-uploaded">';
			foreach ( $meta as $att ) {
				printf( '
					<li>
						%s (<a class="rwtm-delete-file" href="#">%s</a>)
						<input type="hidden" name="%s[]" value="%s">
					</li>',
					wp_get_attachment_link( $att ),
					esc_html__( 'Delete', 'pointfindert2d' ),
					$field['id'],
					$att
				);
			}
			echo '</ol>';

			echo "<a href='#' class='rwtm-file-upload button' data-field='{$field['id']}'>" . esc_html__( 'Select File', 'pointfindert2d' ) . "</a>";
			echo '</td>';
		}

		function show_field_image( $field, $meta ) {
			if ( !is_array( $meta ) )
				$meta = (array) $meta;

			$this->show_field_begin( $field, $meta );
			if ( $field['desc'] )
				echo "{$field['desc']}<br>";

			echo '<ul class="rwtm-uploaded rwtm-images">';
			foreach ( $meta as $att ) {
				printf( '
					<li>
						%s <a class="rwtm-delete-file" href="#">%s</a>
						<input type="hidden" name="%s[]" value="%s">
					</li>',
					wp_get_attachment_image( $att ),
					esc_html__( 'Delete', 'pointfindert2d' ),
					$field['id'],
					$att
				);
			}
			echo '</ul>';

			echo "<a href='#' id='{$field['id']}' class='rwtm-image-upload button' data-field='{$field['id']}'>" . esc_html__( 'Select Image', 'pointfindert2d' ) . "</a>";
			echo "
			<script>
				jQuery('#{$field['id']}').click(function(){
					var id = jQuery(this).data('field');

					var template = '<# _.each(attachments, function(attachment) { #>';
					template += '<li>';
					template += '<img src=\"{{{ attachment.sizes.full.url }}}\">';
					template += '<a class=\"rwtm-delete-file\" href=\"#\">" . esc_html__( 'Delete', 'pointfindert2d' ) . "</a>';
					template += '<input type=\"hidden\" name=\"' + id + '[]\" value=\"{{{ attachment.id }}}\">';
					template += '</li>';
					template += '<# }); #>';

					var \$uploaded = jQuery(this).siblings('.rwtm-uploaded');

					var frame = wp.media({
						multiple : false,
						title    : \"" . esc_html__( 'Select Image', 'pointfindert2d' ) . "\",
						library  : {
							type: 'image'
						}
					});
					frame.on('select', function()
					{
						var selection = frame.state().get('selection').toJSON();

						\$uploaded.append(_.template(template, { attachments: selection }, {
							evaluate:    /<#([\s\S]+?)#>/g,
							interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
							escape:      /\{\{([^\}]+?)\}\}(?!\})/g
						}));
					});
					frame.open();

					return false;
				});</script>
				";
			echo '</td>';
		}

		function show_field_color( $field, $meta ) {
			if ( empty( $meta ) ) $meta = '#';
			$this->show_field_begin( $field, $meta );
			echo "<input type='text' name='{$field['id']}' id='{$field['id']}' value='$meta' class='color'>";
			$this->show_field_end( $field, $meta );
		}

		function show_field_checkbox_list( $field, $meta ) {
			if ( !is_array( $meta ) ) $meta = (array) $meta;
			$this->show_field_begin( $field, $meta );
			$html = array();
			foreach ( $field['options'] as $key => $value ) {
				$html[] = "<input type='checkbox' name='{$field['id']}[]' value='$key'" . checked( in_array( $key, $meta ), true, false ) . "> $value";
			}
			echo implode( '<br>', $html );
			$this->show_field_end( $field, $meta );
		}

		function show_field_date( $field, $meta ) {
			$this->show_field_text( $field, $meta );
		}

		function show_field_time( $field, $meta ) {
			$this->show_field_text( $field, $meta );
		}

		function show_field_iconselector( $field, $meta ) {
			$this->show_field_begin( $field, $meta );
			
			$pf_icons_arr = array(
                    array('icon' => '2440'),
                    array('icon' => '2442'),
                    array('icon' => 'accesibility'),
                    array('icon' => 'air6'),
                    array('icon' => 'air7'),
                    array('icon' => 'airplane67'),
                    array('icon' => 'airplane68'),
                    array('icon' => 'airplane73'),
                    array('icon' => 'alto'),
                    array('icon' => 'android2'),
                    array('icon' => 'angry19'),
                    array('icon' => 'antique9'),
                    array('icon' => 'ascendant6'),
                    array('icon' => 'baby137'),
                    array('icon' => 'bag30'),
                    array('icon' => 'baggage1'),
                    array('icon' => 'basketball35'),
                    array('icon' => 'beach3'),
                    array('icon' => 'biceps'),
                    array('icon' => 'bicycle14'),
                    array('icon' => 'black96'),
                    array('icon' => 'books8'),
                    array('icon' => 'bridge3'),
                    array('icon' => 'building22'),
                    array('icon' => 'building7'),
                    array('icon' => 'buildings5'),
                    array('icon' => 'burger4'),
                    array('icon' => 'bus3'),
                    array('icon' => 'bus8'),
                    array('icon' => 'business60'),
                    array('icon' => 'businessman125'),
                    array('icon' => 'call37'),
                    array('icon' => 'car106'),
                    array('icon' => 'car7'),
                    array('icon' => 'car80'),
                    array('icon' => 'car97'),
                    array('icon' => 'cash9'),
                    array('icon' => 'cctv3'),
                    array('icon' => 'checkered7'),
                    array('icon' => 'checkin'),
                    array('icon' => 'chronometer19'),
                    array('icon' => 'circular3'),
                    array('icon' => 'city8'),
                    array('icon' => 'claw1'),
                    array('icon' => 'climbing6'),
                    array('icon' => 'clock100'),
                    array('icon' => 'coconut5'),
                    array('icon' => 'coconut8'),
                    array('icon' => 'coffee50'),
                    array('icon' => 'coin12'),
                    array('icon' => 'coins15'),
                    array('icon' => 'comments16'),
                    array('icon' => 'concrete'),
                    array('icon' => 'construction16'),
                    array('icon' => 'constructor4'),
                    array('icon' => 'covered16'),
                    array('icon' => 'crane1'),
                    array('icon' => 'credit101'),
                    array('icon' => 'credit50'),
                    array('icon' => 'credit51'),
                    array('icon' => 'credit55'),
                    array('icon' => 'credit99'),
                    array('icon' => 'crime1'),
                    array('icon' => 'crowd'),
                    array('icon' => 'cruise7'),
                    array('icon' => 'crying6'),
                    array('icon' => 'cupcake3'),
                    array('icon' => 'deer2'),
                    array('icon' => 'delivery20'),
                    array('icon' => 'delivery25'),
                    array('icon' => 'delivery36'),
                    array('icon' => 'diamond10'),
                    array('icon' => 'dj4'),
                    array('icon' => 'dollar103'),
                    array('icon' => 'dwelling1'),
                    array('icon' => 'earth53'),
                    array('icon' => 'ecg2'),
                    array('icon' => 'ecological19'),
                    array('icon' => 'end3'),
                    array('icon' => 'escalator5'),
                    array('icon' => 'facebook7'),
                    array('icon' => 'family'),
                    array('icon' => 'favorite11'),
                    array('icon' => 'favourites7'),
                    array('icon' => 'film40'),
                    array('icon' => 'film63'),
                    array('icon' => 'finish'),
                    array('icon' => 'fire34'),
                    array('icon' => 'first21'),
                    array('icon' => 'first32'),
                    array('icon' => 'fish9'),
                    array('icon' => 'fishing11'),
                    array('icon' => 'floating1'),
                    array('icon' => 'for4'),
                    array('icon' => 'for5'),
                    array('icon' => 'glasses23'),
                    array('icon' => 'golf16'),
                    array('icon' => 'graduate20'),
                    array('icon' => 'graduation20'),
                    array('icon' => 'guru'),
                    array('icon' => 'hamburger2'),
                    array('icon' => 'hanger'),
                    array('icon' => 'happy35'),
                    array('icon' => 'hazard1'),
                    array('icon' => 'health3'),
                    array('icon' => 'heart118'),
                    array('icon' => 'heart258'),
                    array('icon' => 'heart288'),
                    array('icon' => 'helicopter'),
                    array('icon' => 'home120'),
                    array('icon' => 'home121'),
                    array('icon' => 'home87'),
                    array('icon' => 'hospital15'),
                    array('icon' => 'hot33'),
                    array('icon' => 'hot51'),
                    array('icon' => 'hot6'),
                    array('icon' => 'hotel68'),
                    array('icon' => 'house114'),
                    array('icon' => 'house118'),
                    array('icon' => 'ice64'),
                    array('icon' => 'images'),
                    array('icon' => 'industry2'),
                    array('icon' => 'insurance1'),
                    array('icon' => 'insurance2'),
                    array('icon' => 'insurance3'),
                    array('icon' => 'italian1'),
                    array('icon' => 'jacket2'),
                    array('icon' => 'job9'),
                    array('icon' => 'jumping27'),
                    array('icon' => 'key162'),
                    array('icon' => 'laptop112'),
                    array('icon' => 'left219'),
                    array('icon' => 'light84'),
                    array('icon' => 'linkedin11'),
                    array('icon' => 'logistics3'),
                    array('icon' => 'lorry1'),
                    array('icon' => 'macos'),
                    array('icon' => 'man362'),
                    array('icon' => 'mechanic3'),
                    array('icon' => 'medical14'),
                    array('icon' => 'medical51'),
                    array('icon' => 'medical68'),
                    array('icon' => 'medicine2'),
                    array('icon' => 'money132'),
                    array('icon' => 'money33'),
                    array('icon' => 'mountain24'),
                    array('icon' => 'multiple25'),
                    array('icon' => 'music200'),
                    array('icon' => 'new105'),
                    array('icon' => 'notes24'),
                    array('icon' => 'nurse6'),
                    array('icon' => 'nurse7'),
                    array('icon' => 'objective'),
                    array('icon' => 'offices'),
                    array('icon' => 'padding'),
                    array('icon' => 'painter14'),
                    array('icon' => 'palm9'),
                    array('icon' => 'parking15'),
                    array('icon' => 'party1'),
                    array('icon' => 'percentage6'),
                    array('icon' => 'person1'),
                    array('icon' => 'personal'),
                    array('icon' => 'pet32'),
                    array('icon' => 'photo147'),
                    array('icon' => 'pilot1'),
                    array('icon' => 'plate1'),
                    array('icon' => 'plate17'),
                    array('icon' => 'poison2'),
                    array('icon' => 'protection3'),
                    array('icon' => 'railway'),
                    array('icon' => 'real5'),
                    array('icon' => 'real6'),
                    array('icon' => 'real9'),
                    array('icon' => 'recycle58'),
                    array('icon' => 'regular2'),
                    array('icon' => 'rentacar'),
                    array('icon' => 'rentacar1'),
                    array('icon' => 'restaurant44'),
                    array('icon' => 'resting5'),
                    array('icon' => 'rose11'),
                    array('icon' => 'round58'),
                    array('icon' => 'round59'),
                    array('icon' => 'rugby98'),
                    array('icon' => 'runer'),
                    array('icon' => 'runner5'),
                    array('icon' => 'running30'),
                    array('icon' => 'running31'),
                    array('icon' => 'sad30'),
                    array('icon' => 'sale13'),
                    array('icon' => 'scissors28'),
                    array('icon' => 'sea9'),
                    array('icon' => 'semaphore7'),
                    array('icon' => 'setting'),
                    array('icon' => 'settings48'),
                    array('icon' => 'shopping101'),
                    array('icon' => 'shopping11'),
                    array('icon' => 'shopping236'),
                    array('icon' => 'skidiving'),
                    array('icon' => 'skiing7'),
                    array('icon' => 'skydiving2'),
                    array('icon' => 'slr2'),
                    array('icon' => 'smart'),
                    array('icon' => 'smartphone13'),
                    array('icon' => 'smiling30'),
                    array('icon' => 'smoking5'),
                    array('icon' => 'soccer38'),
                    array('icon' => 'soccer43'),
                    array('icon' => 'soccer44'),
                    array('icon' => 'social71'),
                    array('icon' => 'sold1'),
                    array('icon' => 'stack21'),
                    array('icon' => 'standing75'),
                    array('icon' => 'standing92'),
                    array('icon' => 'stethoscope1'),
                    array('icon' => 'store5'),
                    array('icon' => 'students17'),
                    array('icon' => 'stylish2'),
                    array('icon' => 'sunbathing'),
                    array('icon' => 'surprised14'),
                    array('icon' => 'surveillance11'),
                    array('icon' => 'sweet9'),
                    array('icon' => 'swimming20'),
                    array('icon' => 'swimming22'),
                    array('icon' => 'target'),
                    array('icon' => 'taxi13'),
                    array('icon' => 'taxi17'),
                    array('icon' => 'teeth1'),
                    array('icon' => 'teeth2'),
                    array('icon' => 'telephone91'),
                    array('icon' => 'television4'),
                    array('icon' => 'theater3'),
                    array('icon' => 'thumb38'),
                    array('icon' => 'tools6'),
                    array('icon' => 'tractor3'),
                    array('icon' => 'train1'),
                    array('icon' => 'tree101'),
                    array('icon' => 'tree30'),
                    array('icon' => 'trophy45'),
                    array('icon' => 'truck'),
                    array('icon' => 'truck30'),
                    array('icon' => 'tshirt18'),
                    array('icon' => 'tsunami1'),
                    array('icon' => 'two119'),
                    array('icon' => 'university2'),
                    array('icon' => 'use'),
                    array('icon' => 'volume32'),
                    array('icon' => 'walking17'),
                    array('icon' => 'weightlift'),
                    array('icon' => 'wine57'),
                    array('icon' => 'woman93'),
                    array('icon' => 'worker8'),
                    array('icon' => 'worker9'),
                    array('icon' => 'wrench60'),
                    array('icon' => 'yin6'),
                    array('icon' => 'yoga12')
            );
			$output ='<div class="pfextendvc_select1" id="'.$field['id'].'-main">';
			$output .= '<ul>';
			if(is_array($pf_icons_arr)){
			   foreach ( $pf_icons_arr as $iconclass ) {
			        $output .= '<li class="flaticon-'.$iconclass['icon'].'""></li>';
			   }
			}
			$output .='</ul>
			<input type="hidden" id="'.$field['id'].'-textarea" name="'.$field['id'].''.'" value="'.$meta.'">
			<script type="text/javascript">
			(function ($) {
			  "use strict"


			  $(function () {
			  
			    ';
			    if($meta!= ''){
			    $output .= '
			        $("#'.$field['id'].'-main ul li").each(function(){
			            if($(this).attr("class") == "'.$meta.'"){
			                $(this).attr("data-pfa-status","active")
			            }
			        });
			    ';
			    }
			    $output.='
			    $("#'.$field['id'].'-main ul li").click(function(){
			        $("#'.$field['id'].'-main ul li").each(function(){
			            $(this).attr("data-pfa-status","")
			        });
			        $(this).attr("data-pfa-status","active")
			        $("#'.$field['id'].'-textarea").val($(this).attr("class"));
			    });
			    
			});

			})(jQuery);</script>
			</div>';

			echo $output;


			$this->show_field_end( $field, $meta );
		}


		function show_field_configcreator( $field, $meta ) {
			
			$this->show_field_begin( $field, $meta );
				
	            $ip_options = array('1' => esc_html__('Enable', 'pointfindert2d') ,'0' => esc_html__('Disable', 'pointfindert2d'));
	            $ip_options2 = array('1' => esc_html__('Left', 'pointfindert2d'),'2' => esc_html__('Right', 'pointfindert2d') ,'0' => esc_html__('Disable', 'pointfindert2d'));

	            echo '<fieldset id="pointfindertheme_options-setup42_itempagedetails_configuration" class="redux-field-container redux-field redux-container-extension_itempage" data-id="setup42_itempagedetails_configuration" data-type="extension_itempage">

	            	<div class="redux-extension_itempage-accordion" data-new-content-title="' . esc_attr (esc_html__( 'New Config', 'pointfindert2d' )) . '">';

	            /* Define Slides */
		            if ( isset ( $meta ) && is_array ( $meta) && !empty ( $meta ) ) {

		                $slides = $meta;
		               
		                if (!array_key_exists('customtab1',$meta)) {
		                 
		                    $newslides = array( array(
		                        'ftitle'=>'customtab1',
		                        'title' => 'Custom Tab1',
		                        'sort' => '9',
		                        'status' => 0
		                    ),
		                    array(
		                        'ftitle'=>'customtab2',
		                        'title' => 'Custom Tab2',
		                        'sort' => '10',
		                        'status' => 0
		                    ),
		                    array(
		                        'ftitle'=>'customtab3',
		                        'title' => 'Custom Tab3',
		                        'sort' => '11',
		                        'status' => 0
		                    ));
		                    $slides = array_merge($slides,$newslides);

		                }

		            }else{
		                $slides = array(
		                    array(
		                        'ftitle'=>'gallery',
		                        'title' => 'Gallery',
		                        'sort' => '1',
		                        'status' => 1
		                    ),
		                    array(
		                        'ftitle'=>'informationbox',
		                        'title' => 'Information',
		                        'sort' => '2',
		                        'status' => 1
		                    ),
		                    array(
		                        'ftitle'=>'description1',
		                        'title' => 'Description',
		                        'sort' => '3',
		                        'fimage' => 1,
		                        'status' => 0
		                    ),
		                    array(
		                        'ftitle'=>'description2',
		                        'title' => 'Details',
		                        'sort' => '4',
		                        'fimage' => 1,
		                        'status' => 0
		                    ),
		                    array(
		                        'ftitle'=>'location',
		                        'title' => 'Map View',
		                        'sort' => '5',
		                        'mheight' => 340,
		                        'status' => 1
		                    ),
		                    array(
		                        'ftitle'=>'streetview',
		                        'title' => 'Street View',
		                        'sort' => '6',
		                        'mheight' => 340,
		                        'status' => 1
		                    ),
		                    array(
		                        'ftitle'=>'video',
		                        'title' => 'Video',
		                        'sort' => '7',
		                        'status' => 1
		                    ),
		                    array(
		                        'ftitle'=>'contact',
		                        'title' => 'Contact',
		                        'sort' => '8',
		                        'status' => 1
		                    ),
		                    array(
		                        'ftitle'=>'customtab1',
		                        'title' => 'Custom Tab1',
		                        'sort' => '9',
		                        'status' => 0
		                    ),
		                    array(
		                        'ftitle'=>'customtab2',
		                        'title' => 'Custom Tab2',
		                        'sort' => '10',
		                        'status' => 0
		                    ),
		                    array(
		                        'ftitle'=>'customtab3',
		                        'title' => 'Custom Tab3',
		                        'sort' => '11',
		                        'status' => 0
		                    )

		                );
		            }

		            foreach ( $slides as $slide ) {

		                if ( empty ( $slide ) ) {
		                    continue;
		                }

		                $defaults = array(
		                    'ftitle'=> '',
		                    'title' => '',
		                    'sort' => '',
		                    'mheight' => 340,
		                    'fimage' => 0,
		                    'status' => 0,
		                    'mcontent'=>''
		                );
		                $slide = wp_parse_args ( $slide, $defaults );

		               
		                echo '<div class="redux-extension_itempage-accordion-group"><fieldset class="redux-field" data-id="' . $field['id'] . '"><h3><span class="redux-extension_itempage-header">' . $slide[ 'title' ] . '</span></h3><div>';

		               

		                echo '<ul id="' . $field['id'] . '-ul" class="redux-extension_itempage-list">';

		                /**
		                *Start: Title of Field
		                **/
		                    $placeholder = esc_html__( 'Title', 'pointfindert2d' );
		                    echo '<li><input type="text" id="' . $field['id'] . '-title_' . $slide[ 'ftitle' ] . '" name="' . $field['id'] . '[' . $slide[ 'ftitle' ] . '][title]'. '" value="' . esc_attr ( $slide[ 'title' ] ) . '" placeholder="' . $placeholder . '" class="full-text extension_itempage-title" /></li>';
		                /**
		                *End: Title of Field
		                **/




		                /**
		                *Start: Status of Field
		                **/
		                    echo '<li class="pf-button-container">';
		                    echo '<span class="pf-inner-title">'.esc_html__('Status','pointfindert2d').' : </span>';
		                    echo '<div class="buttonset ui-buttonset">';
		                    
		                    
		                    foreach ( $ip_options as $k => $v ) {

		                        $selected = '';
		                        
		                        $multi_suffix = "";
		                        $type         = "radio";
		                        $selected     = checked( $slide['status'], $k, false );
		                        

		                        echo '<input data-id="' . $field['id'] . '-status_' . $slide[ 'ftitle' ] . '" type="' . $type . '" id="' . $field['id'] . '-status_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '" name="' . $field['id'] . '[' . $slide[ 'ftitle' ] . '][status]" class="buttonset-item" value="' . $k . '" ' . $selected . '/>';
		                        echo '<label for="' . $field['id'] . '-status_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '">' . $v . '</label>';
		                    }

		                    echo '</div></li>';   
		                /**
		                *End: Status of Field
		                **/



		                
		             
		                

		                if ($slide[ 'ftitle' ] == 'description1' || $slide[ 'ftitle' ] == 'description2') {
		                    /**
		                    *Start: Featured Image of Field
		                    **/
		                        echo '<li class="pf-button-container">';
		                        echo '<span class="pf-inner-title">'.esc_html__('Featured Image','pointfindert2d').' : </span>';
		                        echo '<div class="buttonset ui-buttonset">';
		                        
		                        
		                        foreach ( $ip_options2 as $k => $v ) {

		                            $selected = '';
		                            
		                            $multi_suffix = "";
		                            $type         = "radio";
		                            $selected     = checked( $slide['fimage'], $k, false );
		                            

		                            echo '<input data-id="' . $field['id'] . '-fimage_' . $slide[ 'ftitle' ] . '" type="' . $type . '" id="' . $field['id'] . '-fimage_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '" name="' . $field['id'] . '[' . $slide[ 'ftitle' ] . '][fimage]" class="buttonset-item" value="' . $k . '" ' . $selected . '/>';
		                            echo '<label for="' . $field['id'] . '-fimage_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '">' . $v . '</label>';
		                        }

		                        echo '</div></li>';
		                    /**
		                    *End: Featured Image of Field
		                    **/
		                }


		                if ($slide[ 'ftitle' ] == 'location' || $slide[ 'ftitle' ] == 'streetview') {

		                    /**
		                    *Start: Height of Field
		                    **/
		                        echo '<li>';
		                        echo '<span class="pf-inner-title">'.esc_html__('Map Height','pointfindert2d').' : </span>';
		                        echo '
		                        <input type="text" id="' . $field['id'] . '-mheight_' . $slide[ 'ftitle' ] . '" name="' . $field['id'] . '[' . $slide[ 'ftitle' ] . '][mheight]'. '" value="' . $slide[ 'mheight' ] . '" class="full-text2 extension_itempage-mheight" />px</li>';
		                    /**
		                   * End: Height of Field
		                    **/

		                }

		               
		                echo '<li><input type="hidden" class="extension_itempage-sort" name="' . $field['id'] . '[' . $slide[ 'ftitle' ] . '][sort]'.'" id="' . $field['id'] . '-sort_' . $slide[ 'ftitle' ] . '" value="' . $slide[ 'sort' ] . '" /></li>';
		                echo '<li><input type="hidden" class="extension_itempage-ftitle" name="' . $field['id'] . '[' . $slide[ 'ftitle' ] . '][ftitle]'.'" id="' . $field['id'] . '-ftitle_' . $slide[ 'ftitle' ] . '" value="' . $slide[ 'ftitle' ] . '" /></li>';
		                echo '</ul></div></fieldset></div>';
		       
		            }
		            

		            
		            echo '</div></fieldset><br/>';

			$this->show_field_end( $field, $meta );
		}

	/******************** BEGIN META BOX SAVE **********************/

	// Save meta fields
	function save( $term_id, $tt_id ) {
		$metas = get_option( $this->_meta['id'] );
		if ( !is_array( $metas ) )
			$metas = (array) $metas;

		$meta = isset( $metas[$term_id] ) ? $metas[$term_id] : array();

		foreach ( $this->_fields as $field ) {
			$name = $field['id'];

			if ($name == 'pflt_configuration') {
				$new = isset( $_POST[$name] ) ? $_POST[$name] : array();
			}else{
				$new = isset( $_POST[$name] ) ? $_POST[$name] : ( $field['multiple'] ? array() : '' );
				$new = is_array( $new ) ? array_map( 'stripslashes', $new ) : stripslashes( $new );
			}

			if ( empty( $new ) ) {
				unset( $meta[$name] );
			} else {
				$meta[$name] = $new;
			}
		}

		$metas[$term_id] = $meta;
		update_option( $this->_meta['id'], $metas );
	}

	/******************** BEGIN META BOX DELETE **********************/

	function delete( $term_id, $tt_id ) {
		$metas = get_option( $this->_meta['id'] );
		if ( !is_array( $metas ) ) $metas = (array) $metas;

		unset( $metas[$term_id] );

		update_option( $this->_meta['id'], $metas );
	}

	/******************** BEGIN HELPER FUNCTIONS **********************/

	// Add missed values for meta box
	function normalize() {
		// Default values for meta box
		$this->_meta = array_merge( array(
			'taxonomies' => array( 'category', 'post_tag' )
		), $this->_meta );

		$this->_taxonomies = $this->_meta['taxonomies'];
		$this->_fields = $this->_meta['fields'];

		// Default values for fields
		foreach ( $this->_fields as & $field ) {
			$multiple = in_array( $field['type'], array( 'checkbox_list', 'file', 'image' ) ) ? true : false;
			$std = $multiple ? array() : '';
			$format = 'date' == $field['type'] ? 'yy-mm-dd' : ( 'time' == $field['type'] ? 'hh:mm' : '' );
			$style = in_array( $field['type'], array( 'text', 'textarea' ) ) ? 'width: 95%' : '';
			$optgroups = false;
			if ( 'select' == $field['type'] )
				$style = 'height: auto';

			$field = array_merge( array(
				'multiple'  => $multiple,
				'optgroups' => $optgroups,
				'std'       => $std,
				'desc'      => '',
				'format'    => $format,
				'style'     => $style,
			), $field );
		}
	}

	// Check if field with $type exists
	function has_field( $type ) {
		foreach ( $this->_fields as $field ) {
			if ( $type == $field['type'] ) return true;
		}
		return false;
	}

	/**
	 * Fixes the odd indexing of multiple file uploads from the format:
	 *  $_FILES['field']['key']['index']
	 * To the more standard and appropriate:
	 *  $_FILES['field']['index']['key']
	 */
	function fix_file_array( $files ) {
		$output = array();
		foreach ( $files as $key => $list ) {
			foreach ( $list as $index => $value ) {
				$output[$index][$key] = $value;
			}
		}
		$files = $output;
		return $output;
	}

	/******************** END HELPER FUNCTIONS **********************/
}