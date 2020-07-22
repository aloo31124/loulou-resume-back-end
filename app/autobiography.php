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

    public function changeSort($MovingDirection, $id){     
        try{   
            $thisData = DB::table("autobiography")->where('id','=',$id)->first();
            if($MovingDirection=="up")
                $otherDataSort = $thisData->sort - 1;
            else if($MovingDirection=="down")
                $otherDataSort = $thisData->sort + 1;  
            $otherData = DB::table("autobiography")->where('sort','=',$otherDataSort)->first();
            
            if($otherData != null){
                error_log("this data chapter title: $thisData->title original sort $thisData->sort changet sort to $otherData->sort");
                DB::update('UPDATE autobiography SET sort ='.$otherData->sort.' WHERE id = ?', [$thisData->id]);
                error_log("other data chapter title: $otherData->title original sort $otherData->sort changet sort to $thisData->sort");
                DB::update('UPDATE autobiography SET sort ='.$thisData->sort.' WHERE id = ?',  [$otherData->id]);            
            }else{
                return -1;
            }          
        }catch(Exception $e){
            error_log($e);
            return 0;
        }
        return 1;  
    }
}
