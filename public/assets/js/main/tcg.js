// Load Data TCG
$(document).ready(() => {
    loadDataTCG();
});

// TCG
loadDataTCG = () => {
    $("#dataTable-1").DataTable({
        processing: true,
        serverSide: false,
        destroy: true,
        searching: true,
        ajax: {
            url: "/admin/tcg/get-data-tcg",
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
            { title: "Name", data: "name_tcg" },
            {
                title: "Logo",
                data: "photo_tcg",
                render: function (data, type, row) {
                    var imgUrl = data
                        ? `/assets/img/tcg/${data}` // Hanya gunakan data langsung tanpa menambahkan ".png"
                        : `/assets/img/no-image.jpg`;

                    return `<img src="${imgUrl}" width="100px" height="100px" style="object-fit: cover"/>`;
                },
            },
            {
                title: "Aksi",
                data: null,
                render: function (data, type, row) {
                    var id = data.id_tcg;

                    return `
                    <button class="btn btn-sm btn-primary dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" onclick="modalEditTcg(${id}, true)">Detail</button>
                        <button class="dropdown-item" onclick="modalEditTcg(${id}, false)">Edit</button>
                      <button class="dropdown-item" onclick="hapusTcg(${id})">Hapus</button>
                    </div>
                  `;
                },
            },
        ],
    });
};

// Modal Tambah TCG
$("#btnModalTambahTcg").click(() => {
    $(".modal-title").html("Create TCG");

    $("#result_photos").html(`
        <img src="/assets/img/no-image.jpg" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
    `);

    $(".modal-button").html(`
        <button type="submit" class="btn mb-2 btn-primary" id="btnTambahTcg">Save</button>
    `);

    $("#file").val("");
    $("#file").removeClass("is-invalid");
    $(".file").text("");

    $("#name").val("");
    $("#name").removeClass("is-invalid");
    $(".name").text("");
});

// Modal Edit
modalEditTcg = (id, isDetail) => {
    $.ajax({
        url: `/admin/tcg/${id}/edit`,
        type: "GET",
        dataType: "JSON",
        success: (res) => {
            switch (res.status) {
                case 200:
                    $("#modalTcg").modal("show");

                    let title = isDetail ? "Detail Data TCG" : "Edit Data TCG";
                    $(".modal-title").html(title);

                    $("#result_photos").html(`
                        <img src="/assets/img/tcg/${res.data.photo_tcg}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                    `);

                    $("#file")
                        .prop("disabled", isDetail)
                        .removeClass("is-invalid");
                    $(".file").text("");

                    $("#name")
                        .val(res.data.name_tcg)
                        .prop("disabled", isDetail)
                        .removeClass("is-invalid");
                    $(".name").text("");

                    $("#userId").html(`
                        <input type="hidden" id="id" class="form-control mb-2" name="id" value="${id}">
                    `);

                    // Tombol update hanya muncul saat mode edit
                    if (!isDetail) {
                        $(".modal-button").html(`
                            <button type="submit" class="btn mb-2 btn-primary" id="btnUpdateTcg">Update</button>
                        `);
                    } else {
                        $(".modal-button").html(""); // Kosongkan saat detail
                    }
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

// Add Data TCG
$(document.body).on("click", "#btnTambahTcg", function () {
    event.preventDefault();

    var files = $("#file")[0].files;
    var fd = new FormData();

    fd.append("_token", _token);
    fd.append("file", files[0]);
    fd.append("name", $("#name").val());

    $.ajax({
        url: "/admin/tcg",
        type: "POST",
        dataType: "JSON",
        contentType: false,
        processData: false,
        data: fd,
        beforeSend: () => {
            $("#file").removeClass("is-invalid");
            $(".file").empty();

            $("#name").removeClass("is-invalid");
            $(".name").empty();
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
                    loadDataTCG();
                    $("#modalTcg").modal("hide");
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
                    $("#modalTcg").modal("hide");
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

// Update Data TCG
$(document.body).on("click", "#btnUpdateTcg", function () {
    event.preventDefault();

    var id = $("#id").val();
    var files = $("#file")[0].files;
    var fd = new FormData();

    fd.append("_token", _token);
    fd.append("_method", "PATCH");
    fd.append("id", `${id}`);
    fd.append("file", files[0]);
    fd.append("name", $("#name").val());

    $.ajax({
        url: `/admin/tcg/${id}`,
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        data: fd,
        beforeSend: () => {
            $("#file").removeClass("is-invalid");
            $(".file").empty();

            $("#name").removeClass("is-invalid");
            $(".name").empty();
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
                    loadDataTCG();
                    $("#modalTcg").modal("hide");
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
                    $("#modalUsers").modal("hide");
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

// Hapus TCG
hapusTcg = (id) => {
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
                url: `/admin/tcg/${id}`,
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
                    loadDataTCG();
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
