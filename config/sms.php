<?php

return [

    /*
     * Specify which database driver you want to use.
     */
    'default' => env('SMS_DRIVER', 'null'),


    /*
     * Specify sender name.
     */
    'from' => env('SMS_FROM', 'Laravel'),


    /*
     * List of drivers and theirs configurations.
     */
    'drivers' => [

        /*
         * Driver for sending sms messages to running emulator.
         */
        'emulator' => [

            /*
             * Specify Android SDK path
             */
            'android_sdk_path' => env('SMS_ANDROID_SDK_PATH'),

        ]

    ]

];