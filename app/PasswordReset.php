<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'token', 'used'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
