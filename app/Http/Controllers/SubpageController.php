<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subpage\Subpage as SP;
use View;

class SubpageController extends Controller
{
    //
    private $sp;

    public function __construct(SP $sp){
        $this->sp = $sp;
    }
    public function Subpage(
    	$area,
    	$start,
    	$end,
    	$type,
    	$order_type,
        $this_page,
    	SP $sp
	){
    	
    	$AllInformation = $sp->Subpage(
    		$area, 
    		$start, 
    		$end, 
    		$type,
    		$order_type
		);

		$SpeciesInformation = $sp->SpeciesInformation($area);

		$CountInformation = $sp->CountInformation($area, $type);

		$All = array(
            'area' => $area,
			'type' => $SpeciesInformation,
            'this_type' => $type,
            'this_page' => $this_page,
			'count_page' => $CountInformation,
			'Information' => $AllInformation
		);
        //return $All;
    	//return $All['type'];
    	return view::make('Subpage',['All'=>$All]);
	}
}
