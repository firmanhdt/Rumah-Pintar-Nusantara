<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Pelajaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div>
                        <!-- Nama Pelajaran Dropdown -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Pelajaran
                            </label>
                            <div class="relative">
                                <select name="nama_pelajaran"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#49BBBD] appearance-none bg-white">
                                    <option value="" disabled selected>Pilih Pelajaran</option>
                                    <option value="matematika">Matematika</option>
                                    <option value="bahasa_inggris">Bahasa Inggris</option>
                                    <option value="calistung">Calistung</option>
                                </select>
                                <!-- Dropdown Arrow -->
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea
                                name="deskripsi"
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#49BBBD]"
                                placeholder="Pelajari Tentang Statistika"></textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Thumbnail
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg" id="dropZone">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer rounded-md font-medium text-[#49BBBD] hover:text-[#3da9ab] focus-within:outline-none">
                                        <span>Seret gambar Anda ke sini, atau telusuri</span>
                                        <input type="file" name="thumbnail" class="sr-only" id="thumbnail" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">
                                    JPG, PNG, PDF
                                </p>
                            </div>
                        </div>

                        <!-- Preview Container -->
                        <div id="preview-container" class="mt-4 space-y-2 hidden"></div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 mt-6">
                    <button type="submit" class="px-4 py-2 bg-[#49BBBD] text-white rounded hover:bg-[#49BBBD] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#49BBBD]">
                        PERBARUI
                    </button>
                    <button type="button" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        BATAL
                    </button>
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        HAPUS
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const thumbnailInput = document.getElementById('thumbnail');
        const previewContainer = document.getElementById('preview-container');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-[#49BBBD]', 'bg-blue-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-[#49BBBD]', 'bg-blue-50');
        }

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        thumbnailInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            previewContainer.innerHTML = '';
            previewContainer.classList.remove('hidden');

            [...files].forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';

                    previewItem.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <img src="${e.target.result}" class="h-12 w-12 object-cover rounded">
                            <div>
                                <p class="text-sm font-medium text-gray-900">${file.name}</p>
                                <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="h-1.5 w-24 bg-[#49BBBD] rounded"></div>
                            <svg class="w-5 h-5 text-[#49BBBD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    `;

                    previewContainer.appendChild(previewItem);
                };

                reader.readAsDataURL(file);
            });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html>