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
            'personal_info.full_name'        => ['nullable', 'string', 'max:500'],
            'personal_info.profession'       => ['nullable', 'string', 'max:500'],
            'personal_info.email'            => ['nullable', 'email', 'max:500'],
            'personal_info.phone'            => ['nullable', 'string', 'max:100'],
            'personal_info.location'         => ['nullable', 'string', 'max:500'],
            'personal_info.linkedin'         => ['nullable', 'string', 'max:500'],
            'personal_info.github'           => ['nullable', 'string', 'max:500'],
            'personal_info.website'          => ['nullable', 'string', 'max:500'],

            'summary'                        => ['nullable', 'string'],

            'education'                      => ['nullable', 'array'],
            'education.*.institution'        => ['nullable', 'string', 'max:500'],
            'education.*.degree'             => ['nullable', 'string', 'max:500'],
            'education.*.field'              => ['nullable', 'string', 'max:500'],
            'education.*.start_year'         => ['nullable', 'string', 'max:50'],
            'education.*.end_year'           => ['nullable', 'string', 'max:50'],
            'education.*.gpa'                => ['nullable', 'string', 'max:50'],
            'education.*.relevant_courses'  => ['nullable', 'string'],
            'education.*.is_coursework_bulleted' => ['nullable', 'boolean'],

            'work_experience'                => ['nullable', 'array'],
            'work_experience.*.company'      => ['nullable', 'string', 'max:500'],
            'work_experience.*.position'     => ['nullable', 'string', 'max:500'],
            'work_experience.*.start_date'   => ['nullable', 'string', 'max:50'],
            'work_experience.*.end_date'     => ['nullable', 'string', 'max:50'],
            'work_experience.*.is_current'   => ['nullable', 'boolean'],
            'work_experience.*.description'  => ['nullable', 'string'],

            'skills'                         => ['nullable', 'array'],
            'skills.*.name'                  => ['nullable', 'string', 'max:255'],
            'skills.*.description'           => ['nullable', 'string'],

            'certifications'                 => ['nullable', 'array'],
            'certifications.*.name'          => ['nullable', 'string', 'max:500'],
            'certifications.*.issuer'        => ['nullable', 'string', 'max:500'],
            'certifications.*.year'          => ['nullable', 'string', 'max:50'],
            'certifications.*.description'   => ['nullable', 'string'],

            'languages'                      => ['nullable', 'array'],
            'languages.*.language'           => ['nullable', 'string', 'max:200'],
            'languages.*.proficiency'        => ['nullable', 'string', 'max:200'],

            'organizations'                  => ['nullable', 'array'],
            'organizations.*.organization'   => ['nullable', 'string', 'max:500'],
            'organizations.*.role'           => ['nullable', 'string', 'max:500'],
            'organizations.*.start_date'     => ['nullable', 'string', 'max:50'],
            'organizations.*.end_date'       => ['nullable', 'string', 'max:50'],
            'organizations.*.is_current'     => ['nullable', 'boolean'],
            'organizations.*.description'    => ['nullable', 'string'],
            'portfolio'                      => ['nullable', 'array'],
            'portfolio.*.title'              => ['nullable', 'string', 'max:500'],
            'portfolio.*.link'               => ['nullable', 'string', 'max:500'],
            'portfolio.*.description'        => ['nullable', 'string'],
            'portfolio_title'                => ['nullable', 'string', 'max:255'],
            'status'                         => ['nullable', 'string', 'in:draft,completed'],
        ];
    }
}
