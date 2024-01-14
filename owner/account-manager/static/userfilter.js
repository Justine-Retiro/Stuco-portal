function setActiveFilterButton(adminType) {
    var normalizedAdminType = adminType.toLowerCase().trim();

    $('.filter-btn').removeClass('btn-outline-primary').addClass('text-primary-emphasis');

    $('.filter-btn').each(function() {
        var buttonText = $(this).text().toLowerCase().trim();
        if (buttonText.includes(normalizedAdminType)) {
            $(this).removeClass('text-primary-emphasis').addClass('btn-outline-primary');
        }
    });
}
var currentStatus = 'all';
function userfilter(adminType, page = 1) {
    currentStatus = adminType;
    setActiveFilterButton(adminType);
    $.ajax({
        url: '/stuco/owner/account-manager/api/fetchuser.php',
        type: 'GET',
        data: { adminType: adminType, page: page },
        success: function(data) {
            $('#users_table').html(data);
            updatePagination(page); // This will now update the pagination based on the adminType
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
}
function loadPage(page) {
    userfilter(currentStatus, page);
}

function updatePagination(currentPage) {
    $.ajax({
        url: '/stuco/owner/account-manager/api/getpages.php',
        type: 'GET',
        data: { adminType: currentStatus }, // Pass the currentStatus which holds the adminType
        success: function(response) {
            response = JSON.parse(response); // Add this line
            // console.log("Response from getpages.php:", response); // Debugging line
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
    // console.log("Document is ready");
    // loadPage(1);
    userfilter(currentStatus);

    $('#search-input').on('keyup', function() {
        var query = $(this).val();
        search_bar(query);
    });
    function search_bar(query) {
    $.ajax({
        url: '/stuco/owner/account-manager/api/searchuser.php',
        type: 'GET',
        data: { query: query },
        success: function(data) {
            $('#users_table').html(data);
        },
        error: function(xhr, status, error) {
            console.error('An error occurred:', error);
        }
    });
}
});
