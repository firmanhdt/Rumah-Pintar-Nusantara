<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rumah Pintar Nusantara</title>
    @vite('resources/css/app.css')
</head>
<!--
  Heads up! 👋

  Plugins:
    - @tailwindcss/forms
-->

<!-- <section class="bg-[#40B2B7] min-h-screen flex items-center justify-center">
  <div class="bg-white rounded-lg p-8">
    <main
      class="flex items-center justify-between mx-auto sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6"
    >
      <div class="max-w-xl lg:max-w-3xl">
        <a class="block text-blue-600" href="#">
          <span class="sr-only">Home</span>
          <div class="flex items-center gap-2 mb-6">
                <img src="/img/logo-login.png">
                
            </div>
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">
          Registrasi Siswa
        </h1>

        <form action="#" class="mt-8 mx-auto grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">

            <input
              type="text"
              id="FirstName"
              name="first_name"
              placeholder="Nama Siswa"
              class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm py-2"
            />
          </div>

          <div class="col-span-6 sm:col-span-3">

            <input
              type="text"
              id="LastName"
              name="last_name"
              placeholder="Nomor Telepon Orang Tua"
              class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm py-2"
            />
          </div>

          <div class="col-span-6 sm:col-span-3">

            <input
              type="date"
              id="Date"
              name="date"
              placeholder="Tanggal Lahir"
              class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm py-2"
            />
          </div>
          

          <div class="col-span-6 sm:col-span-3">

            <input
              type="Email"
              id="Email"
              name="email"
              placeholder="Email"
              class="mt-1 w-full rounded-lg border-gray-200 bg-white text-sm text-gray-700 shadow-sm py-2 px-6"
            />
          </div>

          <div class="col-span-6 sm:col-span-3">
            <select id="kelas" name="kelas" class="mt-1 w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-400" required>
                <option value="" disabled selected>Kelas</option>
                <option value="PAUD">PAUD</option>
                <option value="SD Kelas 1 & 2">SD Kelas 1 & 2</option>
                <option value="SD Kelas 3 & 4">SD Kelas 3 & 4</option>
                <option value="SD Kelas 5 & 6">SD Kelas 5 & 6</option>
                <option value="SMP & SMA">SMP & SMA</option>
            </select>
          </div>

          <div class="col-span-6 sm:col-span-3">
            <input  
              type="password"
              id="Password"
              name="Password"
              placeholder="Password"
              class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm py-2 px-6"
            />
          </div>

          <div class="justify-center col-span-6 sm:flex sm:items-center sm:gap-4">
            <button
              class="inline-block shrink-0 rounded-full border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
            >
              Sign in to My Account
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>
</section> -->

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
                Registrasi Siswa
                </h1>
                <div class="mt-2 md:text-lg">
                <p class="text-red-500 text-base">Kelas Paud ambil mata pelajaran Calistung dan mengisi 1 mata pelajaran</p>
                <p class="text-red-500 text-base">Kelas SD s/d SMA ambil mata pelajaran Bahasa Inggris dan Matematika dan mengisi 2 mata pelajaran</p>
                <p class="text-red-500 text-base">Pilih periode terbaru</p>
                </div>
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
                <form action="{{ route('register') }}" method="POST" class="mt-8 mx-auto grid grid-cols-6 gap-6">
                    @csrf
                    
                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Nama Siswa"
                            class="mt-2 p-2 w-full border-2 rounded-full dark:text-black dark:border-gray-300"
                            required
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <input
                            type="text"
                            id="phone_number"
                            name="phone_number"
                            placeholder="Nomor Telepon Orang Tua"
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
                        <select id="class" name="class" class="w-full text-grey border-2 rounded-full p-2 pl-2 pr-2 mt-2 dark:text-black dark:border-gray-300" required>
                            <option value="" disabled selected>Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <select id="subjects1" name="subjects[]" class="w-full text-grey border-2 rounded-full p-2 pl-2 pr-2 mt-2 dark:text-black dark:border-gray-300" required>
                            <option value="" disabled selected>Pilih Mata Pelajaran 1</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <select id="subjects2" name="subjects[]" class="w-full text-grey border-2 rounded-full p-2 pl-2 pr-2 mt-2 dark:text-black dark:border-gray-300">
                            <option value="" disabled selected>Pilih Mata Pelajaran 2</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <select id="period" name="period_id" class="w-full text-grey border-2 rounded-full p-2 pl-2 pr-2 mt-2 dark:text-black dark:border-gray-300" required>
                            <option value="" disabled selected>Pilih Periode</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}">{{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="justify-center col-span-6 sm:flex sm:items-center sm:gap-4">
                        <button
                            type="submit"
                            class="inline-block shrink-0 rounded-full border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
                        >
                            Sign In to My Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('class').addEventListener('change', function() {
        const classId = this.value;
        fetch(`/api/subjects/${classId}`)
            .then(response => response.json())
            .then(data => {
                const subjectsInput = document.getElementById('subjects');
                const subjectIds = data.map(subject => subject.id);
                subjectsInput.value = subjectIds.join(','); // Set IDs to hidden input
            });
    });
</script>
</html>