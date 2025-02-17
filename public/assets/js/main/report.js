// Load Data Tournament
$(document).ready(() => {
    window.location.pathname === "/admin/report" && loadDataReport();
});

// Tournament
loadDataReport = () => {
    $("#dataTable-1").DataTable({
        processing: true,
        serverSide: false,
        destroy: true,
        searching: true,
        ajax: {
            url: "/admin/report/get-data-report",
            type: "POST",
            data: {
                _token: _token,
            },
        },
        columns: [
            {
                render: function (data, type, full, meta) {
                    return meta.row + 1;
                },
            },
            { title: "Name", data: "user.name" },
            { title: "Poin", data: "total_poin" },
            {
                title: "Ranking",
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Menampilkan ranking sesuai urutan data
                },
            },
        ],
    });
};
