/**
 * Initialize jQuery colorpicker
 *
 * @since       1.0.0
 * @package     Button Widget
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */
( function( wp, $ ) {
        'use strict';

        if ( ! wp ) {
            return;
        } // End If Statement

        $( document ).on( 'widget-added widget-updated', onFormUpdate );

        $( document ).ready( function() {
            $( '#widgets-right .widget:has(.button-widget-color-picker)' ).each( function () {
                initColorPicker( $( this ) );
            } );
        } );

        function onFormUpdate( event, widget ) {
            initColorPicker( widget );
        }

        // Initialize color picker on fields with the following classname.
        function initColorPicker( widget ) {
           widget.find( '.button-widget-color-picker' ).wpColorPicker( {
                change: _.throttle( function() { // For Customizer
                    $( this ).trigger( 'change' );
                }, 3000 )
            } );
        }

} )( window.wp, jQuery );