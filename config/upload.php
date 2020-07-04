<?php
return [
    'accessKey' => env('upload.access_key',''),
    'secretKey' => env('upload.secret_key',''),
    'bucket' => env('upload.bucket',''),
    'cdnDomainUrl' => env('upload.cdn_domain_url')
];