        
function putCookies() {
    console.log(document.cookie);
    var member_name = document.getElementById('member_name').value;
    var member_account = document.getElementById('member_account').value;
    var member_phone = document.getElementById('member_phone').value;
    // var member_add = document.getElementById('member_add').value;
    var member_Email = document.getElementById('member_Email').value;
    var member_birthday = document.getElementById('member_birthday').value;
    var member_lineid = document.getElementById('member_lineid').value;
    var recommender_name = document.getElementById('recommender_name').value;
    var recommender_phone = document.getElementById('recommender_phone').value;

    document.cookie = "member_name="+member_name;
    document.cookie = "member_account="+member_account;
    document.cookie = "member_phone="+member_phone;
    // document.cookie = "member_add="+member_add;
    document.cookie = "member_Email="+member_Email;
    document.cookie = "member_birthday="+member_birthday;
    document.cookie = "member_lineid="+member_lineid;
    document.cookie = "recommender_name="+recommender_name;
    document.cookie = "recommender_phone="+recommender_phone;
    return true;
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function getHtmlCookies(){
    document.getElementById('member_name').value=getCookie('member_name');
    document.getElementById('member_account').value=getCookie('member_account');
    document.getElementById('member_phone').value=getCookie('member_phone');
    // document.getElementById('member_add').value=getCookie('member_add');
    document.getElementById('member_Email').value=getCookie('member_Email');
    document.getElementById('member_birthday').value=getCookie('member_birthday');
    document.getElementById('member_lineid').value=getCookie('member_lineid');
    document.getElementById('recommender_name').value=getCookie('recommender_name');
    document.getElementById('recommender_phone').value=getCookie('recommender_phone');
}

