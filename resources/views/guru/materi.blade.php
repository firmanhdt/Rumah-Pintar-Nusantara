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
                      <a href="{{url ('guru/jadwal')}}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-[#49BBBD] hover:text-white rounded-md">
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
                <div class="text-2xl font-semibold">Materi</div>
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="mr-2 text-sm text-gray-700 hover:text-[#49BBBD]">Home</a>
                    <span class="text-gray-400 mx-2">/</span>
                    <div class="text-sm text-gray-500">Materi</div>
                </div>
            </div>

            <!-- Upload Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold mb-2">Unggah Materi</h2>
                <p class="text-gray-600 mb-4">Silakan tambahkan materi pengajaran Anda di bawah ini.</p>
                <button id="uploadButton" class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Unggah Dokumen
                </button>
            </div>

            <!-- Dropdown Kelas -->
            <form method="GET" action="{{ route('materi.show') }}">
                <div class="mb-4">
                    <label for="classSelect" class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
                    <select id="classSelect" name="class_model_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]" onchange="this.form.submit()">
                        <option value="">Pilih Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_model_id') == $class->id ? 'selected' : '' }}>{{ $class->class }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <!-- Materials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($materials as $material)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4">
                            <h3 class="font-semibold mb-1">{{ $material->name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $material->description }}</p>
                            <div class="aspect-video bg-gray-100 rounded-lg mb-3 overflow-hidden">
                                <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="{{ $material->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex justify-between">
                                <button onclick="openEditModal({{ $material->id }})" class="text-[#49BBBD] hover:text-[#3da9ab] text-sm font-medium">Edit</button>
                                <button onclick="window.location='{{ route('preview.materi', $material->id) }}'" class="text-[#49BBBD] hover:text-[#3da9ab] text-sm font-medium">Lihat</button>
                                <form action="{{ route('materi.delete', $material->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    
    <!-- Modal Upload -->
    <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-semibold mb-4">Unggah Materi</h3>
                <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelajaran</label>
                        <input type="text" name="nama_pelajaran" class="w-full p-2 border border-gray-300 rounded-md focus:ring-[#49BBBD] focus:border-[#49BBBD]" placeholder="Judul" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:ring-[#49BBBD] focus:border-[#49BBBD]" placeholder="Deskripsi" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="class_model_id" class="w-full p-2 border border-gray-300 rounded-md focus:ring-[#49BBBD] focus:border-[#49BBBD]" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                        <select name="subject_id" id="subject_id" class="w-full p-2 border border-gray-300 rounded-md focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                            @foreach($user->subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                        <input type="file" name="thumbnail" class="border-2 border-dashed border-gray-300 rounded-md p-4 w-full text-center" accept="image/*">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Materi</label>
                        <input type="file" name="file" class="border-2 border-dashed border-gray-300 rounded-md p-4 w-full text-center" accept=".pdf,.doc,.docx">
                    </div>

                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md hover:bg-[#3da9ab]">Unggah</button>
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-white text-gray-600 border border-gray-300 rounded-md hover:bg-red-500 hover:text-white">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Materi -->
    @foreach ($materials as $material)
    <div id="editMaterialModal{{ $material->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-semibold mb-4">Edit Materi</h3>
                <form action="{{ route('materi.update', $material->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_nama_pelajaran" class="block text-sm font-medium text-gray-700">Nama Pelajaran</label>
                        <input type="text" name="nama_pelajaran" id="edit_nama_pelajaran" value="{{ $material->name }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]" required>{{ $material->description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="edit_class_model_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select id="edit_class_model_id" name="class_model_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]" required>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ $material->class_model_id == $class->id ? 'selected' : '' }}>{{ $class->class }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="edit_subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                        <select id="edit_subject_id" name="subject_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]" required>
                            @foreach($user->subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="edit_thumbnail" class="block text-sm font-medium text-gray-700">Thumbnail</label>
                        <input type="file" name="thumbnail" id="edit_thumbnail" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                    </div>
                    <div class="mb-4">
                        <label for="edit_file" class="block text-sm font-medium text-gray-700">File Materi</label>
                        <input type="file" name="file" id="edit_file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#49BBBD] focus:border-[#49BBBD]">
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-[#49BBBD] text-white px-4 py-2 rounded-md hover:bg-[#3da9ab]">Update Materi</button>
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-white text-gray-600 border border-gray-300 rounded-md hover:bg-red-500 hover:text-white">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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

        // File Upload Preview
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const previewArea = document.getElementById('previewArea');
            previewArea.innerHTML = '';

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'flex items-center justify-between bg-gray-50 p-2 rounded';
                    preview.innerHTML = `
                        <div class="flex items-center">
                            <img src="${file.type === 'application/pdf' ? '/path/to/pdf-icon.png' : e.target.result}"
                                 class="w-8 h-8 object-cover rounded mr-2">
                            <div>
                                <p class="text-sm text-gray-700">${file.name}</p>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                    <div class="bg-[#49BBBD] h-1.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        <button onclick="removeFile(${index})" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    `;
                    previewArea.appendChild(preview);
                }
                reader.readAsDataURL(file);
            });
        });

        // Remove File
        function removeFile(index) {
            const input = document.getElementById('fileInput');
            const dt = new DataTransfer();
            const { files } = input;

            for (let i = 0; i < files.length; i++) {
                if (i !== index) dt.items.add(files[i]);
            }

            input.files = dt.files;
            const previewItems = document.getElementById('previewArea').children;
            if (previewItems[index]) previewItems[index].remove();
        }

        function openEditModal(materialId) {
            // Sembunyikan semua modal terlebih dahulu
            const modals = document.querySelectorAll('[id^="editMaterialModal"]');
            modals.forEach(modal => modal.classList.add('hidden'));

            // Tampilkan modal yang sesuai
            document.getElementById('editMaterialModal' + materialId).classList.remove('hidden');
        }

        function closeEditModal() {
            // Sembunyikan semua modal terlebih dahulu
            const modals = document.querySelectorAll('[id^="editMaterialModal"]');
            modals.forEach(modal => modal.classList.add('hidden'));
        }
    </script>
</body>
</html>
