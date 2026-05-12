<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Http\Requests\UpdateCvRequest;
use App\Models\Cv;
use App\Services\CvService;
use App\Services\PdfService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CvController extends Controller
{
    public function __construct(
        private readonly CvService  $cvService,
        private readonly PdfService $pdfService,
    ) {}

    /**
     * Landing page.
     */
    public function home(): Response
    {
        $recentDrafts = $this->cvService->getAll()->take(3);
        return Inertia::render('Home', [
            'recentDrafts' => $recentDrafts,
        ]);
    }

    /**
     * Halaman form buat CV baru (input nama file + pilih bahasa).
     */
    public function create(): Response
    {
        return Inertia::render('Cv/Create');
    }

    /**
     * Simpan CV baru ke database, redirect ke halaman edit.
     */
    public function store(StoreCvRequest $request): RedirectResponse
    {
        $cv = $this->cvService->createDraft($request->validated());
        return redirect()->route('cv.edit', $cv)->with('success', 'CV berhasil dibuat!');
    }

    /**
     * Halaman form edit isi CV.
     */
    public function edit(Cv $cv): Response
    {
        return Inertia::render('Cv/Edit', [
            'cv' => $cv,
        ]);
    }

    /**
     * Update isi content CV.
     */
    public function update(UpdateCvRequest $request, Cv $cv): RedirectResponse
    {
        $this->cvService->updateContent($cv, $request->validated());
        return redirect()->route('cv.edit', $cv)->with('success', 'CV berhasil disimpan!');
    }

    /**
     * Hapus CV dari database.
     */
    public function destroy(Cv $cv): RedirectResponse
    {
        $this->cvService->delete($cv);
        return redirect()->route('cv.index')->with('success', 'CV berhasil dihapus.');
    }

    /**
     * Generate dan download PDF.
     */
    public function download(Cv $cv): mixed
    {
        $this->cvService->markCompleted($cv);
        return $this->pdfService->generate($cv);
    }

    /**
     * Preview CV sebelum download.
     */
    public function preview(Cv $cv): Response
    {
        return Inertia::render('Cv/Preview', [
            'cv' => $cv,
        ]);
    }

    /**
     * Daftar semua Draft CV.
     */
    public function index(): Response
    {
        $cvs = $this->cvService->getAll('draft');
        return Inertia::render('Draft/Index', [
            'cvs'   => $cvs,
            'title' => 'Drafts'
        ]);
    }

    /**
     * Daftar semua CV yang sudah Selesai.
     */
    public function completed(): Response
    {
        $cvs = $this->cvService->getAll('completed');
        return Inertia::render('Draft/Index', [
            'cvs'   => $cvs,
            'title' => 'Completed'
        ]);
    }
}
