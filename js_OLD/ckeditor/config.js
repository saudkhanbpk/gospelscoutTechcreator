/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
	
	config.toolbar = 'MyToolbar';
	
	config.height = 200;
	//config.startupMode = 'source';
	config.extraPlugins = 'image'; 
	config.width = 410;
	config.fullPage= true;
	config.autoParagraph = false;
	config.allowedContent = true;
	config.fillEmptyBlocks = false;
	config.height = '200px';

	config.toolbar_MyToolbar =
	[
		
		{ name: 'styles', items : [ 'Styles','Format' ] },
		{ name: 'basicstyles', items : [ 'Bold','Source','Italic','Strike','-','RemoveFormat' ] },
	];
};
s
