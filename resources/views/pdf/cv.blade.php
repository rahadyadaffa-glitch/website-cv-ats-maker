@php
    $cv = $cv ?? null;
    $content = $cv ? ($cv->content ?? []) : [];

    $personalInfo = $content['personal_info'] ?? [];
    $summary      = $content['summary'] ?? '';
    $education    = $content['education'] ?? [];
    $workExp      = $content['work_experience'] ?? [];
    $orgExp       = $content['organizations'] ?? [];
    $skills       = $content['skills'] ?? [];
    $certs        = $content['certifications'] ?? [];
    $languages    = $content['languages'] ?? [];

    $isId = ($cv && $cv->bahasa === 'id');

    $labels = $isId ? [
        'summary'        => 'Ringkasan',
        'education'      => 'Pendidikan',
        'work_exp'       => 'Pengalaman Kerja',
        'org_exp'        => 'Pengalaman Organisasi',
        'skills'         => 'Keahlian',
        'certifications' => 'Sertifikasi',
        'languages'      => 'Bahasa',
        'present'        => 'Sekarang',
    ] : [
        'summary'        => 'Summary',
        'education'      => 'Education',
        'work_exp'       => 'Work Experience',
        'org_exp'        => 'Organization Experience',
        'skills'         => 'Skills',
        'certifications' => 'Certifications',
        'languages'      => 'Languages',
        'present'        => 'Present',
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ $isId ? 'id' : 'en' }}">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #1a1a1a;
            line-height: 1.4;
            padding: 0.5in 0.6in;
        }
        .name {
            font-size: 20pt;
            font-weight: bold;
            color: #000;
            letter-spacing: 0.01em;
        }
        .profession {
            font-size: 11pt;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }
        .contact {
            font-size: 9pt;
            color: #444;
            margin-top: 4px;
        }
        .contact span { margin: 0 8px; }
        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 12px 0 8px 0;
        }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }
        .section { margin-bottom: 16px; }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            font-weight: bold;
        }
        .item-table td:last-child {
            text-align: right;
            font-weight: normal;
            font-size: 9pt;
            color: #555;
        }
        .item-sub {
            font-style: italic;
            color: #444;
            font-size: 9.5pt;
            margin-top: 1px;
        }
        .item-desc {
            margin-top: 4px;
            font-size: 9.5pt;
            white-space: pre-line;
        }
        .skills-list {
            font-size: 9.5pt;
        }
        .entry { margin-bottom: 8px; }
    </style>
</head>
<body>

{{-- Header --}}
<div style="text-align: center;">
    <div class="name">{{ $personalInfo['full_name'] ?? '' }}</div>
    @if(!empty($personalInfo['profession']))
        <div class="profession">{{ $personalInfo['profession'] }}</div>
    @endif
    <div class="contact">
        @if(!empty($personalInfo['email'])) <span>{{ $personalInfo['email'] }}</span> @endif
        @if(!empty($personalInfo['phone'])) <span>&nbsp;·&nbsp; {{ $personalInfo['phone'] }}</span> @endif
        @if(!empty($personalInfo['location'])) <span>&nbsp;·&nbsp; {{ $personalInfo['location'] }}</span> @endif
        @if(!empty($personalInfo['linkedin'])) <span>&nbsp;·&nbsp; {{ $personalInfo['linkedin'] }}</span> @endif
    </div>
</div>

{{-- Summary --}}
@if(!empty($summary))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['summary'] }}</div>
    <div>{{ $summary }}</div>
</div>
@endif

{{-- Education --}}
@if(!empty($education))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['education'] }}</div>
    @foreach($education as $edu)
    <div class="entry">
        <table class="item-table">
            <tr>
                <td>{{ $edu['institution'] ?? '' }}</td>
                <td>{{ $edu['start_year'] ?? '' }}{{ !empty($edu['end_year']) ? ' – ' . $edu['end_year'] : '' }}</td>
            </tr>
        </table>
        <div class="item-sub">
            {{ $edu['degree'] ?? '' }}{{ !empty($edu['field']) ? ', ' . $edu['field'] : '' }}
            @if(!empty($edu['gpa'])) &nbsp;·&nbsp; GPA: {{ $edu['gpa'] }} @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Work Experience --}}
@if(!empty($workExp))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['work_exp'] }}</div>
    @foreach($workExp as $work)
    <div class="entry">
        <table class="item-table">
            <tr>
                <td>{{ $work['company'] ?? '' }}</td>
                <td>
                    {{ $work['start_date'] ?? '' }}
                    @if(!empty($work['is_current'])) – {{ $labels['present'] }}
                    @elseif(!empty($work['end_date'])) – {{ $work['end_date'] }}
                    @endif
                </td>
            </tr>
        </table>
        <div class="item-sub">{{ $work['position'] ?? '' }}</div>
        @if(!empty($work['description']))
        <div class="item-desc">{{ $work['description'] }}</div>
        @endif
    </div>
    @endforeach
</div>
@endif

{{-- Organization Experience --}}
@if(!empty($orgExp))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['org_exp'] }}</div>
    @foreach($orgExp as $org)
    <div class="entry">
        <table class="item-table">
            <tr>
                <td>{{ $org['organization'] ?? '' }}</td>
                <td>
                    {{ $org['start_date'] ?? '' }}
                    @if(!empty($org['is_current'])) – {{ $labels['present'] }}
                    @elseif(!empty($org['end_date'])) – {{ $org['end_date'] }}
                    @endif
                </td>
            </tr>
        </table>
        <div class="item-sub">{{ $org['role'] ?? '' }}</div>
        @if(!empty($org['description']))
        <div class="item-desc">{{ $org['description'] }}</div>
        @endif
    </div>
    @endforeach
</div>
@endif

{{-- Skills --}}
@if(!empty($skills))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['skills'] }}</div>
    <div class="skills-list">{{ implode(' · ', $skills) }}</div>
</div>
@endif

{{-- Certifications --}}
@if(!empty($certs))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['certifications'] }}</div>
    @foreach($certs as $cert)
    <div class="entry">
        <table class="item-table">
            <tr>
                <td>{{ $cert['name'] ?? '' }}</td>
                <td>{{ $cert['year'] ?? '' }}</td>
            </tr>
        </table>
        @if(!empty($cert['issuer']))<div class="item-sub">{{ $cert['issuer'] }}</div>@endif
    </div>
    @endforeach
</div>
@endif

{{-- Languages --}}
@if(!empty($languages))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['languages'] }}</div>
    <div class="skills-list">
        @foreach($languages as $lang)
            {{ $lang['language'] ?? '' }}{{ !empty($lang['proficiency']) ? ' (' . $lang['proficiency'] . ')' : '' }}@if(!$loop->last) &nbsp;·&nbsp; @endif
        @endforeach
    </div>
</div>
@endif

</body>
</html>
