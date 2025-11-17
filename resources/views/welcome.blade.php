<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oryphem Library</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link rel="stylesheet" href="{{ asset('assets/templatemo-prism-flux.css') }}"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                            <b> {{ $item->price }} ORX</b> Token
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success buy-book-btn" data-book-id="{{ $item->id }}">Beli</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                    
                </div>
            </div>
        </div>
    @endforeach
    
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
                    <li>
                        <a href="#" class="orx-nav-link">Token</a>
                    </li>
                    <li id="metamask-status-item"> 
                        <a href="#" id="connectMetamaskBtn" class="nav-link">
                            Connect to
                            <span class="badge text-bg-warning rounded-pill">Metamask</span>
                        </a>
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

    <footer class="orx-footer">
        <div class="orx-footer-content">
            <div class="orx-footer-brand">
                <div class="orx-footer-logo">

                    <span class="orx-logo-text">
                        <span class="orx-prism">Oryphem</span>
                        <span class="orx-flux">Library</span>
                    </span>
                </div>
                <p class="orx-footer-description">
bersama Oryphem Library, kami menyediakan varian buku dengan pencatatan transaksi yang aman
                </p>
                <div class="orx-footer-social">
                    <a href="#" class="orx-social-icon">ig</a>
                    <a href="#" class="orx-social-icon">in</a>
                </div>
            </div>
            
            <div class="orx-footer-section">
                <h4>Services</h4>
                <div class="orx-footer-links">
                    <a href="#">Web Development</a>
                    <a href="#">App Development</a>
                    <a href="#">Cloud Solutions</a>
                    <a href="#">AI Integration</a>
                </div>
            </div>
            
            <div class="orx-footer-section">
                <h4>Company</h4>
                <div class="orx-footer-links">
                    <a href="#">About Us</a>
                    <a href="#">Our Team</a>
                    <a href="#">Careers</a>
                    <a href="#">Press Kit</a>
                </div>
            </div>
            
            <div class="orx-footer-section">
                <h4>Resources</h4>
                <div class="orx-footer-links">
                    <a href="#">Documentation</a>
                    <a href="#">API Reference</a>
                    <a href="#">Blog</a>
                    <a href="#">Support</a>
                </div>
            </div>
        </div>
        
        <div class="orx-footer-bottom">
            <div class="orx-copyright">
                ©2025 Oryphem Tech. All rights reserved.
            </div>
            <div class="orx-footer-credits">
                Developed by <a href="https://github.com/b4its" rel="nofollow" target="_blank">b4its</a>
            </div>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.15.0/ethers.umd.min.js" integrity="sha512-UXYETj+vXKSURF1UlgVRLzWRS9ZiQTv3lcL4rbeLyqTXCPNZC6PTLF/Ik3uxm2Zo+E109cUpJPZfLxJsCgKSng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/templatemo-prism-scripts.js') }}"></script>
<script>
    // Fungsi utilitas untuk menyingkat alamat
    const shortenAddress = (address) => {
        if (!address || address.length < 10) return address;
        return `${address.substring(0, 6)}...${address.slice(-4)}`;
    };

    // Fungsi untuk memperbarui tampilan tombol menjadi 'Terhubung'
    const updateMetamaskStatus = (address) => {
        const statusItem = document.getElementById('metamask-status-item');
        if (statusItem) {
            const shortAddress = shortenAddress(address);
            
            // Mengubah konten list item menjadi status 'Terhubung'
            statusItem.innerHTML = `
                <a href="#" id="viewAccountDetailsBtn" class="nav-link">
                    wallet was Connected:
                    <span class="badge text-bg-success rounded-pill ms-2" title="${address}">
                        ${shortAddress}
                    </span>
                </a>
            `;

            // Opsi: Tambahkan event listener untuk detail akun atau logout
            document.getElementById('viewAccountDetailsBtn').addEventListener('click', (e) => {
                e.preventDefault();
                // Tampilkan menu detail atau panggil fungsi logout/disconnect
                // alert('Alamat terhubung: ' + address);
            });
        }
    };
    
    const connectMetamask = async () => {
        // Chain ID untuk Sepolia Testnet
        const SEPOLIA_CHAIN_ID = '0xaa36a7'; // Hex untuk 11155111
        const CHAIN_ID_DECIMAL = 11155111;
        const METAMASK_ADDRESS_KEY = 'metamaskWalletAddress'; // Kunci Local Storage

        if (typeof window.ethereum === 'undefined') {
            alert('Metamask is not installed. Please install it to connect your wallet.');
            return;
        }

        try {
            const provider = new ethers.BrowserProvider(window.ethereum);
            
            // 1a. Minta koneksi akun
            const accounts = await provider.send("eth_requestAccounts", []);
            const walletAddress = accounts[0];
            
            // 1b. Dapatkan informasi jaringan saat ini
            const network = await provider.getNetwork();
            const currentChainId = Number(network.chainId);

            // 1c. Periksa dan Beralih ke Sepolia
            if (currentChainId !== CHAIN_ID_DECIMAL) {
                console.log(`Jaringan saat ini (${currentChainId}) bukan Sepolia. Mencoba beralih.`);
                try {
                    await window.ethereum.request({
                        method: 'wallet_switchEthereumChain',
                        params: [{ chainId: SEPOLIA_CHAIN_ID }],
                    });

                    // Tambahkan delay singkat (500ms) untuk memberi waktu Metamask beralih
                    await new Promise(resolve => setTimeout(resolve, 500)); 
                    
                    // Verifikasi ulang setelah delay
                    const newNetwork = await provider.getNetwork();
                    if (Number(newNetwork.chainId) !== CHAIN_ID_DECIMAL) {
                         throw new Error("Peralihan jaringan Metamask gagal atau dibatalkan pengguna.");
                    }
                    console.log("Berhasil beralih ke Sepolia.");
                } catch (switchError) {
                    if (switchError.code === 4902) {
                        alert("Sepolia belum ditambahkan ke Metamask Anda. Mohon tambahkan secara manual.");
                    } else if (switchError.code === 4001) {
                         alert("Pengguna menolak permintaan peralihan jaringan.");
                    }
                    console.error("Network switch detail:", switchError.message);
                    alert(`Gagal beralih ke Sepolia. Pastikan Anda menerima permintaan switch.`);
                    return; 
                }
            } else {
                 console.log("Sudah terhubung ke Sepolia.");
            }
            
            const signer = await provider.getSigner();
            
            // 2. Definisi pesan yang akan ditandatangani
            const signingMessage = 'Authorize connection to your Metamask wallet for this application.';
            
            // 3. Minta user menandatangani pesan
            const signature = await signer.signMessage(signingMessage);

            // 4. Kirim data ke backend Laravel
            const response = await fetch('/connect-metamask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Mengambil CSRF token dari meta tag
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                },
                body: JSON.stringify({
                    wallet_address: walletAddress,
                    signature: signature
                })
            });

            if (response.ok) {
                // Simpan alamat di Local Storage sebelum redirect
                localStorage.setItem(METAMASK_ADDRESS_KEY, walletAddress); 
                
                const data = await response.json();
                // Mengarahkan ke URL yang dikirim oleh Controller
                window.location.href = data.redirect || '/'; 
            } else {
                // Tangani error verifikasi atau error 4xx lainnya dari Controller
                const errorData = await response.json();
                alert(`Connection failed: ${errorData.message || 'Server error.'}`);
            }

        } catch (error) {
            console.error("Metamask connection error:", error);
            alert(`Connection failed: ${error.message || 'Failed to connect Metamask or user rejected the request.'}`);
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        // --- LOGIKA UTAMA (Memeriksa Status Koneksi di Local Storage) ---
        const METAMASK_ADDRESS_KEY = 'metamaskWalletAddress';
        const storedAddress = localStorage.getItem(METAMASK_ADDRESS_KEY);

        if (storedAddress) {
            // Jika ada alamat tersimpan, tampilkan sebagai "Terhubung"
            updateMetamaskStatus(storedAddress);
        } else {
            // Jika tidak ada alamat tersimpan, pasang event listener untuk tombol koneksi
            const connectButton = document.getElementById('connectMetamaskBtn');
            if (connectButton) {
                connectButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    connectMetamask();
                });
            }
        }

        // Opsional: Listener untuk perubahan akun dari Metamask saat halaman aktif
        if (typeof window.ethereum !== 'undefined') {
            window.ethereum.on('accountsChanged', (accounts) => {
                if (accounts.length > 0) {
                    // Akun berubah atau dikunci
                    localStorage.setItem(METAMASK_ADDRESS_KEY, accounts[0]);
                    window.location.reload(); // Refresh halaman untuk memuat ulang status
                } else {
                    // Akun terputus
                    localStorage.removeItem(METAMASK_ADDRESS_KEY);
                    window.location.reload(); // Refresh halaman untuk kembali ke status 'Connect'
                }
            });
            // Listener untuk perubahan jaringan
            window.ethereum.on('chainChanged', (chainId) => {
                // Biasanya refresh halaman diperlukan saat chain berubah untuk konsistensi
                window.location.reload(); 
            });
        }
    });
</script>
    </body>
</html>