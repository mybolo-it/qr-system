@extends('layouts.app')

@section('title', 'Input Data Baru')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fe;
        }

        .glass-form {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateX(5px);
        }
    </style>

    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="mb-8 animate__animated animate__fadeInDown">
            <h1 class="text-3xl font-extrabold text-gray-800">
                <span class="text-indigo-600">Manajemen</span> Data
            </h1>
            <p class="text-gray-500 text-sm mt-1">Isi formulir di bawah untuk membuat data baru dan generate QR Code
                otomatis.</p>
        </div>

        <div class="glass-form rounded-3xl shadow-2xl overflow-hidden animate__animated animate__fadeInUp">
            <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500"></div>

            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data"
                class="p-8 md:p-10 space-y-6">
                @csrf

                <div class="group">
                    <label for="nama"
                        class="block text-sm font-semibold text-gray-600 mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">
                        Nama Data / Judul
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        class="input-focus w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white @error('nama') border-red-500 @enderror"
                        placeholder="Contoh: Laporan Inventaris Tahunan">
                    @error('nama')
                        <p class="text-red-500 text-xs italic mt-2 animate__animated animate__headShake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="group">
                    <label for="letterhead"
                        class="block text-sm font-semibold text-gray-600 mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">
                        Nomor Surat
                    </label>
                    <textarea name="letterhead" id="letterhead" rows="3"
                        class="input-focus w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white @error('letterhead') border-red-500 @enderror"
                        placeholder="Tuliskan Nomor surat / header dokumen...">{{ old('letterhead') }}</textarea>
                    @error('letterhead')
                        <p class="text-red-500 text-xs italic mt-2 animate__animated animate__headShake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="group">
                    <label for="deskripsi"
                        class="block text-sm font-semibold text-gray-600 mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">
                        Deskripsi Lengkap
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="input-focus w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white @error('deskripsi') border-red-500 @enderror"
                        placeholder="Berikan penjelasan singkat mengenai data ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs italic mt-2 animate__animated animate__headShake">{{ $message }}</p>
                    @enderror
                </div>

                

                <div class="group">
                    <label
                        class="block text-sm font-semibold text-gray-600 mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">
                        Lampiran File
                    </label>
                    <div
                        class="relative border-2 border-dashed border-gray-200 rounded-2xl p-6 hover:border-indigo-400 hover:bg-indigo-50/50 transition-all duration-300 text-center">
                        <input type="file" name="file" id="file" required
                            accept=".jpg,.jpeg,.png,.gif,.bmp,.webp,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip,.rar"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-2">
                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors"
                                stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="text-sm text-gray-600" id="file-name">Klik atau seret file ke sini</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest">
                                Maksimal 5MB (JPG, PNG, GIF, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, ZIP, RAR)
                            </p>
                        </div>
                    </div>
                    @error('file')
                        <p class="text-red-500 text-xs italic mt-2 animate__animated animate__headShake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex flex-col md:flex-row gap-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-emerald-200 hover:shadow-emerald-400 hover:-translate-y-1 transition duration-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Simpan & Generate QR
                    </button>
                    <a href="{{ route('home') }}"
                        class="flex-none md:w-32 bg-gray-100 text-gray-500 font-bold py-4 px-6 rounded-2xl hover:bg-gray-200 text-center transition">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('file').onchange = function() {
            let name = this.files[0].name;
            document.getElementById('file-name').innerHTML = "File terpilih: <span class='text-indigo-600 font-bold'>" +
                name + "</span>";
        };
    </script>
@endsection
