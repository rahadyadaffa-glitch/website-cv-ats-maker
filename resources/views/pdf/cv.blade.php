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
    $portfolio    = $content['portfolio'] ?? [];
    $portfolioTitle = $content['portfolio_title'] ?? null;

    $isId = ($cv && $cv->bahasa === 'id');

    $labels = $isId ? [
        'summary'        => 'Ringkasan',
        'education'      => 'Pendidikan',
        'work_exp'       => 'Pengalaman Kerja',
        'org_exp'        => 'Pengalaman Organisasi',
        'skills'         => 'Keahlian',
        'certifications' => 'Sertifikasi',
        'languages'      => 'Bahasa',
        'portfolio'      => 'Portofolio',
        'present'        => 'Sekarang',
        'location'       => 'Lokasi: ',
        'phone'          => 'Nomor telepon: ',
        'email'          => 'Email: ',
        'linkedin'       => 'LinkedIn: ',
        'github'         => 'GitHub: ',
        'website'        => 'Website: ',
    ] : [
        'summary'        => 'Summary',
        'education'      => 'Education',
        'work_exp'       => 'Work Experience',
        'org_exp'        => 'Organization Experience',
        'skills'         => 'Skills',
        'certifications' => 'Certifications',
        'languages'      => 'Languages',
        'portfolio'      => 'Portfolio',
        'present'        => 'Present',
        'location'       => 'Location: ',
        'phone'          => 'Phone: ',
        'email'          => 'Email: ',
        'linkedin'       => 'LinkedIn: ',
        'github'         => 'GitHub: ',
        'website'        => 'Website: ',
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
            color: #000;
            line-height: 1.3;
            padding: 0.25in 0.4in;
        }
        .name {
            font-size: 22pt;
            font-weight: bold;
            color: #000;
            letter-spacing: -0.02em;
        }
        .profession {
            font-size: 10.5pt;
            font-weight: bold;
            color: #000;
            letter-spacing: 0.02em;
            margin-top: 2px;
        }
        .contact {
            font-size: 8.5pt;
            color: #000;
            font-weight: bold;
            margin-top: 5px;
        }
        .contact span { margin: 0 6px; }
        hr {
            border: none;
            border-top: 2.5px solid #000;
            margin: 8px 0 5px 0;
        }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 5px;
        }
        .section { margin-bottom: 8px; }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            font-weight: bold;
        }
        .item-table td:last-child {
            text-align: right;
            font-weight: bold;
            font-size: 9pt;
            color: #000;
        }
        .item-sub {
            font-weight: bold;
            color: #000;
            font-size: 9.5pt;
            margin-top: 1px;
        }
        .item-desc, .item-list {
            margin-top: 3px;
            font-size: 9.5pt;
            line-height: 1.35;
        }
        .item-list {
            padding-left: 18px;
            margin-top: 3px;
            margin-bottom: 0;
        }
        .item-list li {
            margin-bottom: 2px;
        }
        .skills-list {
            font-size: 9.5pt;
        }
        .entry { margin-bottom: 6px; }
        .rich-text-content p {
            margin: 0;
            padding: 0;
        }
        .rich-text-content ul {
            list-style-type: disc;
            padding-left: 18px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .rich-text-content ol {
            list-style-type: decimal;
            padding-left: 18px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
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
        @php
            function makeUrl($url) {
                if (empty($url)) return '';
                return preg_match('/^https?:\/\//', $url) ? $url : 'https://' . $url;
            }
            
            $contacts = [];
            if(!empty($personalInfo['location'])) {
                $contacts[] = $labels['location'] . $personalInfo['location'];
            }
            if(!empty($personalInfo['email'])) {
                $contacts[] = $labels['email'] . '<a href="mailto:' . $personalInfo['email'] . '" style="color: #000; text-decoration: none;">' . $personalInfo['email'] . '</a>';
            }
            if(!empty($personalInfo['phone'])) {
                $contacts[] = $labels['phone'] . $personalInfo['phone'];
            }
            if(!empty($personalInfo['linkedin'])) {
                $url = makeUrl($personalInfo['linkedin']);
                $contacts[] = $labels['linkedin'] . '<a href="' . $url . '" style="color: #000; text-decoration: none;">' . $personalInfo['linkedin'] . '</a>';
            }
            if(!empty($personalInfo['github'])) {
                $url = makeUrl($personalInfo['github']);
                $contacts[] = $labels['github'] . '<a href="' . $url . '" style="color: #000; text-decoration: none;">' . $personalInfo['github'] . '</a>';
            }
            if(!empty($personalInfo['website'])) {
                $url = makeUrl($personalInfo['website']);
                $contacts[] = $labels['website'] . '<a href="' . $url . '" style="color: #000; text-decoration: none;">' . $personalInfo['website'] . '</a>';
            }
        @endphp
        {!! implode(' &nbsp;<span style="color: #ccc;">|</span>&nbsp; ', array_map(fn($c) => "<span>$c</span>", $contacts)) !!}
    </div>
</div>

{{-- Summary --}}
@if(!empty($summary))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['summary'] }}</div>
    <div class="rich-text-content" style="text-align: justify; line-height: 1.35;">{!! $summary !!}</div>
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
                <td>{{ $work['position'] ?? '' }}</td>
                <td>
                    {{ $work['start_date'] ?? '' }}
                    @if(!empty($work['is_current'])) – {{ $labels['present'] }}
                    @elseif(!empty($work['end_date'])) – {{ $work['end_date'] }}
                    @endif
                </td>
            </tr>
        </table>
        <div class="item-sub">{{ $work['company'] ?? '' }}</div>
        @if(!empty($work['description']))
        <div class="rich-text-content" style="line-height: 1.35;">
            {!! $work['description'] !!}
        </div>
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
        <div class="rich-text-content" style="line-height: 1.35;">
            {!! $org['description'] !!}
        </div>
        @endif
    </div>
    @endforeach
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
                <td>{{ $edu['degree'] ?? '' }}{{ !empty($edu['field']) ? ', ' . $edu['field'] : '' }}</td>
                <td>{{ $edu['start_year'] ?? '' }}{{ !empty($edu['end_year']) ? ' – ' . $edu['end_year'] : '' }}</td>
            </tr>
        </table>
        <div class="item-sub">
            {{ $edu['institution'] ?? '' }}
            @if(!empty($edu['gpa'])) &nbsp;·&nbsp; IPK: {{ $edu['gpa'] }} @endif
        </div>
        @if(!empty($edu['relevant_courses']))
            <div style="margin-top: 4px;">
                <div style="font-weight: bold; font-style: normal; font-size: 8pt; text-transform: uppercase; color: #000; margin-bottom: 2px;">
                    {{ $isId ? 'Mata Kuliah Relevan:' : 'Relevant Coursework:' }}
                </div>
                <div class="rich-text-content" style="font-size: 9pt; color: #000; line-height: 1.35;">
                    {!! $edu['relevant_courses'] !!}
                </div>
            </div>
        @endif
    </div>
    @endforeach
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
        @if(!empty($cert['description']))
        <div class="rich-text-content" style="line-height: 1.35;">
            {!! $cert['description'] !!}
        </div>
        @endif
    </div>
    @endforeach
</div>
@endif

{{-- Portfolio --}}
@if(!empty($portfolio))
<hr>
<div class="section">
    <div class="section-title">{{ $portfolioTitle ?: $labels['portfolio'] }}</div>
    @foreach($portfolio as $item)
    <div class="entry">
        <table class="item-table">
            <tr>
                <td>{{ $item['title'] ?? '' }}</td>
                <td>@if(!empty($item['link']))<span style="font-size: 8.5pt; font-style: italic;"><a href="{{ preg_match('/^https?:\/\//', $item['link']) ? $item['link'] : 'https://' . $item['link'] }}" style="color: #000; text-decoration: none;">{{ $item['link'] }}</a></span>@endif</td>
            </tr>
        </table>
        @if(!empty($item['description']))
        <div class="rich-text-content" style="line-height: 1.35;">
            {!! $item['description'] !!}
        </div>
        @endif
    </div>
    @endforeach
</div>
@endif

{{-- Skills --}}
@if(!empty($skills) && is_array($skills))
<hr>
<div class="section">
    <div class="section-title">{{ $labels['skills'] }}</div>
    @foreach($skills as $group)
        @if(!empty($group['name']))
            <div style="font-weight: bold; font-size: 9.5pt; margin-top: 5px; margin-bottom: 2px;">{{ strtoupper($group['name']) }}</div>
        @endif
        @if(!empty($group['description']))
            <div class="rich-text-content" style="line-height: 1.35; margin-top: 2px;">
                {!! $group['description'] !!}
            </div>
        @endif
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
