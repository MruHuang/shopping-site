@extends('layouts.Master')

@section('title','Register')

@section('anyone_head')
	@include('partials.head.RegisterHead')
@stop

@section('content')
<div class="panel panel-info register_form_style">
  <div class="panel-heading clearfix">
    <img style="float: left; width: 18%;" src=" {{ asset('img/BlueStarSC.png') }}">
    <a href="{{ route('Login',['isRegistered'=>'true','message_text'=>null]) }}"><h3 class="login_title" style="font-size: 45px;">藍星購物</h3></a>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action=" {{ route('RegisterPost') }}" id="register_form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h3>會員註冊</h3>
            <label>會員姓名</label>
            <input type="text" class="form-control" id ="member_name" name="member_name" placeholder="輸入姓名">
            <label>會員帳號(自設，英文、數字無限制)</label>
            <input type="text" class="form-control" id ="member_account" name="member_account"  placeholder="輸入帳號">
            <label>密碼(自設，英文、數字無限制)</label>
            <input type="password" class="form-control" id ="member_password" name="member_password" placeholder="輸入密碼">
            <label>再次輸入密碼</label>
            <input type="password" class="form-control" id ="member_password_again" name="member_password_again" placeholder="再次輸入密碼">
            <label>手機(Ex:0912345678)</label>
            <input type="text" class="form-control" id ="member_phone" name="member_phone" placeholder="輸入手機" maxlength="10" minlength="10">
            <label>通訊地址</label>
            <!-- <input type="text" class="form-control" name="member_add"> -->
            <br>
            <input id="address" type="text" id ="member_add" value="台北市中山區" class="twaddress form-control" name="member_add" placeholder="輸入通訊地址"/>   
            <br>
            <label>信箱</label>
            <input type="text" class="form-control" id ="member_Email" name="member_Email" placeholder="輸入信箱 Ex：XXXX@XXXX.com">
            <label>生日</label>
            <input type="date" class="form-control" id ="member_birthday" name="member_birthday" placeholder="輸入生日 Ex：1990-01-01" >
            <label>Line-id</label>
            <input type="text" class="form-control" id ="member_lineid" name="member_lineid" placeholder="輸入Line-id">
            <div class="alert alert-success">為保障會員權益，加入會員必需要有現任會員推薦</div>
            <label>推薦人(限會員)</label>
            <input type="text" class="form-control" id ="recommender_name" name="recommender_name" placeholder="輸入推薦人">
            <label>推薦人手機(Ex:0912345678)</label>
            <input type="text" class="form-control" id ="recommender_phone" name="recommender_phone" placeholder="輸入推薦人手機" maxlength="10">
            
            <div class="panel panel-info resgister_panel_sytle">
                <div class="panel-heading">
                    <h3 class="panel-title">同意書</h3>
                </div>
                <div class="panel-body">
                    <h4>藍星會員須知</h4>
                    <p style="overflow:scroll; height: 300px; margin-bottom: 20px;">
                    各位好朋友，近年來食品安全與健康保健已日益受到大家重視，但社會上層出不窮的黑心食品事件卻讓人始終無法安心，可能各位也正為揮之不去的化工添加劑、農藥影響食安及家人健康所困擾。<br/>
                    藍星網購平台，透過好友們彼此推薦組成一個封閉式群體，期藉由數量優勢來與優良產品廠商議價，爭取價格上的折讓，幫大家找到低於市場價格的安心商品，降低食安對我們的困擾；我們不以營利為主要目的，期望營造優質的居家生活，建立藍星會員團購網是優質網站的口碑。<br/>
                    本平台有如下的特色：<br/>
                    1、會員對商品的採購與 否，基於自身的需求具有絕對的自主性，無入會費、無配額、無預付款、無邀約下線的壓力，無庸擔心加入網站給您帶來任何不便。<br/>
                    2、因係利用團購力量爭取優惠價格的日用商品 ( 例如，無不良添加物的純蜂蜜，您在市場上通常是難以判定產品真偽且價格居高不下 ) <br/>，簽約的商品價格低於一般市價，依合約只對網群內之會員販售，因此，這是個封閉性的網站，新入會人員須有舊會員推薦，且經本網站審核確認後始完成註冊，成為正式會員。
                    3、所有推薦商品，一定盡力做到符合環保、安全、健康 ( 無不良添加 ) 等條件。<br/>
                    4、成為正式會員後，於網站內購物即享有紅利回饋金積點(每消費滿100元即回饋1點﹝1元﹞)，紅利點數不得要求折換現金或移轉至他人使用，在完成交易後，如果後續有付款失敗、訂單取消、退貨交易等情況的訂單恕無法符合紅利點數回饋資格。另如群組團購量超過商品簽約數量，廠商如果願意降低成本價所產生之額外利潤，亦將依會員購物金額比例回饋會員。<br/>
                    5、凡會員參加團體預購活動，登記前請務必確定購買需求，為了保障參加登記預購會員的權利，您一旦登記後又取消者，累計三次，本網站即會自動取消您的會員資格。<br/>
                    <br/>
                    熱忱歡迎您因為認同我們的理念而加入會員，讓我們發揮螞蟻雄兵的力量找到安心的優質商品一同維護食品安全並守護家人健康，共享美好生活。</p>
                    
                    <h4>藍星團購網隱私權保護政策聲明</h4>
                    <p style="overflow:scroll; height: 300px;">
                    歡迎您光臨藍星團購網！依個人資料保護法規範，請您提供個人資料前務必閱讀本聲明。<br/>
                    為了讓您能夠更安心的使用本網站所提供的各項服務，並透明化本網站如何蒐集、應用及保護您所提供的個人資料，特此向您說明本網站的隱私權保護政策如下：<br/>
                    <br/>
                    一. 個人資料之蒐集政策<br/> 
                    當您參與網購活動、網路調查、加入會員或其他相關服務時，我們可能會請您提供姓名、住址、電話、e-mail 或其他相關資料。除此之外，我們也會保留您在網站上購物時，伺服器自行產生的相關網購記錄，但是除非您願意告知您的個人資料，否則我們不會，也無法將此項紀錄和您對應。請您注意，與本網站連結的其他網站，也可能蒐集您個人的資料，對於您主動提供其他網站的個人資料，這些連結網站有其各自的隱私權保護政策，本網站隱私權保護政策不適用於其資料處理措施。<br/> 
                    <br/>
                    二. 本網站上述蒐集資料之運用政策<br/>
                    本網站所蒐集的個人資料，將依蒐集之特定目的，做為會員資料建檔管理與服務、相關訊息通知、答覆問題、網購相關作業、行銷業務、商業及市場分析及系統管理等之用，並且在您購物時自動帶出您的個人資料，省卻重複填寫資料的麻煩。為提供會員服務（包括但不限於交易之查詢、退換貨及售後服務等），且為基於服務目的，本網站會委任處理營運相關事務之必要第三人（如：合作廠商、物流廠商）使用您的個人資料；惟當會員要求刪除個人資料時，本公司將先凍結該會員資料與其歷史訂單記錄，並禁止員工對該會員資料進行因行銷目的之蒐集、處理、利用，並於法令規定之保存期間屆滿後進行刪除。<br/>
                    <br/>
                    三. 本網站與第三者共用個人資料之政策<br/>本網站絕對不會任意出售、交換、出租或以其他變相之方式，將您的個人資料揭露與其他團體或個人。惟有下列三種情形，本網站會與第三者共用您的個人資料。
                    1. 經過您的事前同意或授權允許時。<br/>
                    2. 司法單位或其他主管機關經合法正式的程序要求時。<br/>
                    3. 為了提供您其他服務或優惠權益，需要與提供該服務或優惠之第三者共用您的資料時，本網站會在活動時提供充分說明並告知，您可以自由選擇是否接受這項服務或優惠。<br/>
                    <br/>
                    四.您可以向本網站行使以下權利：<br/>
                    (1)查詢或請求閱覽。<br/>
                    (2)請求製給複製本。<br/>
                    (3)請求補充或更正。<br/>
                    (4)請求停止蒐集、處理或利用。<br/>
                    (5)請求刪除。但查詢或請求閱覽個人資料或製給複製本者，本網站得酌收必要成本費用每件NT60元。<br/>
                    <br/>
                    五. 自我保護措施<br/>
                    請妥善保管您的任何個人資料、帳號或密碼，不要將任何個人資料，尤其是密碼提供給任何人或其他機構。在您使用完本網站所提供的各項服務功能後，務必記得登出，若您是與他人共享電腦或使用公共電腦，切記要關閉瀏覽器視窗，以防止他人讀取您的個人資料或信件。<br/>
                    <br/>
                    六. 智慧財產權<br/>
                    非經本網站事先書面同意，會員不得將本網站通路之任何資料進行重複製、移轉、散布、改作、租用或出售等行為。同時會員必須遵守商標法、著作權法、電信法、個人資料保護法及其他相關法令之規定，如有違反，本網站得依法請求賠償。<br/>
                    <br/>
                    七. 隱私權保護政策修訂<br/>
                    我們將因應科技發展趨勢、相關法規之修訂或其他環境變遷等因素而對本網站隱私權保護作適當之修改，並且會在網站上張貼告示，以落實保障使用者隱私權之立意。<br/>
                    <br/>
                    八. 問題和建議<br/>
                    如果您有任何問題或建議，請連絡我們(bssc.tw@gmail.com)</p>
                    <label style="float: right">
                        <input type="checkbox" name="agree" >同意
                    </label>
                </div>
            </div>
            <a class="btn btn-info register_button_style" id="submit_btn" >送出</a>
    </form>
  </div>
</div>

@stop

@if(count($errors->all())||count($message_text))
	@section('message')
		@include('partials.Message')
	@stop
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Cookies.js') }} "></script>
	<script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
    <script type="text/javascript" src=" {{ asset('js/Address.js') }} "></script>
    <script type="text/javascript">
        $(document).ready(function() {
                
            getHtmlCookies(); 

            $(".twaddress").twaddress();
            
            $("#submit_btn").click(function(event) {
                putCookies();
                $('#register_form').submit();
            });

            
        });
        
    </script>

@stop
