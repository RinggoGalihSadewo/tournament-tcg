// Ajax Setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var _token = $('meta[name="csrf-token"]').attr("content");

// Login
$('#btnLogin').click(() => {
    event.preventDefault();

    $.ajax({
        url: '/login',
        type: 'POST',
        dataType: 'JSON',
        data: {
            _token: _token,
            email: $('#email').val(),
            password: $('#password').val(),
        },
        beforeSend: (() => {
            $("#email").removeClass('is-invalid');
            $(".email").empty();

            $("#password").removeClass('is-invalid');
            $(".password").empty();
        }),
        success: ((res) => {
            switch(res.status){
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
                    },2000);
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
        }),
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422){
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    })

});

// Logout
$('#btnLogout').click(() => {
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
                url: '/logout',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: _token
                },
                success: ((res) => {
                    switch(res.status){
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
                            },2000);
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
                }),
                error: function (jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 422){
                        var errors = jqXHR.responseJSON.errors;
        
                        $.each(errors, function (key, val) {
                            $("#" + key).addClass("is-invalid");
                            $("." + key).text(val[0]);
                        });
                    }
                },
            })     
        }
    });

});

// Peserta

// Load Data Peserta and Admin
$(document).ready(() => {
    switch(window.location.pathname){
        case '/data-peserta' :        
            loadDataUsers('/data-peserta/get-data-users');
        break;
        case '/data-admin' :        
            loadDataAdmin('/data-admin/get-data-admin');
        break;
    }
});

loadDataUsers = (url) => {
    $('#dataTable-1').DataTable({
        "language": {
          "zeroRecords": "Tidak ada data"
        },
        processing: true,
        serverSide: false,
        destroy: true,
        searching: true,
        ajax : {
          url: url,
          type: 'POST',
          data: {
            _token: _token
          }
        },
        columns: [
            {   
                render: function ( data, type, full, meta ) {
                    return  meta.row + 1;
                }
            },
            { title:'Nama', data: 'name', name: 'name' },
            { title: 'X', data: 'grade.x', name: 'grade.x' },
            { title: 'Y', data: 'grade.y', name: 'grade.y' },
            { title: 'Z', data: 'grade.z', name: 'grade.z' },
            { title: 'W', data: 'grade.w', name: 'grade.w',},
            {
              title: 'Aksi',
              data: null,
              render: function (data, type, row) {
    
                  var id = data.id;
    
                  return `
                    <button class="btn btn-sm btn-primary dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="/data-peserta/${id}">Detail</a>
                      <button class="dropdown-item" onclick="modalEdit(${id})">Edit</button>
                      <button class="dropdown-item" onclick="hapus(${id})">Hapus</button>
                    </div>
                  `;
              }
            }
          ],
    });
}

// Modal Tambah
$('#btnModalTambah').click(() => {
    $('.modal-title').html('Tambah Data Peserta');

    $('#result_photos').html(`
        <img src="assets/img/avatars/default.png" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
    `);
    
    $('.modal-button').html(`
        <button type="submit" class="btn mb-2 btn-primary" id="btnTambah">Save</button>
    `); 

    $('#file').val('');
    $('#file').removeClass('is-invalid');
    $('.file').text('');

    $('#name').val('');
    $('#name').removeClass('is-invalid');
    $('.name').text('');

    $('#email').val('');
    $('#email').removeClass('is-invalid');
    $('.email').text('');

    $('#x').val('');
    $('#x').removeClass('is-invalid');
    $('.x').text('');

    $('#y').val('');
    $('#y').removeClass('is-invalid');
    $('.y').text('');

    $('#z').val('');
    $('#z').removeClass('is-invalid');
    $('.z').text('');

    $('#w').val('');
    $('#w').removeClass('is-invalid');
    $('.w').text('');
})

// Modal Edit
modalEdit = (id) => {
    $.ajax({
        url: `/data-peserta/${id}/edit`,
        type: 'GET',
        dataType: 'JSON',
        success: ((res) => {
            switch(res.status){
                case 200:
                    $('#modalUsers').modal('show');

                    $('#result_photos').html(`
                        <img src="assets/img/avatars/${res.data.photos}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                    `);

                    $('#file').removeClass('is-invalid');
                    $('.file').text('');

                    $('#name').val(res.data.name);
                    $('#name').removeClass('is-invalid');
                    $('.name').text('');

                    $('#email').val(res.data.email);
                    $('#email').removeClass('is-invalid');
                    $('.email').text('');

                    $('#x').val(res.data.grade.x);
                    $('#x').removeClass('is-invalid');
                    $('.x').text('');

                    $('#y').val(res.data.grade.y);
                    $('#y').removeClass('is-invalid');
                    $('.y').text('');

                    $('#z').val(res.data.grade.z);
                    $('#z').removeClass('is-invalid');
                    $('.z').text('');

                    $('#w').val(res.data.grade.w);
                    $('#w').removeClass('is-invalid');
                    $('.w').text('');

                    $('.modal-title').html('Edit Data Peserta');
                    $('#userId').html(`
                        <input type="hidden" id="id" class="form-control form-control mb-2" name="id" value="${id}" placeholder="Id">
                    `);
                    $('.modal-button').html(`
                        <button type="submit" class="btn mb-2 btn-primary" id="btnUpdate">Update</button>
                    `);
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
        }),
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422){
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    })
}

// Show Photos Change Real Time
$('#file').change((e) => {
    var file = e.target.files[0];
    var reader = new FileReader();
  
    reader.onload = function(e) {
      document.getElementById('show_photos').setAttribute('src', e.target.result);
    }
  
    if (file) {
      reader.readAsDataURL(file);
    }
});

// Add Data Users
$(document.body).on('click', '#btnTambah', function () {
    event.preventDefault();

    var files = $('#file')[0].files;
    var fd = new FormData();

    fd.append('_token', _token);
    fd.append('file', files[0]);
    fd.append('name', $('#name').val());
    fd.append('email', $('#email').val());
    fd.append('x', $('#x').val());
    fd.append('y', $('#y').val());
    fd.append('z', $('#z').val());
    fd.append('w', $('#w').val());

    $.ajax({
        url: '/data-peserta',
        type: 'POST',
        dataType: 'JSON',
        contentType: false,
        processData: false,
        data: fd,
        beforeSend: (() => {
            $("#file").removeClass('is-invalid');
            $(".file").empty();

            $("#name").removeClass('is-invalid');
            $(".name").empty();

            $("#email").removeClass('is-invalid');
            $(".email").empty();

            $("#x").removeClass('is-invalid');
            $(".x").empty();

            $("#y").removeClass('is-invalid');
            $(".y").empty();

            $("#z").removeClass('is-invalid');
            $(".z").empty();

            $("#w").removeClass('is-invalid');
            $(".w").empty();
        }),
        success: ((res) => {
            switch(res.status){
                case 200:
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    loadDataUsers('/data-peserta/get-data-users');
                    $('#modalUsers').modal('hide');
                    $('#form-users')[0].reset();
                break;
                case 401: 
                    Swal.fire({
                        title: "Gagal!",
                        text: res.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    $('#modalUsers').modal('hide');
                break;
            }
        }),
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422){
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    })

});

// Update Data Users
$(document.body).on("click", '#btnUpdate', function() {
    event.preventDefault();

    var id = $('#id').val();
    var files = $('#file')[0].files;
    var fd = new FormData();

    fd.append('_token', _token);
    fd.append('_method', 'PATCH');
    fd.append('id', `${id}`);
    fd.append('file', files[0]);
    fd.append('name', $('#name').val());
    fd.append('email', $('#email').val());
    fd.append('x', $('#x').val());
    fd.append('y', $('#y').val());
    fd.append('z', $('#z').val());
    fd.append('w', $('#w').val());

    $.ajax({
        url: `/data-peserta/${id}`,
        type: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        data: fd,
        beforeSend: (() => {
            $("#file").removeClass('is-invalid');
            $(".file").empty();

            $("#name").removeClass('is-invalid');
            $(".name").empty();

            $("#email").removeClass('is-invalid');
            $(".email").empty();

            $("#x").removeClass('is-invalid');
            $(".x").empty();

            $("#y").removeClass('is-invalid');
            $(".y").empty();

            $("#z").removeClass('is-invalid');
            $(".z").empty();

            $("#w").removeClass('is-invalid');
            $(".w").empty();
        }),
        success: ((res) => {
            switch(res.status){
                case 200:
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    loadDataUsers('/data-peserta/get-data-users');
                    $('#modalUsers').modal('hide');
                    $('#form-users')[0].reset();
                break;
                case 401: 
                    Swal.fire({
                        title: "Gagal!",
                        text: res.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    $('#modalUsers').modal('hide');
                break;
            }
        }),
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422){
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    })

});

// Hapus Users
hapus = (id) => {
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
                url: `/data-peserta/${id}`,
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: _token,
                    _method: 'DELETE',
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
                    loadDataUsers('/data-peserta/get-data-users');
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
}

// Admin

loadDataAdmin = (url) => {
    $('#dataTable-1').DataTable({
        "language": {
          "zeroRecords": "Tidak ada data"
        },
        processing: true,
        serverSide: false,
        destroy: true,
        searching: true,
        ajax : {
          url: url,
          type: 'POST',
          data: {
            _token: _token
          }
        },
        columns: [
            {   
                render: function ( data, type, full, meta ) {
                    return  meta.row + 1;
                }
            },
            { title:'Nama', data: 'name', name: 'name' },
            { title:'Email', data: 'email', name: 'email' },
            {
              title: 'Aksi',
              data: null,
              render: function (data, type, row) {
    
                  var id = data.id;
    
                  return `
                    <button class="btn btn-sm btn-primary dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="/data-admin/detail-data/${id}">Detail</a>
                      <button class="dropdown-item" onclick="modalEditAdmin(${id})">Edit</button>
                      <button class="dropdown-item" onclick="hapusAdmin(${id})">Hapus</button>
                    </div>
                  `;
              }
            }
          ],
    });
}

// Modal Tambah
$('#btnModalTambahAdmin').click(() => {
    $('.modal-title').html('Tambah Data Admin');

    $('#result_photos').html(`
        <img src="assets/img/avatars/default.png" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
    `);
    
    $('.modal-button').html(`
        <button type="submit" class="btn mb-2 btn-primary" id="btnTambahAdmin">Save</button>
    `); 

    $('#file').val('');
    $('#file').removeClass('is-invalid');
    $('.file').text('');

    $('#name').val('');
    $('#name').removeClass('is-invalid');
    $('.name').text('');

    $('#email').val('');
    $('#email').removeClass('is-invalid');
    $('.email').text('');

    $('#password').val('');
    $('#password').removeClass('is-invalid');
    $('.password').text('');

    $('#passwordConfirm').val('');
    $('#passwordConfirm').removeClass('is-invalid');
    $('.passwordConfirm').text('');
});

// Modal Edit
modalEditAdmin = (id) => {
    $.ajax({
        url: `/data-admin/${id}/edit`,
        type: 'GET',
        dataType: 'JSON',
        success: ((res) => {
            switch(res.status){
                case 200:
                    $('#modalAdmin').modal('show');

                    $('#result_photos').html(`
                        <img src="assets/img/avatars/${res.data.photos}" class="avatar-img img-thumbnail img-fluid" alt="" id="show_photos" width="140px" height="140px">
                    `);

                    $('#file').removeClass('is-invalid');
                    $('.file').text('');

                    $('#name').val(res.data.name);
                    $('#name').removeClass('is-invalid');
                    $('.name').text('');

                    $('#email').val(res.data.email);
                    $('#email').removeClass('is-invalid');
                    $('.email').text('');

                    $('#password').removeClass('is-invalid');
                    $('.password').text('');

                    $('#passwordConfirm').removeClass('is-invalid');
                    $('.passwordConfirm').text('');

                    $('.modal-title').html('Edit Data Admin');
                    $('#userId').html(`
                        <input type="hidden" id="id" class="form-control form-control mb-2" name="id" value="${id}" placeholder="Id">
                    `);
                    $('.modal-button').html(`
                        <button type="submit" class="btn mb-2 btn-primary" id="btnUpdateAdmin">Update</button>
                    `);
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
        }),
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422){
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    })
}

// Add Data Admin
$(document.body).on('click', '#btnTambahAdmin', function () {
    event.preventDefault();

    var files = $('#file')[0].files;
    var fd = new FormData();

    fd.append('_token', _token);
    fd.append('file', files[0]);
    fd.append('name', $('#name').val());
    fd.append('email', $('#email').val());
    fd.append('password', $('#password').val());
    fd.append('passwordConfirm', $('#passwordConfirm').val());

    $.ajax({
        url: '/data-admin',
        type: 'POST',
        dataType: 'JSON',
        contentType: false,
        processData: false,
        data: fd,
        beforeSend: (() => {
            $("#file").removeClass('is-invalid');
            $(".file").empty();

            $("#name").removeClass('is-invalid');
            $(".name").empty();

            $("#email").removeClass('is-invalid');
            $(".email").empty();

            $("#password").removeClass('is-invalid');
            $(".password").empty();

            $("#passwordConfirm").removeClass('is-invalid');
            $(".passwordConfirm").empty();
        }),
        success: ((res) => {
            switch(res.status){
                case 200:
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    loadDataAdmin('/data-admin/get-data-admin');
                    $('#modalAdmin').modal('hide');
                    $('#form-admin')[0].reset();
                break;
                case 401: 
                    Swal.fire({
                        title: "Gagal!",
                        text: res.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    $('#modalAdmin').modal('hide');
                break;
            }
        }),
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422){
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    })

});

// Update Data Admin
$(document.body).on("click", '#btnUpdateAdmin', function() {
    event.preventDefault();

    var id = $('#id').val();
    var files = $('#file')[0].files;
    var fd = new FormData();

    fd.append('_token', _token);
    fd.append('_method', 'PATCH');
    fd.append('id', `${id}`);
    fd.append('file', files[0]);
    fd.append('name', $('#name').val());
    fd.append('email', $('#email').val());
    fd.append('password', $('#password').val());
    fd.append('passwordConfirm', $('#passwordConfirm').val());

    $.ajax({
        url: `/data-admin/${id}`,
        type: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        data: fd,
        beforeSend: (() => {
            $("#file").removeClass('is-invalid');
            $(".file").empty();

            $("#name").removeClass('is-invalid');
            $(".name").empty();

            $("#email").removeClass('is-invalid');
            $(".email").empty();

            $("#password").removeClass('is-invalid');
            $(".password").empty();

            $("#passwordConfirm").removeClass('is-invalid');
            $(".passwordConfirm").empty();
        }),
        success: ((res) => {
            switch(res.status){
                case 200:
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    loadDataAdmin('/data-admin/get-data-admin');
                    $('#modalAdmin').modal('hide');
                    $('#form-admin')[0].reset();
                break;
                case 401: 
                    Swal.fire({
                        title: "Gagal!",
                        text: res.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    $('#modalUsers').modal('hide');
                break;
            }
        }),
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422){
                var errors = jqXHR.responseJSON.errors;

                $.each(errors, function (key, val) {
                    $("#" + key).addClass("is-invalid");
                    $("." + key).text(val[0]);
                });
            }
        },
    })

});

// Hapus Admin
hapusAdmin = (id) => {
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
                url: `/data-admin/${id}`,
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: _token,
                    _method: 'DELETE',
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
                    loadDataAdmin('/data-admin/get-data-admin');
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
}