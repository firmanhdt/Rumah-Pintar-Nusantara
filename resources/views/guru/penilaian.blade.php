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

        <!-- Content Area -->
        <div class="flex-1 p-4 md:p-6">
            <!-- Header with slash -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-2xl font-semibold">Penilaian</div>
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="mr-2 text-sm text-gray-700 hover:text-[#49BBBD]">Home</a>
                    <span class="text-gray-400 mx-2">/</span>
                    <div class="text-sm text-gray-500">Beri Nilai</div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text"
                           placeholder="Search.."
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD]">
                    <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Debugging: Tampilkan jumlah siswa -->
            <p>Total Siswa: {{ $students->count() }}</p>

            @if ($students->isEmpty())
                <p class="text-red-500">Tidak ada murid yang memenuhi kriteria.</p>
            @endif

            <!-- Student List -->
            <div class="space-y-4">
                @foreach($students as $student)
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <h3 class="font-semibold">{{ $student->name }}</h3>
                                    <p class="text-sm text-gray-500">Kelas: {{ $student->classModel->class }}</p>
                                    
                                    <!-- Cek apakah siswa telah mengumpulkan tugas -->
                                    @php
                                        $submission = $task->submissions->firstWhere('user_id', $student->id);
                                    @endphp

                                    @if ($submission)
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" class="text-blue-500 hover:underline" target="_blank">Lihat Jawaban</a>
                                    @else
                                        <p class="text-red-500">Belum mengumpulkan tugas</p> <!-- Informasi jika belum mengumpulkan -->
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                @if ($submission)
                                    <div class="text-sm text-gray-500 mb-2">Tanggal Pengumpulan: {{ $submission->created_at->format('d M Y') }}</div>
                                    
                                    <!-- Menampilkan hasil dan komentar jika sudah ada -->
                                    @if ($submission->grade !== null)
                                        <div class="text-sm text-gray-600">
                                            <p>Hasil: {{ $submission->grade }}</p>
                                            <p>Komentar: {{ $submission->comment ?? 'Tidak ada komentar' }}</p>
                                        </div>
                                    @else
                                        <!-- Form untuk memberikan nilai -->
                                        <form action="{{ route('guru.gradeSubmission', $task->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="submission_id" value="{{ $submission->id }}">
                                            <div class="flex items-center">
                                                <input type="number" name="grade" class="border border-gray-300 rounded-md px-2 py-1" placeholder="Nilai" required>
                                                <input type="text" name="comment" class="border border-gray-300 rounded-md px-2 py-1 ml-2" placeholder="Komentar (opsional)">
                                                <button type="submit" class="bg-[#49BBBD] text-white px-4 py-1 rounded-md hover:bg-[#3da9ab] ml-2">Beri Nilai</button>
                                            </div>
                                        </form>
                                    @endif
                                @else
                                    <p class="text-red-500">Belum mengumpulkan tugas</p> <!-- Informasi jika belum mengumpulkan -->
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Grading Modal -->
    <div id="gradingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h2 class="text-xl font-semibold mb-4">Beri Nilai</h2>

            <!-- Grade Input -->
            <div class="mb-4">
                <input type="number" id="gradeInput" placeholder="100" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD]" max="100" min="0">
            </div>

            <!-- Comment Input -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Komentar</label>
                <textarea id="commentInput" placeholder="Execelent" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#49BBBD] h-32"></textarea>
            </div>

            <!-- Buttons -->
            <div class="space-y-2">
                <button onclick="submitGrade()" class="w-full bg-[#49BBBD] text-white py-2 rounded-lg hover:bg-[#3da9ab]">
                    SELESAI
                </button>
                <button onclick="closeGradingModal()" class="w-full border border-[#49BBBD] text-[#49BBBD] py-2 rounded-lg hover:bg-gray-50">
                    BATAL
                </button>
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

        // Grading Modal Functions
        let currentSubmissionId;

        function openGradingModal(submissionId) {
            currentSubmissionId = submissionId; // Simpan ID pengumpulan saat ini
            const modal = document.getElementById('gradingModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeGradingModal() {
            const modal = document.getElementById('gradingModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function submitGrade() {
            const grade = document.getElementById('gradeInput').value;
            const comment = document.getElementById('commentInput').value;

            // Kirim data ke server untuk menyimpan nilai
            fetch(`/penilaian/${currentSubmissionId}/grade`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ grade, comment })
            })
            .then(response => response.json())
            .then(data => {
                // Update UI sesuai dengan respons
                closeGradingModal();
                // Tambahkan logika untuk memperbarui tampilan jika perlu
            });
        }

        // Close modal when clicking outside
        document.getElementById('gradingModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('gradingModal')) {
                closeGradingModal();
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