<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rumah Pintar Nusantara</title>
    @vite('resources/css/app.css')
</head>

<section class="bg-[#40B2B7] min-h-screen flex items-center justify-start">
    <div class="lg:w-[80%] md:w-[90%] xs:w-[96%] mx-auto flex gap-4 bg-white rounded-3xl">
        <div
            class="lg:w-[88%] md:w-[80%] sm:w-[88%] xs:w-full mx-auto p-4 h-fit self-center">
            <!--  -->
            <div class="">
                <a class="block text-blue-600" href="#">
                    <span class="sr-only">Home</span>
                    <div class="flex items-center gap-2 mb-6">
                        <img src="/img/logo-login.png">

                    </div>
                </a>
                <h1 class="mt-6 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">
                Registrasi Guru
                </h1>
                @if ($errors->any())
                    <div class="mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-500">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="mb-4 text-green-500">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('register.guru') }}" method="POST" class="mt-8 mx-auto grid grid-cols-6 gap-6">
                    @csrf

                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Nama Guru"
                            class="mt-2 p-2 w-full border-2 rounded-full dark:text-black dark:border-gray-300"
                            required
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="text"
                            id="phone_number"
                            name="phone_number"
                            placeholder="Nomor Telepon"
                            class="mt-2 p-2 w-full border-2 rounded-full dark:text-black dark:border-gray-300"
                            required
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="date"
                            id="birth_date"
                            name="birth_date"
                            placeholder="Tanggal Lahir"
                            class="mt-2 p-2 w-full border-2 rounded-full dark:text-black dark:border-gray-300"
                            required
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Email"
                            class="mt-2 p-2 w-full border-2 rounded-full dark:text-black dark:border-gray-300"
                            required
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Password"
                            class="mt-2 p-2 w-full border-2 rounded-full dark:text-black dark:border-gray-300"
                            required
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Konfirmasi Password"
                            class="mt-2 p-2 w-full border-2 rounded-full dark:text-black dark:border-gray-300"
                            required
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                    <select id="subjects" name="subjects[]" class="w-full text-grey border-2 rounded-full p-2 pl-2 pr-2 mt-2 dark:text-black dark:border-gray-300" required>
                        <option value="" disabled selected>Pilih Mata Pelajaran</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    </div>

                    <div class="justify-center col-span-6 sm:flex sm:items-center sm:gap-4">
                        <button
                            type="submit"
                            class="inline-block shrink-0 rounded-full border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
                        >
                            Daftar
                        </button>
                    </div>
                    <div class="justify-center col-span-6 sm:flex sm:items-center sm:gap-4">
                        <a href="{{ route('admin.dashboard') }}">
                            <button
                                type="button"
                                class="inline-block shrink-0 rounded-full border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
                            >
                                Kembali ke admin
                            </button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</html>