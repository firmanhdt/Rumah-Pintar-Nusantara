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
                    <svg width="10px" height="10px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z" fill="#000000" /></svg>
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
                        <a href="#" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Laporan
                        </a>
                        <a href="/admin/laporan-akhir" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
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
            <h2 class="text-xl font-semibold mb-6">Data Pengguna</h2>

            @if(!isset($users) || !isset($statistics))
                <div class="p-4 bg-red-100 text-red-700 rounded">
                    Data tidak tersedia
                </div>
            @else
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <!-- Total Pengajar Card -->
                    <div class="bg-white p-4 rounded-lg">
                        <div>
                            <div class="text-lg font-semibold">Total Pengajar</div>
                            <div class="text-3xl font-bold mt-2">{{ $statistics['total_teachers'] ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Total Siswa Card -->
                    <div class="bg-white p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">Total Siswa</h3>
                        <div class="text-3xl font-bold mt-2">{{ $statistics['total_students'] ?? 0 }}</div>
                    </div>
                </div>

                <!-- User Table -->
                <div class="bg-white rounded-lg p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="pb-3">Pengguna</th>
                                    <th class="pb-3">Nama</th>
                                    <th class="pb-3">Kelas</th>
                                    <th class="pb-3">Mata Pelajaran</th>
                                    <th class="pb-3">Email</th>
                                    <th class="pb-3">No. Telepon</th>
                                    <th class="pb-3">Tanggal Lahir</th>
                                    <th class="pb-3">Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3">{{ ucfirst($user->role) }}</td>
                                        <td class="py-3">{{ $user->name }}</td>
                                        <td class="py-3">{{ $user->classModel->class ?? 'Tidak ada' }}</td>
                                        <td class="py-3">{{ $user->subjects->pluck('name')->join(', ') ?? 'Matematika' }}</td>
                                        <td class="py-3">{{ $user->email }}</td>
                                        <td class="py-3">{{ $user->phone_number }}</td>
                                        <td class="py-3">{{ $user->birth_date }}</td>
                                        <td class="py-3">{{ $user->period_id ? $user->period->start_date . ' - ' . $user->period->end_date : 'Tidak ada' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-4 text-center text-gray-500">
                                            Tidak ada data pengguna
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end mb-4">
                    <a href="{{ route('export.users') }}" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md">
                        Ekspor ke Excel
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Add this modal HTML just before closing body tag -->
    <div id="downloadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h2 class="text-2xl font-semibold mb-4">Download</h2>

            <!-- Math Image -->
            <div class="mb-6">
                <img src="/img/math-banner.jpg" alt="Math Banner" class="w-full h-48 object-cover rounded-lg">
            </div>

            <!-- Download Button -->
            <div class="text-center">
                <button onclick="closeModal()" class="bg-[#49BBBD] text-white px-6 py-3 rounded-lg hover:bg-[#3da9ab] transition-colors duration-300">
                    Download PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Add this to your existing script section -->
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

        // Add these functions to handle the modal
        function showModal() {
            const modal = document.getElementById('downloadModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('downloadModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('downloadModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Update the "Lihat" buttons to trigger the modal
        document.querySelectorAll('.hover\\:bg-\\[\\#49BBBD\\]').forEach(button => {
            if (button.textContent.trim() === 'Lihat') {
                button.addEventListener('click', showModal);
            }
        });
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