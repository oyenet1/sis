@extends('layouts.auth')
@section('content')
    <div
        class="relative mx-auto my-auto grid w-full max-w-4xl items-center justify-around gap-4 px-4 md:grid-cols-2 lg:gap-12 xl:max-w-5xl 2xl:max-w-7xl 2xl:gap-16">
        <div class="col-span-2 mx-auto w-full rounded-md px-2 pt-4 shadow-lg md:pb-16 lg:col-span-1">
            <div
                class="mx-auto mt-4 flex h-24 w-24 max-w-max items-center justify-center rounded-full bg-background px-4 py-4 shadow 2xl:my-8">
                <img src="/img/alaasu.png" alt="bonifade logo" class="mx-auto h-auto w-20">
            </div>
            <form method="POST" action="{{ route('welcome.update') }}"
                class="mx-auto flex w-full flex-col space-y-8 px-4 sm:px-12 lg:px-16">
                @csrf
                <h1 class="font-rubik text-xl font-bold text-primary md:text-2xl lg:text-3xl">Welcome!</h1>
                <small class="text-gray-500">Kindly update your password to use the system. Make sure the email address is
                    correct
                    <a href="https://bonifade.com" target="_blank" class="font-medium text-primary">Contact
                        Admin</a></small>

                <div class="w-full space-y-6">
                    <div>
                        <div class="relative h-14 w-full overflow-hidden rounded text-gray-500">
                            <label for="email" class="absolute z-50 pt-2 pl-12 text-sm capitalize text-gray-500">Enter
                                Your Email
                            </label>
                            <input type="text" value="{{ $email }}" name="email"
                                class='@error('email') border-red-600 border-2 @enderror tt h-full w-full cursor-not-allowed rounded-lg border-0 bg-gray-100 pt-6 pl-12 text-sm font-medium placeholder-primary focus:border-2 focus:border-primary focus:bg-white'
                                readonly>
                            {{-- span elements --}}
                            <span class="absolute left-2 top-4 z-20 my-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-envelope h-6 w-6 text-primary" viewBox="0 0 16 16 ">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                </svg>
                            </span>
                        </div>
                        @error('email')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-forms.password class="" label="password" name="password">
                            @error('password')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </x-forms.password>
                    </div>
                    <div class="w-full">
                        <div class='relative h-14 w-full overflow-hidden rounded-lg text-gray-500' x-data="{ show: false }">
                            <label for="password_confirmation"
                                class="absolute z-50 pt-2 pl-12 text-sm capitalize text-gray-500">
                                Re-enter Password</label>
                            <input :type="show ? 'text' : 'password'" placeholder="**********" name="password_confirmation"
                                class='@error('password') border-red-600 border-2 @enderror tt h-full w-full rounded-lg border-0 bg-gray-100 pt-7 pl-12 text-sm font-medium placeholder-primary focus:border-2 focus:border-primary focus:bg-white'>
                            <span class="tt absolute left-2 top-4 h-6 w-6 rotate-180 text-primary">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                    </path>
                                </svg>
                            </span>

                            {{-- <span x-cloak class="absolute transition duration-300 cursor-pointer right-2 top-4 hover:text-black"
                  @click="show = !show">
                  <svg :class="show ? 'block' : 'hidden'" class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                    </path>
                  </svg>
                  <svg :class="show ? 'hidden' : 'block'" class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                  </svg>
                </span> --}}
                        </div>
                        @error('password_confirm')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="tex-sm mt-2 flex items-center justify-between">
                        <div>
                            <label for="remember " class="text-sm text-primary">
                                <input type="checkbox" name="remember" id="remember"
                                    class="rounded-sm border-2 border-primary text-secondary focus:bg-secondary focus:text-white">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full rounded bg-primary py-2 text-center text-white transition duration-300 hover:bg-purple-800">Update
                        Password</button>
                </div>

            </form>
        </div>
        <div class="relative hidden w-full gap-8 lg:block">
            <img src="/img/welcome.svg" alt="Bonifade Technologies | school managemnt system"
                class="object-cover object-center">
        </div>
        <p class="-mt-8 max-w-max text-sm font-medium text-gray-500">Powered By <a href="https://bonifade.com"
                class="text-secondary" target="_blank" title="Click to Contact">Meeras</a></p>
        {{-- <a href="mailto:info@bonifade.com"
      class="absolute top-0 px-4 py-2 -mt-8 text-sm font-medium transition duration-300 border-2 rounded text-primary border-primary hover:bg-primary hover:text-white right-3"
      target="_blank" title="Click to Contact">Contact</a> --}}
    </div>
@endsection
