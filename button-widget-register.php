<?php
/**
 * Button widget
 * A simple button widget for your sidebars.
 *
 * @package         button-widget
 * @author          MyPreview (Github: @mahdiyazdani, @mypreview)
 * @since           1.1.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // End If Statement

/**
 * Registering Button Widget - Class
 */
class Button_Widget_Register extends WP_Widget {

    /**
     * Defaults
     *
     * @access  private
     * @var     defaults
     */
    private $defaults;

    /**
     * Setup class.
     *
     * @access  public
     * @return  void
     */
    public function __construct() {

        parent::__construct(
            'button_widget',
            apply_filters( 'button_widget_name', _x( 'Button', 'widget name', 'button-widget' ) ),
            array(
                'description'                 => _x( 'Display a simple button widget in your sidebar areas.', 'widget description', 'button-widget' ),
                'customize_selective_refresh' => true,
            )
        );

        $this->defaults = array(
            'text'             => '',
            'title'            => '',
            'id'               => '',
            'link'             => '',
            'target'           => 0,
            'text_color'       => '',
            'background_color' => '',
        );

    }

    /**
     * Widget Front End.
     *
     * @access  public
     * @param   mixed $args       Arguments.
     * @param   mixed $instance   Instance.
     * @return  void
     */
    public function widget( $args, $instance ) {

        $get_colors   = array();
        $instance     = wp_parse_args( (array) $instance, $this->defaults );
        $get_text     = isset( $instance['text'] ) ? $instance['text'] : $this->defaults['text'];
        $get_title    = isset( $instance['title'] ) ? $instance['title'] : $this->defaults['title'];
        $get_id       = isset( $instance['id'] ) ? $instance['id'] : $this->defaults['id'];
        $get_link     = isset( $instance['link'] ) ? $instance['link'] : $this->defaults['link'];
        $get_target   = isset( $instance['target'] ) ? self::string_to_bool( $instance['target'] ) : $this->defaults['target'];
        $get_colors[] = ! empty( $instance['text_color'] ) ? sprintf( 'color:%s;', sanitize_hex_color( $instance['text_color'] ) ) : $this->defaults['text_color'];
        $get_colors[] = ! empty( $instance['background_color'] ) ? sprintf( 'background:%s;', sanitize_hex_color( $instance['background_color'] ) ) : $this->defaults['background_color'];
        $get_colors   = array_filter( $get_colors );

        // Bail out, if the button text is NOT defined!
        if ( empty( $get_text ) ) {
            return;
        } // End If Statement

        $output = sprintf( '%s<a href="%s" id="%s" title="%s" target="%s" rel="%s" style="%s" class="%s">%s</a>%s', $args['before_widget'], ! empty( $get_link ) ? esc_url( $get_link ) : '#', esc_attr( $get_id ), esc_attr( $get_title ), $get_target ? '_blank' : '_self', $get_target ? 'noopener noreferrer nofollow' : '', implode( '', $get_colors ), esc_attr( apply_filters( 'button_widget_classname', 'button' ) ), esc_html( $get_text ), $args['after_widget'] );

        /**
         * Filters the `Button` widget output.
         *
         * @param string $output    `Button`   Widget html output.
         */
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo apply_filters( 'button_widget_output', $output );

    }

    /**
     * Widget Settings.
     *
     * @access  public
     * @param   mixed $instance   Instance.
     * @return  void
     */
    public function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, $this->defaults );
        ?><p>
            <label 
                for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
            >
            <?php
                echo esc_html_x( 'Text:', 'field label', 'button-widget' );
            ?>
            </label>
            <input
                type="text"
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
                value="<?php echo esc_attr( $instance['text'] ); ?>"
            />
        </p>
        <p>
            <label 
                for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"
            >
            <?php
                /* translators: %s: Small open and close tags. */
                printf( esc_html_x( 'ID %1$sattribute%2$s:', 'field label', 'button-widget' ), '<small>', '</small>' );
            ?>
            </label>
            <input
                type="text"
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>"
                value="<?php echo esc_attr( $instance['id'] ); ?>"
            />
        </p>
        <p>
            <label 
                for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
            >
            <?php
                /* translators: %s: Small open and close tags. */
                printf( esc_html_x( 'Title %1$sattribute%2$s:', 'field label', 'button-widget' ), '<small>', '</small>' );
            ?>
            </label>
            <input
                type="text"
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                value="<?php echo esc_attr( $instance['title'] ); ?>"
            />
        </p>
        <p>
            <label 
                for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"
            >
            <?php
                echo esc_html_x( 'Link to:', 'field label', 'button-widget' );
            ?>
            </label>
            <input
                type="url"
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>"
                value="<?php echo esc_url( $instance['link'] ); ?>"
            />
        </p>
        <p>
            <input
                value="1"
                type="checkbox"
                id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>"
                <?php checked( $instance['target'], 1 ); ?>
            />
            <label 
                for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"
            >
            <?php
                echo esc_html_x( 'Open linked address in a new window?', 'field label', 'button-widget' );
            ?>
            </label>
        </p>
        <p>
            <label 
                for="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>"
            >
            <?php
                echo esc_html_x( 'Color:', 'field label', 'button-widget' );
            ?>
            </label>
            <input
                type="text"
                class="button-widget-color-picker"
                data-default-color="<?php echo sanitize_hex_color( apply_filters( 'button_widget_text_color', '#FFFFFF' ) ); ?>"
                id="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'text_color' ) ); ?>"
                value="<?php echo esc_attr( $instance['text_color'] ); ?>"
            />
        </p>
        <p>
            <label 
                for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>"
            >
            <?php
                echo esc_html_x( 'Background:', 'field label', 'button-widget' );
            ?>
            </label>
            <input
                type="text"
                class="button-widget-color-picker"
                data-default-color="<?php echo sanitize_hex_color( apply_filters( 'button_widget_background_color', '#0085BA' ) ); ?>"
                id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>"
                value="<?php echo esc_attr( $instance['background_color'] ); ?>"
            />
        </p>
        <?php

    }

    /**
     * Update Widget Settings.
     *
     * @access  public
     * @param   mixed $new_instance   New Instance.
     * @param   mixed $old_instance   Old Instance.
     * @return  Instance.
     */
    public function update( $new_instance, $old_instance ) {

        $instance                     = array();
        $instance['text']             = sanitize_text_field( $new_instance['text'] );
        $instance['id']               = sanitize_text_field( $new_instance['id'] );
        $instance['title']            = sanitize_text_field( $new_instance['title'] );
        $instance['link']             = esc_url_raw( $new_instance['link'] );
        $instance['target']           = ( ! isset( $new_instance['target'] ) ) ? 0 : 1;
        $instance['text_color']       = ! empty( $new_instance['text_color'] ) ? sanitize_hex_color( $new_instance['text_color'] ) : $this->defaults['text_color'];
        $instance['background_color'] = ! empty( $new_instance['background_color'] ) ? sanitize_hex_color( $new_instance['background_color'] ) : $this->defaults['background_color'];

        return $instance;

    }

    /**
     * Converts a string (e.g. 'yes' or 'no') to a bool.
     *
     * @access  public
     * @param   string $input   String to convert.
     * @return  bool
     */
    public static function string_to_bool( $input ) {

        return is_bool( $input ) ? $input : ( 'yes' === $input || 1 === $input || 'true' === $input || 'TRUE' === $input || '1' === $input );

    }

} // End Class.
