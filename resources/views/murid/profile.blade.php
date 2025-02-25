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
                      <a href="{{ url('/murid/dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
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
            <!-- Profile Section -->
            <div class="bg-white rounded-2xl p-6 mb-8">
                <h1 class="text-2xl font-semibold mb-1">Profile</h1>
                <h2 class="text-xl text-gray-600 mb-8">{{ $user->name }}</h2>

                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Profile Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold">Nama</h3>
                        <p class="text-sm text-gray-500">{{ $user->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Email</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Kelas</h3>
                        <p class="text-sm text-gray-500">{{ $user->classModel->class ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Mata Pelajaran</h3>
                        <ul class="text-sm text-gray-500">
                            @foreach($user->subjects as $subject)
                                <li>{{ $subject->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Periode</h3>
                        <p class="text-sm text-gray-500">{{ $user->period->start_date ?? 'N/A' }} - {{ $user->period->end_date ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Edit Button --}}
                @if ($user->role === 'murid' && $user->is_edit) <!-- Cek apakah role adalah murid dan is_edit adalah 1 -->
                    <button id="editProfileBtn" class="mt-4 bg-[#49BBBD] text-white px-4 py-2 rounded-md" onclick="openEditProfileModal()">Edit Profil</button>
                @endif
            </div>
        </div>

        <!-- Popup Modal for Editing Profile -->
        <div id="editProfileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96">
                <h2 class="text-2xl font-semibold mb-4">Edit Profil</h2>
                <form id="editProfileForm" action="{{ route('murid.profile.update') }}" method="POST">
                    @csrf
                    <!-- Kelas Dropdown -->
                    <div class="mb-4">
                        <label for="kelas" class="block text-sm font-semibold">Pilih Kelas</label>
                        <select id="kelas" name="kelas" class="w-full mt-2 p-2 border rounded-md" required>
                            <option value="" disabled selected>Pilih Kelas</option>
                            @foreach($classModels as $classModel)
                                <option value="{{ $classModel->id }}" {{ $user->class_id == $classModel->id ? 'selected' : '' }}>{{ $classModel->class }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Pelajaran Dropdown 1 -->
                    <div class="mb-4">
                        <label for="subjects1" class="block text-sm font-semibold">Pilih Mata Pelajaran 1</label>
                        <select id="subjects1" name="subjects[]" class="w-full text-grey border-2 rounded-full p-2 pl-2 pr-2 mt-2 dark:text-black dark:border-gray-300" required>
                            <option value="" disabled selected>Pilih Mata Pelajaran 1</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ in_array($subject->id, $user->subjects->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Pelajaran Dropdown 2 -->
                    <div class="mb-4">
                        <label for="subjects2" class="block text-sm font-semibold">Pilih Mata Pelajaran 2</label>
                        <select id="subjects2" name="subjects[]" class="w-full text-grey border-2 rounded-full p-2 pl-2 pr-2 mt-2 dark:text-black dark:border-gray-300">
                            <option value="" disabled selected>Pilih Mata Pelajaran 2</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ in_array($subject->id, $user->subjects->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Periode Dropdown -->
                    <div class="mb-4">
                        <label for="periode" class="block text-sm font-semibold">Pilih Periode</label>
                        <select id="periode" name="periode" class="w-full mt-2 p-2 border rounded-md" required>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ $user->period_id == $period->id ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Save Button -->
                    <button type="submit" class="w-full bg-[#49BBBD] text-white px-4 py-2 rounded-md">Simpan</button>
                </form>
                <button id="closeModalBtn" class="mt-4 text-gray-500 hover:text-black">Tutup</button>
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

        const editProfileBtn = document.getElementById('editProfileBtn');
        const editProfileModal = document.getElementById('editProfileModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const editProfileForm = document.getElementById('editProfileForm');

        // Open the modal
        editProfileBtn.addEventListener('click', () => {
            editProfileModal.classList.remove('hidden');
        });

        // Close the modal
        closeModalBtn.addEventListener('click', () => {
            editProfileModal.classList.add('hidden');
        });

        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        document.getElementById('closeModalBtn').addEventListener('click', function() {
            document.getElementById('editProfileModal').classList.add('hidden');
        });
    </script>
</body>
</html>