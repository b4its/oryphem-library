<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oryphem Library</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/templatemo-prism-flux.css') }}"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .nav-link .badge.connected {
            background-color: #198754 !important; /* Hijau sukses */
        }
        .nav-link .badge.token-display {
            background-color: #0d6efd !important; /* Biru */
        }
    </style>
</head>
<body>
    
@foreach ($books as $item)
    <div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $item->id }}" aria-hidden="true">
        {{-- 
            MODERNISASI (1):
            Kita buat modal-dialog lebih besar (`modal-xl`) agar layout 2 kolom tidak sempit.
            Kita juga tambahkan `modal-dialog-scrollable` untuk jaga-jaga jika sinopsisnya sangat panjang.
        --}}
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                
                {{-- 
                    MODERNISASI (2):
                    Kita hilangkan `modal-header` dan `modal-footer` bawaan.
                    Kita akan buat header & footer kustom yang lebih menyatu dengan desain.
                    Tombol close kita taruh secara absolut di pojok.
                --}}
                <div class="modal-body p-0"> 
                    {{-- Tombol close kustom di pojok kanan atas --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" 
                            style="position: absolute; top: 1rem; right: 1rem; z-index: 10;"></button>

                    <div class="row g-0"> {{-- `g-0` untuk menghilangkan gutter antar kolom --}}
                        
                        <div class="col-lg-5">
                            {{-- 
                                MODERNISASI (3):
                                Kita gunakan `object-fit: cover` untuk memastikan gambar
                                mengisi penuh area tanpa distorsi (aspect ratio terjaga).
                                Ini adalah trik frontend yang SANGAT penting untuk UI grid.
                            --}}
                            <img src="{{ $item->gambar }}" alt="{{ $item->name }}" class="img-fluid" 
                                 style="width: 100%; height: 100%; min-height: 450px; object-fit: cover;">
                        </div>

                        <div class="col-lg-7 p-4 p-md-5 d-flex flex-column">
                            
                            {{-- Project ID (dibuat subtle) --}}
                            <div class="text-muted small mb-1">
                                Project: 0{{ $item->id }}
                            </div>

                            {{-- Judul Buku --}}
                            <h2 class="modal-title mb-2" id="modalLabel-{{ $item->id }}">{{ $item->name }}</h2>
                            
                            {{-- 
                                MODERNISASI (4):
                                Kategori kita ubah menjadi "Badge" (Pill).
                                Ini memberikan hierarki visual yang jelas.
                            --}}
                            <div class="mb-3">
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis fs-6">
                                    {{ $item->category->name }}
                                </span>
                            </div>

                            {{-- Sinopsis --}}
                            <h5 class="fw-bold mt-2">Sinopsis</h5>
                            <div class="modal-card-description mb-4">
                                {!! $item->descriptions !!}
                            </div>

                            {{-- 
                                MODERNISASI (5):
                                Ini bagian UX. Kita letakkan Harga & Tombol Aksi BERDEKATAN.
                                Prinsip Desain "Proximity": Hal yang terkait harus diletakkan berdekatan.
                                Kita gunakan `mt-auto` untuk mendorong blok ini ke bagian paling bawah
                                dari kolom, menciptakan layout yang rapi.
                            --}}
                            <div class="mt-auto bg-body-tertiary p-3 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    {{-- Info Harga --}}
                                    <div>
                                        <h6 class="text-muted mb-0">Harga</h6>
                                        <h3 class="fw-bold mb-0" id="price-{{ $item->id }}">
                                            {{ $item->price }} 
                                            <span class="fs-5 fw-normal">ORX</span>
                                        </h3>
                                    </div>
                                    
                                    {{-- Tombol Aksi --}}
                                    <div>
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                                        <button type="button" 
                                                class="btn btn-success btn-lg buy-book-btn" 
                                                data-book-id="{{ $item->id }}"
                                                data-book-price="{{ $item->price }}"
                                                data-bs-dismiss="modal">
                                            Beli Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> </div> </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="buyOryModal" tabindex="-1" aria-labelledby="buyOryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 0.8rem;">
            
            {{-- HEADER MODAL --}}
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="buyOryModalLabel">
                    <i class="fas fa-coins me-2 text-warning"></i> 
                    Beli Oryphem Token (ORX)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            {{-- BODY MODAL --}}
            <div class="modal-body p-4">
                
                <form id="form-buy-ory">
                    
                    {{-- INPUT HIDDEN UNTUK BACKEND LARAVEL --}}
                    {{-- Pastikan variabel PHP ini tersedia di view Anda. Asumsikan ID Book/Token ORX adalah 1. --}}
                    @php
                        // Contoh placeholder jika Anda tidak menggunakan Blade/PHP
                        $user_id = Auth::check() ? Auth::id() : ''; 
                    @endphp
                    
                    <input type="hidden" id="input-id-users" value="{{ $user_id }}">

                    {{-- INFORMASI STATIS (Saldo & Kurs) --}}
                    <div class="row g-2 mb-4">
                        {{-- Saldo Anda --}}
                        <div class="col-6">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <p class="text-muted small mb-1">Saldo ORX Anda</p>
                                <h5 class="fw-bold text-dark mb-0" id="orx-balance-display">
                                    0 ORX
                                </h5>
                            </div>
                        </div>
                        {{-- Kurs Saat Ini --}}
                        <div class="col-6">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <p class="text-muted small mb-1">Kurs Saat Ini</p>
                                <h5 class="fw-bold text-dark mb-0">
                                    1 ORX = 10 Wei
                                </h5>
                            </div>
                        </div>
                    </div>

                    {{-- INPUT UTAMA (STEPPER) --}}
                    <h5 class="text-center text-muted mb-3">Jumlah ORX yang Ingin Dibeli</h5>
                    
                    {{-- Menggunakan Input Group untuk UI yang lebih kohesif --}}
                    <div class="input-group input-group-lg w-75 mx-auto mb-3">
                        <button class="btn btn-outline-secondary" type="button" onclick="updateOryAmount(-1)" aria-label="Kurangi jumlah">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                        <input type="text" id="ory-amount-input" class="form-control text-center fw-bolder display-6" 
                                value="1" min="1" readonly 
                                aria-label="Jumlah token"
                                style="height: auto;">
                        
                        <button class="btn btn-outline-secondary" type="button" onclick="updateOryAmount(1)" aria-label="Tambah jumlah">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    {{-- OUTPUT HARGA DINAMIS (Konfirmasi Total) --}}
                    <div class="p-3 rounded-3 bg-success-subtle text-success-emphasis text-center mt-4">
                        <p class="mb-1 small">Total Harga (Sepolia ETH):</p>
                        <h3 class="fw-bold mb-0" id="eth-total-price">
                            0.000000000000000010 ETH
                        </h3>
                    </div>

                    <p class="text-danger small text-center mt-3">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Pastikan Anda memiliki Sepolia ETH yang cukup.
                    </p>

                </form>
            </div>
            
            {{-- FOOTER MODAL (Tombol Aksi) --}}
            <div class="modal-footer border-top-0 pt-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="submitBuyOry" class="btn btn-success fw-bold">
                    <i class="fas fa-check-circle me-2"></i>
                    Konfirmasi Pembelian
                </button>
            </div>
            
        </div>
    </div>
</div>


    <header class="orx-header" id="header">
        <nav class="orx-nav-container">
            <a href="#home" class="orx-logo">
                <span class="orx-logo-text">
                    <span class="orx-prism">Oryphem</span>
                    <span class="orx-flux">Library</span>
                </span>
            </a>
            
            <ul class="orx-nav-menu" id="navMenu">
                <li><a href="#home" class="orx-nav-link orx-active">Home</a></li>
                <li><a href="#stats" class="orx-nav-link">Book</a></li>
                @auth
                    <li id="metamask-status-item"> 
                        <a href="#" id="connectMetamaskBtn" class="nav-link">
                            Connect to
                            <span class="badge text-bg-warning rounded-pill ms-2">Metamask</span>
                        </a>
                    </li>
                    <li class="orx-nav-link">
                        <a class="badge text-bg-success rouded-pill" data-bs-toggle="modal" data-bs-target="#buyOryModal">
                            Beli Token
                        </a>
                        {{-- <p class="token-display" id="orx-balance-display">ORX:0</p> --}}
                    </li>
                @else
                    <li>
                        <a href="{{ route('filament.admin.auth.login') }}" class="nav-link">
                            Auth
                            <span class="badge text-bg-info rounded-pill ms-2">Login</span>
                        </a>
                    </li>
                @endauth
            </ul>
            
            <div class="orx-menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <section class="orx-hero" id="home">
        <div class="orx-carousel-container">
            <div class="orx-carousel" id="carousel">
            </div>
            
            <div class="orx-carousel-controls">
                <button class="orx-carousel-btn" id="prevBtn">‹</button>
                <button class="orx-carousel-btn" id="nextBtn">›</button>
            </div>
            
            <div class="orx-carousel-indicators" id="indicators">
            </div>
        </div>
    </section>

    <section class="orx-philosophy-section" id="about">
        <div class="orx-philosophy-container">
            <div class="orx-prism-line"></div>
            
            <h2 class="orx-philosophy-headline">
                reach your dreams<br>achieve your goals
            </h2>
            
            <p class="orx-philosophy-subheading">
Oryphem Library mempersembahkan varian buku yang dilengkapi fitur pencatatan transaksi terintegrasi. Setiap kegiatan dicatat secara real-time dan terjamin keamanannya menggunakan teknologi Blockchain yang revolusioner, kami menggunakan Oryphem NFT untuk melakukan transaksi, memberikan pengalaman praktis tanpa risiko.
            </p>
            
            <div class="orx-philosophy-pillars">
                <div class="orx-pillar">
                    <div class="orx-pillar-icon">💡</div>
                    <h3 class="orx-pillar-title">Reach Your Dreams</h3>
                    <p class="orx-pillar-description">
Wujudkan potensi maksimal Anda! Oryphem Library hadir dengan varian buku panduan edukasi yang inovatif, didukung oleh fitur pencatatan transaksi yang sangat aman.
                    </p>
                </div>

                <div class="orx-pillar">
                    <div class="orx-pillar-icon">🎯</div>
                    <h3 class="orx-pillar-title">Achieve Your Goals</h3>
                    <p class="orx-pillar-description">
                        Semua transaksi edukasi dicatat secara langsung menggunakan teknologi <b>Blockchain</b> untuk menjamin keamanan dan transparansi penuh.
                    </p>
                </div>

                <div class="orx-pillar">
                    <div class="orx-pillar-icon">🔒</div>
                    <h3 class="orx-pillar-title">Secure Transaction</h3>
                    <p class="orx-pillar-description">
                        Untuk kegiatan transaksi dan pembelajaran, kami menggunakan <b>Sepolia Testnet Token</b> untuk deploy token, dan itu tercatat di etherscan sehingga bisa di audit, serta memberikan pengalaman praktis di lingkungan yang aman.
                    </p>
                </div>
            </div>
            
            <div class="orx-philosophy-particles" id="particles">
            </div>
        </div>
    </section>
    
    <section class="orx-stats-section" id="stats">
        <div class="orx-section-header">
            <h2 class="orx-section-title">Rekomendasi Buku</h2>
            <p class="orx-section-subtitle">kami menyediakan beberapa referensi buku terbaik untuk dibaca</p>
        </div>
        <div class="orx-philosophy-pillars">
            @foreach ($books as $item)
                <div class="orx-stat-card">
                    <div class="orx-card-number">0{{ $item->id }}</div>
                    <div class="orx-card-image">
                        <img src="{{ $item->gambar }}" alt="{{ $item->name }}">
                    </div>
                    <h3 class="orx-card-title">{{ $item->name }}</h3>
                    <p class="orx-card-description">{{ Str::limit(strip_tags($item->descriptions), 100) }}</p>
                    <div class="orx-card-tech">
                        <span class="orx-tech-badge">{{ $item->category->name }}</span>
                    </div>
                    <div>
                        <p class="badge text-bg-success rounded-pill">Price: {{ $item->price }} ORX</p>
                    </div>
                    <button class="orx-card-cta" data-bs-toggle="modal" data-bs-target="#modal-{{ $item->id }}">Jelajahi</button>
                </div>
            @endforeach
        </div>
    </section>

    @include('footer')
    
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.15.0/ethers.umd.min.js" integrity="sha512-UXYETj+vXKSURF1UlgVRLzWRS9ZiQTv3lcL4rbeLyqTXCPNZC6PTLF/Ik3uxm2Zo+E109cUpJPZfLxJsCgKSng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/templatemo-prism-scripts.js') }}"></script>
    
<script>
    // =========================================================================
    // --- KONFIGURASI WEB3 (WAJIB DIGANTI!) ---
    // Ganti ini dengan nilai kontrak dan alamat yang sesungguhnya.
    // =========================================================================

    // Alamat Kontrak OryphemToken (ORX) yang di-deploy di Sepolia
    // GANTI INI dengan alamat kontrak ORX Anda yang sudah di-deploy.
    const ORX_TOKEN_ADDRESS = "0x472563012E256D0338c75efd727D629A35283986"; 
    
    // Alamat Dompet Platform/Penerima Pembayaran
    const PLATFORM_WALLET_ADDRESS = "0x6EdcA860c066FCdA6c434095d5901810DCE12b48"; 

    // ✅ KOREKSI PENTING: Jika 5 ORX harus ditransfer sebagai 5 unit, 
    // desimal token harus 0. Sesuaikan angka ini dengan desimal kontrak Anda.
    const ORX_TOKEN_DECIMALS = 0; 
    
    // Konstanta Harga Buy ORX: 1 ORX = 10 Wei ETH
    const ORX_TO_WEI_RATE = 10n; // Menggunakan BigInt untuk presisi Wei

    const SEPOLIA_CHAIN_ID = '0xaa36a7'; // Hex untuk 11155111
    const CHAIN_ID_DECIMAL = 11155111;
    const METAMASK_ADDRESS_KEY = 'b6561b56270a4d34878dbf311580ddd3'; 

    // ABI Minimal untuk fungsi transfer, balanceOf, dan buy
    const ORX_TOKEN_ABI = [
        // Function: transfer(address to, uint256 value)
        {
            "constant": false,
            "inputs": [
                { "name": "to", "type": "address" },
                { "name": "value", "type": "uint256" }
            ],
            "name": "transfer",
            "outputs": [
                { "name": "", "type": "bool" }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        // Function: balanceOf(address owner)
        {
            "constant": true,
            "inputs": [
                { "name": "owner", "type": "address" }
            ],
            "name": "balanceOf",
            "outputs": [
                { "name": "", "type": "uint256" }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        // Fungsi: buy() - Memungkinkan pengguna mengirim ETH dan menerima token
        {
            "constant": false,
            "inputs": [],
            "name": "buy",
            "outputs": [],
            "stateMutability": "payable", 
            "type": "function"
        }
    ];

    let currentAccount = localStorage.getItem(METAMASK_ADDRESS_KEY);

    // -------------------------------------------------------------------------
    // --- UTILS & STATUS ---
    // -------------------------------------------------------------------------

    const shortenAddress = (address) => {
        if (!address || address.length < 10) return address;
        return `${address.substring(0, 6)}...${address.slice(-4)}`;
    };

    const updateMetamaskStatus = (address) => {
        const statusItem = document.getElementById('metamask-status-item');
        if (statusItem) {
            const shortAddress = shortenAddress(address);
            statusItem.innerHTML = `
                <a href="#" id="viewAccountDetailsBtn" class="nav-link">
                    Wallet Connected:
                    <span class="badge connected rounded-pill ms-2" title="${address}">
                        ${shortAddress}
                    </span>
                </a>
            `;
            currentAccount = address;
        }
    };

    const updateORXBalance = async (address) => {
        const balanceDisplay = document.getElementById('orx-balance-display');
        if (!balanceDisplay) return;

        try {
            const provider = new ethers.BrowserProvider(window.ethereum);
            const orxContract = new ethers.Contract(ORX_TOKEN_ADDRESS, ORX_TOKEN_ABI, provider);

            const balanceBigInt = await orxContract.balanceOf(address); 
            
            // Menggunakan desimal token yang telah dikonfigurasi
            const balanceFormatted = ethers.formatUnits(balanceBigInt, ORX_TOKEN_DECIMALS); 
            
            balanceDisplay.textContent = `${parseFloat(balanceFormatted).toFixed(0)} ORX`;

        } catch (error) {
            console.error("Gagal mendapatkan saldo ORX:", error.message);
            balanceDisplay.textContent = `ORX: Error`;
        }
    }

    // -------------------------------------------------------------------------
    // --- FUNGSI KHUSUS MODAL PEMBELIAN ORX (DINAMIS) ---
    // -------------------------------------------------------------------------

    /**
     * FUNGSI PERHITUNGAN HARGA DINAMIS (1 ORX = 10 WEI)
     * @returns {bigint} Total harga dalam Wei.
     */
    function calculateTotalEth() {
        const inputElement = document.getElementById('ory-amount-input');
        const priceElement = document.getElementById('eth-total-price');
        
        const orxAmount = BigInt(inputElement.value || '0');
        
        // Hitung Total Wei = Jumlah ORX * 10 Wei
        const totalWei = orxAmount * ORX_TO_WEI_RATE;
        
        // Konversi BigInt Wei ke string ETH (1 ETH = 10^18 Wei)
        const totalEth = ethers.formatUnits(totalWei, 18); // 18 desimal untuk ETH
        
        priceElement.textContent = `${totalEth} ETH`;
        
        return totalWei; 
    }

    /**
     * FUNGSI UNTUK MENGUBAH JUMLAH ORX YANG AKAN DIBELI
     */
    function updateOryAmount(change) {
        const input = document.getElementById('ory-amount-input');
        let currentVal = parseInt(input.value);
        let newVal = currentVal + change;
        
        if (newVal >= 1) {
            input.value = newVal;
            calculateTotalEth(); // Hitung ulang harga
        }
    }


    /**
     * FUNGSI WEB3 UTAMA: MEMBELI ORX
     */
    async function buyOry() {
        if (!window.ethereum || !currentAccount) {
            alert('Harap hubungkan dompet Metamask Anda terlebih dahulu.');
            return;
        }

        const provider = new ethers.BrowserProvider(window.ethereum);
        const signer = await provider.getSigner();

        try {
            // 1. Dapatkan input dari user dan hitung harga
            const totalWei = calculateTotalEth();
            if (totalWei === 0n) return; 
            
            const totalEthDisplay = ethers.formatUnits(totalWei, 18); 
            const orxAmount = BigInt(document.getElementById('ory-amount-input').value);
            const orxAmountDisplay = orxAmount.toString();
            
            const idUsersElement = document.getElementById('input-id-users');
            const idUsers = idUsersElement ? idUsersElement.value : null;

            if (!idUsers) {
                console.error('ERROR: ID Pengguna tidak ditemukan.');
                alert('ERROR: ID Pengguna tidak ditemukan. Harap refresh halaman.');
                return;
            }

            const orxContract = new ethers.Contract(ORX_TOKEN_ADDRESS, ORX_TOKEN_ABI, signer);

            const isConfirmed = confirm(`Anda akan membeli ${orxAmountDisplay} ORX seharga ${totalEthDisplay} ETH Sepolia. Lanjutkan?`);
            if (!isConfirmed) return;
            
            // 2. Transaksi Smart Contract
            
            console.log(`[Blockchain] Memanggil buy() pada kontrak ${ORX_TOKEN_ADDRESS} dengan nilai: ${totalEthDisplay} ETH...`);

            const tx = await orxContract.buy({
                value: totalWei 
            });

            console.log(`[Blockchain] Transaksi dikirim! Hash: ${tx.hash}. Menunggu konfirmasi...`);
            
            const receipt = await tx.wait(); 

            if (receipt.status !== 1) {
                alert('Transaksi Blockchain gagal dikonfirmasi.');
                return;
            }
            
            console.log(`✅ Transaksi Blockchain sukses! Token dicetak ke wallet. Hash: ${receipt.hash}.`);
            console.log(`[Server] Mencoba mencatat transaksi ke backend Laravel...`);
            
            // 3. Pencatatan Backend Laravel
            
            try {
                const response = await fetch('/buy-ory-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        wallet_address: currentAccount,
                        transaction_hash: tx.hash,
                        orx_amount: orxAmountDisplay,
                        eth_paid: totalEthDisplay,
                        id_users: idUsers,
                    })
                });

                if (!response.ok) {
                    let serverErrorData;
                    try {
                        serverErrorData = await response.json();
                    } catch (e) {
                        throw new Error(`Server Error (${response.status}): ${response.statusText}. Cek Koneksi DB & Log Laravel. (Gagal Parse JSON)`);
                    }
                    
                    throw new Error(`Pencatatan Gagal (${response.status}): ${serverErrorData.message || 'Error server tidak terdefinisi.'}`);
                }

                const data = await response.json();

                // SCRIPT SUCCESS AKHIR
                console.log("✅ Pencatatan Server Berhasil:", data.message);
                alert(`🎉 Pembelian Sukses! ${data.message}`);
                
                updateORXBalance(currentAccount); 
                const modal = bootstrap.Modal.getInstance(document.getElementById('buyOryModal'));
                if (modal) modal.hide();

            } catch (fetchError) {
                console.error("❌ Kesalahan Pencatatan Laravel:", fetchError);
                alert(`⚠️ Gagal Mencatat Transaksi di Server! Pesan: ${fetchError.message}. Token ORX Anda sudah masuk, mohon hubungi admin.`);
            }
            
        } catch (error) { 
            console.error("❌ Kesalahan Transaksi Blockchain:", error);
            let message = 'Gagal melakukan transaksi kontrak.'; 
            
            if (error.message && error.message.includes('user rejected transaction')) {
                message = 'Transaksi dibatalkan oleh pengguna Metamask.';
            } else if (error.message && error.message.includes('insufficient funds')) {
                message = 'Saldo ETH tidak mencukupi.';
            } else if (error.message && error.message.includes('revert')) {
                message = 'Transaksi dibatalkan oleh kontrak (revert).';
            } else if (error.code === 'ACTION_REJECTED') {
                message = 'Transaksi dibatalkan oleh pengguna Metamask (Ethers v6).';
            } else if (error.code === 'CALL_EXCEPTION') {
                message = 'Transaksi gagal dieksekusi (revert). Cek saldo ETH dan ORX Anda.';
            }
            alert(`❌ ${message}`);
        }
    }

    // -------------------------------------------------------------------------
    // --- FUNGSI METAMASK & PEMBELIAN BUKU ---
    // -------------------------------------------------------------------------

    /**
     * FUNGSI KONEKSI METAMASK & VERIFIKASI SIGNATURE
     */
    const connectMetamask = async () => {
        if (typeof window.ethereum === 'undefined') {
            alert('Metamask is not installed. Please install it to connect your wallet.');
            return;
        }

        try {
            const provider = new ethers.BrowserProvider(window.ethereum);
            
            // 1a. Minta koneksi akun
            const accounts = await provider.send("eth_requestAccounts", []);
            const walletAddress = accounts[0];
            
            // 1b. Periksa dan Beralih ke Sepolia
            const network = await provider.getNetwork();
            if (Number(network.chainId) !== CHAIN_ID_DECIMAL) {
                await window.ethereum.request({
                    method: 'wallet_switchEthereumChain',
                    params: [{ chainId: SEPOLIA_CHAIN_ID }],
                });
                await new Promise(resolve => setTimeout(resolve, 500)); 
            }
            
            const signer = await provider.getSigner();
            
            // 2. Minta user menandatangani pesan untuk verifikasi backend
            const signingMessage = 'Authorize connection to your Metamask wallet for this application.';
            const signature = await signer.signMessage(signingMessage);

            // 3. Kirim data ke backend Laravel untuk verifikasi
            const response = await fetch('/connect-metamask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                },
                body: JSON.stringify({
                    wallet_address: walletAddress,
                    signature: signature
                })
            });

            if (response.ok) {
                localStorage.setItem(METAMASK_ADDRESS_KEY, walletAddress); 
                const data = await response.json();
                
                updateMetamaskStatus(walletAddress);
                updateORXBalance(walletAddress);

                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } else {
                const errorData = await response.json();
                alert(`Connection failed: ${errorData.message || 'Server error.'}`);
            }

        } catch (error) {
            console.error("Metamask connection error:", error);
            alert(`Connection failed: ${error.message || 'Failed to connect Metamask or user rejected the request.'}`);
        }
    };


    /**
     * FUNGSI TRANSAKSI PEMBELIAN BUKU MENGGUNAKAN ORX (ERC-20 Transfer)
     */
    const buyBookWithORX = async (bookId, price) => {
        if (!currentAccount) {
            alert('Harap hubungkan dompet Metamask Anda terlebih dahulu.');
            return;
        }

        try {
            const provider = new ethers.BrowserProvider(window.ethereum);
            const signer = await provider.getSigner();
            
            const orxContract = new ethers.Contract(ORX_TOKEN_ADDRESS, ORX_TOKEN_ABI, signer);

            // ✅ PERBAIKAN: Menggunakan konstanta desimal yang benar. 
            // Jika desimal 0, 5 ORX akan diubah menjadi 5 (unit terkecil).
            const amountInWei = ethers.parseUnits(price.toString(), ORX_TOKEN_DECIMALS); 
            
            alert(`Meminta transfer ${price} ORX ke Platform...`);
            
            const tx = await orxContract.transfer(PLATFORM_WALLET_ADDRESS, amountInWei);

            // Tunggu konfirmasi transaksi
            alert(`Transaksi dikirim! Hash: ${tx.hash}. Menunggu konfirmasi Blockchain...`);
            const receipt = await tx.wait(); 
            
            if (receipt.status === 1) {
                alert('✅ Transfer ORX berhasil! Memproses pembelian di server...');

                const response = await fetch('/purchase-book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        book_id: bookId,
                        wallet_address: currentAccount,
                        transaction_hash: tx.hash,
                        price_paid: price
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert(`Pembelian Buku Berhasil! ${data.message}`);
                    updateORXBalance(currentAccount); 
                } else {
                    alert(`Pembelian Gagal di Server: ${data.message || 'Server gagal memproses pembelian.'}`);
                }

            } else {
                alert('Transaksi Blockchain gagal dikonfirmasi.');
            }

        } catch (error) {
            console.error("Kesalahan Pembelian ORX:", error);
            let message = 'Gagal melakukan transfer token.';
            if (error.message && error.message.includes('insufficient funds')) {
                message = 'Saldo ORX Anda tidak mencukupi untuk membeli buku ini.';
            } else if (error.message && error.message.includes('user rejected transaction')) {
                message = 'Transaksi dibatalkan oleh pengguna Metamask.';
            } else if (error.code === 'CALL_EXCEPTION') {
                 message = 'Transaksi gagal dieksekusi (revert). Pastikan Anda memiliki saldo ORX yang cukup.';
            }
            alert(`❌ ${message}`);
        }
    };


    // -------------------------------------------------------------------------
    // --- INITIALIZATION & EVENT LISTENERS ---
    // -------------------------------------------------------------------------

    document.addEventListener('DOMContentLoaded', () => {
        // Cek status tersimpan saat halaman dimuat
        const storedAddress = localStorage.getItem(METAMASK_ADDRESS_KEY);

        if (storedAddress) {
            updateMetamaskStatus(storedAddress);
            updateORXBalance(storedAddress);
        }

        // --- Event Listeners untuk Tombol Utama ---

        // 1. Listener untuk tombol Connect Metamask
        const connectButton = document.getElementById('connectMetamaskBtn');
        if (connectButton) {
            connectButton.addEventListener('click', (e) => {
                e.preventDefault();
                connectMetamask();
            });
        }
        
        // 2. Listener untuk tombol Beli Buku
        document.querySelectorAll('.buy-book-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const bookId = e.target.getAttribute('data-book-id');
                const price = e.target.getAttribute('data-book-price');
                buyBookWithORX(bookId, price);
            });
        });

        // 3. Listener untuk tombol Konfirmasi Pembelian ORX (Modal)
        const submitBuyOryButton = document.getElementById('submitBuyOry');
        if (submitBuyOryButton) {
            submitBuyOryButton.addEventListener('click', buyOry);
        }

        // --- Event Listeners untuk Modal Pembelian ORX ---
        
        // Panggil perhitungan harga awal saat skrip dimuat
        calculateTotalEth();
        
        // Pastikan kalkulasi total ETH dihitung ulang saat modal dibuka
        const buyModal = document.getElementById('buyOryModal');
        if (buyModal) {
            buyModal.addEventListener('shown.bs.modal', calculateTotalEth);
        }


        // --- Metamask Event Listeners ---
        if (typeof window.ethereum !== 'undefined') {
            window.ethereum.on('accountsChanged', (accounts) => {
                if (accounts.length > 0) {
                    localStorage.setItem(METAMASK_ADDRESS_KEY, accounts[0]);
                } else {
                    localStorage.removeItem(METAMASK_ADDRESS_KEY);
                }
                window.location.reload(); 
            });
        }
    });
</script>


</body>
</html>