<?php

class ModalNotification
{
    private $options;

    public function __construct() {
        add_action('admin_menu', [$this, 'add_page']);
        add_action('admin_init', [$this, 'page_init']);

        $time = $this->getTimeWhenModalDisplay();

        if(!isset($_COOKIE['modal-notification'])) {
            add_action('the_content', [$this, 'init_modal']);
            setcookie('modal-notification', 'set', $time);
        }        
    }

    public function init_modal() {
        echo 
        '<div class="modal">
        <a class="close-modal">X</a>
        <div>';
            echo get_option('modal_notification')['content'];
            echo
        '</div>
        </div>';
    }

    public function add_page() {
        add_options_page(
            'Settings Admin',
            'Modal Notification',
            'manage_options',
            'modal_notification_settings_page',
            [$this, 'create_page']
        );
    }

    public function create_page() {
        $this->options = get_option('modal_notification');
        ?>
            <div class="wrap">
                <h2>Modal Notification</h2>
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

    public function page_init(){
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

        add_settings_field(
            'time',
            'Co jaki czas ma się wyświetlać okno?',
            array($this, 'time_callback'),
            'modal_notification_settings_page',
            'modal_notification_id'
        );
    }

    public function sanitize($input) {
        $new_input = array();

        if (isset($input['content'])) {
            $new_input['content'] = sanitize_text_field($input['content']);
        }

        if (isset($input['time'])) {
            $new_input['time'] = sanitize_text_field($input['time']);
        }

        return $new_input;
    }

    public function section_callback() {
        //
    }

    public function time_callback() {
        ?>
          <select name="modal_notification[time]" id="time">
          <option value="1" <?php selected($this->options['time'], 1); ?> >Co godzinę</option>
          <option value="2" <?php selected($this->options['time'], 2); ?> >Co 3 godziny</option>
          <option value="3" <?php selected($this->options['time'], 3); ?> >Co 1 dzień</option>
          </select>
        <?php
    }

    public function content_callback() {
        echo '<textarea id="content" name="modal_notification[content]" class="" rows="10" cols="100">'.$this->options['content'].'</textarea>';
    }

    public function getTimeWhenModalDisplay() {
        $selectedOption = get_option('modal_notification')['time'];

        switch ($selectedOption) {
            case '1':
                return time()+3600;
                break;
            case '2':
                return time()+10800;
                break;
            case '3':
                return time()+3600*24;
                break;
        }
    }
}
