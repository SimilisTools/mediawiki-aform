<?php

class AformHooks
{
    public static function onParserFirstCallInit($parser)
    {
        $parser->setFunctionHook('aform', [ 'Aform', 'process_aform' ], SFH_OBJECT_ARGS);
        $parser->setFunctionHook('ainput', [ 'Aform', 'process_ainput' ], SFH_OBJECT_ARGS);
        $parser->setFunctionHook('ainput_multi', [ 'Aform', 'process_ainput_multi' ], SFH_OBJECT_ARGS);
        $parser->setFunctionHook('aselect', [ 'Aform', 'process_aselect' ], SFH_OBJECT_ARGS);
        $parser->setFunctionHook('aformend', [ 'Aform', 'process_aformend' ], SFH_OBJECT_ARGS);
        $parser->setFunctionHook('alabel', [ 'Aform', 'process_alabel' ], SFH_OBJECT_ARGS);
        return true;
    }
}
