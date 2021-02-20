/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.toolbar = 'TSF';

    config.fillEmptyBlocks = false;
    config.ignoreEmptyParagraph = true;

    // config.disableNativeSpellChecker = true;
    // config.removePlugins = 'scayt,menubutton,contextmenu';
    //config.scayt_autoStartup = true;

    config.disableNativeSpellChecker = false;
    config.removePlugins = 'scayt,menubutton';
    config.browserContextMenuOnCtrl = true;

    config.toolbar_TSF =
        [
            { name: 'document', items : [ 'Source' ] },
            { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar'] },
            { name: 'styles', items : [ 'Format','Font','FontSize' ] },
            { name: 'colors', items : [ 'TextColor','BGColor' ] }
        ];

    config.toolbar_deadsimple =
        [
            { name: 'document', items : [ 'Source' ] },
            { name: 'clipboard', items : [ 'Copy','Paste','PasteFromWord','-','Undo','Redo' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'Blockquote'] },
            { name: 'links', items : [ 'Link','Unlink','Anchor','Image' ] }
        ];
};
