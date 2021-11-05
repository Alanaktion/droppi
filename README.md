```
 ▄▄▄▄▄▄  ▄▄▄▄▄▄   ▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄ ▄▄▄
█      ██   ▄  █ █       █       █       █   █
█  ▄    █  █ █ █ █   ▄   █    ▄  █    ▄  █   █
█ █ █   █   █▄▄█▄█  █ █  █   █▄█ █   █▄█ █   █
█ █▄█   █    ▄▄  █  █▄█  █    ▄▄▄█    ▄▄▄█   █
█       █   █  █ █       █   █   █   █   █   █
█▄▄▄▄▄▄██▄▄▄█  █▄█▄▄▄▄▄▄▄█▄▄▄█   █▄▄▄█   █▄▄▄█
```

An inherently-insecure drop box for simple file uploads.

## Setup

Put these files somewhere web-accessible with a vaguely recent PHP.

By default, anyone can upload files, and they'll be stored in a new `uploads` directory wherever your droppi install is. To change those things, make a `config.php` file in the droppi install, and add values as shown in `config-sample.php`.

## Security

This is not secure. Don't use this on a network you don't fully trust. Even when using the built in subnet configuration you should have additional layers limiting access to this. Keep it behind HTTP auth or a known-safe IP list, use TLS, and disable execution of any code in the upload directory.

Droppi makes no attempt to verify the safety of uploaded files, if you use this and you get compromised, oof sorry.
