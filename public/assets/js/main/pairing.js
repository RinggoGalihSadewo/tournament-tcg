$(document).ready(function () {
    // Event listener untuk tombol Random Pairing
    $("#btnRandomPairing").on("click", function () {
        const id_tournament = $("#tournament").val(); // Ambil ID tournament yang dipilih
        if (!id_tournament) {
            Swal.fire({
                title: "Gagal!",
                text: "Silakan pilih turnamen terlebih dahulu!",
                icon: "error",
                showConfirmButton: false,
                timer: 2000,
            });
            return;
        }

        // Mengambil data peserta melalui AJAX
        $.ajax({
            url: "/admin/tournament-participants/pairing/get-participant-by-tournament",
            type: "POST",
            data: {
                id_tournament,
                _token: $('meta[name="csrf-token"]').attr("content"), // Pastikan token CSRF tersedia
            },
            success: function (res) {
                if (res.status === 200 && res.data.length >= 8) {
                    let participants = res.data.map((p) => p.name); // Ambil nama peserta
                    let totalPairs = 4;
                    let shuffled = participants.sort(() => Math.random() - 0.5); // Acak peserta
                    let usedIndexes = new Set();

                    // Pairing peserta ke dalam select input
                    for (let i = 0; i < totalPairs; i++) {
                        let indexA, indexB;

                        // Pilih index untuk participant A
                        do {
                            indexA = Math.floor(
                                Math.random() * participants.length
                            );
                        } while (usedIndexes.has(indexA));

                        usedIndexes.add(indexA);

                        // Pilih index untuk participant B (tidak boleh sama dengan A)
                        do {
                            indexB = Math.floor(
                                Math.random() * participants.length
                            );
                        } while (indexA === indexB || usedIndexes.has(indexB));

                        usedIndexes.add(indexB);

                        // Set nilai pada select input berdasarkan hasil acakan
                        document.getElementById(`participant-${i}-a`).value =
                            shuffled[indexA];
                        document.getElementById(`participant-${i}-b`).value =
                            shuffled[indexB];
                    }
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Jumlah peserta kurang untuk pairing!",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat mengambil data peserta!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000,
                });
            },
        });
    });
});

$(document.body).on("change", "#tournament", function () {
    const id_tournament = $("#tournament").val();

    $.ajax({
        url: "/admin/tournament-participants/pairing/get-participant-by-tournament",
        type: "POST",
        data: {
            id_tournament,
            _token,
        },
        success: (res) => {
            switch (res.status) {
                case 200:
                    if (res.data && res.data.length > 0) {
                        for (let i = 0; i < 4; i++) {
                            let selectA = $("#participant-" + i + "-a");
                            let selectB = $("#participant-" + i + "-b");
                            let selectWinner = $("#winner-" + i);

                            selectA.empty();
                            selectB.empty();
                            selectWinner.empty();

                            selectA.append(
                                '<option disabled selected value="">--Choose Participant--</option>'
                            );
                            selectB.append(
                                '<option disabled selected value="">--Choose Participant--</option>'
                            );
                            selectWinner.append(
                                '<option disabled selected value="">--Choose Participant--</option>'
                            );

                            res.data.forEach((participant) => {
                                selectA.append(
                                    `<option value="${participant.name}">${participant.name}</option>`
                                );
                                selectB.append(
                                    `<option value="${participant.name}">${participant.name}</option>`
                                );
                                selectWinner.append(
                                    `<option value="${participant.name}">${participant.name}</option>`
                                );
                            });
                        }
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
});

$(document).ready(function () {
    $("#btnAddToRank").on("click", function () {
        let participants = [];
        let totalPairs = 4;
        let points = 10; // Set poin untuk semua peserta

        // Ambil nilai dari setiap select input
        for (let i = 0; i < totalPairs; i++) {
            let winnerName = $("#winner-" + i).val(); // Ambil nama peserta dari select
            if (winnerName) {
                participants.push(winnerName);
            }
        }

        // Pastikan ada peserta yang dipilih
        if (participants.length < totalPairs) {
            Swal.fire({
                title: "Gagal!",
                text: "Pastikan semua peserta terpilih!",
                icon: "error",
                showConfirmButton: false,
                timer: 2000,
            });
            return;
        }

        // Menambahkan atau mengupdate data ke dalam tabel "Standing Ranking"
        let tableBody = $(".datatables tbody");

        // Cek jika jumlah baris dalam tabel sudah mencapai 4
        if (tableBody.find("tr").length >= 4) {
            // Hapus data paling atas jika sudah ada 4 baris
            tableBody.find("tr:first").remove();
        }

        participants.forEach((participant, index) => {
            let rowFound = false;

            // Cek apakah peserta sudah ada di dalam tabel
            tableBody.find("tr").each(function () {
                let existingName = $(this).find("td").eq(0).text(); // Ambil nama peserta dari kolom kedua

                if (existingName === participant) {
                    // Jika peserta sudah ada, update poin
                    $(this).find("td").eq(1).text(points); // Update poin di kolom ketiga
                    rowFound = true;
                    return false; // Stop the loop
                }
            });

            // Jika peserta belum ada, tambahkan ke tabel
            if (!rowFound) {
                let row = `<tr>
                            <td>${participant}</td>
                            <td>${points}</td>
                           </tr>`;
                tableBody.append(row);
            }
        });

        // Setelah data ditambahkan atau diupdate, reset form select
        // for (let i = 0; i < totalPairs; i++) {
        //     $("#winner-" + i).val(""); // Reset select input
        // }

        Swal.fire({
            title: "Berhasil!",
            text: "Data berhasil ditambahkan atau diupdate di ranking!",
            icon: "success",
            showConfirmButton: false,
            timer: 2000,
        });
    });
});

$(document.body).on("click", "#btnPairingSave", function () {
    event.preventDefault();

    let participantsData = [];
    let tableBody = $(".datatables tbody");

    // Ambil data dari setiap row tabel (Nama dan Poin)
    tableBody.find("tr").each(function () {
        let name = $(this).find("td").eq(0).text(); // Ambil nama peserta dari kolom kedua
        let points = $(this).find("td").eq(1).text(); // Ambil poin dari kolom ketiga

        // Simpan data dalam array untuk dikirim ke API
        participantsData.push({ name: name, points: points });
    });

    // Pastikan ada data yang akan disubmit
    if (participantsData.length === 0) {
        Swal.fire({
            title: "Gagal!",
            text: "Tidak ada data peserta yang dapat disimpan!",
            icon: "error",
            showConfirmButton: false,
            timer: 2000,
        });
        return;
    }

    let fd = new FormData();
    fd.append("_token", _token); // Token CSRF
    fd.append("id_tournament", $("#tournament").val());
    fd.append("participants", JSON.stringify(participantsData)); // Data peserta dalam format JSON

    // Kirim request POST ke API
    $.ajax({
        url: "/admin/tournament-participants/pairing/save-pairing", // Ganti dengan URL API yang sesuai
        type: "POST",
        dataType: "JSON",
        contentType: false,
        processData: false,
        data: fd,
        beforeSend: () => {
            // Bersihkan validasi error
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").empty();
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
                        window.location.href = res.redirect;
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
            // Handle error jika API gagal
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
