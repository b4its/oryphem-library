// JavaScript Document

/*

TemplateMo 600 Prism Flux

https://templatemo.com/tm-600-prism-flux

*/

// Variabel global untuk menyimpan data buku
let portfolioData = []; 

// --- Portfolio data for carousel ---

async function fetchBookData() {
    try {
        // Panggil endpoint API Laravel
        const response = await fetch('/api/books'); 
        
        if (!response.ok) {
            // Lempar error untuk status HTTP yang tidak berhasil (e.g., 404, 500)
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Data JSON dari Laravel akan diubah menjadi array objek JavaScript.
        const bookData = await response.json(); 
        console.log("Data buku berhasil diambil:", bookData); 
        return bookData;
    } catch (error) {
        console.error('Error fetching book data:', error);
        // Kembalikan array kosong jika terjadi kesalahan
        return []; 
    }
}

// --- FUNGSI BARU UNTUK MEMBATASI TEKS ---
function truncateText(text, maxLength) {
    if (!text || text.length <= maxLength) {
        return text;
    }
    // Potong teks dan tambahkan elipsis
    return text.substring(0, maxLength) + '...';
}


// Scroll to section function
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    const header = document.getElementById('header');
    if (section && header) { // Tambahkan pengecekan header
        const headerHeight = header.offsetHeight;
        const targetPosition = section.offsetTop - headerHeight;
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}

// Initialize particles for philosophy section
function initParticles() {
    const particlesContainer = document.getElementById('particles');
    if (!particlesContainer) return; // Keluar jika kontainer tidak ditemukan
    
    const particleCount = 15;
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        // PREFIX: particle -> orx-particle
        particle.className = 'orx-particle';
        
        // Random horizontal position
        particle.style.left = Math.random() * 100 + '%';
        
        // Start particles at random vertical positions throughout the section
        particle.style.top = Math.random() * 100 + '%';
        
        // Random animation delay for natural movement
        particle.style.animationDelay = Math.random() * 20 + 's';
        
        // Random animation duration for variety
        particle.style.animationDuration = (18 + Math.random() * 8) + 's';
        
        particlesContainer.appendChild(particle);
    }
}

// Initialize carousel
let currentIndex = 0;
const carousel = document.getElementById('carousel');
const indicatorsContainer = document.getElementById('indicators');

function createCarouselItem(data, index) {
    const item = document.createElement('div');
    // PREFIX: carousel-item -> orx-carousel-item
    item.className = 'orx-carousel-item';
    item.dataset.index = index;
    
    // Pastikan data.idCategory adalah array sebelum menggunakan map, 
    // dan tangani kasus di mana nilainya bukan array (misalnya string tunggal atau null).
    const categories = Array.isArray(data.idCategory) ? data.idCategory : [data.idCategory].filter(c => c);
    
    const techBadges = categories.map(category => 
        // PREFIX: tech-badge -> orx-tech-badge
        `<span class="orx-tech-badge">${category}</span>`
    ).join('');
    const shortDescription = truncateText(data.descriptions, 150);
    
    // Semua kelas custom di dalam string HTML ini harus di-prefix
    item.innerHTML = `
        <div class="orx-card-box">
            <div class="orx-card-number">0${data.id}</div>
            <div class="orx-card-image">
                <img src="${data.gambar}" alt="${data.name}">
            </div>
            <h3 class="orx-card-title">${data.name}</h3>
            <div class="orx-card-description">
            ${shortDescription}..
            </div>
            <div class="orx-card-tech">${techBadges}</div>
            <div>
                <p class="badge text-bg-success rounded-pill">Price: ${data.price} ORX</p>
            </div>
            <button class="orx-card-cta" data-bs-toggle="modal" data-bs-target="#modal-${data.id}">
                Jelajahi
            </button>
        </div>


    `;
    
    return item;
}

function initCarousel() {
    if (!carousel || !indicatorsContainer || portfolioData.length === 0) {
        console.warn("Carousel element or data not found. Skipping carousel initialization.");
        return; // Hentikan inisialisasi jika tidak ada data/elemen
    }
    
    // Kosongkan carousel dan indikator sebelumnya
    carousel.innerHTML = '';
    indicatorsContainer.innerHTML = '';
    currentIndex = 0; // Reset index saat inisialisasi
    
    // Create carousel items
    portfolioData.forEach((data, index) => {
        const item = createCarouselItem(data, index);
        carousel.appendChild(item);
        
        // Create indicator
        const indicator = document.createElement('div');
        // PREFIX: indicator -> orx-indicator
        indicator.className = 'orx-indicator';
        // PREFIX: active -> orx-active
        if (index === 0) indicator.classList.add('orx-active');
        indicator.dataset.index = index;
        indicator.addEventListener('click', () => goToSlide(index));
        indicatorsContainer.appendChild(indicator);
    });
    
    updateCarousel();
}

function updateCarousel() {
    if (portfolioData.length === 0) return;
    
    // PREFIX: .carousel-item -> .orx-carousel-item
    const items = document.querySelectorAll('.orx-carousel-item');
    // PREFIX: .indicator -> .orx-indicator
    const indicators = document.querySelectorAll('.orx-indicator');
    const totalItems = items.length;
    const isMobile = window.innerWidth <= 768;
    const isTablet = window.innerWidth <= 1024;
    
    items.forEach((item, index) => {
        // Calculate relative position
        let offset = index - currentIndex;
        
        // Wrap around for continuous rotation
        if (offset > totalItems / 2) {
            offset -= totalItems;
        } else if (offset < -totalItems / 2) {
            offset += totalItems;
        }
        
        const absOffset = Math.abs(offset);
        const sign = offset < 0 ? -1 : 1;
        
        // Reset transform
        item.style.transform = '';
        item.style.opacity = '';
        item.style.zIndex = '';
        // Tetapkan transisi hanya sekali, tapi di sini untuk memastikan, tidak masalah.
        item.style.transition = 'all 0.8s cubic-bezier(0.4, 0.0, 0.2, 1)'; 
        
        // Adjust spacing based on screen size
        let spacing1 = 400;
        let spacing2 = 600;
        let spacing3 = 750;
        
        if (isMobile) {
            spacing1 = 280; 
            spacing2 = 420;
            spacing3 = 550;
        } else if (isTablet) {
            spacing1 = 340;
            spacing2 = 520;
            spacing3 = 650;
        }
        
        // Aturan untuk penempatan 3D
        if (absOffset === 0) {
            // Center item
            item.style.transform = 'translate(-50%, -50%) translateZ(0) scale(1)';
            item.style.opacity = '1';
            item.style.zIndex = '10';
        } else if (absOffset === 1) {
            // Side items
            const translateX = sign * spacing1;
            const rotation = isMobile ? 25 : 30;
            const scale = isMobile ? 0.88 : 0.85;
            item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-200px) rotateY(${-sign * rotation}deg) scale(${scale})`;
            item.style.opacity = '0.8';
            item.style.zIndex = '5';
        } else if (absOffset === 2) {
            // Further side items
            const translateX = sign * spacing2;
            const rotation = isMobile ? 35 : 40;
            const scale = isMobile ? 0.75 : 0.7;
            item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-350px) rotateY(${-sign * rotation}deg) scale(${scale})`;
            item.style.opacity = '0.5';
            item.style.zIndex = '3';
        } else if (absOffset === 3) {
            // Even further items
            const translateX = sign * spacing3;
            const rotation = isMobile ? 40 : 45;
            const scale = isMobile ? 0.65 : 0.6;
            item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-450px) rotateY(${-sign * rotation}deg) scale(${scale})`;
            item.style.opacity = '0.3';
            item.style.zIndex = '2';
        } else {
            // Hidden items (behind)
            // Cepat pindahkan yang lainnya ke belakang dan sembunyikan untuk performa.
            item.style.transform = 'translate(-50%, -50%) translateZ(-500px) scale(0.5)';
            item.style.opacity = '0';
            item.style.zIndex = '1';
        }
    });
    
    // Update indicators
    indicators.forEach((indicator, index) => {
        // PREFIX: active -> orx-active
        indicator.classList.toggle('orx-active', index === currentIndex);
    });
}

function nextSlide() {
    if (portfolioData.length === 0) return;
    currentIndex = (currentIndex + 1) % portfolioData.length;
    updateCarousel();
}

function prevSlide() {
    if (portfolioData.length === 0) return;
    currentIndex = (currentIndex - 1 + portfolioData.length) % portfolioData.length;
    updateCarousel();
}

function goToSlide(index) {
    if (portfolioData.length === 0) return;
    currentIndex = index;
    updateCarousel();
}


// --- Fungsi Utama untuk Menangani Initialisasi Asinkron ---

async function mainInitialization() {
    // 1. Ambil data buku
    portfolioData = await fetchBookData();
    
    // 2. Lanjutkan inisialisasi yang bergantung pada data
    initCarousel(); 
    initParticles(); // Partikel tidak tergantung pada data buku
    
    // 3. Tambahkan event listeners hanya jika ada data untuk carousel
    if (portfolioData.length > 0) {
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        
        // Pengecekan null agar tidak terjadi error jika tombol tidak ada
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);

        // Auto-rotate carousel
        setInterval(nextSlide, 5000);

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') prevSlide();
            if (e.key === 'ArrowRight') nextSlide();
        });
        
        // Update carousel on window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                updateCarousel();
            }, 250);
        });
    }
}


// --- Sisanya dari kode (tidak terlalu banyak perubahan) ---

// Mobile menu toggle
const menuToggle = document.getElementById('menuToggle');
const navMenu = document.getElementById('navMenu');

if (menuToggle && navMenu) { // Pengecekan null
    menuToggle.addEventListener('click', () => {
        // PREFIX: active -> orx-active
        navMenu.classList.toggle('orx-active');
        menuToggle.classList.toggle('orx-active');
    });
}


// Header scroll effect
const header = document.getElementById('header');
if (header) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            // PREFIX: scrolled -> orx-scrolled
            header.classList.add('orx-scrolled');
        } else {
            header.classList.remove('orx-scrolled');
        }
    });
}


// Smooth scrolling and active navigation
const sections = document.querySelectorAll('section[id]');
// PREFIX: .nav-link -> .orx-nav-link
const navLinks = document.querySelectorAll('.orx-nav-link');

navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        scrollToSection(targetId); // Gunakan fungsi scrollToSection yang sudah ada
        
        // Close mobile menu if open
        if (navMenu && menuToggle) {
            // PREFIX: active -> orx-active
            navMenu.classList.remove('orx-active');
            menuToggle.classList.remove('orx-active');
        }
    });
});

// Update active navigation on scroll
function updateActiveNav() {
    const headerHeight = header ? header.offsetHeight : 0; // Ambil tinggi header, default 0 jika null
    const scrollPosition = window.scrollY + headerHeight + 10; // Sesuaikan sedikit untuk penanda yang lebih baik
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        const sectionId = section.getAttribute('id');
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                // PREFIX: active -> orx-active
                link.classList.remove('orx-active');
                const href = link.getAttribute('href').substring(1);
                if (href === sectionId) {
                    link.classList.add('orx-active');
                }
            });
        }
    });
}

window.addEventListener('scroll', updateActiveNav);
// Panggil sekali saat load untuk mengatur link aktif yang pertama
document.addEventListener('DOMContentLoaded', updateActiveNav); 

// Animated counter for stats
function animateCounter(element) {
    const target = parseInt(element.dataset.target);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const counter = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target;
            clearInterval(counter);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Intersection Observer for stats animation
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px 0px -100px 0px'
};

// PREFIX: .stats-section -> .orx-stats-section
const statsSection = document.querySelector('.orx-stats-section');
if (statsSection) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // PREFIX: .stat-number -> .orx-stat-number
                const statNumbers = entry.target.querySelectorAll('.orx-stat-number');
                statNumbers.forEach(number => {
                    // PREFIX: animated -> orx-animated
                    if (!number.classList.contains('orx-animated')) {
                        number.classList.add('orx-animated');
                        animateCounter(number);
                    }
                });
                // Hentikan pengamatan setelah terpicu
                observer.unobserve(entry.target); 
            }
        });
    }, observerOptions);
    observer.observe(statsSection);
}

// Loading screen
window.addEventListener('load', () => {
    // Tambahkan panggilan mainInitialization di sini
    mainInitialization(); 
    
    setTimeout(() => {
        const loader = document.getElementById('loader');
        if (loader) {
            // PREFIX: hidden -> orx-hidden
            loader.classList.add('orx-hidden');
        }
    }, 1500);
});

// Add parallax effect to hero section
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    // PREFIX: .hero -> .orx-hero
    const parallax = document.querySelector('.orx-hero');
    if (parallax) {
        parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});