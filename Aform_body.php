<?php

class Alink {

	private static $attrs_ref = array( "href", "rel", "target", "class", "id", "content", "name", "itemprop" ); 
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
		$text = "";

		$tag = 	Html::openElement(
			'form',
				$attrs,
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}

	public static function process_aformend( &$parser, $frame, $args ) {

		$attrs = array();
		$text = "";

		$tag = 	Html::closeElement(
			'form',
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}

	public static function process_ainput( &$parser, $frame, $args ) {

		$attrs = array();
		$text = "";

		$tag = 	Html::element(
			'input',
				$attrs,
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}

	public static function process_aselect( &$parser, $frame, $args ) {

		$attrs = array();
		$text = "";

		$tag = 	Html::element(
			'select',
				$attrs,
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}
	
	public static function process_alabel( &$parser, $frame, $args ) {

		$attrs = array();
		$text = "";

		$tag = 	Html::element(
			'label',
				$attrs,
		);
		
		return $parser->insertStripItem( $tag, $parser->mStripState );
	}
	
}
