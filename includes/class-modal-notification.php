<?php

class ModalNotification
{
    private $options;

    public function __construct()
    {
        add_action('wp_head', [$this, 'init_scripts']);
        add_action('wp_head', [$this, 'init_styles']);

        add_action('admin_menu', [$this, 'add_page']);
        add_action('admin_init', [$this, 'page_init']);
        add_action('the_content', [$this, 'init_modal']);
    }

    public function init_modal()
    {
        echo '
            <div class="page-wrapper">
              <a class="btn trigger" href="javascript:;">Click Me!</a>
            </div>
            <div class="modal-wrapper">
              <div class="modal">
                <div class="head">
                  <a class="btn-close trigger" href="javascript:;"></a>
                </div>
                <div class="content">';
                    echo $this->options['content'];
                    echo '
                </div>
              </div>
            </div>';
    }

    public function init_styles()
    {
        echo '<link rel="stylesheet" href="' . plugins_url('styles/modal-notification.css', __FILE__) . '" type="text/css"/>';
    }

    public function init_scripts()
    {
        if (!wp_script_is('jquery')) {

            echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
        }

        echo '<script type="text/javascript" src="' . plugins_url('scripts/modal-notification.js', __FILE__) . '"></script>';
    }

    public function add_page()
    {
        add_options_page(
            'Settings Admin',
            'Modal Notification',
            'manage_options',
            'modal_notification_settings_page',
            [$this, 'create_page']
        );
    }

    public function create_page()
    {
        $this->options = get_option('modal_notification');
        ?>
            <div class="wrap">
                <h2>Ustawienia okna z powiadomieniem</h2>
                <form method="post" action="options.php">
                    <?php
settings_fields('modal_notification_group');
        do_settings_sections('modal_notification_settings_page');
        submit_button();
        ?>
                </form>
            </div>
        <?php
}

    public function page_init()
    {
        register_setting(
            'modal_notification_group',
            'modal_notification',
            array($this, 'sanitize')
        );

        add_settings_section(
            'modal_notification_id',
            'Edycja okna z powiadomieniem',
            array($this, 'section_callback'),
            'modal_notification_settings_page'
        );

        add_settings_field(
            'content',
            'Kontent',
            array($this, 'content_callback'),
            'modal_notification_settings_page',
            'modal_notification_id'
        );
    }

    public function sanitize($input)
    {
        $new_input = array();

        if (isset($input['content'])) {
            $new_input['content'] = sanitize_text_field($input['content']);
        }

        return $new_input;
    }

    public function section_callback()
    {
        echo '';
    }

    public function content_callback()
    {
        printf(
            '<textarea id="content" name="modal_notification[content]" value="%s"> </textarea>',
            isset($this->options['modal_notification']) ? esc_attr($this->options['modal_notification']) : ''
        );
    }
}
