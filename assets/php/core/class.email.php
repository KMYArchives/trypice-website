<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Email {

		private static function email_subject(string $subject): string {
			return match($subject) {
				'reset'		=>	'Reset Password',
				'confirm'	=>	'Confirm Email',
				'login'		=>	'Confirm login',
			};
		}

		private static function otp_code(string $type, string $text, string $code): string {
			return "<tr>
				<td class='container'>
					<div class='content'>
						<table>
							<tr>
								<td>
									<h4>" . self::email_subject($type) . "</h4>
									<p>$text</p>
									<p class='callout border bg center'>$code</p>
									<p class='center'>
										<b>
											<i>If it wasn't you, just ignore this email.</i>
										</b>
									</p>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>";
		}

		public static function sender(array $params): bool {
			// Instantiation and passing `true` enables exceptions
			$mail = new PHPMailer;
			Utils::load_env();

			try {
				//Server settings
				$mail->isSMTP(); // Send using SMTP
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output

				$mail->Host			=	$_ENV['SMTP_DB']; // Set the SMTP server to send through
				$mail->SMTPAuth		=	$_ENV['SMTP_AUTH']; // Enable SMTP authentication
				$mail->Username		=	$_ENV['SMTP_USER']; // SMTP username
				$mail->Password		=	$_ENV['SMTP_PASS']; // SMTP password
				$mail->SMTPSecure	=	PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port			=	$_ENV['SMTP_PORT']; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
				$mail->CharSet		=	$_ENV['SMTP_CHARSET']; // Fix characters problems

				//Recipients
				$mail->setFrom($_ENV['SMTP_EMAIL'], System::global('name'));
				$mail->addAddress($params['email'], $params['name']); // Add a recipient

				// Content
				$mail->isHTML(true); // Set email format to HTML
				$mail->Subject	=	self::email_subject($params['subject']);
				$mail->Body		=	self::body($params['type'], $params['subject'], $params['body']);
				//$mail->AltBody	=	'This is the body in plain text for non-HTML mail clients';

				$mail->send();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public static function body(string $type, string $subject, string $body): string {
			switch ($type) {
				case 'otp':
					return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
					<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
							<meta name='viewport' content='width=device-width'>
							<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
							<style>" . 
								File::read(System::global('html_mail'), [ 
									'remote' => true 
								]) . 
							"</style>
						</head>

						<body>
							<table class='head-wrap'>
								<tr>
									<td class='header container border bg'>
										<div class='center padding'>
											<img src='" . System::images('logo_online') . "' class='logo'>
										</div>
									</td>
								</tr>
							</table>
							
							<table class='body-wrap'>" . self::otp_code($subject, 'To recovery your account, use the One Time Password (OTP):', $body) . "</table>
						</body>
					</html>";
					break;
			}
		}

	}