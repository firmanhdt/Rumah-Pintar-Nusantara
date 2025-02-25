<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RPN Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

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
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                                Dasbor Admin
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-1">
                        <!-- Manajemen User -->
                        <a href="{{ route('admin.management-user') }}" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
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
            <h2 class="text-xl font-semibold mb-6">Management User</h2>

            <!-- User Management Section -->
            <div class="bg-white rounded-lg p-6">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="text-gray-600">{{ $users->count() }} Users</div>
                    <div class="flex gap-4 w-full md:w-auto">
                        <div class="relative flex-1 md:flex-none">
                            <input type="text" id="searchInput" placeholder="Search by name" class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300" onkeyup="searchUsers()">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <form action="{{ route('admin.users.toggleEdit') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="text-white {{ $allUsersAreEditable ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600' }} px-4 py-2 rounded-md">
                                {{ $allUsersAreEditable ? 'Tutup Edit' : 'Buka Edit' }}
                            </button>
                        </form>
                        <a href="{{ route('guru.register.form') }}" class="bg-[#49BBBD] text-white px-4 py-2 rounded-lg hover:bg-[#3da9ab]">
                            Add Guru
                        </a>
                    </div>
                </div>

                <!-- Filter Dropdown -->
                <div class="flex items-center mb-4">
                    <select id="roleFilter" class="border rounded-lg px-4 py-2" onchange="filterUsers()">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ $roleFilter == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="murid" {{ $roleFilter == 'murid' ? 'selected' : '' }}>Murid</option>
                        <option value="guru" {{ $roleFilter == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto"></div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="text-left border-b bg-gray-200">
                                <th class="pb-3 pr-4">
                                    <input type="checkbox" class="rounded" id="selectAll" onclick="toggleSelectAll(this)">
                                </th>
                                <th class="pb-3">Nama</th>
                                <th class="pb-3">Role</th>
                                <th class="pb-3">Kelas</th>
                                <th class="pb-3">Mata Pelajaran</th>
                                <th class="pb-3">Periode</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Waktu Daftar</th>
                                <th class="pb-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            @foreach ($users as $user)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-4 pr-4">
                                    <input type="checkbox" class="user-checkbox" value="{{ $user->id }}">
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="font-medium">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <span class="px-2 py-1 text-xs rounded {{ $user->role === 'admin' ? 'bg-gray-100' : ($user->role === 'guru' ? 'bg-[#FFE4E4] text-[#FF0000]' : 'bg-[#48ff3f] text-[#FF0000]') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-gray-500">{{ $user->class_id ? $user->classModel->class : 'N/A' }}</td>
                                <td class="text-gray-500">{{ $user->subjects->pluck('name')->join(', ') }}</td>
                                <td class="text-gray-500">{{ $user->period_id ? $user->period->start_date . ' - ' . $user->period->end_date : 'N/A' }}</td>
                                <td class="text-gray-500">{{ $user->is_approved ? 'Disetujui' : 'Belum Disetujui' }}</td>
                                <td class="text-gray-500">{{ $user->created_at->format('F j, Y') }}</td>
                                <td>
                                    @if (!$user->is_approved)
                                    <button class="text-white bg-[#49BBBD] px-4 py-1 rounded-md hover:bg-[#3da9ab]" onclick="approveUser({{ $user->id }})">
                                        Setujui
                                    </button>
                                    @else
                                    <form action="{{ route('admin.users.sendMessage', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="text-white bg-[#49BBBD] px-4 py-1 rounded-md hover:bg-[#3da9ab]">
                                            Kirim Pesan
                                        </button>
                                    </form>
                                    @endif
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white bg-red-500 px-4 py-1 rounded-md hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                    <!-- Tombol Nonaktifkan/Aktifkan -->
                                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="text-white {{ $user->is_active ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600' }} px-4 py-1 rounded-md">
                                            {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Kembali Akun' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-500">
                        Result per page:
                        <select id="resultsPerPage" class="border rounded px-2 py-1" onchange="changeResultsPerPage()">
                            <option value="1" {{ $users->perPage() == 1 ? 'selected' : '' }}>1</option>
                            <option value="6" {{ $users->perPage() == 6 ? 'selected' : '' }}>6</option>
                            <option value="12" {{ $users->perPage() == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ $users->perPage() == 24 ? 'selected' : '' }}>24</option>
                            <option value="50" {{ $users->perPage() == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $users->perPage() == 100 ? 'selected' : '' }}>100</option>
                            <option value="300" {{ $users->perPage() == 300 ? 'selected' : '' }}>300</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        {{ $users->links() }}
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

    function approveUser(userId) {
        if (confirm('Apakah Anda yakin ingin menyetujui pengguna ini?')) {
            fetch(`/admin/users/approve/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    location.reload(); // Muat ulang halaman setelah menyetujui
                } else {
                    alert('Terjadi kesalahan saat menyetujui pengguna.');
                }
            });
        }
    }

    function filterUsers() {
        const role = document.getElementById('roleFilter').value;
        const url = new URL(window.location.href);
        url.searchParams.delete('search');
        url.searchParams.set('role', role);
        window.location.href = url.toString();
    }

    function searchUsers() {
        const query = document.getElementById('searchInput').value;
        const url = new URL(window.location.href);
        url.searchParams.set('search', query);
        window.location.href = url.toString();
    }

    function changeResultsPerPage() {
        const resultsPerPage = document.getElementById('resultsPerPage').value;
        const url = new URL(window.location.href);
        url.searchParams.set('results_per_page', resultsPerPage);
        window.location.href = url.toString();
    }

    function toggleSelectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }

    function performAction() {
        const selectedUserIds = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(checkbox => checkbox.value);
        
        if (selectedUserIds.length === 0) {
            alert('Silakan pilih setidaknya satu pengguna.');
            return;
        }

        // Lakukan aksi yang diinginkan, misalnya mengirim data ke server
        console.log('Selected User IDs:', selectedUserIds);
        
        // Contoh: Kirim data ke server menggunakan fetch
        // fetch('/your-action-url', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //     },
        //     body: JSON.stringify({ userIds: selectedUserIds })
        // }).then(response => {
        //     // Tangani respons
        // }).catch(error => {
        //     console.error('Error:', error);
        // });
    }
    </script>
</body>
</html>