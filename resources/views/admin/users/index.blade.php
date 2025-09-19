<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Pengguna</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama/email" class="border rounded p-2 w-72">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Cari</button>
        </form>

        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="text-left border-b">
                    <th class="p-2">ID</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $u)
                    <tr class="border-b">
                        <td class="p-2">{{ $u->id }}</td>
                        <td class="p-2">{{ $u->name }}</td>
                        <td class="p-2">{{ $u->email }}</td>
                        <td class="p-2 uppercase">{{ $u->role }}</td>
                        <td class="p-2">
                            @if (auth()->id() !== $u->id)
                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Hapus</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-500">Akun sendiri</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-admin-layout>

