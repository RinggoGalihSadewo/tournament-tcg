// Load Data Tournament
$(document).ready(() => {
    if (window.location.pathname === "/admin/report") {
        loadDataReport();

        $("#tournament").on("change", function () {
            var selectedTournament = $(this).val(); // Ambil nilai yang dipilih

            // Perbarui URL pada tombol Download
            if (selectedTournament) {
                $("#downloadBtn").attr(
                    "href",
                    "/admin/report/download-pdf/" + selectedTournament
                );
            } else {
                // Jika belum ada pilihan, set href ke URL default atau disable tombol
                $("#downloadBtn").attr("href", "#");
            }

            // Kirimkan data ke backend dengan menggunakan AJAX
            $.ajax({
                url: "/admin/report/get-data-report-filter", // URL endpoint backend
                type: "POST",
                processing: true,
                destroy: true,
                searching: true,
                stateSave: true,
                data: {
                    _token: _token, // Pastikan _token ada untuk keamanan
                    id_tournament: selectedTournament, // Kirim id tournament yang dipilih
                },
                success: (res) => {
                    switch (res.status) {
                        case 200:
                            // Hapus data lama dan masukkan data baru ke dalam DataTable
                            var table = $("#dataTable-1").DataTable();
                            table.clear(); // Menghapus data lama
                            table.rows.add(res.data); // Menambahkan data baru
                            table.draw(); // Menarik ulang tabel untuk menampilkan data baru
                            break;
                        case 401:
                            Swal.fire({
                                title: "Gagal!",
                                text: res.message,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            break;
                    }
                },
                error: function (xhr, status, error) {
                    // Tangani jika terjadi error
                    alert("Terjadi kesalahan, coba lagi.");
                },
            });
        });
    }
});

// Tournament
loadDataReport = () => {
    $("#dataTable-1").DataTable({
        processing: true,
        destroy: true,
        searching: true,
        stateSave: true,
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
