( function( $ ) {

	'use strict';

	var LaStudioKitEditor = {

		activeSection: null,

		editedElement: null,

		modal: false,

		modalConditions: false,

		init: function() {
			//elementor.channels.editor.on( 'section:activated', LaStudioKitEditor.onAnimatedBoxSectionActivated );

			elementor.channels.editor.on( 'section:activated', LaStudioKitEditor.onSearchSectionActivated );

			window.elementor.on( 'preview:loaded', function() {
				elementor.$preview[0].contentWindow.LaStudioKitEditor = LaStudioKitEditor;

				LaStudioKitEditor.onPreviewLoaded();
			});
		},

		onSearchSectionActivated: function( sectionName, editor ) {

			var editedElement = editor.getOption( 'editedElementView' );

			if ( 'lakit-search' !== editedElement.model.get( 'widgetType' ) ) {
				return;
			}

			window.LaStudioKitEditor.activeSection = sectionName;

			var isPopup = -1 !== [ 'section_popup_style', 'section_popup_close_style', 'section_form_style' ].indexOf( sectionName );

			if ( isPopup ) {
				editedElement.$el.find( '.lakit-search' ).addClass( 'lakit-search-popup-active' );
			} else {
				editedElement.$el.find( '.lakit-search' ).removeClass( 'lakit-search-popup-active' );
			}

		},

		onPreviewLoaded: function() {
			var elementorFrontend = $('#elementor-preview-iframe')[0].contentWindow.elementorFrontend;

			elementorFrontend.hooks.addAction( 'frontend/element_ready/lakit-tabs.default', function( $scope ){
				$scope.find( '.lakit-tabs__edit-cover' ).on( 'click', LaStudioKitEditor.showTemplatesModal );
				$scope.find( '.lakit-tabs-new-template-link' ).on( 'click', function( event ) {
					window.location.href = $( this ).attr( 'href' );
				} );
			} );

			elementorFrontend.hooks.addAction( 'frontend/element_ready/lakit-template.default', function( $scope ){
				$scope.find( '.lakit-tabs__edit-cover' ).on( 'click', LaStudioKitEditor.showTemplatesModal );
				$scope.find( '.lakit-tabs-new-template-link' ).on( 'click', function( event ) {
					window.location.href = $( this ).attr( 'href' );
				} );
			} );

			elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ){
				$scope.find( '.lastudio-kit-edit-template-link' ).on( 'click', function( event ) {
					window.open( $( this ).attr( 'href' ) );
				} );
			} );

			LaStudioKitEditor.getModal().on( 'hide', function() {
				window.elementor.reloadPreview();
			});
		},

		showTemplatesModal: function() {
			var editLink = $( this ).data( 'template-edit-link' );

			LaStudioKitEditor.showModal( editLink );
		},

		showModal: function( link ) {
			var $iframe,
				$loader;

			LaStudioKitEditor.getModal().show();

			$( '#lakit-tabs-template-edit-modal .dialog-message').html( '<iframe src="' + link + '" id="lakit-tabs-edit-frame" width="100%" height="100%"></iframe>' );
			$( '#lakit-tabs-template-edit-modal .dialog-message').append( '<div id="lakit-tabs-loading"><div class="elementor-loader-wrapper"><div class="elementor-loader"><div class="elementor-loader-boxes"><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div></div></div><div class="elementor-loading-title">Loading</div></div></div>' );

			$iframe = $( '#lakit-tabs-edit-frame');
			$loader = $( '#lakit-tabs-loading');

			$iframe.on( 'load', function() {
				$loader.fadeOut( 300 );
			} );
		},

		getModal: function() {

			if ( ! LaStudioKitEditor.modal ) {
				this.modal = elementor.dialogsManager.createWidget( 'lightbox', {
					id: 'lakit-tabs-template-edit-modal',
					closeButton: true,
					hide: {
						onBackgroundClick: false
					}
				} );
			}

			return LaStudioKitEditor.modal;
		},
	};

	$( window ).on( 'elementor:init', LaStudioKitEditor.init );

	window.LaStudioKitEditor = LaStudioKitEditor;

}( jQuery ) );
