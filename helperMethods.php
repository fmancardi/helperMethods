<?php
# Copyright (C) 2018  TESISQUARE
#  
#             
class helperMethodsPlugin extends MantisPlugin {

	function register() {
		$this->name = 'helperMethods';
		$this->description = 'Collection of Useful Miscelaneous Methods';
    $this->page = '';

		$this->version = '1.0.1';
		$this->requires		= array(
			'MantisCore' => '2.0.0',
		);

		$this->author		= 'Francisco Mancardi';
		$this->contact		= 'francisco.mancardi@tesisquare.com';
		$this->url			= 'http://www.tesisquare.com';
	}

	/**
	 */
	function init() {
	}

	/**
	 * Plugin configuration
	 */
	function config() {
        return array();
	}

	/**
	 * Event hooks.
	 */
	function hooks() {
        return array();
  }

  /**
   *
   */
  static function drawInputTextAreaRow($idcard, $value = null, $options = null) {

          $opt = array('lbl' => null, 'suffix' => '_code', 
                       'rows' => 20, 'cols' => 50,
                       'input_prefix' => null, 'input_suffix' => null,
                       'input_name' => null);       
          $opt = array_merge($opt,(array)$options);

          $lbl = $opt['lbl'];
          $suffix = $opt['suffix'];
          $input_prefix = $opt['input_prefix'];
          $input_suffix = $opt['input_suffix'];
          $input_name = trim($opt['input_name']);
          $rows = $opt['rows'];
          $cols = $opt['cols'];

          $access_key = "{$idcard}{$suffix}";
          if( null == $input_name ) {
              $input_name = $input_prefix . $idcard . $input_suffix;
          }  

          $l10n = is_null($lbl) ? plugin_lang_get( $item_idcard ) : $lbl;

          echo '<tr ', helper_alternate_class(), '><td class="category">', $l10n,'</td>';
          echo '<td>';
          echo '<textarea name="' . $input_name . '" '. 
               ' id="' . $input_name . '" ';
          echo ' rows="' . $rows . '" ';
          echo ' cols="' . $cols . '">';
          echo trim($value); 
          echo '</textarea></td></tr>';
    }


  /**
   *
   */
  static function drawInputTextRow($idcard, $value = null, $options = null) {

          $opt = array('lbl' => null, 'suffix' => '_code', 
                       'maxlenght' => 50, 'size' => 50,
                       'input_prefix' => null, 'input_suffix' => null,
                       'input_name' => null);       
          $opt = array_merge($opt,(array)$options);

          $lbl = $opt['lbl'];
          $suffix = $opt['suffix'];
          $input_prefix = $opt['input_prefix'];
          $input_suffix = $opt['input_suffix'];
          $input_name = trim($opt['input_name']);
          $maxlenght = $opt['maxlenght'];
          $size = $opt['size'];

          $access_key = "{$idcard}{$suffix}";
          if( null == $input_name ) {
              $input_name = $input_prefix . $idcard . $input_suffix;
          }  

          $l10n = is_null($lbl) ? plugin_lang_get( $item_idcard ) : $lbl;

          echo '<tr ', helper_alternate_class(), '><td class="category">', $l10n,'</td>';
          echo '<td>';
          echo '<input type="text" name="' . $input_name . '" '. 
               ' id="' . $input_name . '" ';
          echo ' maxlenght="' . $maxlenght . '" ';
          echo ' size="' . $size . '" ';
                
          echo ' value="' . trim($value) . '">';
          echo '</td></tr>';
    }



    /**
     *  attr => key:input name
     *          val: value
     */
    static function drawGenericYesNoComboRow($attr, $opt=null) {
      $t_items = array( 0 => 'No', 1 => 'Si');

      $t_opt = array('suffix' => '', 'input_prefix' => '');
      $t_opt = array_merge($t_opt,(array)$opt);

      // ugly
      foreach( $attr as $key => $val ) {
        $t_in = $key;
        break;
      }
      self::drawComboRow($t_in,$t_items,$attr,$t_opt);
    }

    /**
     * 
     * es.:
     * $item_idcard: domain
     * $access_key = "{$item_idcard}{$suffix}"; => domain_code
     * $attr[$access_key]
     *
     */ 
    static function drawComboRow($item_idcard,$item_set,$attr=null,$options=null) {

          $opt = array('lbl' => null, 'suffix' => '_code', 
                       'input_prefix' => null, 'input_suffix' => null,
                       'input_name' => null);       
          $opt = array_merge($opt,(array)$options);

          $lbl = $opt['lbl'];
          $suffix = $opt['suffix'];
          $input_prefix = $opt['input_prefix'];
          $input_suffix = $opt['input_suffix'];
          $input_name = $opt['input_name'];

          $access_key = "{$item_idcard}{$suffix}";
          if( null == $input_name ) {
              $input_name = $input_prefix . $item_idcard . $input_suffix;
          }  

          $l10n = is_null($lbl) ? plugin_lang_get( $item_idcard ) : $lbl;

          echo '<tr ', helper_alternate_class(), '><td class="category">', $l10n,'</td>';
          echo '<td>';
          echo '<select name="' . $input_name . '">';
          if( !is_null($item_set) && count($item_set) > 0 ) {
                foreach($item_set as $code => $description) {
                      echo '<option value="' . $code . '"';
                      if( !is_null($attr) && isset($attr[$access_key]) && 
                          $code == $attr[$access_key] ) {
                          echo ' selected="selected" ';
                      }
                      echo '>' . $description . '</option>';  
                }
          }
          echo '</select>';
          echo '</td></tr>';
    }


  /**
   * Print a button which presents a standalone form.
   * If $p_security_token is OFF, the button's form will not contain a security
   * field; this is useful when form does not result in modifications (CSRF is not
   * needed). If otherwise specified (i.e. not null), the parameter must contain
   * a valid security token, previously generated by form_security_token().
   * Use this to avoid performance issues when loading pages having many calls to
   * this function, such as adm_config_report.php.
   * @param string $p_action_page    The action page.
   * @param string $p_label          The button label.
   * @param array  $p_args_to_post   Associative array of arguments to be posted, with
   *                                 arg name => value, defaults to null (no args).
   * @param mixed  $p_security_token Optional; null (default), OFF or security token string.
   * @param string $p_class          The CSS class of the button.
   * @see form_security_token()
   * @return void
   *
   * MantisBT original print_form_button()
   */

  static function printFormButton( $p_action_page, $p_label, array $p_args_to_post = null, $p_security_token = null, $p_class = '', $p_form_name = null ) {
      $t_form_name = explode( '.php', $p_action_page, 2 );

      if( !is_null($p_form_name) ) {
          $t_form_name = array($p_form_name);     
      }

      # TODO: ensure all uses of print_button supply arguments via $p_args_to_post (POST)
      # instead of via $p_action_page (GET). Then only add the CSRF form token if
      # arguments are being sent via the POST method.
      echo '<form method="post" action="', htmlspecialchars( $p_action_page ), '" class="form-inline inline single-button-form">';
      echo '<fieldset>';
      if( $p_security_token !== OFF ) {
          echo form_security_field( $t_form_name[0], $p_security_token );
      }
      if( $p_class !== '') {
          $t_class = $p_class;
      } else {
          $t_class = 'btn btn-primary btn-xs btn-white btn-round';
      }
      echo '<button type="submit" class="' . $t_class . '">' . $p_label . '</button>';
      if( $p_args_to_post ) {
          print_hidden_inputs( $p_args_to_post );
      }
      echo '</fieldset>';
      echo '</form>';
  }

  /**
   *
   */
  static function printOptionList( $p_enum_name, $p_domain, $p_val = 0 ) {
      $t_val = (int)$p_val;
      foreach ( $p_domain as $t_key ) {
        $t_elem2 = get_enum_element( $p_enum_name, $t_key );
        echo '<option value="' . $t_key . '"';
        check_selected( $t_val, $t_key );
        echo '>' . string_html_specialchars( $t_elem2 ) . '</option>';
      }
  }

  /**
   * based/copied from print_custom_field_input
   */
  static function printCustomFieldInput(array $p_field_def, $p_value, $p_required = false ) {

    $t_custom_field_value = $p_value;
    if( $t_custom_field_value === null &&
      ( $p_field_def['type'] == CUSTOM_FIELD_TYPE_ENUM ||
        $p_field_def['type'] == CUSTOM_FIELD_TYPE_LIST ||
        $p_field_def['type'] == CUSTOM_FIELD_TYPE_MULTILIST ||
        $p_field_def['type'] == CUSTOM_FIELD_TYPE_RADIO ) ) {
      $t_custom_field_value = custom_field_default_to_value( $p_field_def['default_value'], $p_field_def['type'] );
    }

    global $g_custom_field_type_definition;
    if( isset( $g_custom_field_type_definition[$p_field_def['type']]['#function_print_input'] ) ) {
      call_user_func( $g_custom_field_type_definition[$p_field_def['type']]['#function_print_input'], $p_field_def,
        $t_custom_field_value, $p_required ? ' required ' : '' );
      print_hidden_input( custom_field_presence_field_name( $p_field_def['id'] ), '1' );
    } else {
      trigger_error( ERROR_CUSTOM_FIELD_INVALID_DEFINITION, ERROR );
    }

  }

} // Class end