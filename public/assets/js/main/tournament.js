// Load Data Tournament
$(document).ready(() => {
    window.location.pathname === "/admin/tournament" && loadDataTournament();
});

// Tournament
loadDataTournament = () => {
    $("#dataTable-1").DataTable({
        processing: true,
        serverSide: false,
        destroy: true,
        searching: true,
        ajax: {
            url: "/admin/tournament/get-data-tournament",
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
            { title: "Name Tournament", data: "name_tournament" },
            {
                title: "Date Tournament",
                data: "date_tournament",
                render: function (data, type, row) {
                    if (!data) return "-"; // Handle jika data kosong
                    let date = new Date(data);
                    let formattedDate = date.toLocaleDateString("id-ID", {
                        day: "2-digit",
                        month: "2-digit",
                        year: "numeric",
                    });
                    return formattedDate; // Format ke "DD/MM/YYYY"
                },
            },
            { title: "Description", data: "description_tournament" },
            {
                title: "Aksi",
                data: null,
                render: function (data, type, row) {
                    var id = data.id_tournament;

                    return `
                    <button class="btn btn-sm btn-primary dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/admin/tournament/${id}">Detail</a>
                        <a class="dropdown-item" href="/admin/tournament/${id}/edit">Edit</a>
                      <button class="dropdown-item" onclick="hapusTournament(${id})">Hapus</button>
                    </div>
                  `;
                },
            },
        ],
    });
};

// Add Data Tournament
$(document.body).on("click", "#btnTambahTournament", function () {
    event.preventDefault();

    var files = $("#file")[0].files;
    var status_tournament = $('input[name="customRadio"]:checked').val();
    var fd = new FormData();

    fd.append("_token", _token);
    fd.append("file", files[0]);
    fd.append("name_tournament", $("#name_tournament").val());
    fd.append("date_tournament", $("#date_tournament").val());
    fd.append("description_tournament", $("#description_tournament").val());
    fd.append("status_tournament", status_tournament);

    $.ajax({
        url: "/admin/tournament",
        type: "POST",
        dataType: "JSON",
        contentType: false,
        processData: false,
        data: fd,
        beforeSend: () => {
            $("#file").removeClass("is-invalid");
            $(".file").empty();

            $("#name_tournament").removeClass("is-invalid");
            $(".name_tournament").empty();

            $("#date_tournament").removeClass("is-invalid");
            $(".date_tournament").empty();

            $("#description_tournament").removeClass("is-invalid");
            $(".description_tournament").empty();

            $("#status_tournament").removeClass("is-invalid");
            $(".status_tournament").empty();
        },
        success: (res) => {
            switch (res.status) {
                case 200:
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    setTimeout(() => {
                        window.location.href = "/admin/tournament";
                    }, 2000);
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
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == 422) {
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    });
});

// Update Data Tournament
$(document.body).on("click", "#btnUpdateTournament", function () {
    event.preventDefault();

    var id = $("#id").val();
    var files = $("#file")[0].files;
    var fd = new FormData();

    fd.append("_token", _token);
    fd.append("_method", "PATCH");
    fd.append("id", `${id}`);
    fd.append("file", files[0]);
    fd.append("name_tournament", $("#name_tournament").val());
    fd.append("date_tournament", $("#date_tournament").val());
    fd.append("description_tournament", $("#description_tournament").val());
    fd.append("status_tournament", $("#status_tournament").val());

    $.ajax({
        url: `/admin/tournament/${id}`,
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        data: fd,
        beforeSend: () => {
            $("#file").removeClass("is-invalid");
            $(".file").empty();

            $("#name_tournament").removeClass("is-invalid");
            $(".name_tournament").empty();

            $("#date_tournament").removeClass("is-invalid");
            $(".date_tournament").empty();

            $("#description_tournament").removeClass("is-invalid");
            $(".description_tournament").empty();

            $("#status_tournament").removeClass("is-invalid");
            $(".status_tournament").empty();
        },
        success: (res) => {
            switch (res.status) {
                case 200:
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    setTimeout(() => {
                        window.location.href = "/admin/tournament";
                    }, 2000);
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
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == 422) {
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    });
});

// Hapus Tournament
hapusTournament = (id) => {
    Swal.fire({
        title: "Apakah anda yakin ingin?",
        text: "Proses ini akan menghapus data secara permanent!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "rgb(0, 59, 95)",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/tournament/${id}`,
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: _token,
                    _method: "DELETE",
                    id: id,
                },
                success: (res) => {
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    loadDataTournament();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: "Maaf data gagal di hapus!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${
                            jqXHR.status + "\n"
                        }</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                },
            });
        }
    });
};
