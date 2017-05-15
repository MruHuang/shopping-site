<?php

namespace App\Search;

use App\Search\SearchInformation as SI;

class Search
{
    private $si;
   
    public function __construct(SI $si){
        $this->si = $si;
    }

    public function Search(
        $search_text,
        $StartNumber,
        $EndNumber,
        $search_type,
        $groupby_type
    ){
        $commodity_information = $this->si->SearchInformation(
            $search_text,
            $search_type
        );
        $result = array();
        foreach ($commodity_information as $key => $value) {
            foreach ($value as $key2 => $value2) {
                array_push($result, $value2);
            }
        }
        $result_count = count($result);
        return  array('data'=>collect($result)
        ->sortBy($groupby_type)
        ->slice($StartNumber-1, $EndNumber-$StartNumber+1)
        ->values()->all(),
        'count'=>$result_count);
    }
}
