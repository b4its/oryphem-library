<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oryphem Library</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link rel="stylesheet" href="{{ asset('assets/templatemo-prism-flux.css') }}"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
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
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-{{ $item->id }}">{{ $item->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="modal-card-image text-center mb-3">
                            <img src="{{ $item->gambar }}" alt="{{ $item->name }}" class="img-fluid rounded" style="max-height: 400px;">
                        </div>
                        
                        <div class="modal-card-number text-muted small">
                            Project: 0{{ $item->id }}
                        </div>
                        
                        <h4 class="mt-2">Sinopsis</h4>
                        <p class="modal-card-description">
                            {!! $item->descriptions !!}
                        </p>
                        
                        <h5 class="mt-3">Kategori</h5>
                        <div class="orx-card-tech">
                            {{ $item->category->name }}
                        </div>
                        <h5 class="mt-3">Harga</h5>
                        <div class="orx-card-tech">
                            <b><span id="price-{{ $item->id }}">{{ $item->price }}</span> ORX</b> Token
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn btn-success buy-book-btn" 
                                data-book-id="{{ $item->id }}"
                                data-book-price="{{ $item->price }}"
                                data-bs-dismiss="modal">
                            Beli Sekarang (ORX)
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                    
                </div>
            </div>
        </div>
    @endforeach
    
<div class="modal fade" id="buyOryModal" tabindex="-1" aria-labelledby="buyOryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            
            {{-- HEADER MODAL --}}
            <div class="modal-header">
                <h5 class="modal-title" id="buyOryModalLabel">Beli Oryphem Token (ORX)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            {{-- BODY MODAL --}}
            <div class="modal-body text-center">
                
                {{-- INFORMASI SALDO ORYPHEM TOKEN --}}
                <div class="mb-4 p-2 bg-light rounded">
                    <p class="text-muted mb-0 small">ORYPHEM TOKEN YANG DIMILIKI:</p>
                    <h4 class="text-dark">
                        {{-- ID yang digunakan di skrip utama --}}
                        <p class="token-display" id="orx-balance-display">0 ORX</p>
                    </h4>
                </div>

                <form id="form-buy-ory">
                    
                    {{-- INPUT JUMLAH PEMBELIAN --}}
                    <h5 class="mt-3 text-muted">Jumlah yang Ingin Dibeli (ORX)</h5>
                    <div class="d-flex align-items-center justify-content-center my-3">
                        <button type="button" class="btn btn-outline-secondary me-3" onclick="updateOryAmount(-1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                        <input type="number" id="ory-amount-input" class="form-control form-control-lg text-center fw-bold" 
                            style="width: 120px; font-size: 2.5rem; height: 3.5rem; border: none;" value="1" min="1" readonly>

                        <button type="button" class="btn btn-outline-secondary ms-3" onclick="updateOryAmount(1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    {{-- OUTPUT HARGA DINAMIS (BARU) --}}
                    <div class="alert alert-success py-2 mt-4" role="alert">
                        <p class="mb-0 small text-muted">Total Harga (Sepolia ETH):</p>
                        <strong class="h5" id="eth-total-price">0.000000000000000010 ETH</strong>
                        <p class="text-muted small mb-0 mt-1">
                            (Kurs: 1 ORX = 10 Wei)
                        </p>
                    </div>
                    
                    <p class="text-danger small mt-2">
                        Pastikan Anda memiliki Sepolia ETH yang cukup di wallet Anda.
                    </p>
                </form>

            </div>
            
            {{-- FOOTER MODAL (Tombol Submit Warna Hijau) --}}
            <div class="modal-footer d-flex justify-content-between">
                {{-- TOMBOL SUBMIT HIJAU (Menggunakan type="button" dan memanggil fungsi JS) --}}
                <button type="button" id="submitBuyOry" class="btn btn-success fw-bold">
                    Konfirmasi Pembelian
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal / Tutup</button>
                
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
    // Pastikan Anda telah mengimpor library ethers.js di halaman Anda.
    
    // =========================================================================
    // --- KONFIGURASI WEB3 (WAJIB DIGANTI!) ---
    // =========================================================================
    
    // Alamat Kontrak OryphemToken (ORX) yang di-deploy di Sepolia
    const ORX_TOKEN_ADDRESS = "0x472563012E256D0338c75efd727D629A35283986"; 
    
    // Alamat Dompet Platform/Penerima Pembayaran (Nilai ini diabaikan oleh buyOry()
    // tetapi mungkin masih diperlukan untuk buyBookWithORX() atau fungsi lain)
    const PLATFORM_WALLET_ADDRESS = "0x6EdcA860c066FCdA6c434095d5901810DCE12b48"; 
    
    // Konstanta Harga: 1 ORX = 10 Wei (Wei adalah satuan terkecil dari ETH)
    const ORX_TO_WEI_RATE = 10n; // Menggunakan BigInt untuk presisi Wei
    
    const SEPOLIA_CHAIN_ID = '0xaa36a7'; // Hex untuk 11155111
    const CHAIN_ID_DECIMAL = 11155111;
    const METAMASK_ADDRESS_KEY = 'b6561b56270a4d34878dbf311580ddd3'; 
    
    // 🔥 ABI Minimal yang Diperbarui untuk OryphemToken.sol
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
            "name": "balanceOf",
            "stateMutability": "view",
            "type": "function"
        },
        // 🔥 Fungsi BARU: buy() - Memungkinkan pengguna mengirim ETH dan menerima token
        {
            "constant": false,
            "inputs": [],
            "name": "buy",
            "outputs": [],
            "stateMutability": "payable", // HARUS 'payable'
            "type": "function"
        }
    ];

    let currentAccount = localStorage.getItem(METAMASK_ADDRESS_KEY);
    
    // =========================================================================
    
    /**
     * UTILS (Tidak Berubah)
     */
    const shortenAddress = (address) => {
        if (!address || address.length < 10) return address;
        return `${address.substring(0, 6)}...${address.slice(-4)}`;
    };

    const updateMetamaskStatus = (address) => {
        const statusItem = document.getElementById('metamask-status-item');
        if (statusItem) {
            const shortAddress = shortenAddress(address);
            
            // Mengubah konten list item menjadi status 'Terhubung'
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
        
        // 🔥 PERUBAHAN: Gunakan 0 Desimal
        // Jika token Anda adalah token penuh (tanpa desimal)
        const balanceFormatted = ethers.formatUnits(balanceBigInt, 0);
        
        // Gunakan parseFloat().toFixed(0) untuk menampilkan angka bulat.
        balanceDisplay.textContent = `${parseFloat(balanceFormatted).toFixed(0)} ORX`;

    } catch (error) {
        console.error("Gagal mendapatkan saldo ORX:", error.message);
        balanceDisplay.textContent = `ORX: Error`;
    }
}

    // =========================================================================
    // FUNGSI KHUSUS MODAL PEMBELIAN ORX (DINAMIS)
    // =========================================================================

    /**
     * FUNGSI PERHITUNGAN HARGA DINAMIS (1 ORX = 10 WEI)
     * @returns {bigint} Total harga dalam Wei.
     */
    function calculateTotalEth() {
        const inputElement = document.getElementById('ory-amount-input');
        const priceElement = document.getElementById('eth-total-price');
        
        const orxAmount = BigInt(inputElement.value);
        
        // Hitung Total Wei = Jumlah ORX * 10 Wei
        const totalWei = orxAmount * ORX_TO_WEI_RATE;
        
        // Konversi BigInt Wei ke string ETH yang mudah dibaca (1 ETH = 10^18 Wei)
        const totalEth = ethers.formatUnits(totalWei, 18); // 18 desimal untuk ETH
        
        priceElement.textContent = `${totalEth} ETH`;
        
        return totalWei; 
    }

    /**
     * FUNGSI UNTUK MENGUBAH JUMLAH ORX YANG AKAN DIBELI (Tidak Berubah)
     */
    function updateOryAmount(change) {
        const input = document.getElementById('ory-amount-input');
        let currentVal = parseInt(input.value);
        let newVal = currentVal + change;
        
        if (newVal >= 1) {
            input.value = newVal;
            calculateTotalEth(); // **PENTING:** Hitung ulang harga setiap kali jumlah berubah
        }
    }

    /**
     * 🔥 FUNGSI WEB3 YANG DIPERBAIKI: MEMBELI ORX DENGAN MEMANGGIL KONTRAK buy()
     * Transaksi: Kirim ETH ke Kontrak OryphemToken yang akan memanggil fungsi buy().
     */
    async function buyOry() {
        if (!currentAccount) {
            alert('Harap hubungkan dompet Metamask Anda terlebih dahulu.');
            return;
        }
        
        if (ORX_TOKEN_ADDRESS.includes(0x472563012E256D0338c75efd727D629A35283986)) {
            alert('ERROR: Harap ganti alamat kontrak token (ORX_TOKEN_ADDRESS) di kode JavaScript!');
            return;
        }

        const provider = new ethers.BrowserProvider(window.ethereum);
        const signer = await provider.getSigner();

        try {
            // 1. Dapatkan total Wei yang harus dikirim
            const totalWei = calculateTotalEth();
            const totalEthDisplay = ethers.formatUnits(totalWei, 18);
            const orxAmount = BigInt(document.getElementById('ory-amount-input').value); // Hanya untuk display
            
            // Inisialisasi kontrak dengan signer untuk menulis transaksi
            const orxContract = new ethers.Contract(ORX_TOKEN_ADDRESS, ORX_TOKEN_ABI, signer);

            // Konfirmasi ke pengguna
            const isConfirmed = confirm(`Anda akan membeli ${orxAmount} ORX seharga ${totalEthDisplay} ETH Sepolia. Lanjutkan?`);
            if (!isConfirmed) return;
            
            // 2. 🔥 Panggil fungsi 'buy' pada Smart Contract dan lampirkan nilai ETH (totalWei)
            console.log(`Memanggil fungsi buy() pada kontrak ${ORX_TOKEN_ADDRESS} dengan nilai: ${totalEthDisplay} ETH (${totalWei} Wei)...`);

            const tx = await orxContract.buy({
                value: totalWei // Mengirim ETH (value) bersamaan dengan panggilan fungsi
            });

            // 3. Tunggu konfirmasi transaksi
            alert(`Transaksi dikirim! Hash: ${tx.hash}. Menunggu konfirmasi Blockchain...`);
            const receipt = await tx.wait(); 

            if (receipt.status === 1) {
                // Transaksi Blockchain SUKSES. Kontrak telah mencetak token ke msg.sender (currentAccount).
                alert('✅ Pembelian ORX berhasil di Blockchain! Token telah dicetak ke wallet Anda. Mencatat pembelian di server...');
                
                // --- Panggil Backend Laravel (hanya untuk pencatatan) ---
                const response = await fetch('/buy-ory-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        wallet_address: currentAccount,
                        transaction_hash: tx.hash,
                        orx_amount: orxAmount.toString(),
                        eth_paid: totalEthDisplay
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert(`Pencatatan Pembelian ORX Berhasil! ${data.message}`);
                    updateORXBalance(currentAccount); 
                    // Tutup modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('buyOryModal'));
                    if (modal) modal.hide();
                } else {
                    alert(`Pencatatan Pembelian Gagal di Server: ${data.message || 'Server gagal mencatat pembelian.'} Token ORX Anda *seharusnya* sudah masuk, periksa saldo Anda.`);
                }

            } else {
                alert('Transaksi Blockchain gagal dikonfirmasi.');
            }

        } catch (error) {
            console.error("Kesalahan Pembelian ORX:", error);
            let message = 'Gagal melakukan transaksi kontrak.';
            if (error.message && error.message.includes('user rejected transaction')) {
                 message = 'Transaksi dibatalkan oleh pengguna Metamask.';
            } else if (error.message && error.message.includes('insufficient funds')) {
                 message = 'Saldo Sepolia ETH Anda tidak mencukupi.';
            } else if (error.message && error.message.includes('revert')) {
                 message = 'Transaksi dibatalkan oleh kontrak (revert). Cek apakah saldo ETH Anda mencukupi untuk token minimum.';
            }
            alert(`❌ ${message}`);
        }
    }


    // =========================================================================
    // FUNGSI UTAMA (Tidak Berubah)
    // =========================================================================
    
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

            // Konversi harga (ORX) ke format BigInt/Wei (asumsi 18 desimal)
            const amountInWei = ethers.parseUnits(price.toString(), 18);
            
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
            }
            alert(`❌ ${message}`);
        }
    };


    /**
     * INITIALIZATION & EVENT LISTENERS
     */
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
        
        // 2. Listener untuk tombol Beli di modal (Pemanggilan fungsi ERC-20 Transfer)
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
            
            window.ethereum.on('chainChanged', (chainId) => {
                window.location.reload(); 
            });
        }
    });

    // Panggil fungsi ini agar tersedia di scope global (untuk button onclick di HTML)
    window.updateOryAmount = updateOryAmount;
    window.buyOry = buyOry; 
    window.connectMetamask = connectMetamask; 
    window.buyBookWithORX = buyBookWithORX;
    
</script>
</body>
</html>