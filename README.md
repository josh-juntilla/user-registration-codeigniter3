# Simple Registration System for CodeIgniter 3
This is a simple PHP based User Registration system for CodeIgniter. It has Registration, Email verification, Reset password and Login. It uses PHPMailer for email sending. Bootstrap was used for the design.

## Setting up
Everything at CodeIgniter is set-up but make sure to set your own configuration accordingly like `base_url` and the `database` credentials

## Database
Import the sql file `user-registration`.

Database has 3 tables
- ci_sessions
- tokens
- users

## Setup Mailer
To make the email sending work for Registration, Email verification, and Password reset, you have to configure your Email/SMTP credentials at `application/config/mailer.php`

```php
$config['host'] =               ;//SMTP server to send through
$config['name'] =               ;//any name will do;
$config['username'] =           ;//username of the email/SMTP;
$config['password'] =           ;//password of the email/SMTP;
$config['smtp_auth'] =          ;//enable SMTP authentication. set true or false 
```