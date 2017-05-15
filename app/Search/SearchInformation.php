<?php

namespace App\Search;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;


class SearchInformation
{
    public function SearchInformation(
        $search_text,
        $speciestype
    ){
        return array(
        cmSQL::LikeSelect($search_text)
        ->Product()
         ->get(),
        cmSQL::LikeSelect($search_text)
        ->JoinGroupbuy()
        ->get(),
        cmSQL::LikeSelect($search_text)
        ->JoinLimited()
        ->get()
        );
    }

}
