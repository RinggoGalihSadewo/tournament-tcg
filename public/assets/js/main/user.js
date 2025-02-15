// Load Data Tournament Participant
$(document).ready(() => {
    window.location.pathname === "/admin/tournament-participants" &&
        loadDataTournamentParticipant();
});

// Tournament Participant
loadDataTournamentParticipant = () => {
    $("#dataTable-1").DataTable({
        processing: true,
        serverSide: false,
        destroy: true,
        searching: true,
        ajax: {
            url: "/admin/tournament-participants/get-data-tournament-participant",
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
            { title: "Username", data: "registration.username" },
            {
                title: "Date Tournament",
                data: "registration.date_registration",
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
            {
                title: "Tournament",
                data: "registration.tournament.name_tournament",
            },
            {
                title: "Aksi",
                data: null,
                render: function (data, type, row) {
                    var id = data.id_user;

                    return `
                    <button class="btn btn-sm btn-primary dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" onclick="modalEditTournamentParticipant(${id}, true)">Detail</button>
                        <button class="dropdown-item" onclick="modalEditTournamentParticipant(${id}, false)">Edit</button>
                      <button class="dropdown-item" onclick="hapusTournamentParticipant(${id})">Hapus</button>
                    </div>
                  `;
                },
            },
        ],
    });
};

// Modal Tambah TournamentParticipant
$("#btnModalTambahTournamentParticipant").click(() => {
    $(".modal-title").html("Create Participant");

    $("#result_photos").html(`
        <img src="/assets/img/profile/default.png" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
    `);

    $(".modal-button").html(`
        <button type="submit" class="btn mb-2 btn-primary" id="btnTambahTournamentParticipant">Save</button>
    `);

    $("#file").val("").prop("disabled", false);
    $("#file").removeClass("is-invalid");
    $(".file").text("");

    $("#name").val("").prop("disabled", false);
    $("#name").removeClass("is-invalid");
    $(".name").text("");

    $("#username").val("").prop("disabled", false);
    $("#username").removeClass("is-invalid");
    $(".username").text("");

    $("#email").val("").prop("disabled", false);
    $("#email").removeClass("is-invalid");
    $(".email").text("");

    $("#password").val("").prop("disabled", false);
    $("#password").removeClass("is-invalid");
    $(".password").text("");

    $("#tournament").val("").prop("disabled", false);
    $("#tournament").removeClass("is-invalid");
    $(".tournament").text("");

    $("#phone_number").val("").prop("disabled", false);
    $("#phone_number").removeClass("is-invalid");
    $(".phone_number").text("");

    $("#address").val("").prop("disabled", false);
    $("#address").removeClass("is-invalid");
    $(".address").text("");
});

// Modal Edit
modalEditTournamentParticipant = (id, isDetail) => {
    $.ajax({
        url: `/admin/tournament-participants/${id}/edit`,
        type: "GET",
        dataType: "JSON",
        success: (res) => {
            switch (res.status) {
                case 200:
                    $("#modalTournamentParticipant").modal("show");

                    let title = isDetail
                        ? "Detail Data Tournament Participant"
                        : "Edit Data Tournament Participant";
                    $(".modal-title").html(title);

                    if (!isDetail) {
                        $(".modal-button").html(`
                            <button type="submit" class="btn mb-2 btn-primary" id="btnUpdateTournamentParticipants">Update</button>
                        `);
                    } else {
                        $(".modal-button").html("");
                    }

                    $("#userId").html(`
                        <input type="hidden" id="id" class="form-control mb-2" name="id" value="${id}">
                    `);

                    $("#result_photos").html(`
                        <img src="/assets/img/profile/${res.data.photo}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                    `);

                    $("#file")
                        .prop("disabled", isDetail)
                        .removeClass("is-invalid");
                    $(".file").text("");

                    $("#username")
                        .val(res.data.username)
                        .prop("disabled", isDetail)
                        .removeClass("is-invalid");
                    $(".username").text("");

                    $("#name")
                        .val(res.data.name)
                        .prop("disabled", isDetail)
                        .removeClass("is-invalid");
                    $(".name").text("");

                    $("#email")
                        .val(res.data.email)
                        .prop("disabled", true)
                        .removeClass("is-invalid");
                    $(".email").text("");

                    $("#password")
                        .val(res.data.password)
                        .prop("disabled", true)
                        .removeClass("is-invalid");
                    $(".password").text("");

                    $("#phone_number")
                        .val(res.data.phone_number)
                        .prop("disabled", isDetail)
                        .removeClass("is-invalid");
                    $(".phone_number").text("");

                    $("#address")
                        .val(res.data.address)
                        .prop("disabled", isDetail)
                        .removeClass("is-invalid");
                    $(".address").text("");

                    $("#tournament")
                        .prop("disabled", isDetail)
                        .val(res.data.registration.tournament.id_tournament)
                        .removeClass("is-invalid");
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
};

// Add Data Tournament Participant
$(document.body).on("click", "#btnTambahTournamentParticipant", function () {
    event.preventDefault();

    var files = $("#file")[0].files;
    var fd = new FormData();

    fd.append("_token", _token);
    fd.append("file", files[0]);
    fd.append("name", $("#name").val());
    fd.append("username", $("#username").val());
    fd.append("email", $("#email").val());
    fd.append("password", $("#password").val());
    fd.append("phone_number", $("#phone_number").val());
    fd.append("tournament", $("#tournament").val());

    $.ajax({
        url: "/admin/tournament-participants",
        type: "POST",
        dataType: "JSON",
        contentType: false,
        processData: false,
        data: fd,
        beforeSend: () => {
            $("#username").removeClass("is-invalid");
            $(".username").empty();

            $("#name").removeClass("is-invalid");
            $(".name").empty();

            $("#email").removeClass("is-invalid");
            $(".email").empty();

            $("#password").removeClass("is-invalid");
            $(".password").empty();

            $("#phone_number").removeClass("is-invalid");
            $(".phone_number").empty();

            $("#tournament").removeClass("is-invalid");
            $(".tournament").empty();
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
                    loadDataTournamentParticipant();
                    $("#modalTournamentParticipant").modal("hide");
                    $("#form-admin")[0].reset();
                    break;
                case 401:
                    Swal.fire({
                        title: "Gagal!",
                        text: res.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    $("#modalTournamentParticipant").modal("hide");
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

// Update Data Tournament Participant
$(document.body).on("click", "#btnUpdateTournamentParticipants", function () {
    event.preventDefault();

    var id = $("#id").val();
    var files = $("#file")[0].files;
    var fd = new FormData();

    fd.append("_token", _token);
    fd.append("_method", "PATCH");
    fd.append("id", `${id}`);
    fd.append("file", files[0]);
    fd.append("name", $("#name").val());
    fd.append("username", $("#username").val());
    fd.append("email", $("#email").val());
    fd.append("password", $("#password").val());
    fd.append("phone_number", $("#phone_number").val());
    fd.append("address", $("#address").val());
    fd.append("tournament", $("#tournament").val());

    $.ajax({
        url: `/admin/tournament-participants/${id}`,
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        data: fd,
        beforeSend: () => {
            $("#username").removeClass("is-invalid");
            $(".username").empty();

            $("#name").removeClass("is-invalid");
            $(".name").empty();

            $("#email").removeClass("is-invalid");
            $(".email").empty();

            $("#password").removeClass("is-invalid");
            $(".password").empty();

            $("#phone_number").removeClass("is-invalid");
            $(".phone_number").empty();

            $("#tournament").removeClass("is-invalid");
            $(".tournament").empty();
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
                    loadDataTournamentParticipant();
                    $("#modalTournamentParticipant").modal("hide");
                    $("#form-admin")[0].reset();
                    break;
                case 401:
                    Swal.fire({
                        title: "Gagal!",
                        text: res.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    $("#modalTournamentParticipant").modal("hide");
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

// Hapus Tournament Participant
hapusTournamentParticipant = (id) => {
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
                url: `/admin/tournament-participants/${id}`,
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
                    loadDataTournamentParticipant();
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
