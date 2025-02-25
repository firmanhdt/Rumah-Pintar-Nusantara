<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rumah Pintar Nusantara</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Ulang Tahun:</strong> {{ $user->birth_date }}</p>
        <p><strong>Nomor HP:</strong> {{ $user->phone_number }}</p>
        <p><strong>Kelas:</strong> {{ $user->class }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>

        <h2>Mata Pelajaran yang Diajarkan:</h2>
        <ul>
            @if($subjects->isEmpty())
                <li>Tidak ada mata pelajaran yang diajarkan.</li>
            @else
                @foreach($subjects as $subject)
                    <li>{{ $subject->name }}</li>
                @endforeach
            @endif
        </ul>

        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-200">
                Logout
            </button>
        </form>
    </div>
</body>
</html> 