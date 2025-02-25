<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Tugas</title>
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

                    <!-- Navigation -->
                    <nav class="space-y-1">
                      <a href="{{ url('/guru/dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Beranda
                      </a>
                      <a href="{{ url('/guru/materi') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Materi
                      </a>
                      <a href="{{ url('/guru/tugas') }}" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
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

        <!-- Content Area -->
        <div class="flex-1 p-4 md:p-6">
            <div class="flex justify-end mb-6">
                <button onclick="openTaskModal()" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md hover:bg-[#3da9ab]">
                    Tambah Tugas
                </button>
            </div>
            <!-- Header with slash -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-2xl font-semibold">Detail Tugas</div>
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="mr-2 text-sm text-gray-700 hover:text-[#49BBBD]">Home</a>
                    <span class="text-gray-400 mx-2">/</span>
                    <div class="text-sm text-gray-500">Detail Tugas</div>
                </div>
            </div>

            <!-- Dropdown Periode -->
            <div class="mb-4">
                <label for="periodSelect" class="block text-sm font-medium text-gray-700">Pilih Periode</label>
                <select id="periodSelect" name="period_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                    <option value="">Pilih Periode</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Kelas -->
            <div class="mb-4">
                <label for="classSelect" class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
                <select id="classSelect" name="class_model_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                    <option value="">Pilih Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->class }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Task Details -->
            <div id="taskDetails">
                @foreach ($tasks as $task)
                    <div class="task-item" data-class-id="{{ $task->class_model_id }}" style="display: none;">
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h3 class="font-semibold text-lg">{{ $task->title }}</h3>
                            <p class="text-gray-600">{{ $task->description }}</p>
                            <p class="text-gray-500">Waktu Tenggat : {{ $task->due_date }}</p>
                            @if ($task->due_date)
                                @php
                                    $dueDate = \Carbon\Carbon::parse($task->due_date)->endOfDay();
                                    $isPast = \Carbon\Carbon::now()->greaterThan($dueDate);
                                @endphp
                                @if ($isPast)
                                    <p class="text-red-500 font-semibold">Status: Waktu Sudah Habis</p>
                                @else
                                    <p class="text-green-500 font-semibold">Status: Waktu Berjalan</p>
                                @endif
                            @endif
                            @if ($task->file_path)
                                <a href="{{ asset('storage/' . $task->file_path) }}" class="text-blue-500 underline">Download File</a>
                            @endif
                            <div class="mt-2">
                                <button onclick="editTask({{ $task->id }})" class="text-yellow-500 hover:underline">Edit</button>
                                <a href="{{ route('guru.penilaian', $task->id) }}" class="text-blue-500 hover:underline">Beri Nilai</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- List of Other Tasks -->
            <div class="mt-6">
                <h4 class="font-semibold">Tugas Lainnya</h4>
                <ul class="list-disc pl-5" id="otherTasks">
                    @foreach ($tasks as $otherTask)
                        <li class="task-item" data-class-id="{{ $otherTask->class_model_id }}">
                            <a href="{{ route('task.details', $otherTask->id) }}" class="text-blue-500 hover:underline">{{ $otherTask->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tugas -->
    <div id="editTaskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl mx-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Edit Tugas</h2>
            </div>
            <form id="editTaskForm" action="{{ route('tasks.update', 'task_id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editTaskId" name="task_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="editTaskTitle" class="block text-sm font-medium text-gray-700">Tugas Anda</label>
                            <input placeholder="Judul" type="text" id="editTaskTitle" name="title" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD]">
                        </div>
                        <div>
                            <label for="editTaskDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea id="editTaskDescription" name="description" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD] h-32"></textarea>
                        </div>
                        <div>
                            <label for="editTaskFile" class="block text-sm font-medium text-gray-700">Upload File</label>
                            <input type="file" id="editTaskFile" name="file" class="border-2 border-dashed border-gray-300 rounded-lg p-4 w-full text-center">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                        <select id="editClassSelect" name="class_model_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div>
                            <label for="editTaskDueDate" class="block text-sm font-medium text-gray-700">Tenggat Waktu</label>
                            <input type="date" id="editTaskDueDate" name="due_date" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD] h-32">
                        </div>
                        <div>
                            <label for="editPeriodSelect" class="block text-sm font-medium text-gray-700">Pilih Periode</label>
                            <select id="editPeriodSelect" name="period_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                <option value="">Pilih Periode</option>
                                @foreach ($periods as $period)
                                    <option value="{{ $period->id }}">{{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md">Simpan</button>
                            <button type="button" onclick="closeEditTaskModal()" class="ml-2 text-gray-500 hover:text-gray-700">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add this modal HTML before closing body tag -->
    <div id="addTaskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl mx-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Tambah Tugas</h2>
                <button onclick="closeTaskModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <select name="subject_id" id="subject_id" class="form-select">
                    @foreach($user->subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Side -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm mb-2">Tugas Anda</h3>
                            <input type="text" id="taskTitle" name="title" placeholder="Judul" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD]">
                        </div>

                        <div>
                            <h3 class="text-sm mb-2">Deskripsi</h3>
                            <textarea id="taskDescription" name="description" placeholder="Deskripsi" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD] h-32"></textarea>
                        </div>
                        <div>
                            <h3 class="text-sm mb-2">File</h3>
                            <input type="file" id="taskFile" name="file" class="border-2 border-dashed border-gray-300 rounded-lg p-4 w-full text-center">
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm mb-2">Kelas</h3>
                            @if($classes->isEmpty())
                                <p>Tidak ada kelas yang tersedia.</p>
                            @else
                                <select id="classSelect" name="class_model_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD]" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->class }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm mb-2">Tenggat Waktu</h3>
                            <input type="date" id="taskDueDate" name="due_date" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD]" required>
                        </div>
                        <div>
                            <h3 class="text-sm mb-2">Pilih Periode</h3>
                            <select id="periodSelect" name="period_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD]">
                                <option value="">Pilih Periode</option>
                                @foreach ($periods as $period)
                                    <option value="{{ $period->id }}">{{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-[#49BBBD] text-white py-2 rounded-lg hover:bg-[#3da9ab]">
                        Tambah Tugas
                    </button>
                </div>
            </form>
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

        function openTaskModal() {
            const modal = document.getElementById('addTaskModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTaskModal() {
            const modal = document.getElementById('addTaskModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        document.getElementById('classSelect').addEventListener('change', function() {
            const selectedClassId = this.value;
            const tasks = document.querySelectorAll('.task-item');

            tasks.forEach(task => {
                task.style.display = 'none'; // Sembunyikan semua tugas
            });

            tasks.forEach(task => {
                if (selectedClassId === "" || task.getAttribute('data-class-id') === selectedClassId) {
                    task.style.display = 'block'; // Tampilkan tugas yang sesuai
                }
            });
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

        function editTask(taskId) {
            fetch(`/tasks/${taskId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editTaskId').value = data.id;
                    document.getElementById('editTaskTitle').value = data.title;
                    document.getElementById('editTaskDescription').value = data.description;
                    document.getElementById('editTaskDueDate').value = data.due_date;
                    document.getElementById('editClassSelect').value = data.class_model_id;
                    document.getElementById('editPeriodSelect').value = data.period_id;
                    document.getElementById('editTaskForm').action = `/tasks/${taskId}`;
                    document.getElementById('editTaskModal').classList.remove('hidden');
                });
        }

        function closeEditTaskModal() {
            document.getElementById('editTaskModal').classList.add('hidden');
        }
    </script>
</body>
</html>