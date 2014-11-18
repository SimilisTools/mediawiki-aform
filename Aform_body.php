<?php

class Aform {

	private static $attrs_ref_common = array( "rel", "class", "id", "content", "name", "itemprop", "style" ); 
	private static $attrs_like = array( "data-" );
	private static $protocols = array( "https://", "http://", "ftp://" );
	
	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	public static function process_aform( &$parser, $frame, $args ) {

		$attrs = array();
		
		$attrs_ref = array( "method", "action" );

		foreach ( $args as $arg ) {
			$arg_clean = trim( $frame->expand( $arg ) );
			$arg_proc = explode( "=", $arg_clean, 2 );
			
			if ( count( $arg_proc ) == 1 ){
				$text = trim( $arg_proc[0] );
			} else {
			
				if ( in_array( trim( $arg_proc[0] ), self::$attrs_ref_common ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				if ( in_array( trim( $arg_proc[0] ), $attrs_ref ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				
				foreach ( self::$attrs_like as $attr_like ) {
					if ( strpos( $arg_proc[0], $attr_like ) == 0 ) {
						$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
					}
				}
			}
		}
		
		// Code for dealing with internal - external
		$external = 0;  
		if ( isset( $attrs["action"] ) ) {
			foreach ( self::$protocols as $protocol ) {
				$detect = strpos( $attrs["action"], $protocol );
				if ( is_int( $detect ) ) {
						$external = 1;
				}
			}
		}

		if ( $external == 0 ) {
			if ( isset( $attrs["action"] ) ) {
				global $wgArticlePath;
				$page = $attrs["action"];
				$page = str_replace( " ", "_", $page );
				$attrs["action"] = $wgArticlePath;
				$attrs["action"] = str_replace( "$1", urlencode( $page ), $attrs["action"] );
			}
		}
		
		$tag = 	Html::openElement(
			'form',
				$attrs
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}

	public static function process_aformend( &$parser, $frame, $args ) {

		$tag = 	Html::closeElement(
			'form'
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}

	public static function process_ainput( &$parser, $frame, $args ) {

		$attrs = array();
		
		$attrs_ref = array( "type", "name", "value", "size", "readonly", "disabled", "checked", "alt" );

		foreach ( $args as $arg ) {
			$arg_clean = trim( $frame->expand( $arg ) );
			$arg_proc = explode( "=", $arg_clean, 2 );
			
			if ( count( $arg_proc ) == 1 ){
				$text = trim( $arg_proc[0] );
			} else {
			
				if ( in_array( trim( $arg_proc[0] ), self::$attrs_ref_common ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				if ( in_array( trim( $arg_proc[0] ), $attrs_ref ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				
				foreach ( self::$attrs_like as $attr_like ) {
					if ( strpos( $arg_proc[0], $attr_like ) == 0 ) {
						$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
					}
				}
			}
		}
		
		$tag = 	Html::element(
			'input',
				$attrs
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}

	public static function process_aselect( &$parser, $frame, $args ) {

		$attrs = array();

		$attrs_ref = array( "name", "size", "multiple" );
		$attrs_pseudo = array( "names", "values", "selected", "sep" );
		$store = array();
		$separator = ",";

		foreach ( $args as $arg ) {
			$arg_clean = trim( $frame->expand( $arg ) );
			$arg_proc = explode( "=", $arg_clean, 2 );
			
			if ( count( $arg_proc ) == 1 ){
				$text = trim( $arg_proc[0] );
			} else {
			
				if ( in_array( trim( $arg_proc[0] ), self::$attrs_ref_common ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				
				if ( in_array( trim( $arg_proc[0] ), $attrs_ref ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}

				// We store pseudo values here
				if ( in_array( trim( $arg_proc[0] ), $attrs_pseudo ) ) {
					$store[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				
				foreach ( self::$attrs_like as $attr_like ) {
					if ( strpos( $arg_proc[0], $attr_like ) == 0 ) {
						$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
					}
				}
			}
		}

		$tag = 	Html::openElement(
			'select',
				$attrs
		);
		
		if ( array_key_exists("sep", $store) ) {
			$separator = $store["sep"];
		}
		
		if ( array_key_exists("values", $store) ) {
			
			// Let's split
			$values = explode( $separator, $store["values"] );
			$names = array();
			$selected = array();
			
			if ( count( $values  > 0 ) ) {
				// We have stuff
				
				if ( array_key_exists("names", $store) ) {
					
					$names = explode( $separator, $store["names"] );
				}
				
				if ( array_key_exists("selected", $store) ) {
					
					$selected = explode( $separator, $store["selected"] );
				}
				
				for ($i = 0; $i < count($values); ++$i) {
					$option = self::addOption( $i, $values, $names, $selected );
					$tag.= $option;
				}
			}
		}
		
		$tag.= Html::closeElement(
			'select',
				$attrs
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}
	
	public static function process_alabel( &$parser, $frame, $args ) {

		$attrs = array();
		$text = "";

		foreach ( $args as $arg ) {
			$arg_clean = trim( $frame->expand( $arg ) );
			$arg_proc = explode( "=", $arg_clean, 2 );
			
			if ( count( $arg_proc ) == 1 ){
				$text = trim( $arg_proc[0] );
			} else {
			
				if ( in_array( trim( $arg_proc[0] ), self::$attrs_ref_common ) ) {
					$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
				}
				
				foreach ( self::$attrs_like as $attr_like ) {
					if ( strpos( $arg_proc[0], $attr_like ) == 0 ) {
						$attrs[ trim( $arg_proc[0] ) ] = trim( $arg_proc[1] );
					}
				}
			}
		}		
		
		$tag = 	Html::element(
			'label',
				$attrs,
				$text
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}
	
	
	private static function addOption( $iter, $values, $names, $selected ) {
		
		$option = "";
		
		if ( array_key_exists( $iter, $values ) ) {
			
			$attrs = array();
			if ( in_array( $values[$iter], $selected ) ) {
				$attrs["selected"] = "selected";
			}
			
			if ( array_key_exists( $iter, $names ) ) {
				$attrs["value"] = $values[$iter];
				
				$option = Html::element(
					'option',
					$attrs,
					$names[$iter]
				);
				
			} else {
				
				$option = Html::element(
					'option',
					$attrs,
					$values[$iter]
				);
			}
		}
		
		return $option;

	}
	
}
