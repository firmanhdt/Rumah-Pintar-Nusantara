<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RPN Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4">
        <div class="text-[#49BBBD] text-lg font-bold mb-4 md:mb-0">RPN DASHBOARD</div>
        <div class="flex-1 w-full md:w-auto md:mx-32 relative mb-4 md:mb-0">
        </div>
        <div class="flex items-center gap-2 relative">
            <div>
                <span class="text-sm">{{ $user->name }}</span>
                <span class="text-xs text-gray-500 block">
                    {{ $user->classModel ? $user->classModel->class : 'Belum memilih kelas' }}
                </span>
            </div>
            <div class="relative">
                <button id="dropdownButton" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md">
                    <svg width="10px" height="10px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z" fill="#000000" /></svg>
                </button>
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                    <a href="{{ route('murid.profile') }}" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar with Toggle Button -->
        <div class="relative">
            <!-- Toggle Button - Positioned in middle -->
            <button id="sidebarToggle" class="absolute -right-4 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-lg hover:bg-white">
                <svg id="sidebarIcon" class="w-5 h-5 text-[#3da9ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden fixed bottom-4 right-4 bg-[#49BBBD] text-white p-3 rounded-full shadow-lg z-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Sidebar Content -->
            <div id="sidebar" class="w-full md:w-64 bg-white min-h-screen transition-all duration-300 overflow-hidden fixed md:relative z-40">

                <!-- Menu -->
                <div class="px-4">

                    <!-- Navigation -->
                    <nav class="space-y-1">
                      <a href="{{ url('/murid/dashboard') }}" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Beranda
                      </a>
                      <a href="{{ url('/murid/materi') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Materi
                      </a>
                      <a href="{{ url('/murid/tugas') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Tugas
                      </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-4 md:p-6">
            <!-- Welcome Section -->
            <div class="bg-white rounded-2xl p-6 mb-8">
                <h1 class="text-2xl font-semibold mb-1">Selamat Datang</h1>
                <h2 class="text-xl text-gray-600 mb-8">{{ $user->name }}</h2>
                @if (!$user->is_active)
                    <span class="text-red-500">(Akun Anda dinonaktifkan)</span>
                @endif

                <!-- Kelas Saya Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Kelas Saya</h2>
                    </div>

                    <!-- Class Cards Scroll -->
                    <div class="flex space-x-4">
                        <div class="flex-shrink-0 w-64 bg-green-200 rounded-2xl p-4">
                            <h3 class="text-lg font-medium mb-1">Total Hadir</h3>
                            <p class="text-2xl font-bold">{{ $totalHadir }}</p>
                        </div>
                        <div class="flex-shrink-0 w-64 bg-red-200 rounded-2xl p-4">
                            <h3 class="text-lg font-medium mb-1">Total Tidak Hadir</h3>
                            <p class="text-2xl font-bold">{{ $totalTidakHadir }}</p>
                        </div>
                        <div class="flex-shrink-0 w-64 bg-yellow-200 rounded-2xl p-4">
                            <h3 class="text-lg font-medium mb-1">Total Izin</h3>
                            <p class="text-2xl font-bold">{{ $totalIzin }}</p>
                        </div>
                    </div>

                    <!-- Class Absensi Scroll -->
                    <div class="flex space-x-4 overflow-x-auto pb-4 p-4">
                        @foreach($user->subjects as $subject)
                            <a href="{{ url('/' . strtolower(str_replace(' ', '-', $subject->name))) }}" class="flex-shrink-0 w-64 bg-[#FFF4EA] rounded-2xl p-4 hover:shadow-lg transition-shadow duration-300">
                                <div class="bg-[#FFA873] w-16 h-16 rounded-xl mb-4 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <!-- SVG Path Here -->
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium mb-1">{{ $subject->name }}</h3>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Tugas Baru Section -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Tugas Baru</h2>
                        </div>

                        <!-- Headers -->
                        <div class="grid grid-cols-1 md:grid-cols-4 mb-4">
                            <div class="text-sm text-gray-500">Materi</div>
                            <div class="text-sm text-gray-500 text-center">Dibuat</div>
                            <div class="text-sm text-gray-500 text-center">Deadline</div>
                            <div></div> <!-- Empty column for spacing -->
                        </div>

                    <!-- Task List -->
                    <div class="space-y-4">
                        @foreach($tasks as $task)
                            @php
                                $submission = $task->submissions->where('user_id', auth()->id())->first(); // Ambil pengumpulan siswa saat ini
                            @endphp
                            <div class="grid grid-cols-4 items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">{{ $task->title }}</h3>
                                        <p class="text-sm text-gray-500">{{ $task->subject->name }}</p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500 text-center">{{ \Carbon\Carbon::parse($task->due_date)->format('F d') }}</div>
                                <div class="text-sm text-gray-500 text-center">
                                    @if ($submission)
                                        @if ($submission->grade)
                                            Nilai: {{ $submission->grade }} - {{ $submission->comment ?? 'Tidak ada komentar' }}
                                        @else
                                            Menunggu nilai
                                        @endif
                                    @else
                                        Belum mengumpulkan
                                    @endif
                                </div>
                                <div></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Jadwal Pengajar Section -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Jadwal Pengajar</h2>
                    </div>

                    <!-- Schedule List -->
                    <div class="space-y-3">
                        @foreach($schedules as $schedule)
                            <div class="bg-[#49BBBD] text-white p-4 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                        </svg>
                                    </div>
                                    <span>{{ $schedule->subject->name}}</span
                                    <span>{{ $schedule->description }}</span>
                                </div>
                                <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</span>
                                {{-- <span>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</span> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Add this script at the end of your body tag -->
    <script>
        function toggleDashboard() {
            const menu = document.getElementById('dashboardMenu');
            const arrow = document.getElementById('dashboardArrow');
            menu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Simplified sidebar toggle function for minimize only
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarIcon = document.getElementById('sidebarIcon');
        let isOpen = true;

        sidebarToggle.addEventListener('click', () => {
            sidebar.style.width = isOpen ? '0px' : '256px';
            sidebarIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            isOpen = !isOpen;
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        let isMobileOpen = false;

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.style.transform = isMobileOpen ? 'translateX(-100%)' : 'translateX(0)';
            isMobileOpen = !isMobileOpen;
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768) {  // Only for mobile
                if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target) && isMobileOpen) {
                    sidebar.style.transform = 'translateX(-100%)';
                    isMobileOpen = false;
                }
            }
        });

        // Handle resize events
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {  // Desktop
                sidebar.style.transform = '';
                sidebar.style.width = isOpen ? '256px' : '0px';
            } else {  // Mobile
                sidebar.style.width = '256px';
                sidebar.style.transform = isMobileOpen ? 'translateX(0)' : 'translateX(-100%)';
            }
        });

        // Initial setup
        if (window.innerWidth < 768) {
            sidebar.style.transform = 'translateX(-100%)';
        }

        document.getElementById('dropdownButton').addEventListener('click', function() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
        });

        // Menutup dropdown jika klik di luar
        document.addEventListener('click', function(event) {
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownButton = document.getElementById('dropdownButton');
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>