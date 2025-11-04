<x-petugas-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Tiket
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="qr-reader" style="width: 500px"></div>
                    <div id="qr-reader-results"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);

            let resultsDiv = document.getElementById('qr-reader-results');
            resultsDiv.innerHTML = 'Verifying...';

            fetch('/api/verify-booking', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_data: decodedText })
            })
            .then(response => {
                console.log(response);
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (data.error) {
                    resultsDiv.innerHTML = `<div class="text-red-500">Error: ${data.error}</div>`;
                } else {
                    resultsDiv.innerHTML = `
                        <div class="text-green-500">Booking Verified!</div>
                        <div><strong>Booking Code:</strong> ${data.booking_code}</div>
                        <div><strong>Ticket:</strong> ${data.ticket.name}</div>
                        <div><strong>Name:</strong> ${data.user.name}</div>
                        <div><strong>Visit Date:</strong> ${data.visit_date}</div>
                        <div><strong>Quantity:</strong> ${data.quantity}</div>
                        <div><strong>Status:</strong> ${data.status}</div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultsDiv.innerHTML = `<div class="text-red-500">An error occurred.</div>`;
            });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            // console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            {
                fps: 10,
                qrbox: {width: 250, height: 250}
            },
            /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
    @endpush
</x-petugas-layout>
