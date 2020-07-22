<?php

namespace App;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class autobiography extends Model
{
    protected $table = 'autobiography'; 

    public function getAutogiographyAllChapterBySort(){
        return DB::table("autobiography")
                ->orderBy("sort")
                ->get();
    }

    public function findMaxSort(){   
        return DB::table("autobiography")
                ->select("sort")
                ->max("sort");
    }

    public function reorganizeSort(){
        $allChapters = $this->getAutogiographyAllChapterBySort();
        $count = 1;
        try{
            foreach($allChapters as $allChapter){
                if($allChapter->sort != $count){
                    error_log("reorganizeSort Inconsistent ordering start. count: $count, error sort=$allChapter->sort and id=$allChapter->id");                
                    $affected = DB::update('UPDATE autobiography SET sort ='.$count.' WHERE id = ?', [$allChapter->id]);
                    error_log("reorganizeSort Inconsistent ordering end. Number of modified data(affected)=$affected");
                }
                $count++;
            }            
        }catch(Exception $e){
            return 0;
        }    
        return 1;    
    }
}
