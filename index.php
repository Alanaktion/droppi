<?php

/*
 ▄▄▄▄▄▄  ▄▄▄▄▄▄   ▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄ ▄▄▄
█      ██   ▄  █ █       █       █       █   █
█  ▄    █  █ █ █ █   ▄   █    ▄  █    ▄  █   █
█ █ █   █   █▄▄█▄█  █ █  █   █▄█ █   █▄█ █   █
█ █▄█   █    ▄▄  █  █▄█  █    ▄▄▄█    ▄▄▄█   █
█       █   █  █ █       █   █   █   █   █   █
█▄▄▄▄▄▄██▄▄▄█  █▄█▄▄▄▄▄▄▄█▄▄▄█   █▄▄▄█   █▄▄▄█

An inherently-insecure drop box for simple file uploads.
*/

// Load configuration from the config.php file, if it exists

$config = [
    'upload_dir' => __DIR__ . '/uploads/',
    'allowed_ips' => [],
];
if (is_file(__DIR__ . '/config.php')) {
    $userConfig = include __DIR__ . '/config.php';
    if (is_array($userConfig)) {
        $config = array_merge($config, $userConfig);
    }
}

// Check if the remote IP is allowed to upload files
$allowed = true;
if (count($config['allowed_ips'])) {
    $allowed = false;
    foreach ($config['allowed_ips'] as $subnet) {
        if (strpos($subnet, '/') == false) {
            $subnet .= '/32';
        }
        [$subnet, $netmask] = explode('/', $subnet, 2);
        $subnet_dec = ip2long($subnet);
        $ip_dec = ip2long($_SERVER['REMOTE_ADDR']);
        $wildcard_dec = pow(2, (32 - $netmask)) - 1;
        $netmask_dec = ~$wildcard_dec;
        if (($ip_dec & $netmask_dec) == ($subnet_dec & $netmask_dec)) {
            $allowed = true;
            break;
        }
    }
}

// Save uploaded files
if (isset($_FILES['files']) && $allowed) {
    $errors = [];
    $success = [];
    if (!is_dir($config['upload_dir'])) {
        mkdir($config['upload_dir'], 0755, true);
    }
    foreach ($_FILES['files']['error'] as $i => $error) {
        if ($error != UPLOAD_ERR_OK) {
            $errors[] = $_FILES['files']['name'][$i];
            continue;
        }
        $tmp_name = $_FILES['files']['tmp_name'][$i];
        $name = $_FILES['files']['name'][$i];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $name = substr(md5(microtime() . $name), 0, 10) . '.' . $ext;
        $path = $config['upload_dir'] . $name;
        if (move_uploaded_file($tmp_name, $path)) {
            $success[] = $name;
        } else {
            $errors[] = $_FILES['files']['name'][$i];
        }
    }
}

require('droppi.phtml');
