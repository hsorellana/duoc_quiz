<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['read'];

    public static function randomComexQuestion()
    {
        return Question::where('career', 'Comercio exterior')->where('q_read', 0)->inRandomOrder()->first();
    }

    public static function randomLogisticQuestion()
    {
    	return Question::where('career', 'Logistica')->where('q_read', 0)->inRandomOrder()->first();
    }
}
