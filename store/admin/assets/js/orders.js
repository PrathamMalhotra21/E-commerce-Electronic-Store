$(document).ready(function() {
    let limit = 10;
    let currentPage = 1;

    function getPagination(page, totalItems, limit) {
        console.log(page, totalItems);
        const total = Math.ceil(totalItems / limit);
        let pagination = '';

        pagination += `<li class="page-item ${page <= 1 ? 'disabled' : ''}"><span class="page-link text-dark px-3 py-2" data-page="${page - 1}">Prev</span></li>`;
        for (let i = 1; i <= total; i++) {
            if (i >= page - 2 && i <= page + 2) {
                pagination += `<li class="page-item ${page === i ? 'active' : ''}"><span class="page-link text-dark px-3 py-2" data-page="${i}">${i}</span></li>`;
            }
        }
        pagination += `<li class="page-item ${page >= total ? 'disabled' : ''}"><span class="page-link text-dark px-3 py-2" data-page="${page + 1}">Next</span></li>`;
        $(".pagination").html(pagination);
    }

    $(document).on("click", ".pagination span", function (e) {
        e.preventDefault();
        const page = $(this).data("page");
        if (page) {
            currentPage = page;
            loadOrders(page);
        }
    });

    function loadOrders(page = 1) {
        $.ajax({
            url: "../process/manage_orders.php",
            data: {
                loadOrder: true,
                page: page,
                limit: limit
            },
            method: "POST",
            success: function(response) {
                const data = JSON.parse(response);
                $("#orderTable").html(data.text);
                getPagination(Number(data.page), Number(data.total), limit);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
    loadOrders(currentPage);

    $(document).on("click", "#viewOrder", function() {});
    
});