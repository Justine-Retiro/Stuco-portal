function getpage(page = 1) {
    $.ajax({
        url: '/Stuco/owner/archive/api/fetchdocument.php',
        type: 'GET',
        data: { page: page },
        success: function(data) {
            $('#archive_table').html(data);
            updatePagination(page);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
}
function loadPage(page) {
    getpage(page);
}

function updatePagination(currentPage) {
    $.ajax({
        url: '/Stuco/owner/archive/api/getpages.php',
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            var total = Number(response.total_pages);
            var pagination = '';
            for (var i = 1; i <= total; i++) {
                if (i == currentPage) {
                    pagination += '<li class="page-item active"><button class="page-link" onclick="loadPage(' + i + ')">' + i + '</button></li>';
                } else {
                    pagination += '<li class="page-item"><button class="page-link" onclick="loadPage(' + i + ')">' + i + '</button></li>';
                }
            }
            $('#pagination').html(pagination);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
}

$(document).ready(function() {
    getpage();

});
