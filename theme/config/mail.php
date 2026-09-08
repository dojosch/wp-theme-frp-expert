<?php
/**
 * SMTP Mail Setup (via wp-config.php constants)
 *
 * @package wp-starter-tw
 */

add_action(
	'phpmailer_init',
	function ($phpmailer) {
		if (
		defined('SMTP_HOST') &&
		defined('SMTP_PORT') &&
		defined('SMTP_USER') &&
		defined('SMTP_PASS') &&
		defined('SMTP_FROM') &&
		defined('SMTP_NAME')
		) {
			$phpmailer->isSMTP();
			$phpmailer->host = SMTP_HOST;
			$phpmailer->smtp_auth = SMTP_AUTH;
			$phpmailer->port = SMTP_PORT;
			$phpmailer->username = SMTP_USER;
			$phpmailer->password = SMTP_PASS;
			$phpmailer->smtp_secure = SMTP_SECURE;
			$phpmailer->from = SMTP_FROM;
			$phpmailer->from_name = SMTP_NAME;
			$phpmailer->smtp_debug = defined('SMTP_DEBUG') ? SMTP_DEBUG : 0;
		}
	}
);

/*
 * SMTP Settings for Outgoing Emails
 * Define before ABSPATH in wp-config.php

	define('SMTP_USER',   'user@example.com');
	define('SMTP_PASS',   'smtp-password');
	define('SMTP_HOST',   'smtp.example.com');
	define('SMTP_FROM',   'website@example.com');
	define('SMTP_NAME',   'Website Mailer');
	define('SMTP_PORT',   587);
	define('SMTP_SECURE', 'tls'); // ssl or tls
	define('SMTP_AUTH',    true);
	define('SMTP_DEBUG',   0);    // 0 = off, 1 = client msgs, 2 = client+server msgs

*/
