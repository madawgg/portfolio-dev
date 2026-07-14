<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'sender_email',
        'subject',
        'message',
        'ip',
    ];
}
