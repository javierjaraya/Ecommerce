<?php
return array(
    // set your paypal credential
    'client_id' => 'Adb6Ug6MfyDuUCqXI6PO-lZ3SYahCCJAhd3nOCa-3bVk42CB36B2Pu3bvYRK8b8tb2QLX2qzFyaKiElC',
    //'DATO-DE-TU-APP-DE-PAYPAL',
    'secret' => 'EKUvBS56Ejnj9qMvxMGzhqBAOzRvIz8XLl6AKY3q1F4o0SPJsiVbu1HNs5u_EgOcGM7UXSq-rQxPjoOS',
    //'DATO-DE-TU-APP-DE-PAYPAL',

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);