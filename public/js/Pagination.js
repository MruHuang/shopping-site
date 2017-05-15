
'use strict';
var pagination_page = 2;
var pagination_MaxPage = 5;

function checkPagination(select_page, last_page){
    if (last_page < 5) {
            SmallPagination(select_page, last_page);
    } else if (last_page > 5) {
            LargePagination(select_page, last_page);
    }
}

function SmallPagination(select_page, last_page) {
    for (var i = 0; i <= last_page; i++) {
        $("ul.pagination li:eq(" + i + ")").attr('class', '');
    }
    $("ul.pagination li:eq(" + select_page + ")").attr('class', 'active');
}

function LargePagination(select_page, last_page) {
    if (select_page > pagination_page && select_page <= (last_page - pagination_page)) {
        for (var i = 1; i <= pagination_MaxPage; i++) {
            $("ul.pagination li:eq(" + i + ") a").attr('data-page', (parseInt(select_page) + i - 3));
            $("ul.pagination li:eq(" + i + ") a").html(parseInt(select_page) + i - 3);
            $("ul.pagination li:eq(" + i + ")").attr('class', '');
            if (parseInt(select_page) + i - 3 == select_page) {
                $("ul.pagination li:eq(" + i + ")").attr('class', 'active');
            }
        }
    } else {
        var page_Min = (select_page - pagination_page) > 0 ? (last_page - pagination_MaxPage + 1) : 　1;
        //var page_Max = (select_page + pagination_page) > last_page ? 　last_page : pagination_MaxPage;
        for (var i = 1; i <= pagination_MaxPage; i++) {
            $("ul.pagination li:eq(" + i + ") a").attr('data-page', page_Min + i - 1);
            $("ul.pagination li:eq(" + i + ") a").html(page_Min + i - 1);
            $("ul.pagination li:eq(" + i + ")").attr('class', '');
            if (page_Min + i - 1 == select_page) {
                $("ul.pagination li:eq(" + i + ")").attr('class', 'active');
            }
        }
    }
}
