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
                    {{ implode(', ', $user->subjects->pluck('name')->toArray()) }}
                </span>
            </div>
            <div class="relative">
                <button id="dropdownButton" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md">
                    <svg width="10px" height="10px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z" fill="#000000" /></svg>
                </button>
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
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
                    <!-- Dasbor Dropdown -->
                    <div>
                        <button onclick="toggleDashboard()" class="flex items-center justify-between w-full text-[#49BBBD] text-sm mb-2 hover:text-[#3da9ab]">
                            <span>Dasbor</span>
                            <svg class="w-4 h-4 transition-transform" id="dashboardArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Content -->
                        <div id="dashboardMenu" class="hidden ml-2 mb-3">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                                Dasbor Admin
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-1">
                        <!-- Manajemen User -->
                        <a href="{{ route('admin.management-user') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Manajemen User
                        </a>

                        <!-- Laporan -->
                        <a href="/admin/laporan" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Laporan
                        </a>

                        <a href="/admin/laporan-akhir" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l9 9 9-9" />
                            </svg>
                            Laporan Akhir
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-4 md:p-6">
            <h2 class="text-xl font-semibold mb-6">Laporan Akhir</h2>

            <form method="GET" action="{{ route('admin.laporan-akhir') }}">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <!-- Periode Dropdown -->
                    <div>
                        <label for="periodSelect" class="block text-sm font-medium text-gray-700">Pilih Periode</label>
                        <select id="periodSelect" name="period_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                            <option value="">Pilih Periode</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}">
                                    {{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Pelajaran Dropdown -->
                    <div>
                        <label for="mataPelajaran" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                        <select id="mataPelajaran" name="subject_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kelas Dropdown -->
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select id="kelas" name="class_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                            <option value="">Pilih Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button id="uploadButton" class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Tambah Periode
                        </button>
                    </div>

                    <div>
                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 flex items-center gap-2">
                            Tampilkan Laporan
                        </button>
                    </div>
                </div>
            </form>

            <!-- User Table -->
            <div class="overflow-x-auto bg-white rounded-lg p-6">
                <table class="min-w-full table-auto">
                    <thead class="bg-[#49BBBD] text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama Siswa</th>
                            <th class="px-4 py-2 text-left">Kelas</th>
                            <th class="px-4 py-2 text-left">Mata Pelajaran</th>
                            <th class="px-4 py-2 text-left">Nilai Akhir</th>
                            <th class="px-4 py-2 text-left">Periode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td class="px-4 py-2">{{ $student->name }}</td>
                                <td class="px-4 py-2">{{ $student->classModel->class ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $subjects = \App\Models\Subject::whereIn('id', function($query) use ($student) {
                                            $query->select('subject_id')->from('subject_user')->where('user_id', $student->id);
                                        })->get();
                                    @endphp
                                    @foreach($subjects as $subject)
                                        {{ $subject->name }}@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="px-4 py-2">
                                    @php
                                        $finalGrade = \App\Models\FinalGrade::where('student_id', $student->id)
                                            ->where('period_id', $request->period_id)
                                            ->first();
                                    @endphp
                                    {{ $finalGrade->final_grade ?? 'Belum ada nilai' }}
                                </td>
                                <td class="px-4 py-2">{{ $student->period->start_date ?? 'N/A' }} - {{ $student->period->end_date ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6 p-4">
                    <a href="{{ route('admin.laporan-akhir.export', ['class_id' => request('class_id'), 'subject_id' => request('subject_id'), 'period_id' => request('period_id')]) }}" class="bg-[#49BBBD] text-white px-6 py-2 rounded-md">Export Excel</a>
                </div>
            </div>

            <!-- Modal Upload -->
            <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-semibold mb-4">Tambah Periode</h3>
                        <form action="{{ route('periods.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]" required>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]" required>
                            </div>
                            <div class="flex justify-between mt-4">
                                <button type="submit" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md hover:bg-[#3da9ab]">Unggah</button>
                                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-white text-gray-600 border border-gray-300 rounded-md hover:bg-red-500 hover:text-white">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        document.addEventListener("DOMContentLoaded", function () {
            const uploadButton = document.getElementById("uploadButton");
            const uploadModal = document.getElementById("uploadModal");

            // Fungsi untuk menampilkan modal
            function showModal() {
                uploadModal.classList.remove("hidden");
            }

            // Fungsi untuk menutup modal
            function closeModal() {
                uploadModal.classList.add("hidden");
                resetForm();
            }

            // Reset form saat modal ditutup
            function resetForm() {
                const form = uploadModal.querySelector("form");
                if (form) {
                    form.reset();
                }
            }

            // Event listener untuk membuka modal saat tombol ditekan
            uploadButton.addEventListener("click", showModal);

            // Menutup modal jika pengguna mengklik di luar modal
            uploadModal.addEventListener("click", (event) => {
                if (event.target === uploadModal) {
                    closeModal();
                }
            });

            // Menutup modal dengan tombol Batal
            document.querySelector("#uploadModal button[onclick='closeModal()']").addEventListener("click", closeModal);
        });
    </script>
</body>
</html>