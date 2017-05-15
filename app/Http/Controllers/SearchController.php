<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Search\Search as SH;
use View;
class SearchController extends Controller
{
    //
    private $sh;
    public function __construct(SH $sh){
        $this->sh = $sh;
    }

    public function Search(
    	$StartNumber = 0,
        $EndNumber = 0,
        $this_page = 1,
        $search_text = null,
    	$search_type = "all",
    	$groupby_type = "AddTime"
	){
        //$AllInformation = array();
    	$AllInformation = $this->sh->Search(
    		"%".$search_text."%",
    		$StartNumber,
        	$EndNumber,
    		$search_type,
    		$groupby_type
		);
        array_push($AllInformation,$this_page,$search_text);
        //return $AllInformation;
        //return $AllInformation['data'];
        //(array_keys($AllInformation['data']));*/
        return View::make('SearchResult',['AllInformation'=>$AllInformation]);
        
    }
}
