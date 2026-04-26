@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    @php use Illuminate\Support\Facades\Crypt; @endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        /* Menyamakan Background dengan halaman Dokumen Anda */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fe !important;
            /* Warna sesuai request */
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Animasi Staggered */
        .stagger-item {
            opacity: 0;
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Manual Stagger Delay */
        .stagger-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stagger-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stagger-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stagger-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stagger-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        /* Responsive Card Mode untuk HP */
        @media (max-width: 768px) {
            .hide-on-mobile {
                display: none;
            }

            .table-responsive-stack thead {
                display: none;
            }

            .table-responsive-stack tr {
                display: block;
                margin-bottom: 1.5rem;
                border-radius: 1.5rem;
                background: white;
                padding: 1.25rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
                border: 1px solid #f1f5f9;
            }

            .table-responsive-stack td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0.5rem;
                border-bottom: 1px solid #f3f4f6;
                width: 100%;
            }

            .table-responsive-stack td:last-child {
                border-bottom: none;
            }

            .table-responsive-stack td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #6366f1;
                text-align: left;
                font-size: 0.75rem;
                text-transform: uppercase;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-6 md:py-10">
        <div class="mb-8 animate__animated animate__fadeInDown">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">
                        Manajemen <span class="text-indigo-600">User</span>
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola hak akses dan kontrol pengguna sistem.</p>
                </div>
                <div>
                    <a href="{{ route('users.create') }}"
                        class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-2xl text-sm font-bold shadow-lg shadow-indigo-100 hover:scale-105 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah User
                    </a>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden border border-white">
            <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500"></div>

            <div class="p-4 md:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-responsive-stack">
                        <thead class="hide-on-mobile">
                            <tr class="border-b border-gray-100">
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">No</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Nama</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Email</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Role</th>
                                <th class="px-6 py-5 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($users as $index => $user)
                                @php $encryptedId = Crypt::encrypt($user->id); @endphp
                                <tr class="stagger-item group hover:bg-indigo-50/30 transition-all duration-300">
                                    <td data-label="No" class="px-6 py-4 md:py-6 text-sm text-gray-400 font-medium">
                                        {{ $users->firstItem() + $index }}
                                     </td>
                                    <td data-label="Nama" class="px-6 py-4 md:py-6">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs mr-3">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $user->name }}</span>
                                        </div>
                                     </td>
                                    <td data-label="Email" class="px-6 py-4 md:py-6 text-sm text-gray-500">
                                        {{ $user->email }}
                                     </td>
                                    <td data-label="Role" class="px-6 py-4 md:py-6">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                            {{ $user->role == 'superadmin' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                            {{ $user->role }}
                                        </span>
                                     </td>
                                    <td data-label="Opsi" class="px-6 py-4 md:py-6 text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('users.edit', $encryptedId) }}"
                                                class="text-indigo-500 hover:text-indigo-700 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $encryptedId) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="button" onclick="confirmDelete('{{ $user->id }}')" class="text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data user tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6366f1', // Indigo-600
            cancelButtonColor: '#f4f7fe',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem] border-none shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold',
                cancelButton: 'rounded-xl px-6 py-3 font-bold text-gray-500'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        })
    }
</script>
