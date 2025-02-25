<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Materi - RPN Dashboard</title>
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

    <div class="flex flex-col md:flex-row">
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
                    <a href="{{ url('/guru/dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Beranda
                    </a>
                    <a href="{{ url('/guru/materi') }}" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Materi
                    </a>
                    <a href="{{ url('/guru/tugas') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Tugas
                    </a>
                    <a href="{{ url('/guru/absensi') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Absensi
                    </a>
                    <a href="{{route('show.schedule')}}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Jadwal
                      </a>

                      <a href="{{url ('guru/data-nilai')}}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Penilaian
                      </a>
                      <a href="{{url ('guru/nilai-akhir')}}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Nilai Akhir
                      </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex-1 p-4 md:p-6">
            <!-- Main Content -->
            <div class="flex-1">
                <!-- Content Area -->
                <div class="p-6 max-w-5xl mx-auto">
                    <!-- Video Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="aspect-w-16 aspect-h-9 bg-gradient-to-r from-purple-900 via-pink-700 to-red-500 rounded-lg overflow-hidden relative mb-6">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <button class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-50 transition-colors">
                                    <svg class="w-8 h-8 text-[#49BBBD]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 5v10l8-5-8-5z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-start">
                            <div class="flex-1 pr-8">
                                <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="{{ $material->name }}" class="w-full h-auto mb-4 rounded-lg">
                                <h3 class="text-2xl font-semibold mb-4">{{ $material->name }}</h3>
                                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                                    {{ $material->description }}
                                </p>
                                <div>
                                    <h4 class="text-lg font-semibold mb-2">File Materi:</h4>
                                    <a href="{{ asset('storage/' . $material->file_path) }}" class="text-blue-500 hover:underline" target="_blank">Lihat File</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Add any necessary JavaScript for video player functionality
        const playButton = document.querySelector('button');
        playButton.addEventListener('click', () => {
            // Add video play functionality here
            console.log('Play video');
        });

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

        // Reset Form
        function resetForm() {
            document.getElementById('uploadForm').reset();
            document.getElementById('previewArea').innerHTML = '';
        }
    </script>
</body>
</html>