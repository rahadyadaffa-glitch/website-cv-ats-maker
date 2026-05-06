<?php

namespace App\Services;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Collection;

class CvService
{
    /**
     * Ambil semua CV, diurutkan dari yang paling baru diubah.
     */
    public function getAll(): Collection
    {
        return Cv::orderBy('updated_at', 'desc')->get();
    }

    /**
     * Buat CV baru dengan status draft dan content kosong.
     */
    public function createDraft(array $data): Cv
    {
        return Cv::create([
            'nama_file' => $data['nama_file'],
            'bahasa'    => $data['bahasa'],
            'status'    => 'draft',
            'content'   => $this->emptyContent(),
        ]);
    }

    /**
     * Update isi content CV (dari form edit).
     */
    public function updateContent(Cv $cv, array $content): Cv
    {
        $cv->update(['content' => $content]);
        return $cv->fresh();
    }

    /**
     * Tandai CV sebagai completed (setelah download PDF).
     */
    public function markCompleted(Cv $cv): void
    {
        $cv->update(['status' => 'completed']);
    }

    /**
     * Hapus CV.
     */
    public function delete(Cv $cv): void
    {
        $cv->delete();
    }

    /**
     * Template content kosong untuk CV baru.
     */
    private function emptyContent(): array
    {
        return [
            'personal_info' => [
                'full_name' => '',
                'email'     => '',
                'phone'     => '',
                'location'  => '',
                'linkedin'  => '',
                'website'   => '',
            ],
            'summary'        => '',
            'education'      => [],
            'work_experience'=> [],
            'skills'         => [],
            'certifications' => [],
            'languages'      => [],
            'organizations'  => [],
        ];
    }
}
