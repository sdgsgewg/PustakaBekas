<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyUserTag extends Model
{
    use HasFactory;

    protected $table = 'reply_user_tags';
    protected $fillable = ['reply_id', 'user_id'];
}
