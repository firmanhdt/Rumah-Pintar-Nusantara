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
                    <svg width="10px" height="10px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z" fill="#000000" />
                    </svg>
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
                      <a href="{{ url('/murid/tugas') }}" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
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
            <!-- Tugas Section -->
            <div class="bg-white rounded-2xl p-6">
                <h2 class="text-xl font-semibold mb-6">Tugas</h2>

                @if(session('warning'))
                    <div class="bg-yellow-500 text-white p-4 rounded-md mb-4">
                        {{ session('warning') }}
                    </div>
                @endif

            <!-- Form untuk Filter Mata Pelajaran -->
            <form action="{{ route('murid.tugas') }}" method="GET">
                <div class="mb-4">
                    <label for="subjectSelect" class="block text-sm font-medium text-gray-700">Pilih Mata Pelajaran</label>
                    <select id="subjectSelect" name="subject_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" onchange="this.form.submit()">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $subjectId == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tasks as $task)
                        @php
                            $dueDate = \Carbon\Carbon::parse($task->due_date)->endOfDay();
                            $isPast = now()->isAfter($dueDate);
                            $submission = $task->submissions->where('user_id', auth()->id())->first();
                        @endphp
                        <div onclick="{{ !$isPast ? 'openTaskModal(' . $task->id . ')' : '' }}" class="bg-white rounded-lg border border-gray-200 overflow-hidden cursor-pointer {{ $isPast ? 'opacity-50 cursor-not-allowed' : 'hover:shadow-lg transition-all' }}">
                            <div class="p-4">
                                <h3 class="font-medium mb-1">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $task->description }}</p>
                                <p class="text-sm text-gray-600 mb-2">Batas waktu: {{ $task->due_date }}</p>
                                @if ($task->file_path)
                                    <a href="{{ asset('storage/' . $task->file_path) }}" class="text-blue-500 hover:underline" target="_blank">Lihat File</a>
                                @endif
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $task->createdBy->name }}</span>
                                    <span class="text-sm text-green-500">
                                        @if ($submission)
                                            @if ($submission->grade)
                                                Nilai: {{ $submission->grade }} - {{ $submission->comment ?? 'Tidak ada komentar' }}
                                            @else
                                                Menunggu nilai
                                            @endif
                                            @if ($submission->file_path)
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $submission->file_path) }}" class="text-blue-500 hover:underline">Lihat Jawaban</a>
                                                </div>
                                            @endif
                                        @else
                                            Belum mengumpulkan
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Task Modal -->
            <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 relative">
                    <!-- Close button -->
                    <button onclick="closeTaskModal()" class="absolute right-4 top-4">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Modal content -->
                    <div class="p-6">
                        <h3 class="font-medium mb-4">Upload Tugas</h3>
                            <form action="{{ route('murid.tugas.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="task_id" id="taskIdInput"> <!-- Hidden input for task ID -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Upload File</label>
                                    <input type="file" name="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Komentar</label>
                                    <textarea name="comment" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" rows="4" placeholder="Masukkan komentar (opsional)"></textarea>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="px-6 py-2 bg-[#49BBBD] text-white rounded-lg hover:bg-[#3da9ab] transition-colors">
                                        Kirim
                                    </button>
                                    <button type="button" onclick="closeTaskModal()" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        Batal
                                    </button>
                                </div>
                            </form>

                        <!-- Download PDF Tab -->
                        <div id="downloadContent" class="hidden space-y-4">
                            <p class="text-sm font-medium mb-2">Download Tugas</p>
                            <div class="space-y-4">
                                @foreach($tasks as $task)
                                    @if($task->file_path) <!-- Pastikan file_path ada -->
                                        <div class="border rounded-lg p-4">
                                            <h4 class="font-medium">{{ $task->title }}</h4>
                                            <a href="{{ asset('storage/' . $task->file_path) }}" class="w-full px-4 py-2 bg-[#49BBBD] text-white rounded-lg hover:bg-[#3da9ab] transition-colors">
                                                Download PDF
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
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

        const taskModal = document.getElementById('taskModal');
        const taskTitle = document.getElementById('taskTitle');
        const taskDescription = document.getElementById('taskDescription');
        const submitButton = document.getElementById('submitButton');
        let isTaskCompleted = false;

        function openTaskModal(taskId) {
            const modal = document.getElementById('taskModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('taskIdInput').value = taskId;
        }

        function closeTaskModal() {
            const modal = document.getElementById('taskModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function handleSubmit() {
            // Add your submit logic here
            closeTaskModal();
        }

        // Tab switching functionality
        function switchTab(tab) {
            const submitTab = document.getElementById('submitTab');
            const downloadTab = document.getElementById('downloadTab');
            const submitContent = document.getElementById('submitContent');
            const downloadContent = document.getElementById('downloadContent');

            if (tab === 'submit') {
                submitTab.classList.add('border-[#49BBBD]', 'text-[#49BBBD]');
                submitTab.classList.remove('text-gray-500');
                downloadTab.classList.remove('border-[#49BBBD]', 'text-[#49BBBD]');
                downloadTab.classList.add('text-gray-500');
                submitContent.classList.remove('hidden');
                downloadContent.classList.add('hidden');
            } else {
                downloadTab.classList.add('border-[#49BBBD]', 'text-[#49BBBD]');
                downloadTab.classList.remove('text-gray-500');
                submitTab.classList.remove('border-[#49BBBD]', 'text-[#49BBBD]');
                submitTab.classList.add('text-gray-500');
                downloadContent.classList.remove('hidden');
                submitContent.classList.add('hidden');
            }
        }

                // Dropdown menu toggle functionality
            document.getElementById('dropdownButton').addEventListener('click', function(event) {
            event.stopPropagation();  // Menghentikan event agar tidak mengarah ke elemen lain
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('hidden');  // Menyembunyikan atau menampilkan menu
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', function(event) {
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownButton = document.getElementById('dropdownButton');
            // Menutup dropdown jika klik di luar tombol atau menu
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');  // Menyembunyikan menu jika klik di luar
            }
        });


        // File upload handling
        const dropZone = document.querySelector('.border-dashed');
        const fileInput = document.getElementById('fileInput');

        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-[#49BBBD]');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-[#49BBBD]');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-[#49BBBD]');
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
            }
        });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                // Handle file selection
                console.log('File selected:', file.name);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('dropdownButton')
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (dropdownButton && dropdownMenu) { // Pastikan elemen ada
                dropdownButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(event) {
                    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            } else {
                console.error('Dropdown button or menu not found');
            }
        });

    </script>
</body>
</html>