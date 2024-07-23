<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $guarded = ['id'];

    protected $table = 'email_sms_templates';

    protected $casts = [
        'shortcodes' => 'object'
    ];

}
