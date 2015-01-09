<?php


if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$GLOBALS['wgExtensionCredits']['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Aform',
	'version' => '0.1',
	'url' => 'https://github.com/SimilisTools/mediawiki-Aform',
	'author' => array( 'Toniher' ),
	'descriptionmsg' => 'Aform-desc',
);

$GLOBALS['wgAutoloadClasses']['Aform'] = __DIR__.'/Aform_body.php';
$GLOBALS['wgMessagesDirs']['Aform'] = __DIR__ . '/i18n';
$GLOBALS['wgExtensionMessagesFiles']['Aform'] = __DIR__ . '/Aform.i18n.php';
$GLOBALS['wgExtensionMessagesFiles']['AformMagic'] = __DIR__ . '/Aform.i18n.magic.php';

$GLOBALS['wgHooks']['ParserFirstCallInit'][] = 'wfRegisterAform';


/**
 * @param $parser Parser
 * @return bool
 */
function wfRegisterAform( $parser ) {
	$parser->setFunctionHook( 'aform', 'Aform::process_aform', SFH_OBJECT_ARGS );
	$parser->setFunctionHook( 'ainput', 'Aform::process_ainput', SFH_OBJECT_ARGS );
	$parser->setFunctionHook( 'ainput_multi', 'Aform::process_ainput_multi', SFH_OBJECT_ARGS );
	$parser->setFunctionHook( 'aselect', 'Aform::process_aselect', SFH_OBJECT_ARGS );
	$parser->setFunctionHook( 'aformend', 'Aform::process_aformend', SFH_OBJECT_ARGS );
	$parser->setFunctionHook( 'alabel', 'Aform::process_alabel', SFH_OBJECT_ARGS );
	return true;
}
