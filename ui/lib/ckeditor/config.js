/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// ONLY IMAGES should be uploaded. Don't want upload tab appearing on 'link' popup
	//config.filebrowserBrowseUrl = '/ui/lib/kcfinder/browse.php?type=files';
	//config.filebrowserUploadUrl = '/ui/lib/kcfinder/upload.php?type=files';

	config.filebrowserImageBrowseUrl = '/ui/lib/kcfinder/browse.php?type=images';
	config.filebrowserImageUploadUrl = '/ui/lib/kcfinder/upload.php?type=images';

   	CKEDITOR.config.toolbar = [
	   ['Styles','Format','Font','FontSize','Bold','Italic','Underline','Subscript','Superscript','-','TextColor','BGColor','-','RemoveFormat'],
 	   ['SpellChecker','Scayt','Print'],
	   '/',
	   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Outdent','Indent'],
	   ['StrikeThrough','-','Undo','Redo','-','SelectAll','Cut','Copy','Paste','PasteText','PasteFromWord','Find','Replace'],
	   ['Image','Table','-','Link','Source','-','Maximize']
	] ;

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// needed to stop error message 'incorrect server response'
	config.filebrowserUploadMethod = 'form';

	// Simplify the dialog windows.
	//config.removeDialogTabs = 'image:advanced;link:advanced';
};
