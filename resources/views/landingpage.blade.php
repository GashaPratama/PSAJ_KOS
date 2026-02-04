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
                    <flux:navbar.item href="#poi" class="hidden md:flex">{{ __('Lokasi') }}</flux:navbar.item>
                    <flux:navbar.item href="#kontak" class="hidden md:flex">{{ __('Kontak') }}</flux:navbar.item>

                    <flux:spacer />

                    <div class="flex items-center gap-4">
                        @auth
                            <flux:button href="{{ route('dashboard') }}" variant="ghost" class="hidden md:flex">
                                {{ __('Dashboard') }}
                            </flux:button>
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
        </flux:sidebar.nav>
    </flux:sidebar>

    <main>
    <!-- Hero Section -->
    <section id="hero" class="relative flex min-h-screen items-center justify-center overflow-hidden pt-16">
        <div class="absolute inset-0 z-0">
            <img src="/img/background.jpeg" alt="Kos Background" class="h-full w-full object-cover">
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

        <!-- About Us -->
        <section id="tentang" class="py-24 bg-zinc-50 dark:bg-zinc-900/50">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div>
                        <flux:badge variant="neutral" class="mb-4">TENTANG KAMI</flux:badge>
                        <flux:heading size="xl" class="mb-6 text-2xl font-bold lg:text-3xl">Kost Eksklusif di Kota Pelajar dan Kota Wisata Banyumas</flux:heading>
                        <flux:text class="mb-6 leading-relaxed">
                        Hadirkan kesegaran baru setiap hari di hunian eksklusif kami. Dirancang sebagai tempat recharging terbaik di Banyumas, lokasi kami berada di area perumahan yang tenang dan asri, bebas dari polusi suara kendaraan. Dengan sistem keamanan terpadu, Anda bisa beristirahat dengan nyaman dan fokus pada hal-hal yang menyenangkan.
                        </flux:text>
                        <flux:text class="mb-8 leading-relaxed">
                            Seperti Banyumas Berhati Nyaman, Kos Eksklusif RoWwwWrRRR bersih, sehat, indah, and nyaman.
                        </flux:text>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/30">
                                    <flux:icon icon="sparkles" class="size-5" />
                                </div>
                                <span class="font-medium">Bersih & Sehat</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/30">
                                    <flux:icon icon="shield-check" class="size-5" />
                                </div>
                                <span class="font-medium">Keamanan 24 Jam</span>
                            </div>
                        </div>
                    </div>
                    <div class="relative group" x-data="{ 
                        active: 0, 
                        images: [
                            '/img/facility.jpg',
                            '/img/facility.jpg',
                            '/img/facility.jpg'
                        ] 
                    }" x-init="setInterval(() => { active = (active + 1) % images.length }, 3000)">
                        <div class="relative aspect-4/3 overflow-hidden rounded-2xl shadow-2xl">
                            <template x-for="(img, index) in images" :key="index">
                                <img 
                                    :src="img" 
                                    x-show="active === index" 
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0 scale-105"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="absolute inset-0 h-full w-full object-cover"
                                >
                            </template>
                            
                            <!-- Navigation -->
                            <div class="absolute inset-0 flex items-center justify-between px-4 opacity-0 transition-opacity group-hover:opacity-100">
                                <button @click="active = active === 0 ? images.length - 1 : active - 1" class="rounded-full bg-black/20 p-2 text-white backdrop-blur-md hover:bg-black/40">
                                    <flux:icon icon="chevron-left" variant="micro" class="size-5" />
                                </button>
                                <button @click="active = active === images.length - 1 ? 0 : active + 1" class="rounded-full bg-black/20 p-2 text-white backdrop-blur-md hover:bg-black/40">
                                    <flux:icon icon="chevron-right" variant="micro" class="size-5" />
                                </button>
                            </div>

                            <!-- Indicators -->
                            <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-1.5">
                                <template x-for="(img, index) in images" :key="index">
                                    <button @click="active = index" :class="active === index ? 'bg-white w-4' : 'bg-white/50 w-1.5'" class="h-1.5 rounded-full transition-all duration-300"></button>
                                </template>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 -left-6 z-10 rounded-2xl bg-white p-6 shadow-xl dark:bg-zinc-800">
                            <div class="flex items-center gap-4">
                                <div class="text-4xl font-bold text-primary-600">5+</div>
                                <div class="text-sm font-medium leading-tight text-zinc-500">Tahun<br>Pengalaman</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Units -->
        <section id="unit" class="py-24">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="mb-16 text-center">
                    <flux:badge variant="neutral" class="mb-4 uppercase tracking-widest">UNIT KAMI</flux:badge>
                    <flux:heading size="lg">Tipe Unit Kamar</flux:heading>
                </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <!-- Standard -->
                    <div class="group overflow-hidden rounded-2xl border border-zinc-200 bg-white transition-all hover:shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="aspect-4/3 overflow-hidden">
                            <img src="https://jogjalodge.com/wp-content/uploads/2023/10/Standard-Jogja-Lodge-1.jpg" alt="Standard Unit" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-6">
                            <flux:heading class="mb-2">Standard</flux:heading>
                            <flux:text class="mb-4">Luas kamar 3,00 x 6,50 meter persegi dengan fasilitas lengkap.</flux:text>
                            <div class="mb-6 flex items-end gap-1">
                                <span class="text-2xl font-bold text-primary-600">Hubungi Kami</span>
                            </div>
                            <flux:button variant="primary" class="w-full" href="https://wa.me/6282136677730">Booking Sekarang</flux:button>
                        </div>
                    </div>

                    <!-- Deluxe -->
                    <div class="group overflow-hidden rounded-2xl border border-zinc-200 bg-white transition-all hover:shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="aspect-4/3 overflow-hidden">
                            <img src="https://jogjalodge.com/wp-content/uploads/2023/10/Deluxe-Jogja-Lodge-1.jpg" alt="Deluxe Unit" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-6">
                            <flux:heading class="mb-2">Deluxe</flux:heading>
                            <flux:text class="mb-4">Luas 5,50 x 5,00 meter persegi dengan fasilitas yang lebih luas.</flux:text>
                            <div class="mb-6 flex items-end gap-1">
                                <span class="text-2xl font-bold text-primary-600">Hubungi Kami</span>
                            </div>
                            <flux:button variant="primary" class="w-full" href="https://wa.me/6282136677730">Booking Sekarang</flux:button>
                        </div>
                    </div>

                    <!-- VIP -->
                    <div class="group overflow-hidden rounded-2xl border border-zinc-200 bg-white transition-all hover:shadow-xl dark:border-zinc-800 dark:bg-zinc-900 border-primary-500 dark:border-primary-400">
                        <div class="aspect-4/3 overflow-hidden">
                            <img src="https://jogjalodge.com/wp-content/uploads/2023/10/VIP-Jogja-Lodge-1.jpg" alt="VIP Unit" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-6">
                            <div class="mb-2 flex items-center justify-between">
                                <flux:heading>VIP</flux:heading>
                                <flux:badge variant="primary">Terbaik</flux:badge>
                            </div>
                            <flux:text class="mb-4">Luas 7,00 x 6,50 meter persegi dengan fasilitas super lengkap.</flux:text>
                            <div class="mb-6 flex items-end gap-1">
                                <span class="text-2xl font-bold text-primary-600">Hubungi Kami</span>
                            </div>
                            <flux:button variant="primary" class="w-full" href="https://wa.me/6282136677730">Booking Sekarang</flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Point of Interest -->
        <section id="poi" class="py-24 bg-zinc-950 text-white">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="mb-16 text-center">
                    <flux:badge variant="neutral" class="mb-4 border-white/20 text-white">POINT OF INTEREST</flux:badge>
                    <flux:heading size="lg" class="text-white">Tempat Terdekat dari Kos RoWwwWrRRR</flux:heading>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['name' => 'Ambarukmo Plaza', 'time' => '5 Menit', 'icon' => 'shopping-bag'],
                        ['name' => 'Pakuwon Mall', 'time' => '5 Menit', 'icon' => 'shopping-cart'],
                        ['name' => 'RS JIH', 'time' => '10 Menit', 'icon' => 'heart'],
                        ['name' => 'Polda DIY', 'time' => '10 Menit', 'icon' => 'shield-check'],
                        ['name' => 'KPP Pratama', 'time' => '10 Menit', 'icon' => 'building-library'],
                        ['name' => 'Bandara Adi Sucipto', 'time' => '15 Menit', 'icon' => 'paper-airplane'],
                        ['name' => 'Terminal Jombor', 'time' => '15 Menit', 'icon' => 'truck'],
                        ['name' => 'Malioboro', 'time' => '15 Menit', 'icon' => 'map-pin'],
                    ] as $item)
                        <div class="flex flex-col items-center rounded-xl bg-white/5 p-6 text-center backdrop-blur-sm transition-colors hover:bg-white/10">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-500/20 text-primary-400">
                                <flux:icon :name="$item['icon']" class="size-6" />
                            </div>
                            <div class="text-lg font-bold">{{ $item['name'] }}</div>
                            <div class="text-zinc-400">{{ $item['time'] }}</div>
                        </div>
                    @endforeach
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
                        <img src="https://jogjalodge.com/wp-content/uploads/2023/10/Lobby-2-Jogja-Lodge.jpg" alt="Lobby" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="https://jogjalodge.com/wp-content/uploads/2023/10/Parkiran-Jogja-Lodge.jpg" alt="Parkiran" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="https://jogjalodge.com/wp-content/uploads/2023/10/Selasar-Jogja-Lodge.jpg" alt="Selasar" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="https://jogjalodge.com/wp-content/uploads/2023/10/Tangga-Jogja-Lodge.jpg" alt="Tangga" class="w-full transition-transform hover:scale-105">
                    </div>
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="https://jogjalodge.com/wp-content/uploads/2023/10/Lobby-4-Jogja-Lodge.jpg" alt="Lobby 2" class="w-full transition-transform hover:scale-105">
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
                                    <div class="text-zinc-500 dark:text-zinc-400">0821-3667-7730</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white p-8 shadow-xl dark:bg-zinc-800">
                        <form action="#" class="space-y-6">
                            <flux:field>
                                <flux:label>Nama Lengkap</flux:label>
                                <flux:input placeholder="Masukkan nama Anda" />
                            </flux:field>
                            <flux:field>
                                <flux:label>Pesan</flux:label>
                                <flux:textarea placeholder="Apa yang ingin Anda tanyakan?" rows="4" />
                            </flux:field>
                            <flux:button variant="primary" class="w-full">Kirim Pesan</flux:button>
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
                        <li><a href="#poi" class="hover:text-primary-600">Lokasi</a></li>
                    </ul>
                </div>
                <div>
                    <div class="mb-6 font-bold uppercase tracking-wider">Kontak</div>
                    <ul class="space-y-4 text-zinc-500 dark:text-zinc-400">
                        <li>Admin: 0821-3667-7730</li>
                        <li>Email: info@jogjalodge.com</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-zinc-200 pt-8 text-center text-sm text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">
                &copy; {{ date('Y') }} Kos RoWwwWrRRR - Built with Laravel & Flux UI.
            </div>
        </div>
    </footer>

    @fluxScripts
</body>
</html>
