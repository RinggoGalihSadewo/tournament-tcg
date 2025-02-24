// Ajax Setup
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

var _token = $('meta[name="csrf-token"]').attr("content");

$("#file").change(function (event) {
    let reader = new FileReader();
    reader.onload = function (e) {
        $("#preview").attr("src", e.target.result).removeClass("d-none");
    };
    reader.readAsDataURL(this.files[0]);
});

$(document).ready(function () {
    // Tangani perubahan pada dropdown filter
    $("#tournament").on("change", function () {
        var selectedTournament = $(this).val(); // Ambil ID tournament yang dipilih

        // Jika ada ID tournament yang dipilih
        if (selectedTournament) {
            // Menampilkan hanya tournament yang sesuai dengan id_tournament yang dipilih
            $(".tournament-item").each(function () {
                var tournamentId = $(this).attr("id").split("-")[1]; // Ambil id_tournament dari id element
                if (tournamentId === selectedTournament) {
                    $(this).show(); // Tampilkan tournament yang sesuai
                } else {
                    $(this).hide(); // Sembunyikan tournament yang tidak sesuai
                }
            });
        } else {
            // Jika tidak ada filter yang dipilih, tampilkan semua tournament
            $(".tournament-item").show();
        }
    });

    let debounceTimeout;

    $("#search").on("input", function () {
        var key = $(this).val(); // Ambil nilai input
        console.log(key); // Anda dapat mengganti alert() dengan log untuk debugging

        // Clear timeout sebelumnya jika ada, dan set timeout baru
        clearTimeout(debounceTimeout);

        // Set timeout untuk menunggu pengguna selesai mengetik (500ms)
        debounceTimeout = setTimeout(function () {
            // Panggil fungsi pencarian setelah 500ms
            $.ajax({
                url: "/tournaments/search",
                type: "POST",
                data: {
                    _token,
                    search: key,
                },
                success: (res) => {
                    if (res.status === 200) {
                        // Misalnya, ganti konten div #tournaments-container
                        var tournaments = res.data; // Pastikan server mengirimkan data dalam bentuk ini

                        console.log(tournaments);

                        // Clear kontainer dan tampilkan hasil baru
                        var tournamentsContainer = $("#tournaments-container");
                        tournamentsContainer.empty(); // Kosongkan kontainer sebelumnya

                        // Loop untuk menampilkan hasil pencarian
                        tournaments.forEach(function (tournament) {
                            // Gunakan Blade untuk menangani URL gambar di luar template literal
                            var imageUrl =
                                "/assets/img/tournament//" +
                                tournament.photo_tournament;

                            tournamentsContainer.append(`
                            <div class="col-12 col-md-6 col-lg-4 tournament-item" id="tournament-${tournament.id_tournament}">
                                <div class="single-event-area mb-30">
                                    <div class="event-thumbnail">
                                        <img src="${imageUrl}" alt="" style="height: 400px; width: 100%; object-fit: cover;">
                                    </div>
                                    <div class="event-text">
                                        <h4>${tournament.name_tournament}</h4>
                                        <div class="event-meta-data">
                                            <p>${tournament.date_tournament}</p>
                                        </div>
                                        <p>${tournament.description_tournament}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        });
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
        }, 500); // 500ms bisa diubah sesuai kebutuhan
    });
});

if (window.location.pathname === "/deck-log") {
    $(document).on("change", ".file-input", function (event) {
        let index = $(this).data("index"); // Ambil index dari data-index
        let reader = new FileReader();
        reader.onload = function (e) {
            // Set preview gambar berdasarkan index
            $(".preview[data-index='" + index + "']")
                .attr("src", e.target.result)
                .removeClass("d-none");
        };
        reader.readAsDataURL(this.files[0]);
    });
}

// Registration
$("#btnRegistration").click(() => {
    event.preventDefault();

    const form = $("#form_registration")[0];
    const data = new FormData(form);

    $.ajax({
        url: "/registration",
        type: "POST",
        dataType: "JSON",
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,
        cache: false,
        data,
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
                        location.href = res.redirect;
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

// Login
$("#btnLogin").click(() => {
    event.preventDefault();

    $.ajax({
        url: "/login",
        type: "POST",
        dataType: "JSON",
        data: {
            _token: _token,
            email: $("#email").val(),
            password: $("#password").val(),
        },
        beforeSend: () => {
            $("#email").removeClass("is-invalid");
            $(".email").empty();

            $("#password").removeClass("is-invalid");
            $(".password").empty();
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
                        location.href = res.redirect;
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

// Logout
$("#btnLogout").click(() => {
    event.preventDefault();

    Swal.fire({
        title: "Apakah anda yakin ingin?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#eea303",
        confirmButtonText: "#fffff",
        confirmButtonText: "Logout",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/logout",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: _token,
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
                                location.href = res.redirect;
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
        }
    });
});

// Regis Tournamnet
$("#btnRegisTournament").click(function (event) {
    event.preventDefault();

    var id_user = $(this).data("id-user");
    var username = $(this).data("username");
    var id_tournament = $(this).data("id-tournament");

    console.log(id_user, username, id_tournament);

    $.ajax({
        url: "/tournaments",
        type: "POST",
        dataType: "JSON",
        data: {
            _token: _token,
            id_user,
            username,
            id_tournament,
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
                        location.href = res.redirect;
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

// Update My Profile
$("#btnUpdateProfile").click(() => {
    event.preventDefault();

    const form = $("#form_update_my_profile")[0];
    const data = new FormData(form);

    const id_user = $("#id_user").val();
    data.append("id_user", id_user);

    data.append("_token", _token);
    data.append("_method", "PATCH");

    $.ajax({
        url: "/my-profile",
        type: "post",
        dataType: "JSON",
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,
        cache: false,
        data,
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
                        location.href = res.redirect;
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

// deck log
$(document).on("change", ".file-input", function (event) {
    const index = $(this).data("index");
    const form = $("#form_deck_log_" + index)[0];
    const data = new FormData(form);

    $.ajax({
        url: "/deck-log",
        type: "POST",
        dataType: "JSON",
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,
        cache: false,
        data: data,
        success: (res) => {
            if (res.status === 200) {
                Swal.fire({
                    title: "Berhasil!",
                    text: res.message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000,
                });

                setTimeout(() => {
                    location.href = res.redirect;
                }, 2000);
            } else if (res.status === 401) {
                Swal.fire({
                    title: "Gagal!",
                    text: res.message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000,
                });
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
hapusDeckLog = (id) => {
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
                url: `/deck-log/${id}`,
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
                    setTimeout(() => {
                        location.href = res.redirect;
                    }, 2000);
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
