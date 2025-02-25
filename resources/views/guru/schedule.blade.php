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
            <button id="mobileMenuBtn" class="md:hidden fixed bottom-4 right-4 hover:bg-[#49BBBD] text-white p-3 rounded-full shadow-lg z-50">
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
                        <a href="/guru/materi" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
                          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                          </svg>
                          Materi
                        </a>
                        <a href="/guru/tugas" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
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
                        <a href="{{route('show.schedule')}}" class="flex items-center px-4 py-2 text-white bg-[#49BBBD] hover:text-gray-700 rounded-md">
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
            <!-- Header with Add Button -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Calendar</h2>
                <button id="openModal" class="bg-[#49BBBD] hover:bg-[#3da9ab] text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Jadwal
                </button>
            </div>

            <!-- Calendar Section -->
            <div class="bg-white rounded-2xl p-6">
                <!-- Calendar Header -->
                <div class="flex items-center gap-4">
                    <h2 class="text-xl font-semibold">
                        Calendar {{ \Carbon\Carbon::createFromDate(request('year', now()->year), request('month', now()->month), 1)->translatedFormat('F Y') }}
                    </h2>
                    <form action="{{ route('show.schedule') }}" method="GET" class="flex items-center">
                        <select name="month" class="text-lg font-medium bg-transparent" onchange="this.form.submit()">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == request('month', now()->month) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" class="text-lg font-medium bg-transparent" onchange="this.form.submit()">
                            @for ($y = now()->year - 5; $y <= now()->year + 5; $y++)
                                <option value="{{ $y }}" {{ $y == request('year', now()->year) ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>

                <!-- Calendar Grid -->
                <div class="border rounded-lg">
                    <!-- Calendar Days Header -->
                    <div class="grid grid-cols-7 border-b">
                        <div class="py-2 px-3 text-center text-sm font-medium">Minggu</div>
                        <div class="py-2 px-3 text-center text-sm font-medium">Senin</div>
                        <div class="py-2 px-3 text-center text-sm font-medium">Selasa</div>
                        <div class="py-2 px-3 text-center text-sm font-medium">Rabu</div>
                        <div class="py-2 px-3 text-center text-sm font-medium">Kamis</div>
                        <div class="py-2 px-3 text-center text-sm font-medium">Jumat</div>
                        <div class="py-2 px-3 text-center text-sm font-medium">Sabtu</div>
                    </div>

                    <!-- Calendar Days Grid -->
                    <div class="grid grid-cols-7" id="calendarDays">
                        @php
                            // Mendapatkan bulan dan tahun dari request atau menggunakan bulan dan tahun saat ini
                            $month = request('month', now()->month);
                            $year = request('year', now()->year);
                            $currentDate = \Carbon\Carbon::createFromDate($year, $month, 1);
                            $daysInMonth = $currentDate->daysInMonth;
                            $firstDayOfMonth = $currentDate->dayOfWeek; // Hari pertama bulan ini
                            $dayCount = 1;

                            // Mengisi grid dengan hari-hari
                            for ($i = 0; $i < 6; $i++) { // 6 baris untuk 6 minggu
                                for ($j = 0; $j < 7; $j++) { // 7 kolom untuk 7 hari
                                    if ($i === 0 && $j < $firstDayOfMonth) {
                                        echo '<div class="py-2 px-3 text-center text-sm"></div>'; // Kosongkan hari sebelum hari pertama bulan
                                    } elseif ($dayCount > $daysInMonth) {
                                        echo '<div class="py-2 px-3 text-center text-sm"></div>'; // Kosongkan hari setelah hari terakhir bulan
                                    } else {
                                        // Cek apakah ada jadwal untuk hari ini
                                        $dateString = $currentDate->copy()->day($dayCount)->toDateString();
                                        $schedulesForDay = $schedule->filter(function ($item) use ($dateString) {
                                            return $item->date === $dateString;
                                        });

                                        // Tampilkan hari dan jadwal
                                        echo '<div class="py-2 px-3 text-center text-sm">';
                                        echo $dayCount;
                                        if ($schedulesForDay->isNotEmpty()) {
                                            foreach ($schedulesForDay as $scheduleItem) {
                                                echo '<div class="text-xs mt-1 bg-[#FFF4EA]">' . $scheduleItem->class->class . ' - ' . $scheduleItem->subject->name . '</div>';
                                                echo '<div class="text-xs mt-1 bg-[#FFF4EA]">Mulai: ' . $scheduleItem->start_time . ' - Akhir: ' . $scheduleItem->end_time . '</div>'; // Tampilkan jam
                                                // echo '<div class="flex justify-center mt-1">';
                                                // echo '<button class="text-blue-500 edit-schedule" data-id="' . $scheduleItem->id . '">Edit</button>';
                                                // echo '<form action="' . route('schedules.destroy', $scheduleItem->id) . '" method="POST" class="inline ml-2">';
                                                // echo '<button type="submit" class="text-red-500">Hapus</button>';
                                                // echo '</form>';
                                                // echo '</div>';
                                            }
                                        }
                                        echo '</div>';
                                        $dayCount++;
                                    }
                                }
                            }
                        @endphp
                    </div>
                </div>
            </div>

            <!-- Modal for Creating Schedule -->
            <div id="scheduleModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-lg p-6 w-1/3">
                    <h3 class="text-lg font-semibold mb-4">Tambah Jadwal</h3>
                    <form action="{{ url('/api/schedule') }}" method="POST">
                        @csrf <!-- Token untuk keamanan -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium">Tanggal</label>
                            <input type="date" id="date" name="date" class="mt-1 block w-full border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="class" class="block text-sm font-medium">Kelas</label>
                            <select id="class" name="class" class="mt-1 block w-full border rounded-lg" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium">Subject</label>
                            <select id="subject" name="subject" class="mt-1 block w-full border rounded-lg" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($user->subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                 @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="start_time" class="block text-sm font-medium">Waktu Mulai</label>
                            <input type="time" id="start_time" name="start_time" class="mt-1 block w-full border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="end_time" class="block text-sm font-medium">Waktu Akhir</label>
                            <input type="time" id="end_time" name="end_time" class="mt-1 block w-full border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium">Keterangan</label>
                            <textarea id="description" name="description" class="mt-1 block w-full border rounded-lg" rows="3"></textarea>
                        </div>
                        <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-lg">Submit</button>
                        <button type="button" id="closeModal" class="px-3 py-1 bg-red-500 text-white rounded-lg" onclick="document.getElementById('scheduleModal').classList.add('hidden');">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Modal for Editing Schedule -->
            {{-- <div id="editScheduleModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-lg p-6 w-1/3">
                    <h3 class="text-lg font-semibold mb-4">Edit Schedule</h3>
                    <form action="{{ route('schedules.update', '') }}" method="POST" id="editScheduleForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="edit_schedule_id" name="schedule_id">
                        <div class="mb-4">
                            <label for="edit_date" class="block text-sm font-medium">Date</label>
                            <input type="date" id="edit_date" name="date" class="mt-1 block w-full border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="edit_class_id" class="block text-sm font-medium">Class</label>
                            <select id="edit_class_id" name="class_id" class="mt-1 block w-full border rounded-lg" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="edit_subject_id" class="block text-sm font-medium">Subject</label>
                            <select id="edit_subject_id" name="subject_id" class="mt-1 block w-full border rounded-lg" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="edit_start_time" class="block text-sm font-medium">Start Time</label>
                            <input type="time" id="edit_start_time" name="start_time" class="mt-1 block w-full border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="edit_end_time" class="block text-sm font-medium">End Time</label>
                            <input type="time" id="edit_end_time" name="end_time" class="mt-1 block w-full border rounded-lg" required>
                        </div>
                        <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-lg">Update</button>
                        <button type="button" id="closeEditModal" class="px-3 py-1 bg-red-500 text-white rounded-lg" onclick="document.getElementById('editScheduleModal').classList.add('hidden');">Cancel</button>
                    </form>
                </div>
            </div> --}}
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

        // Open Modal
        document.getElementById('openModal').onclick = function() {
            document.getElementById('scheduleModal').classList.remove('hidden');
        };

        // Close Modal
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('scheduleModal').classList.add('hidden');
        };

        // Handle Form Submission
        document.getElementById('scheduleForm').onsubmit = function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('/api/schedule', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Schedule created successfully!');
                    // Optionally, refresh the calendar or update the UI
                    addScheduleToCalendar(formData.get('date'), formData.get('subject'), formData.get('class'));
                    document.getElementById('scheduleModal').classList.add('hidden');
                } else {
                    alert('Error creating schedule.');
                }
            });
        };

        function addScheduleToCalendar(date, subject, classId) {
            const calendarDays = document.getElementById('calendarDays');
            const dayElement = document.createElement('div');
            dayElement.className = 'min-h-[120px] p-2 border-b border-r';
            dayElement.innerHTML = `
                <span class="text-sm">${new Date(date).getDate()}</span>
                <div class="mt-1 bg-[#FFF4EA] rounded p-2 text-xs">
                    <div class="font-medium">${subject}</div>
                    <div class="text-gray-600">Class ID: ${classId}</div>
                </div>
            `;
            calendarDays.appendChild(dayElement);
        }

        // document.addEventListener('DOMContentLoaded', function () {
        //     const editLinks = document.querySelectorAll('.edit-schedule');
        //     const editModal = document.getElementById('editScheduleModal');
        //     const editForm = document.getElementById('editScheduleForm');

        //     editLinks.forEach(link => {
        //         link.addEventListener('click', function (e) {
        //             e.preventDefault();
        //             const scheduleId = this.getAttribute('data-id');

        //             // Fetch schedule data from the server
        //             fetch(`/schedules/${scheduleId}/edit`)
        //                 .then(response => response.json())
        //                 .then(data => {
        //                     // Populate the form with the fetched data
        //                     document.getElementById('edit_schedule_id').value = data.id;
        //                     document.getElementById('edit_date').value = data.date;
        //                     document.getElementById('edit_class_id').value = data.class_id;
        //                     document.getElementById('edit_subject_id').value = data.subject_id;
        //                     document.getElementById('edit_start_time').value = data.start_time;
        //                     document.getElementById('edit_end_time').value = data.end_time;

        //                     // Set the action for the form
        //                     document.getElementById('editScheduleForm').action = `/guru/schedule/${data.id}`;

        //                     // Show the modal
        //                     editModal.classList.remove('hidden');
        //                 });
        //         });
        //     });
        // });
    </script>

    <style>
        /* Optional: Add custom styles for the calendar */
        .calendar-event {
            background-color: #FFF4EA;
            border-radius: 0.375rem;
            padding: 0.5rem;
            margin-top: 0.25rem;
        }
    </style>
</body>
</html>