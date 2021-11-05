<?php

// Set these values in config.php to override the defaults

return [
    // An absolute path to where uploaded files will be stored.
    // Defaults to ./uploads/
    'upload_dir' => '/path/to/uploads/',

    // Limit uploads to specific IPv4 subnets.
    // Defaults to an empty array, which allows any IP to upload files.
    'allowed_ips' => ['127.0.0.1', '192.168.1.0/24'],
];
