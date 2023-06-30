<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  {{-- <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"> --}}
  <title>{{ $student->first_name . ' '.  $student->last_name ?? 'Report Card' }}</title>

  <style>
    .flex {
      display: flex;
    }

    .flex-wrap {
      flex-wrap: wrap;
    }

    .keep-all {
      word-wrap: normal;
      word-break: keep-all;
    }

    img.icon,
    .text-white {
      color: white !important;
      /* background-color: white; */
    }

    *,
    ::before,
    ::after {
      box-sizing: border-box;
      /* 1 */
      border-width: 0;
      /* 2 */
      border-style: solid;
      /* 2 */
      border-color: #e5e7eb;
      /* 2 */
    }

    html {
      line-height: 1.5;
      /* 1 */
      -webkit-text-size-adjust: 100%;
      /* 2 */
      -moz-tab-size: 4;
      /* 3 */
      -o-tab-size: 4;
      tab-size: 4;
      /* 3 */
    }

    body {
      font-family: 'Fira Sans', sans-serif;
    }

    header {
      background-color: #E4EEFA;
      display: flex;
      align-items: center;
      justify-content: space-between !important;
    }

    /* tr.od:nth-child(even) {
            background: #E4EEFA !important;
        } */

    p.flex {
      margin-left: 4px;
      margin-right: 4px;
    }

    .justify-between {
      justify-content: space-between !important;
    }

    .items-center {
      align-items: center;
    }

    .text-center {
      text-align: center;
    }

    .max-w-xs {
      max-width: 320px !important;
    }

    .text-primary {
      color: #0C6E45;
    }

    footer {
      color: white;
      background-color: #0C6E45;
    }

    a {
      text-decoration: none;
    }

    .rounded-full {
      border-radius: 50%;
    }

    .p-4 {
      padding: 12px;
    }

    .p-0 {
      padding: 0px !important;
    }

    .px-2 {
      padding: 3px 0px;
    }

    .text-sm {
      font-size: 14px;
    }

    .text-xs {
      font-size: 12px;
    }

    .bg-primary {
      background-color: #0C6E45;
    }

    .relative {
      position: relative;
    }

    .gap-2 {
      gap: 16px
    }

    .absolute {
      position: absolute;
    }

    .font-medium {
      font-weight: 500 !important;
    }

    .capitalize {
      text-transform: capitalize;
    }

    .italic {
      font-style: italic;
    }

    .text-secondary {
      color: #EC3237;
    }

    .text-lg {
      font-size: 20px;
    }

    .text-2xl {
      font-size: 1.5rem;
      line-height: 2rem;
    }

    .text-3xl {
      font-size: 1.5rem;
      line-height: 4rem;
    }

    .text-xl {
      font-size: 20px;
      line-height: 1.75rem;
    }

    .m-0 {
      margin: 0px !important;

    }

    .p-0 {
      padding: 0px !important;

    }

    .z-20 {
      z-index: 20;
    }

    .m-4 {
      margin: 4px;
    }

    .w-full {
      width: 100%;
    }

    .right-0 {
      right: 0;
      bottom: 0;
    }

    .block {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .w-24 {
      width: 6rem;
    }

    .h-32,
    .w-32 {
      height: 8rem;
      width: 8rem;
    }

    .opacity-30 {
      opacity: 30%;
    }

    .justify-center {
      justify-content: center;
    }

    table,
    th,
      {
      border: none !important;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      /* font-size: 10px; */
    }

    .xxs {
      font-size: 10px !important
    }

    .inside {
      border: 1px solid black;
    }

    .max-w-7xl {
      max-width: 1024px !important;
    }

    .mx-auto {
      margin-left: auto;
      margin-right: auto;
    }

    .block {
      display: block;
    }

    .text-right {
      text-justify: right !important;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .w-40 {
      width: 40%;
    }

  </style>
</head>

<body class="font-fira print:py-0 space-y-4">
  <div class="relative mx-auto max-w-5xl bg-white space-y-4">
    <div class="flex w-full justify-between items-center bg-[#eff6f3] p-4 relative">
      <img src="{{ asset('img/alaasu.png') }}" alt="{{ env('APP_NAME') }}" class="inline-block w-20 h-auto object-cover">
      <div class="space-y-2 text-center px-6">
        <p class="text-xl font-semibold uppercase text-primary m-0  text-center">
          {{ env('APP_NAME', 'Al-Ansar Academy Suleja, Niger State Nigeria') }}
        </p>
        <p class="font-medium uppercase text-primary  text-center text-xs">
          MOTTO: <span class="text-secondary pl-1 text-normal">{{ env('MOTTO', 'Inspiring for excellence') }}</span>
        </p>
        <p class=" font-medium uppercase text-grey-500  text-center text-sm">
          <span class="pl-1">{{ env('ADDRESS', 'No 48 Usman Faruq Street, along Suleja/Kaduna Road, Suleja') }}</span>
        </p>
      </div>

      <img src="{{ $student->getFirstMediaUrl('student') }}" alt="{{ $student->first_name . ' '. $student->lasst_name }}" class="inline-block w-24 h-auto p-1 rounded border-2 border-gray-200">
    </div>
    <div class="flex justify-between">
      <div></div>
      <p class="text-xl uppercase font-medium px-4 text-center">REPORT SHEET FOR {{ $term->name . ' term' . ', '.$term->sesion->name }} ACADEMIC SESSION</p>
    <p class="px-4  py-1 max-w-max flex space-x-2 items-center text-white rounded text-xs bg-red-800 cursor-pointer print:text-white print:bg-white print:hidden" onclick="print()">
      <span class=""><i class="bi bi-printer text-xl"></i></span>
      <span>print</span>
    </p>
    </div>
    <div class="py-4 bg-gray-50 w-full space-y-4 px-6 print:p-0 print:bg-white">
      <div class="w-full flex justify-between">
        <h1 class="text-xl font-semibold uppercase text-dark">
          {{ $student->first_name . ' ' . $student->last_name }}</h1>
        <h1 class="font-semibold text-gray-500 uppercase">Final Grade: <span class="text-dark">{{ grd(studentFinalAverage($student->id, $term->id)) }}</span></h1>
      </div>
      <div class="space-y-2 lg:col-span-3">
        <div class="flex w-full justify-between">
          <div class="p-3 w-[32%] border rounded border-dark">
            <table class="w-full">
              <tbody class="w-full">
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">Class:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ $student->clas->name . $student->clas->section }}
                  </td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs" style="word-wrap: normal; word-break: keep-all">Admission No:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ $student->admission_id ?? $student->student_id }}</td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">Session:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ $term->sesion->name }}
                  </td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">Term:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ $term->name }}
                  </td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">No in Class:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ $student->clas->students->count() }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="p-3 w-[32%] border rounded border-dark">
            <table class="w-full">
              <tbody class="w-full">
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs" style="word-wrap: normal; word-break: keep-all">Final Position</td>
                  <td class="py-1 lowercase text-dark">
                    {{ ordinal(positionInClass($student->clas_id, $term->id, $student->id)) }}
                  </td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">Final Average:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ studentFinalAverage($student->id, $term->id) }}
                  </td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">Class Average:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ classFinalAverage($student->clas_id, $term->id) }}
                  </td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">Highest Ave. in Class:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ classHighestAverage($student->clas_id, $term->id) }}
                  </td>
                </tr>
                <tr class="py-1 font-medium print:py-0 text-black text-opacity-50">
                  <td class="py-1 print:text-xxs">Lowest Ave. in Class:</td>
                  <td class="py-1 uppercase text-dark print:text-xxs">
                    {{ classLowestAverage($student->clas_id, $term->id) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="w-[28%] border rounded border-dark p-3">
            <div class="flex justify-between">
              <h1 class="font-semibold uppercase text-dark pl-2">Attendance</h1>
            </div>
            <div class="">
              <table class="w-full ">
                <tbody class="w-full">
                  @php
                  $studentAttendance = $student->studentAttendance($student->id, $term->id);
                  @endphp
                  <tr class="py-2 font-medium text-black text-opacity-50">
                    <td class="py-2 print:text-xxs" style="word-wrap: normal; word-break: keep-all">Days School Opens:</td>
                    <td class="py-2 print:text-xxs text-right uppercase text-dark">
                      {{ $term->dso ?? $term->start->diffInDays($term->end) }}</td>
                  </tr>
                  <tr class="py-2 font-medium text-black text-opacity-50">
                    <td class="py-2 print:py-1 print:text-xxs">Day<span class="">(s)</span> Present:</td>
                    <td class="py-2 print:py-1 print:text-xxs text-right uppercase text-dark">
                      {{ $studentAttendance }}
                    </td>
                  </tr>
                  <tr class="py-2 font-medium text-black text-opacity-50">
                    <td class="py-2 print:py-1 print:text-xxs">Day<span class="">(s)</span> Absent:</td>
                    <td class="py-2 print:py-1 text-right print:text-xxs uppercase text-dark">
                      {{ intval($term->dso ?? $term->start->diffInDays($term->end)) - $studentAttendance}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- subjects scores --}}
    <div class="w-full mx-auto overflow-x-auto">
      @php
      $scores = studentScores($student->id, $term->id);
      @endphp
      <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap border border-dark border-collapse">
        <thead class="w-full pb-4 border-b border-gray-500">
          <tr class="z-10 py-1 text-sm text-center text-gray-500 uppercase border-b border-gray-500">
            <th class="text-left text-xs print:text-xxs pl-2 w-[100px]">Subject</th>
            <th class="print:text-xxs p-0 text-xs text-center">ca1 <br> (10%)</th>
            <th class="print:text-xxs p-0 text-xs text-center">ca2 <br> (10%)</th>
            <th class="print:text-xxs p-0 text-xs text-center">pm <br> (20%)</th>
            <th class="print:text-xxs p-0 text-xs text-center">bm <br> (20%)</th>
            <th class="print:text-xxs p-0 text-xs text-center">em <br> (40%)</th>
            <th class="print:text-xxs p-0 text-xs text-center">total <br> (100%)</th>
            <th class="print:text-xxs p-0 text-xs text-center">grd</th>
            <th class="print:text-xxs p-0 text-xs text-center">pos</th>
            <th class="print:text-xxs p-0 text-xs text-center">out <br> of</th>
            <th class="print:text-xxs p-0 text-xs text-center">low <br> in <br> class</th>
            <th class="print:text-xxs p-0 text-xs text-center">high <br> in <br> class</th>
            <th class="print:text-xxs p-0 text-xs text-center">class <br>avg</th>
            <th class="text-left print:text-xxs p-0 text-xs w-[100px]">comment</th>
          </tr>
        </thead>
        <tbody class="w-full overflow-x-auto break-normal">
          @foreach ($scores as $score)
          <tr class="border-b border-primary">
            {{-- <td class="p-2">
              {{ $loop->iteration }}

            </td> --}}
            <td class="text-xs print:text-xxs border border-dark">
              {{ $score->subject->name }} <br>

            </td>
            <td class="text-xs print:text-xxs border border-dark text-center">

              {{ number_format($score->ca1, 2) }}</span>
            </td>
            <td class="text-xs print:text-xxs border border-dark text-center">

              {{ number_format($score->ca2, 2) }}</span>
            </td>
            <td class="text-xs print:text-xxs border border-dark text-center">

              {{ number_format($score->pm, 2) }}</span>
            </td>
            <td class="text-xs print:text-xxs border border-dark text-center">

              {{ number_format($score->bm, 2) }}</span>
            </td>
            <td class="text-xs print:text-xxs border border-dark text-center">

              {{ number_format($score->em, 2) }}</span>
            </td>
            <td class="text-xs print:text-xxs border border-dark text-center">
              <span class="{{ grdColor(grd($score->total)) }} font-medium p-1">
                {{ number_format($score->total, 2) }}</span>
            </td>
            <td class="text-center text-xs print:text-xxs border border-dark">
              <b class="inline-block p-1 {{ grdColor(grd($score->total)) }}">{{ grd($score->total) }}</b>
            </td>
            <td class="text-center text-xs print:text-xxs"> <span class="py-1  border-black {{ $score->total == highInClass($score->subject_id, $score->term_id, $score->clas_id, $score->total) && $score->total > 0 ? 'text-green-500' : '' }}">{{ positionInSubject($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}
            </td>
            <td class="text-center text-xs print:text-xxs border border-dark"> {{ $score->clas->students->count() }}
            </td>
            <td class="text-center text-xs print:text-xxs border border-dark">
              <b class="p-1">{{ lowInClass($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}</b>
            </td>
            <td class="text-center text-xs print:text-xxs border border-dark">
              <b class="p-1">{{ highInClass($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}</b>
            </td>
            <td class="text-center text-xs print:text-xxs border border-dark">
              <b class="p-1">{{ classAverage($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}</b>
            </td>
            <td class="text-sm uppercase print:text-xxs"> {{ $score->total > 0 ? comment($score->total) : '' }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="pt-4 text-right text-dark font-medium">
        <p>No. of Subject: <span> {{ $scores->count() }}</span></p>
      </div>
    </div>

    {{-- affective trait and psychomotor --}}
    <div class="flex justify-between">
      <div class="w-[30%]  rounded-lg">
        <table class="w-full bg-white border text-sm print:text-xxs border-dark uppercase">
          <tr>
            <th class="text-left py-2 border font-medium print:text-xxs border-dark px-3">affective trait</th>
            <th class="py-2 border font-medium print:text-xxs border-dark px-3 text-center">rating</th>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">punctuality</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->punctuality: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">attendance</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->attendance: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">reliability</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->reliability: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">neatness</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->neatness: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">politeness</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->politeness: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">honesty</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->honesty: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">relationship</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->relationship: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">self control</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->self_control: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">attentiveness</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->attentiveness: '' }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 border text-sm print:text-xxs border-dark">perseverance</td>
            <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ affectiveTrait($student->id, $term->id) ? affectiveTrait($student->id, $term->id)->perseverance: '' }}</td>
          </tr>
        </table>
      </div>
      <div class="w-[30%] flex flex-col gap-8 p-0">
        <div class=" bg-white">
          <table class="w-full bg-white border text-sm print:text-xxs border-dark uppercase">
            <tr>
              <th class="text-left py-2 font-medium border print:text-xxs border-dark px-3">psychomotors</th>
              <th class="py-2 border  print:text-xxs font-medium border-dark px-3 text-center">rating</th>
            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">handwriting</td>
              <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ pyschomotors($student->id, $term->id) ? pyschomotors($student->id, $term->id)->handwriting: '' }}</td>
            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">games</td>
              <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ pyschomotors($student->id, $term->id) ? pyschomotors($student->id, $term->id)->games: '' }}</td>
            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">sports</td>
              <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ pyschomotors($student->id, $term->id) ? pyschomotors($student->id, $term->id)->sports: '' }}</td>
            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">drawing</td>
              <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ pyschomotors($student->id, $term->id) ? pyschomotors($student->id, $term->id)->drawing: '' }}</td>
            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">crafts</td>
              <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ pyschomotors($student->id, $term->id) ? pyschomotors($student->id, $term->id)->crafts: '' }}</td>
            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">music</td>
              <td class="p-2 border text-sm print:text-xxs border-dark text-center">{{ pyschomotors($student->id, $term->id) ? pyschomotors($student->id, $term->id)->music: '' }}</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="w-[35%] flex flex-col gap-8 p-0">
        <div class=" bg-white">
          <table class="w-full bg-white border text-sm print:text-xxs border-dark uppercase">
            <tr>
              <th class="text-left py-2 font-medium border print:text-xxs border-dark px-3">scale</th>
            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">5 - Excellence Degree of Observable Trait</td>

            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">4 - Good Level of Observable Trait</td>

            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">3 - Fair But Acceptable Levelof Observable Trait</td>

            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">2 - Poor Level of Observable</td>

            </tr>
            <tr class="border text-sm print:text-xxs border-dark">
              <td class="p-2 border text-sm print:text-xxs border-dark">1 - No Observable of Observable</td>

            </tr>
          </table>
        </div>
        <div>

        </div>
      </div>
    </div>

    <div class="flex flex-col space-y-4">
      <div class=" bg-white">
        @php
        $teachersComment = resultComment($student->id, 'teacher', $term->id);
        $hosComment = resultComment($student->id, 'hos', $term->id);
        @endphp
        <table class="w-full bg-white border text-sm print:text-xxs border-dark uppercase">
          <tr class="bg-dark text-white">
            <th class="text-left py-2 font-medium border print:text-xxs border-dark px-3" colspan="2">Remarks</th>
          </tr>
          <tr>
            <th class="text-left py-2 font-medium border print:text-xxs border-dark px-3">Class teacher</th>
            <th class="text-left py-2 font-medium border print:text-xxs border-dark px-3">Head of School</th>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 px-3 border text-sm print:text-xxs border-dark">
              {{ $teachersComment ? usersNameById($teachersComment->user_id) : null }}
             
            </td>
            <td class="p-2 px-3 border text-sm print:text-xxs border-dark"> {{ $hosComment ? usersNameById($hosComment->user_id) : null }}</td>
          </tr>
          <tr class="border text-sm print:text-xxs border-dark">
            <td class="p-2 px-3 border text-sm print:text-xxs border-dark capitalize">{{ $teachersComment ? $teachersComment->remarks : null }}</td>
            <td class="p-2 px-3 border text-sm print:text-xxs border-dark capitalize">{{ $hosComment ? $hosComment->remarks : null }}</td>
        </table>
      </div>
    </div>

    <div class="text-dark uppercase font-medium">
      <p>Next term begins: <span class="font-medium"> {{ $term->resumption ? $term->resumption->date->format('d M, Y'): 'date not set' }}</span></p>
    </div>
    <footer class="p-4 footer text-center justify-center text-sm">
      <p class="flex items-center justify-center text-sm p-0 m-0">
        {{-- <img src="{{ asset('icons/location.svg') }}" alt="icons" class="text-white icon"> --}}
        <span> &copy {{ date('Y') }}
          {{ env('APP_NAME', 'Al-Ansar Academy Suleja, Niger State Nigeria') }}</span>
      </p>
      <div class="flex space-x-2 gap-2 items-center justify-center text-sm m-0 p-0">
        <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
          <img src="{{ asset('icons/email.svg') }}" alt="icons" class="text-white icon">
          <a href="mailto:info@alaasu.ng" class="px-2" style="color: white">info@alaasu.ng</a>
        </p>
        <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
          <img src="{{ asset('icons/globe.svg') }}" alt="icons" class="text-white icon">
          <a href="http://alaasu.ng" class="px-2" style="color: white">www.alaasu.ng</a>
        </p>
      </div>
    </footer>
  </div>

  <script>
    setTimeout(() => {
      window.print();
    }, 100000);
  </script>
</body>


</html>
