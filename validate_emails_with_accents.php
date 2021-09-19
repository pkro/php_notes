<?php

$emails = [
    'david@example.com',
    'björn@example.com',
    'åsgöt@invalid.com',
    'françoise@example.com',
    'саша@invalid.com'];


foreach ($emails as $email) {
    echo $email . " " . filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE) . '<br>';
}
