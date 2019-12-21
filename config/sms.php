<?php

return [

    /*
     * Specify which database driver you want to use.
     */
    'default' => env('SMS_DRIVER', 'null'),


    'from' => env('SMS_FROM', 'Laravel'),


    /*
     * List of drivers and theirs configurations.
     */
    'drivers' => [
        'emulator' => [
            'android_sdk_path' => env('SMS_ANDROID_SDK_PATH'),
        ]
    ]
];