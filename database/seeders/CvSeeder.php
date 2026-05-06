<?php

namespace Database\Seeders;

use App\Models\Cv;
use Illuminate\Database\Seeder;

class CvSeeder extends Seeder
{
    public function run(): void
    {
        // CV Bahasa Indonesia
        Cv::create([
            'nama_file' => 'CV-Software-Engineer-2025',
            'bahasa'    => 'id',
            'status'    => 'draft',
            'content'   => [
                'personal_info' => [
                    'full_name' => 'Budi Santoso',
                    'email'     => 'budi@example.com',
                    'phone'     => '081234567890',
                    'location'  => 'Jakarta, Indonesia',
                    'linkedin'  => 'linkedin.com/in/budisantoso',
                    'website'   => '',
                ],
                'summary'        => 'Software engineer dengan 3 tahun pengalaman di bidang pengembangan web backend menggunakan PHP dan Laravel.',
                'education'      => [[
                    'institution' => 'Universitas Indonesia',
                    'degree'      => 'S1',
                    'field'       => 'Teknik Informatika',
                    'start_year'  => '2018',
                    'end_year'    => '2022',
                    'gpa'         => '3.75',
                ]],
                'work_experience' => [[
                    'company'     => 'PT Teknologi Maju',
                    'position'    => 'Junior Backend Developer',
                    'start_date'  => '2022-07',
                    'end_date'    => '',
                    'is_current'  => true,
                    'description' => "- Mengembangkan REST API menggunakan Laravel dan MySQL\n- Menulis unit test dengan PHPUnit\n- Berkolaborasi dengan tim frontend dalam integrasi API",
                ]],
                'skills'         => ['PHP', 'Laravel', 'MySQL', 'Git', 'REST API', 'PHPUnit'],
                'certifications' => [],
                'languages'      => [
                    ['language' => 'Bahasa Indonesia', 'proficiency' => 'Native'],
                    ['language' => 'Inggris', 'proficiency' => 'Intermediate'],
                ],
            ],
        ]);

        // CV Bahasa Inggris
        Cv::create([
            'nama_file' => 'CV-Frontend-Developer',
            'bahasa'    => 'en',
            'status'    => 'completed',
            'content'   => [
                'personal_info' => [
                    'full_name' => 'Sari Dewi',
                    'email'     => 'sari@example.com',
                    'phone'     => '+62 812 9876 5432',
                    'location'  => 'Bandung, Indonesia',
                    'linkedin'  => 'linkedin.com/in/saridewi',
                    'website'   => 'saridewi.dev',
                ],
                'summary'        => 'Frontend developer with 2 years of experience building responsive web applications using Vue.js and modern CSS frameworks.',
                'education'      => [[
                    'institution' => 'Bandung Institute of Technology',
                    'degree'      => 'Bachelor',
                    'field'       => 'Informatics Engineering',
                    'start_year'  => '2019',
                    'end_year'    => '2023',
                    'gpa'         => '3.80',
                ]],
                'work_experience' => [[
                    'company'     => 'Startup XYZ',
                    'position'    => 'Frontend Developer',
                    'start_date'  => '2023-03',
                    'end_date'    => '',
                    'is_current'  => true,
                    'description' => "- Building responsive UI using Vue.js and Tailwind CSS\n- Collaborating with backend team for API integration\n- Improving performance and accessibility scores",
                ]],
                'skills'         => ['Vue.js', 'JavaScript', 'Tailwind CSS', 'HTML', 'CSS', 'Git'],
                'certifications' => [
                    ['name' => 'AWS Cloud Practitioner', 'issuer' => 'Amazon', 'year' => '2023'],
                ],
                'languages'      => [
                    ['language' => 'Indonesian', 'proficiency' => 'Native'],
                    ['language' => 'English', 'proficiency' => 'Professional'],
                ],
            ],
        ]);
    }
}
