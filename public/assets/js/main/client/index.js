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
