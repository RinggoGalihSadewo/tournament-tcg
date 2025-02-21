<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Ranking;
use App\Models\Tournament;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournaments = Tournament::all();

        return view('main.admin.report.index', compact('tournaments'));
    }

    public function get_data_report()
    {
        $data = Ranking::selectRaw('id_user, SUM(poin) as total_poin')
        ->groupBy('id_user')
        ->orderByDesc('total_poin') // Mengurutkan berdasarkan total poin terbesar ke terkecil
        ->with(['user']) // Menambahkan relasi user untuk mengambil data user terkait
        ->get();

        return response()->json([
            'data'      => $data,
            'status'    => 200
        ]);
    }

    public function get_data_report_filter(Request $request)
    {

        $data = Ranking::selectRaw('id_user, SUM(poin) as total_poin')
        ->where('id_tournament', $request->id_tournament)
        ->groupBy('id_user')
        ->orderByDesc('total_poin') // Mengurutkan berdasarkan total poin terbesar ke terkecil
        ->with(['user']) // Menambahkan relasi user untuk mengambil data user terkait
        ->get();

        return response()->json([
            'data'      => $data,
            'status'    => 200
        ]);
    }

    public function download_pdf($id_tournament)
    {
        // Ambil data ranking dari database, sudah diurutkan dan dihitung total poin
        $data = Ranking::with('user')
            ->where('id_tournament', $id_tournament)
            ->selectRaw('id_user, SUM(poin) as total_poin')
            ->groupBy('id_user')
            ->orderByDesc('total_poin')
            ->get();

        // Generate PDF
        $pdf = $this->generatePdf($data);

        // Download PDF
        return response()->stream(
            function() use ($pdf) {
                echo $pdf->output();
            },
            200,
            [
                "Content-Type" => "application/pdf",
                "Content-Disposition" => "attachment; filename=\"Report-Tournament.pdf\"",
            ]
        );
    }

    private function generatePdf($data)
    {
        // Inisialisasi DOMPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Buat HTML dari data
        $html = view('main.admin.report.pdf', compact('data'))->render();

        // Load HTML ke DOMPDF
        $dompdf->loadHtml($html);

        // Set ukuran halaman (A4) dan orientasi (Portrait)
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        return $dompdf;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
