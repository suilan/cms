<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAA6etUHXI:APA91bFjNeWTIJHe76zAAjOo0uyQyED1ty6TqPuPZgNdbOzC-CZ0BYkTnPrNZY7aaUDKN6oI5YkYPUH6jYVOgF-5Qgu2yCJpoUIbLGC-MU8iVe1wCy2zmYMigWIs0zgeXqwEUma4iDjd'),
        'sender_id' => env('FCM_SENDER_ID', '1004675538290'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
