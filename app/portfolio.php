<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class portfolio extends Model
{
    protected $table = 'portfolio';

    function findportfolioInfoByCategoryId(int $categoryId){
        return DB::table('portfolio')
        ->where('portfolio_category_id','=', $categoryId )
        ->where('is_delete','=',0)
        ->get();
    }
}
