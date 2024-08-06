<!-- Footer -->
<footer class="custom-footer mt-auto py-3">
    <div class="container text-center">
        <p class="mb-0" style="display: flex; justify-content: center; align-items: center;">
            <img src="{{ asset('assets/images/kat.png') }}" alt="Logo KAT" style="height: 2em; margin-left: 10px;">
        </p>
        <p class="mb-0" style="display: flex; justify-content: center; align-items: center;">
            &copy; {{ date('Y') }} CV. KAT Inovasi Bersama. All rights reserved.
        </p>
    </div>
</footer>

<style>
    /* Custom Footer Styling */
    .custom-footer {
        background-color: #ffffff;
        color: #343a40;
        padding: 1.5rem 0;
        font-size: 0.875rem;
    }

    .custom-footer p {
        margin-bottom: 0;
    }

    .custom-footer .footer-link {
        color: #17a2b8;
        text-decoration: none;
    }

    .custom-footer .footer-link:hover {
        text-decoration: underline;
        color: #138496;
    }
</style>