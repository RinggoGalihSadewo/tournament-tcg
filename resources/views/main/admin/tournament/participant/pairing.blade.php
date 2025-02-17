@extends('layout.main.master')

@section('title', $title . ' | Tournament TCG')

@section('content')

<div class="d-flex justify-content-between">
    <h2 class="mb-2 page-title">{{ $title }}</h2>
    <div>
        <a href="{{ url('/admin/tournament-participants') }}" class="btn mb-2 btn-secondary mr-1">Back</a>
        <button type="button" class="btn mb-2 btn-primary" id="btnPairingSave">Save</button>
    </div>
</div>

<div class="row my-4">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div>
                            <h2 class="mb-2 page-title text-center">Pairing</h2>
                            <div class="d-flex justify-content-center" style="gap: 10px">
                                <button type="button" class="btn mb-2 btn-secondary" id="btnResetPairing">Reset Pairing</button>
                                <button type="button" class="btn mb-2 btn-secondary" id="btnRandomPairing">Random Pairing</button>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group mb-3">
                                    <select class="form-control" id="tournament" value="" name="tournament" placeholder="tournament" >
                                    <option disabled selected value="">--Choose Tournament--</option>
                                    @foreach($tournaments as $key => $tournament)
                                    <option value="{{$tournament->id_tournament}}">{{ $tournament->name_tournament }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                @for($i = 0;$i<4;$i++)
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group mb-3">
                                            <select class="form-control" id="participant-{{ $i }}-a" value="" name="participant-{{ $i }}-a" placeholder="participant-{{ $i }}-a" >
                                            <option disabled selected value="">--Choose Participant--</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <h3 class="text-center">VS</h3>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group mb-3">
                                            <select class="form-control" id="participant-{{ $i }}-b" value="" name="participant-{{ $i }}-b" placeholder="participant-{{ $i }}-b" >
                                            <option disabled selected value="">--Choose Participant--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn mb-2 btn-primary w-100" id="btnFinishPairing">Finish Pairing</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div>
                            <h2 class="mb-2 page-title text-center mt-2">Winner</h2>
                            <div style="height: 58.5px;"></div>
                            <div style="margin-top: 51px">
                                @for($i = 0;$i<4;$i++)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <select class="form-control" id="winner-{{ $i }}" name="winner-{{ $i }}" placeholder="winner-{{ $i }}" >
                                            <option disabled selected value="">--Choose Participant--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-primary w-100" id="btnAddToRank">Add to Ranking</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div>
                            <h2 class="mb-2 page-title text-center mt-2">Standing Ranking</h2>
                            <div style="height: 43px;"></div>
                            <table class="table table-hover datatables w-100">
                                <thead>
                                  <tr>
                                    {{-- <th class="text-dark">#</th> --}}
                                    <th class="text-dark">Name</th>
                                    <th class="text-dark">Poin</th>
                                  </tr>
                                </thead>
                                <tbody>
                          
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript is loaded and document is ready!");

    document.getElementById("btnResetPairing").addEventListener("click", function () {
    let totalPairs = 4; // Sesuaikan dengan jumlah pasangan

    for (let i = 0; i < totalPairs; i++) {
        document.getElementById(`participant-${i}-a`).value = "";
        document.getElementById(`participant-${i}-b`).value = "";
    }

    // Kosongkan dropdown winner
    for (let i = 0; i < totalPairs; i++) {
        document.getElementById(`participant-winner-${i + 1}`).value = "";
    }

    });

    document.getElementById("btnFinishPairing").addEventListener('click', () => {
        Swal.fire({
            title: "Berhasil!",
            text: "Finish Pairing",
            icon: "success",
            showConfirmButton: false,
            timer: 2000,
        });
    })
});
</script>