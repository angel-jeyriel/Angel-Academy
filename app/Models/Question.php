<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['test_id', 'text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option'];

    protected $casts = [
        'correct_option' => 'string',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
