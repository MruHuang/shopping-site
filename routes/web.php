<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('test',[
	'as'=>"test",
	'uses'=>'Member_commodityController@test'
]);

Route::get('/', function () {
   return View::make('Login',[
				'message_text'=>null,
				'isRegistered'=>null
		]);
});

Route::group(['prefix'=>'Login'],function(){

	Route::get('ForgetPwd', [ 
		'as'=>'ForgetPwd',
		'uses'=>function () {
   			return view('ForgetPwd',[
				'message_text'=>null
			]);
		}
	]);

	Route::get('Register/{message_text?}',[ 
		'as'=>'Register',
		'uses'=>function ($message_text = null) {
   			return view('Register',[
				'message_text'=>$message_text
				
			]);
		}
	]);

	Route::get('/{isRegistered?}/{message_text?}',[
		'as'=>'Login', 
		'uses'=>function ($isRegistered = null,$message_text=null) {
    	return View::make('Login',[
    			'isRegistered'=>$isRegistered,
				'message_text'=>$message_text
				
		]);
	}]);
			
	
	Route::post('Login',[
		'as'=>'LoginPost',
		'uses'=>'LoginController@LoginCheck'
	]);

	Route::post('ForgetPwd',[
		'as'=>'ForgetPwdPost',
		'uses'=>'ForgetPwdController@ForgetPwdCheck'
	]);

	Route::get('LogOut',[
		'as'=>'LogOut',
		'uses'=>'LoginController@LogOut'
	]);
});
//信用卡
Route::group(['prefix'=>'CreditCard'],function(){
	Route::post('BackData',[
		'as'=>'postCreditCard',
		'uses'=>'CreditCardController@BackData'
	]);
	Route::get('BackData',[
		'as'=>'getCreditCard',
		'uses'=>'CreditCardController@BackData'
	]);
	Route::get('OrderReverse/{TYP}/{ONO}',[
		'as'=>'CreditCardReverse',
		'uses'=>'CreditCardController@Reverse'
	]);
	Route::get('OrderCancel/{ONO}',[
		'as'=>'CreditCardCancel',
		'uses'=>'CreditCardController@CreditCardCancel'
	]);
});

Route::post('Register',[
	'as'=>'RegisterPost',
	'uses'=>'RegisterController@RegisterPost'
]);

Route::get('home',[
	'as'=>'HomeGet',
	'uses'=>'HomeController@Home'
]);

Route::get('Subpage/{area}/{start}/{end}/{type}/{order_type}/{this_page}',[
	'as'=>'Subpage',
	'uses'=>'SubpageController@Subpage'
	]
);

Route::get('Commoditypage/{type}/{ID}',[
	'as'=>'Commoditypage',
	'uses'=>'SingleCommodityController@SingleCommodity'
]);



Route::get('Commoditypage/{ID}/{commodityClass}/{commodityArea}/{amount?}',[
	'as'=>'addShoppingCar',
	'uses'=>'SingleCommodityController@Member_commodityInsertData'

	]);

Route::get('goCheckout/{ID}/{commodityClass}/{commodityArea}/{amount?}',[
	'as'=>'goCheckout',
	'uses'=>'SingleCommodityController@GoCheckout'

	]);

Route::get('goGroupbuyCheckout/{ID}/{commodityClass}/{commodityArea}/{amount?}',[
	'as'=>'goGroupbuyCheckout',
	'uses'=>'SingleCommodityController@GoGroupbuyCheckout'

]);

/*Route::get('SearchResult',[
	'as'=>'SearchResult',
	'uses'=>function () {
		   return View::make('SearchResult');
		}
]);*/

Route::get('CollectionArea',[
	'as'=>'CollectionArea',
	'uses'=>function () {
		   return View::make('CollectionArea');
		}
]);

Route::get('ShoppingCar/{speciestype}',[
	'as'=>'ShoppingCar',
	'uses'=>'Member_commodityController@Member_commodity'
]);

Route::post('Checkout',[
	'as'=>'Checkout',
	'uses'=>'Member_commodityController@Checkout'
]);

Route::post('OrderShoppingCar',[
	'as'=>'OrderShoppingCar',
	'uses'=>'Member_commodityController@OrderShoppingCar'
]);

Route::post('OrderGroupbuyShoppingCar',[
	'as'=>'OrderGroupbuyShoppingCar',
	'uses'=>'Member_commodityController@OrderGroupbuyShoppingCar'
]);

Route::get('GroupbuyShoppingCar',[
	'as'=>'GroupbuyShoppingCar',
	'uses'=>function () {
		   return View::make('GroupbuyShoppingCar');
		}
]);

// Route::get('DMC/{ID}/{speciestype}',[
// 	'as'=>'DelMemberCommodity',
// 	'uses'=>'Member_commodityController@DelMemberCommodity'
// ]);

Route::post('DelMemberCommodity',[
	'as'=>'DelMemberCommodity',
	'uses'=>'Member_commodityController@DelMemberCommodity'
]);

Route::get('TrackOrder',[
	'as'=>'TrackOrder',
	'uses'=>function () {
		   return View::make('TrackOrder');
		}
]);

Route::get('TrackOrder/{state}/{message_text?}',[
	'as'=>'TrackOrder',
	'uses'=>'TrackOrderController@OrderController'
]);

// Route::post('TrackOrderFive/{orderID}/{orderState}',[
// 	'as'=>'TrackOrderFive',
// 	'uses'=>'TrackOrderController@OrderUpdateFiveNumber'
// ]);

Route::post('TrackOrderFive',[
	'as'=>'TrackOrderFive',
	'uses'=>'TrackOrderController@OrderUpdateFiveNumber'
]);

Route::post('TrackOrderCreditCard',[
	'as'=>'TrackOrderCreditCard',
	'uses'=>'TrackOrderController@TrackOrderCreditCard'
]);

Route::get('cancelOrder/{orderID?}',[
	'as'=>'cancelOrder',
	'uses'=>'TrackOrderController@CancelOrder'
]);

Route::get('Search/{StartNumber}/{EndNumber}/{this_page}/{search_text?}/{search_type?}/{groupby_type?}',[
    'as'=>'Search',
    'uses'=>'SearchController@Search'
]);

/*Route::get('MemberCenter',[
	'as'=>'MemberCenter',
	'uses'=>function () {
		   return View::make('MemberCenter',['message_text'=>null]);
		}
]);*/

Route::get('MemberCenter',[
	'as'=>'MemberCenter',
	'uses'=>'MemberDataUpateController@MemberCenter'
]);

Route::post('MDU',[
	'as'=>'MemberDataUpate',//
	'uses'=>'MemberDataUpateController@MemberDataUpate'
]);

Route::get('mail',[
	'as'=>'Mail',
	'uses'=>'MailController@SentMail'
]);


Route::get('getmsg',function(){
	$msg = "This is a simple message.";
	 return response()->json(array(
            'status' => 1,
            'msg' => 'ok'
        ));
	}
);

Route::get('SingleOrder/{orderID}/{orderState}',[
	'as'=>'SingleOrder',
	'uses'=>'TrackOrderController@OrderControllerDetailed'
]);

Route::get('GetCreditCard',[
	'as'=>"GetCreditCard",
	'uses'=>'Member_commodityController@GetCreditCard'
]);