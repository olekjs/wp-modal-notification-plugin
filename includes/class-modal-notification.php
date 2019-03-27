<?php

class ModalNotification
{
    public function __construct() {
        add_action('admin_menu', [$this, 'add_page']);
        // add_action('admin_init', [$this, 'page_init']);
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
		?>
			<div class="wrap">
				<h2>Ustawienia okna z powiadomieniem</h2>           
				<form method="post" action="options.php">
					<?php
						echo 'test'; 
					?>
				</form>
			</div>
		<?php
	}

	public function page_init() {        
		//     
	}
}
