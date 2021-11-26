<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/stylenav.css') }}">
</head>

<body>
    <div class="navigation">
        <div class="profiles">
            <div class="users">
                <ion-icon name="person-outline"></ion-icon>
            </div>
            <span class="name">{{ auth()->user()->name }}</span>
            <span class="name">({{ $jabatan }})</span>
            <br>
            <div class="line"></div>
        </div>
        <ul>
            @if (request()->routeIs('dashboard'))
            <li class="list active">
                @else
            <li class="list">
                @endif
                <b></b>
                <b></b>
                <a href="{{ route('dashboard') }}">
                    <span class="icon">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            {{-- @if (route('masuk')) --}}
            @if (request()->routeIs('surat_masuk') OR request()->routeIs('surat_masuk_kepsek') OR request()->routeIs('surat_masuk_waka'))
            <li class="list active">
                @else
            <li class="list">
                @endif
                <b></b>
                <b></b>
                @if (auth()->user()->level=='admin')
                <a href="{{ route('surat_masuk') }}">
                    <span class="icon">
                        <ion-icon name="mail-unread-outline"></ion-icon>
                    </span>
                    <span class="title">Surat Masuk</span>
                </a>
                @elseif (auth()->user()->level=='tata_usaha')
                <a href="{{ route('surat_masuk') }}">
                    <span class="icon">
                        <ion-icon name="mail-unread-outline"></ion-icon>
                    </span>
                    <span class="title">Surat Masuk</span>
                </a>
                @elseif (auth()->user()->level=='kepala_sekolah')
                <a href="{{ route('surat_masuk_kepsek') }}">
                    <span class="icon">
                        <ion-icon name="mail-unread-outline"></ion-icon>
                    </span>
                    <span class="title">Surat Masuk</span>
                </a>
                @elseif (auth()->user()->level=='disposisi')
                <a href="{{ route('surat_masuk_waka') }}">
                    <span class="icon">
                        <ion-icon name="mail-unread-outline"></ion-icon>
                    </span>
                    <span class="title">Surat Masuk</span>
                </a>
                @endif
            </li>

            </li>
            {{-- @if (route('surat_masuk')) --}}
            @if (request()->routeIs('disposisi'))
            <li class="list active">
                @else
            <li class="list">
                @endif
                <b></b>
                <b></b>
                <a href="{{ route('disposisi') }}">
                    <span class="icon">
                        <ion-icon name="newspaper-outline"></ion-icon>
                    </span>
                    <span class="title">Disposisi</span>
                </a>
            </li>
            {{-- @endif --}}
            @if (request()->routeIs('arsip') OR request()->routeIs('arsip') OR request()->routeIs('arsip'))
            <li class="list active">
                @else
            <li class="list">
                @endif
                <b></b>
                <b></b>
                <a href="{{ route('arsip') }}">
                    <span class="icon">
                        <ion-icon name="archive-outline"></ion-icon>
                    </span>
                    <span class="title">Arsip</span>
                </a>
            </li>

            <li class="list">
                <b></b>
                <b></b>
                <a href="{{ route('logout') }}">
                    <span class="icon">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </span>
                    <span class="title">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="toggle">
        <ion-icon name="menu-outline" class="open"></ion-icon>
        <ion-icon name="close-outline" class="close"></ion-icon>

    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('js/nav.js') }}">

    </script>
</body>

</html>
