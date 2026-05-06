<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personal_info'                  => ['nullable', 'array'],
            'personal_info.full_name'        => ['nullable', 'string', 'max:255'],
            'personal_info.profession'       => ['nullable', 'string', 'max:255'],
            'personal_info.email'            => ['nullable', 'email', 'max:255'],
            'personal_info.phone'            => ['nullable', 'string', 'max:50'],
            'personal_info.location'         => ['nullable', 'string', 'max:255'],
            'personal_info.linkedin'         => ['nullable', 'string', 'max:255'],
            'personal_info.website'          => ['nullable', 'string', 'max:255'],

            'summary'                        => ['nullable', 'string'],

            'education'                      => ['nullable', 'array'],
            'education.*.institution'        => ['nullable', 'string', 'max:255'],
            'education.*.degree'             => ['nullable', 'string', 'max:100'],
            'education.*.field'              => ['nullable', 'string', 'max:255'],
            'education.*.start_year'         => ['nullable', 'string', 'max:10'],
            'education.*.end_year'           => ['nullable', 'string', 'max:10'],
            'education.*.gpa'               => ['nullable', 'string', 'max:10'],

            'work_experience'                => ['nullable', 'array'],
            'work_experience.*.company'      => ['nullable', 'string', 'max:255'],
            'work_experience.*.position'     => ['nullable', 'string', 'max:255'],
            'work_experience.*.start_date'   => ['nullable', 'string', 'max:10'],
            'work_experience.*.end_date'     => ['nullable', 'string', 'max:10'],
            'work_experience.*.is_current'   => ['nullable', 'boolean'],
            'work_experience.*.description'  => ['nullable', 'string'],

            'skills'                         => ['nullable', 'array'],
            'skills.*'                       => ['nullable', 'string', 'max:100'],

            'certifications'                 => ['nullable', 'array'],
            'certifications.*.name'          => ['nullable', 'string', 'max:255'],
            'certifications.*.issuer'        => ['nullable', 'string', 'max:255'],
            'certifications.*.year'          => ['nullable', 'string', 'max:10'],

            'languages'                      => ['nullable', 'array'],
            'languages.*.language'           => ['nullable', 'string', 'max:100'],
            'languages.*.proficiency'        => ['nullable', 'string', 'max:100'],

            'organizations'                  => ['nullable', 'array'],
            'organizations.*.organization'   => ['nullable', 'string', 'max:255'],
            'organizations.*.role'           => ['nullable', 'string', 'max:255'],
            'organizations.*.start_date'     => ['nullable', 'string', 'max:10'],
            'organizations.*.end_date'       => ['nullable', 'string', 'max:10'],
            'organizations.*.is_current'     => ['nullable', 'boolean'],
            'organizations.*.description'    => ['nullable', 'string'],
        ];
    }
}
