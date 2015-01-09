Aform
===============

Convenient parser function for setting up form markup in MediaWiki

## Example

{{#aform:action={{FULLPAGENAME}}|method=get}}

{{#ainput_multi:type=hidden|list=text=House&size=100}}

{{#ainput:type=text|size=4|name=offset}}

{{#aselect:name=aninal[]|multiple=multiple|values=Dog,Cat,Mouse|selected=Dog}}

{{#aformend:}}

