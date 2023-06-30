<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Acce-kano')</title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <style>
            [x-cloak] {
                display: none !important;
            }

            .half-screen {
                width: calc(100% - 74px) !important;
            }

            .full-screen {
                width: calc(100% - 275px) !important;
            }

            .confirm,
            .deny {
                padding: 8px 15px !important;
                border-radius: 10px;
                color: white;
                outline: none !important;
                border: none !important;
            }

            .deny {
                background-color: rgb(255, 20, 50) !important;
            }

            .confirm {
                background-color: #003973 !important;
            }

            .modal {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                right: 0 !important;
                left: 0 !important;
            }

            span.text-red-600::first-letter {
                text-transform: capitalize !important;
            }
        </style>
        @livewireStyles
    </head>

    <body class="relative flex w-screen h-screen bg-background font-fira selection:bg-secondary selection:text-white"
        x-data="{ sidebar: true }" x-cloak>

        <aside
            class="fixed top-0 bottom-0 left-0 z-30 flex flex-col h-screen p-0 m-0 bg-white border-gray-100 aside print:hidden"
            :class="sidebar ? 'w-[275px]' : 'w-[70px]'" x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            {{-- school icons/logo --}}
            <div class="w-full text-center shadow-sm">
                <img src="/img/accekano.png" alt="" class="block object-cover w-12 mx-auto"
                    :class="sidebar ? 'w-18 2xl:my-14 my-12' : 'w-12 my-4'">

            </div>

            {{-- navigation bar --}}
            <ul
                class="p-0 py-4 m-0 space-y-1 overflow-y-auto capitalize list-none mb-7 font-fira drop-shadow-sm lg:py-8 2xl:pb-20">
                {{-- getting the roles --}}

                @include('navigations.side-nav')
            </ul>
            <div class="absolute bottom-0 left-0 z-50 w-full bg-white shadow-sm font-fira">
                <hr class="w-full shadow-sm">
                <a href="route('logout')"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="-shadow-lg {{ request()->is('/settings') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-4 hover:bg-red-50 hover:text-red-500 2xl:space-x-4"
                    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
                    <span class="">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </span>
                    <span class="text" :class="sidebar ? '' : 'hidden'">Logout</span>
                </a>
                <form class="hidden logout-form" id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </aside>
        <main x-data="{ header: false }" class="fixed top-0 right-0 flex-1 h-screen p-0 overflow-auto main"
            :class="sidebar ? 'full-screen' : 'half-screen'">
            <header @scroll.window="header = (window.pageYOffset > 40) ? true : false"
                class="sticky top-0 right-0 z-50 w-full px-4 py-2 bg-opacity-75 shadow-sm bg-background backdrop-blur-sm print:hidden">
                <div class="z-30 flex items-center justify-between">
                    {{-- navigation bar --}}
                    <span class="font-medium cursor-pointer tt text-primary hover:text-secondary"
                        @click="sidebar = !sidebar">
                        <i class="text-4xl bi bi-list"></i>
                    </span>

                    <div>
                        <p
                            class="hidden px-6 py-1 text-sm font-medium uppercase bg-white rounded-lg shadow-sm text-primary md:block">
                            {{ config('app.name') }} <span class="px-2 py-1">{{ currentTerm() ?? 'ok' }}</span>
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        {{-- notification from livewire --}}
                        @livewire('notification')
                        <div class="relative flex items-center space-x-2 cursor-pointer" x-data="{ profile: false }"
                            @click="profile = !profile">
                            @if (currentUser()->image)
                            <img src="{{ asset('/storage/' . auth()->user()->image) }}"
                                alt="{{ currentUser()->first_name }}" class="object-cover rounded-full h-14 w-14">
                            @else
                            <img src="/img/avatar.png" alt="{{ currentUser()->first_name }}"
                                class="object-cover rounded-full h-14 w-14">
                            @endif

                            <span class="tt" :class="profile ? 'rotate-180' : ''">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                            <div x-show="profile" @click.away="profile = false"
                                class="dropdown divide-2 absolute top-[70px] right-2 z-50 w-[187px] rounded-lg bg-white py-6 px-4 shadow-sm">
                                <ul class="flex flex-col w-full space-y-2 list-none">
                                    <li class="w-full tt hover:translate-x-2">
                                        <a href="{{ route('profile', currentUser()->id) }}">Profile</a>
                                    </li>
                                    {{-- <li class="w-full tt hover:translate-x-2">
									<a href="">Settings</a>
								</li> --}}
                                    <li class="w-full tt hover:translate-x-2">
                                        <a href="/documentation">Help and Support</a>
                                    </li>
                                </ul>
                                <hr class="my-4 h-[2px] bg-dark">
                                <a href="route('logout')" class="block w-full text-red-600 tt hover:translate-x-2"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="block">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="z-30 px-6 overflow-auto bg-background">
                {{ $slot ?? '' }}
            </section>
            <section>
                @yield('content')
            </section>
        </main>
        <footer class="p-4 print:hidden"></footer>
        @livewireScripts

        {{-- sweetalert --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // success message
        window.addEventListener('swal:success', function(e) {
            Swal.fire(e.detail);
        });

        // reload page 5secs after this event is called
        window.addEventListener('reload', function() {
            setTimeout(() => {
                location.reload();
            }, 3000);

        });

        // confirm single deleted
        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won\'t be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#f11',
                customClass: {
                    confirmButton: 'confirm',
                    denyButton: 'deny',
                    cancelButton: 'deny',
                },
                confirmButtonText: 'Yes delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteConfirm');
                }
            });
        });

        // confirm mutiple role detachment
        window.addEventListener('swal:roles', event => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are removing all roles from the user",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#f11',
                customClass: {
                    confirmButton: 'confirm',
                    denyButton: 'deny',
                    cancelButton: 'deny',
                },
                confirmButtonText: 'Yes Remove all'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('revokeConfirm');
                }
            });
        });

        // confirm single role detachment
        window.addEventListener('swal:role', event => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are removing this role from the user",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#f11',
                customClass: {
                    confirmButton: 'confirm',
                    denyButton: 'deny',
                    cancelButton: 'deny',
                },
                confirmButtonText: 'Go ahead'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('revokeRole');
                }
            });
        });

        // confirm multiple delete
        window.addEventListener('swal:multiple', event => {
            Swal.fire({
                title: 'Are you sure you?',
                text: "You are deleting buck records at once, you won\'t be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#f11',
                confirmButtonText: 'Go Ahead'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteMutipleConfirm');
                }
            });
        });

        // confirm score submittion
        window.addEventListener('swal:score', event => {
            Swal.fire({
                title: 'Are you sure you?',
                text: "Kindly check for errors and mistakes, you won\'t be able to edit submitted scores!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#f11',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('scoreConfirm');
                }
            });
        });
        </script>

        {{-- select 2 with jquery
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
        {{-- paystack api --}}
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
            window.addEventListener('paystack', payWithPaystack, false);
        let fee_id = e.detail.fee_id;
        let student_id = e.detail.student_id;

        function payWithPaystack(e) {
            let handler = PaystackPop.setup({
                key: 'pk_test_99a8cd7670b63ea9d458957e4195fb9ceed0bbb3', // Replace with your public key
                email: e.detail.email,
                amount: e.detail.amount * 100,
                currency: 'NGN',
                metadata: e.detail.metadata,
                ref: '' + Math.floor((Math.random() * 1000000000) +
                    1
                ),
                onClose: function() {
                    Swal.fire({
                        title: 'Payment Cancelled',
                        text: "You you can still repaid",
                        icon: 'error',
                        timer: 4000
                    })
                },
                callback: function(response) {
                    Livewire.emit('payFee', response);
                    //   let message = 'Payment complete! Reference: ' + response.reference;
                    //   alert(message);
                }
            });

            handler.openIframe();
        }
        </script>

        {{-- fontawesome icons --}}
        <script src="/js/all.js"></script>
    </body>

</html>