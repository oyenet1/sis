<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <title>{{ $title ?? 'Reports' }}</title>

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

    .border {
      border: 2px black solid !important;
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

    tr.od:nth-child(even) {
      background: #E4EEFA !important;
    }

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
      color: #003973;
    }

    footer {
      color: white;
      background-color: #003973;
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
      background-color: #003973;
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
      color: #FA7800;
    }

    .text-lg {
      font-size: 20px;
    }

    .text-2xl {
      font-size: 1.5rem;
      line-height: 2rem;
    }

    .text-xl {
      font-size: 20px;
      line-height: 1.75rem;
    }

    .m-0 {
      margin: 0px !important;
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

    .shadow {
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2);
    }

    .justify-center {
      justify-content: center;
    }

    thead {
      background-color: #003973 !important;
      color: white !important;
      font-weight: 500 !important;
    }

    table,
    th,
    tr,
    td {
      border: none !important;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
    }

    .max-w-7xl {
      max-width: 1280px !important;
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
  </style>
</head>

<body class="font-fira">
  <div class="relative mx-auto max-w-7xl">
    <table class="w-full" style="background-color: #E4EEFA">
      <tr class=" w-full py-4 m-0 ">
        <td> <img src="{{ asset('img/logo2.png') }}" alt="{{ env('APP_NAME') }}" class="w-24"></td>
        <td class=" text-right bg-white" style="float: right; text-justify: center">
          <p class="text-lg font-medium uppercase text-primary m-0  text-center">AL-ANSER CENTER FOR <br> COMPREHENSIVE
            EDUCATION</p>
          <p class="italic capitalize text-secondary m-0 text-center">inspiring excellence</p>
        </td>
      </tr>
    </table>
    <table class="w-full">
      <tr class=" w-full py-4 m-0">
        <td class="text-2xl font-medium">Staff Report</td>
        <td class="text-right" style="float: right; text-justify: right">
          <p>Generated on <br>{{ date('d M, Y') }}</p>
        </td>
      </tr>
    </table>
    <table class="w-full"></table>

    {{-- stamped --}}
    {{-- <div
      class="absolute bottom-0 right-0 z-20 flex items-center w-32 h-32 m-4 rounded-full shadow opacity-30 bg-background">
      <img src="{{ asset('img/logo2.png') }}" alt="{{ env('APP_NAME') }}"
        class="block w-24 mx-auto backdrop-blur-0 filter">
    </div> --}}
    <table class="w-full">
      <thead>
        <tr class="w-full">
          <th></th>
          <th>Fee Type</th>
          <th>Session</th>
          <th>Class</th>
          <th>Amount</th>
          <th>Sum</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $staff)
          <tr class="od text-xs border">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $staff['first_name'] . ' ' . $staff['last_name'] }}</td>
            <td style="word-break: keep-all!important" class="keep-all">{{ $staff['school_id'] }}</td>
            <td style="text-transform: uppercase">{{ $staff['roles'][0]['name'] ?? '' }}</td>
            <td>{{ $staff['email'] }}</td>
            <td>{{ $staff['phone'] }}</td>
          </tr>
        @endforeach

      </tbody>
    </table>

    <footer class="p-4 footer text-center justify-center text-sm">
      <p class="flex items-center justify-center text-sm p-0 m-0">
        <img src="{{ asset('icons/location.svg') }}" alt="icons" class="text-white icon">
        {{-- <span class="text-white">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-geo text-white" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
          </svg>
        </span> --}}
        <span>Plot 81, Kafe District, Opposite Majia Plaza, Adjaxent to Saraha Estate, Gwarinpa, Abuja</span>
      </p>
      <div class="flex space-x-2 gap-2 items-center justify-center text-sm m-0 p-0">
        <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
          <img src="{{ asset('icons/email.svg') }}" alt="icons" class="text-white icon">
          <a href="mailto:info@acce-abuja.com" class="px-2" style="color: white">info@acce-abuja.com</a>
        </p>
        <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
          <img src="{{ asset('icons/globe.svg') }}" alt="icons" class="text-white icon">
          <a href="http://acce-abuja.com" class="px-2" style="color: white">www.acce-abuja.com</a>
        </p>
        <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
          <img src="{{ asset('icons/phone.svg') }}" alt="icons" class="text-white icon">
          <a href="tel:+23480234567891" class="px-2" style="color: white">+234 (0)8012345678</a>
        </p>
        <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
          <img src="{{ asset('icons/whatsapp.svg') }}" alt="icons" class="text-white icon">
          <a href="tel:+23480234567891" class="px-2" style="color: white">+234 (0)8012345678</a>
        </p>
      </div>
    </footer>
  </div>
</body>


</html>
