<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class JWT extends BaseConfig
{
    public $key = '29qTTocLyUDR1ATqdCvmBqvxmVPxvHBW';
    public $algorithm = 'HS256';
    public $issuer = 'school_hub';    // Issuer claim
    public $audience = 'school_hub'; // Audience claim
    public $expiry = 3600;
}
