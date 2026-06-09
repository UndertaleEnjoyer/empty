<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 py-4" style="min-height: 100vh;">
    <div class="mb-4">
        {{ $logo }}
    </div>

    <div class="w-100 mx-auto" style="max-width: 450px; padding: 0 1.5rem;">
        {{ $slot }}
    </div>
</div>

<style>
    .min-vh-100 {
        min-height: 100vh;
    }
</style>
