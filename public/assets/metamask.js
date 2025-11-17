const connectMetamask = async () => {
    if (typeof window.ethereum === 'undefined') {
        alert('Metamask is not installed. Please install it to connect your wallet.');
        return;
    }

    try {
        // 1. Minta koneksi ke Metamask
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        await provider.send("eth_requestAccounts", []);
        const signer = provider.getSigner();
        const walletAddress = await signer.getAddress();

        // 2. Definisi pesan yang akan ditandatangani
        // PESAN INI HARUS SAMA PERSIS DENGAN YANG DI CONTROLLER!
        const signingMessage = 'Authorize connection to your Metamask wallet for this application.';
        
        // 3. Minta user menandatangani pesan
        const signature = await signer.signMessage(signingMessage);

        // 4. Kirim data ke backend Laravel
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
            // Berhasil, Laravel akan mengarahkan ke dashboard
            window.location.href = response.url; 
        } else {
            // Tangani error dari backend (misalnya verifikasi gagal)
            const errorData = await response.json();
            alert(`Connection failed: ${errorData.message || 'Server error.'}`);
        }

    } catch (error) {
        console.error("Metamask connection error:", error);
        alert('Failed to connect Metamask or user rejected the request.');
    }
};

// Hubungkan fungsi di atas ke tombol Anda
document.addEventListener('DOMContentLoaded', () => {
    const connectButton = document.querySelector('.nav-link[href="#metamask"]');
    if (connectButton) {
        // Hapus href="#" dan ganti dengan event listener
        connectButton.addEventListener('click', (e) => {
            e.preventDefault();
            connectMetamask();
        });
    }
});

