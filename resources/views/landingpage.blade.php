<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    @include('partials.head')
    <script>
        (function() {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const dark = stored === 'dark' || (!stored && prefersDark);
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>
</head>
<body class="min-h-screen bg-white font-sans text-zinc-900 antialiased dark:bg-zinc-950 dark:text-white">
    <!-- Navbar Wrapper for Hide/Show Logic -->
    <div 
        x-data="{ 
            visible: true, 
            timeout: null,
            startTimeout() {
                this.stopTimeout();
                this.timeout = setTimeout(() => {
                    this.visible = false;
                }, 300000); // ditambahkan jika mau
            },
            stopTimeout() {
                clearTimeout(this.timeout);
                this.visible = true;
            },
            handleScroll() {
                this.stopTimeout();
                this.startTimeout();
            }
        }"
        x-init="startTimeout()"
        @scroll.window="handleScroll()"
        class="fixed top-0 left-0 right-0 z-50 transition-transform duration-500"
        :class="visible ? 'translate-y-0' : '-translate-y-full'"
    >
        <!-- Invisible trigger zone when hidden -->
        <div 
            class="absolute top-full left-0 right-0 h-4 cursor-pointer" 
            @mouseenter="stopTimeout()"
        ></div>

        <flux:header 
            @mouseenter="stopTimeout()"
            @mouseleave="startTimeout()"
            class="border-b border-zinc-200 bg-white/80 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-950/80"
        >
            <div class="container mx-auto px-4 lg:px-8">
                <flux:navbar>
                    <x-app-logo href="/" />
                    
                    <flux:spacer />

                    <flux:navbar.item href="#hero" class="hidden md:flex">{{ __('Home') }}</flux:navbar.item>
                    <flux:navbar.item href="#tentang" class="hidden md:flex">{{ __('Tentang') }}</flux:navbar.item>
                    <flux:navbar.item href="#unit" class="hidden md:flex">{{ __('Unit') }}</flux:navbar.item>
                    <flux:navbar.item href="#galeri" class="hidden md:flex">{{ __('Galeri') }}</flux:navbar.item>
                    <flux:navbar.item href="#kontak" class="hidden md:flex">{{ __('Kontak') }}</flux:navbar.item>

                    <flux:spacer />

                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="hidden md:flex shrink-0 rounded-full ring-2 ring-transparent transition-shadow hover:ring-zinc-300 dark:hover:ring-zinc-600" aria-label="{{ __('Profil') }}">
                                <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="h-9 w-9 rounded-full object-cover" />
                            </a>
                        @else
                            <flux:button href="{{ route('login') }}" variant="ghost" class="hidden md:flex">
                                {{ __('Login') }}
                            </flux:button>
                        @endauth
                        

                        {{-- Theme toggle: dark/light --}}
                        <button
                            type="button"
                            x-data="{ dark: false }"
                            x-init="dark = document.documentElement.classList.contains('dark'); $watch('dark', val => { document.documentElement.classList.toggle('dark', val); localStorage.setItem('theme', val ? 'dark' : 'light'); })"
                            @click="dark = !dark"
                            aria-label="Toggle dark mode"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                        >
                            <flux:icon x-show="!dark" icon="moon" class="size-5" />
                            <flux:icon x-show="dark" icon="sun" class="size-5" x-cloak />
                        </button>
                        
                        <flux:sidebar.toggle class="md:hidden" icon="bars-3" />
                    </div>
                </flux:navbar>
            </div>
        </flux:header>
    </div>

    <!-- Mobile Menu -->
    <flux:sidebar collapsible="mobile" class="md:hidden">
        <flux:sidebar.nav>
            <flux:sidebar.item href="#hero">{{ __('Home') }}</flux:sidebar.item>
            <flux:sidebar.item href="#tentang">{{ __('Tentang') }}</flux:sidebar.item>
            <flux:sidebar.item href="#unit">{{ __('Unit') }}</flux:sidebar.item>
            <flux:sidebar.item href="#poi">{{ __('Lokasi') }}</flux:sidebar.item>
            <flux:sidebar.item href="#kontak">{{ __('Kontak') }}</flux:sidebar.item>
            <flux:sidebar.item href="https://wa.me/6282136677730">{{ __('Booking Sekarang') }}</flux:sidebar.item>
            @auth
                <flux:sidebar.item href="{{ route('profile.edit') }}">{{ __('Profil') }}</flux:sidebar.item>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-3 py-2 text-start text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800" data-test="logout-button">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </li>
            @else
                <flux:sidebar.item href="{{ route('login') }}">{{ __('Login') }}</flux:sidebar.item>
            @endauth
        </flux:sidebar.nav>
    </flux:sidebar>

    <main>
    <!-- Hero Section -->
    <section id="hero" class="relative flex min-h-screen items-center justify-center overflow-hidden pt-16">
        <div class="absolute inset-0 z-0">
            <img src="/img/background2.png" alt="Kos Background" class="h-full w-full object-cover">
            {{-- Dark Overlay for better text readability --}}
            <div class="absolute inset-0 bg-black/50 dark:bg-zinc-950/70"></div>
            <div class="absolute inset-0 bg-linear-to-b from-black/20 via-transparent to-black/60 dark:from-zinc-950/40 dark:to-zinc-950/80"></div>
        </div>

        <div class="container relative z-10 mx-auto px-4 py-20 text-center lg:px-8">
            <flux:badge variant="primary" class="mb-6 uppercase tracking-widest bg-primary-600/20 text-primary-300 border-primary-500/30"></flux:badge>
            <flux:heading size="xl" class="mb-6 max-w-4xl mx-auto font-extrabold tracking-tight text-white lg:text-7xl">
                Kost Eksklusif <span class="text-primary-400">Serasa Hotel Berbintang</span>
            </flux:heading>
            <flux:text size="lg" class="mb-10 max-w-2xl mx-auto text-zinc-100 drop-shadow-md">
                Rasakan Kemewahan di Tengah Kehangatan Kota Satria. Kos Eksklusif di Banyumas yang memadukan kenyamanan modern dengan akses mudah ke destinasi wisata terbaik. Hunian asri untuk produktivitas maksimal.
            </flux:text>
            
            <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                <flux:button variant="primary" href="https://wa.me/6282136677730" icon-trailing="chevron-right" class="shadow-lg shadow-primary-600/30">
                    {{ __('Book Now') }}
                </flux:button>
                <flux:button variant="ghost" href="#tentang" class="text-primary-400! hover:bg-primary-400/10">
                    {{ __('Learn More') }}
                </flux:button>
            </div>
        </div>
    </section>

        <!-- About Us - Modern & Minimal -->
        <section id="tentang" class="py-28 lg:py-36 bg-white dark:bg-zinc-950">
            <div class="container mx-auto px-4 lg:px-8 max-w-6xl">
                <div class="grid items-center gap-16 lg:grid-cols-2 lg:gap-20">
                    <div class="lg:py-8">
                        <p class="mb-5 text-xs font-medium uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500">Tentang Kami</p>
                        <h2 class="mb-8 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl lg:text-[1.75rem] lg:leading-tight">
                            Kost Eksklusif di Kota Pelajar dan Kota Wisata Banyumas
                        </h2>
                        <div class="space-y-5 text-zinc-600 dark:text-zinc-400 text-[15px] leading-relaxed">
                            <p>
                                Hadirkan kesegaran baru setiap hari di hunian eksklusif kami. Dirancang sebagai tempat recharging terbaik di Banyumas, lokasi kami berada di area perumahan yang tenang dan asri, bebas dari polusi suara kendaraan.
                            </p>
                            <p>
                                Dengan sistem keamanan terpadu, Anda bisa beristirahat dengan nyaman dan fokus pada hal-hal yang menyenangkan. Seperti Banyumas Berhati Nyaman—bersih, sehat, indah, dan nyaman.
                            </p>
                        </div>
                        <ul class="mt-10 flex flex-wrap gap-x-10 gap-y-4 border-t border-zinc-200 pt-8 dark:border-zinc-800">
                            <li class="flex items-center gap-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800 text-primary-600 dark:text-primary-400">
                                    <flux:icon icon="sparkles" class="size-4" />
                                </span>
                                Bersih & Sehat
                            </li>
                            <li class="flex items-center gap-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800 text-primary-600 dark:text-primary-400">
                                    <flux:icon icon="shield-check" class="size-4" />
                                </span>
                                Keamanan 24 Jam
                            </li>
                        </ul>
                    </div>
                    <div class="relative" x-data="{ 
                        active: 0, 
                        images: [
                            '/img/facility.jpg',
                            '/img/facility.jpg',
                            '/img/facility.jpg'
                        ] 
                    }" x-init="setInterval(() => { active = (active + 1) % images.length }, 3000)">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-900">
                            <template x-for="(img, index) in images" :key="index">
                                <img 
                                    :src="img" 
                                    x-show="active === index" 
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    class="absolute inset-0 h-full w-full object-cover"
                                    alt="Fasilitas kos"
                                >
                            </template>
                            <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-1.5">
                                <template x-for="(img, index) in images" :key="index">
                                    <span :class="active === index ? 'w-5 bg-white' : 'w-1.5 bg-white/40'" class="h-1 rounded-full transition-all duration-300"></span>
                                </template>
                            </div>
                        </div>
                        <div class="absolute -bottom-4 -right-4 flex items-center gap-4 rounded-xl border border-zinc-200/80 bg-white/90 px-5 py-4 shadow-sm backdrop-blur-sm dark:border-zinc-800 dark:bg-zinc-900/90">
                            <span class="text-2xl font-semibold tabular-nums text-primary-600 dark:text-primary-400">5+</span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Tahun<br>Pengalaman</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Unit Kamar (1 jenis) -->
        <section id="unit" class="py-24 bg-white dark:bg-zinc-950">
            <div class="container mx-auto px-4 lg:px-8 max-w-5xl">
                <div class="mb-14 text-center">
                    <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500">Unit Kami</p>
                    <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl mt-10 ">Tipe Unit Kamar</h2>
                </div>

                @php
                    $unit = [
                        'name' => 'Kamar Standard',
                        'status' => 'Tersedia',
                        'status_full' => false,
                        'price' => '600.000',
                        'remaining' => 0, 
                        'size' => '3×6,5m',
                        'description' => 'Kamar nyaman dengan fasilitas lengkap untuk hunian harian Anda.',
                        'image' => '/img/foto_kamar.png',
                        'facilities' => [
                            ['icon' => 'signal', 'label' => 'WiFi'],
                            ['icon' => 'home', 'label' => 'Kamar Mandi Dalam'],
                        ],
                    ];
                @endphp

                <div class="grid gap-12 lg:grid-cols-2 lg:items-center mb-10">
                    <div class="relative aspect-[4/3] overflow-hidden bg-zinc-100 dark:bg-zinc-900">
                        <img src="{{ $unit['image'] }}" alt="{{ $unit['name'] }}" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <div class="mb-4 flex flex-wrap items-center gap-3">
                            <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $unit['name'] }}</h3>
                            @php
                                $isAvailable = isset($unit['remaining']) && $unit['remaining'] > 0;
                            @endphp
                            <span class="rounded-full px-3 py-1 text-xs font-medium {{ $isAvailable ? 'bg-primary-500/15 text-primary-600 dark:bg-primary-500/20 dark:text-primary-400' : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300' }}">
                                {{ $isAvailable ? $unit['status'] : 'Tidak tersedia' }}
                            </span>
                        </div>
                        <p class="mb-4 text-2xl font-semibold tabular-nums text-zinc-900 dark:text-white">
                            Rp{{ $unit['price'] }}<span class="text-lg font-normal text-zinc-500 dark:text-zinc-400">/bulan</span>
                        </p>
                        <p class="mb-1 text-sm text-zinc-500 dark:text-zinc-400">
                            @if (isset($unit['remaining']) && $unit['remaining'] > 0)
                                Sisa {{ $unit['remaining'] }} kamar tersedia
                            @else
                                Tidak tersedia
                            @endif
                            · Luas {{ $unit['size'] }}
                        </p>
                        @if (!empty($unit['description']))
                            <p class="mb-6 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                                {{ $unit['description'] }}
                            </p>
                        @endif
                        <ul class="mb-8 flex flex-wrap gap-x-6 gap-y-3">
                            @foreach ($unit['facilities'] as $f)
                                <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                    <flux:icon :icon="$f['icon']" class="size-4 text-zinc-400 dark:text-zinc-500" />
                                    <span>{{ $f['label'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="https://wa.me/6282136677730" class="inline-flex items-center justify-center rounded-lg bg-zinc-900 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                            Booking Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>

        

        <!-- Gallery -->
        <section id="galeri" class="py-24">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="mb-16 text-center">
                    <flux:badge variant="neutral" class="mb-4">GALERI</flux:badge>
                    <flux:heading size="lg">Foto Fasilitas Umum</flux:heading>
                </div>

                <div class="columns-1 gap-4 sm:columns-2 lg:columns-3">
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="img/foto_kamar.png" alt="Lobby" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="img/foto_kamar.png" alt="Parkiran" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="img/foto_kamar.png" alt="Parkiran" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="img/foto_kamar.png" alt="Parkiran" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="img/foto_kamar.png" alt="Parkiran" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="img/foto_kamar.png" alt="Parkiran" class="w-full transition-transform hover:scale-105">
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form -->
        <section id="kontak" class="py-24 bg-zinc-50 dark:bg-zinc-900/50">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2">
                    <div>
                        <flux:badge variant="neutral" class="mb-4">KONTAK</flux:badge>
                        <flux:heading size="lg" class="mb-6">Hubungi Kami</flux:heading>
                        <flux:text class="mb-8">Silakan isi formulir di samping atau hubungi kami melalui WhatsApp untuk informasi lebih lanjut dan reservasi.</flux:text>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <flux:icon icon="map-pin" class="mt-1 size-6 text-primary-600" />
                                <div>
                                    <div class="font-bold">Lokasi</div>
                                    <div class="text-zinc-500 dark:text-zinc-400">Jl. Kalimantan, Dabag, Condongcatur, Kec. Depok, Kabupaten Sleman, DIY 55281</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <flux:icon icon="phone" class="mt-1 size-6 text-primary-600" />
                                <div>
                                    <div class="font-bold">WhatsApp</div>
                                    <div class="text-zinc-500 dark:text-zinc-400">0853-2699-4413</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white p-8 shadow-xl dark:bg-zinc-800">
                        <form
                            class="space-y-6"
                            x-data="{ nama_lengkap: '', pesan: '' }"
                            @submit.prevent="const text = encodeURIComponent('Halo, nama saya ' + nama_lengkap + ', ' + pesan); window.open('https://wa.me/628532694413?text=' + text, '_blank')"
                        >
                            <flux:field>
                                <flux:label>Nama Lengkap</flux:label>
                                <flux:input name="nama_lengkap" placeholder="Masukkan nama Anda" x-model="nama_lengkap" />
                            </flux:field>
                            <flux:field>
                                <flux:label>Pesan</flux:label>
                                <flux:textarea name="pesan" placeholder="Apa yang ingin Anda tanyakan?" rows="4" x-model="pesan" />
                            </flux:field>
                            <flux:button type="submit" variant="primary" class="w-full">Kirim Pesan</flux:button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-zinc-200 bg-white py-12 dark:border-zinc-800 dark:bg-zinc-950">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid gap-12 md:grid-cols-4">
                <div class="md:col-span-2">
                    <x-app-logo class="mb-6" />
                    <flux:text class="mb-6 max-w-sm">Kos RoWwwWrRRR - Kost eksklusif yang memberikan spirit recharging buat hari-harimu makin menyenangkan.</flux:text>
                    <div class="flex gap-4">
                        <a href="#" class="text-zinc-400 hover:text-primary-600"><flux:icon icon="globe-alt" class="size-6" /></a>
                        <a href="#" class="text-zinc-400 hover:text-primary-600"><flux:icon icon="globe-asia-australia" class="size-6" /></a>
                        <a href="#" class="text-zinc-400 hover:text-primary-600"><flux:icon icon="globe-europe-africa" class="size-6" /></a>
                    </div>
                </div>
                <div>
                    <div class="mb-6 font-bold uppercase tracking-wider">Menu</div>
                    <ul class="space-y-4 text-zinc-500 dark:text-zinc-400">
                        <li><a href="#hero" class="hover:text-primary-600">Home</a></li>
                        <li><a href="#tentang" class="hover:text-primary-600">Tentang</a></li>
                        <li><a href="#unit" class="hover:text-primary-600">Unit</a></li>
                        <li><a href="#galeri" class="hover:text-primary-600">Galeri</a></li>
                    </ul>
                </div>
                <div>
                    <div class="mb-6 font-bold uppercase tracking-wider">Kontak</div>
                    <ul class="space-y-4 text-zinc-500 dark:text-zinc-400">
                        <li>Admin: 0853-2699-4413</li>
                        <li>Website: kosrowrrr.com</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-zinc-200 pt-8 text-center text-sm text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">
                &copy; {{ date('Y') }} Kos RoWwwWrRRR - by. Team Rowrrr.
            </div>
        </div>
    </footer>

    @fluxScripts
</body>
</html>
