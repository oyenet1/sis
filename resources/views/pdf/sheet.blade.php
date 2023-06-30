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
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">
        <title>{{ $title ?? 'Reports sheet' }}</title>

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

            .shadow {
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2);
            }

            .justify-center {
                justify-content: center;
            }

            thead {
                background-color: #0C6E45 !important;
                color: white !important;
                font-weight: 500 !important;
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

    <body class="font-fira print:py-0">
        <div class="relative mx-auto max-w-7xl">
            <table class="w-full" style="background-color: #eff6f3">
                <tr class=" w-full py-4 m-0 ">
                    <td> <img src="{{ asset('img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="w-24"></td>
                    <td class=" text-center " style="float: right; text-justify: center">
                        <div class="uppercase">
                            <p class="text-3xl font-medium uppercase text-primary m-0  text-center">
                                {{ config('app.name') }}
                            </p>
                            <span class="italic capitalize text-secondary m-0 text-right">inspiring for
                                excellence</span>
                        </div>
                    </td>
                    <td></td>
                </tr>

            </table>
            <div class="text-center">

                <p class="text-xl uppercase font-semibold py-3">CONTINOUS ACCESSMENT SHEET for {{ currentTerm() }}</p>

            </div>
            <table class="w-full">
                <tr class=" w-full py-4 m-0 ">
                    <td class="text-lg font-medium">Class: <span
                            class="uppercase">{{ $clas->name . $clas->section }}</span>
                    </td>
                    <td class="text-lg font-medium">Subject: <span class="uppercase">{{ $subject->name }}</span></td>
                    <td class="text-right" style="float: right; text-justify: right">
                        {{-- <x-button.print /> --}}
                        <p class="px-4 py-1 flex space-x-2 items-center text-white rounded text-xs bg-red-800 cursor-pointer print:text-white print:bg-white print:hidden"
                            onclick="print()">
                            <span class=""><i class="bi bi-printer text-xl"></i></span>
                            <span>print</span>
                        </p>
                    </td>
                </tr>
            </table>

            <table class="w-full">
                <thead>
                    <tr class="w-full border border-primary">
                        <th class="print:border">S/N</th>
                        <th class="print:border">Admission ID</th>
                        <th class="print:border" class="w-40">Name</th>
                        <th class="print:border" style="text-align: center">CA1</th>
                        <th class="print:border" style="text-align: center">CA2</th>
                        <th class="print:border" style="text-align: center">PM</th>
                        <th class="print:border" style="text-align: center">BM</th>
                        <th class="print:border" style="text-align: center">EM</th>
                    </tr>
                </thead>
                <tbody class="border-black">
                    @foreach ($clas->students as $student)
                    <tr class="od text-xs  {{ $loop->last ? 'border-t' : 'border-b' }}">
                        <td class=" print:border print:border-black">{{ $loop->iteration }}</td>
                        <td class="text-base print:border print:border-black print:text-sm">
                            {{ $student->admission_id ?? $student->student_id }}
                        </td>
                        <td class="text-base print:border print:border-black print:text-sm">
                            {{ $student['first_name'] . ' ' . $student['last_name'] }}
                        </td>
                        <td class=" print:border print:border-black" style=""></td>
                        <td class=" print:border print:border-black"></td>
                        <td class=" print:border print:border-black"></td>
                        <td class="print:border print:border-black"></td>
                        <td class="print:border print:border-black"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <footer class="p-4 footer text-center justify-center text-sm">
                <p class="flex items-center justify-center text-sm p-0 m-0">
                    {{-- <img src="{{ asset('icons/location.svg') }}" alt="icons" class="text-white icon"> --}}
                    <span> &copy {{ date('Y') }}
                        {{ config('app.name') }}</span>
                </p>
                <div class="flex space-x-2 gap-2 items-center justify-center text-sm m-0 p-0">
                    <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
                        <img src="{{ asset('icons/email.svg') }}" alt="icons" class="text-white icon">
                        <a href="mailto:info@acce-kano.ng" class="px-2" style="color: white">info@acce-kano.ng</a>
                    </p>
                    <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
                        <img src="{{ asset('icons/globe.svg') }}" alt="icons" class="text-white icon">
                        <a href="http://acce-kano.ng" class="px-2" style="color: white">www.acce-kano.ng</a>
                    </p>
                    {{-- <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
                    <img src="{{ asset('icons/phone.svg') }}" alt="icons" class="text-white icon">
                    <a href="tel:+23480234567891" class="px-2" style="color: white">+234 (0)8012345678</a>
                    </p>
                    <p class="flex items-center justify-center text-sm p-0 px-2 m-0">
                        <img src="{{ asset('icons/whatsapp.svg') }}" alt="icons" class="text-white icon">
                        <a href="tel:+23480234567891" class="px-2" style="color: white">+234 (0)8012345678</a>
                    </p> --}}
                </div>
            </footer>
        </div>
    </body>


</html>