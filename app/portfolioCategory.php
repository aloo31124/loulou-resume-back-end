<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class portfolioCategory extends Model
{
    protected $table = 'portfolio_category';

    public function findAllChildNodesByParentId(int $parentId){
        return DB::table('portfolio_category')
        ->where('parent_id','=', $parentId )
        ->where('is_delete','=',0)
        ->get();
    }
}
