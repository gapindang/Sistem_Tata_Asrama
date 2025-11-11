{{-- JQuery dulu --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Baru Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Script custom (menu-link handler, stack, dsb) --}}
<script>
    $(document).ready(function() {
        $('.menu-link').on('click', function(e) {
            e.preventDefault();
            const url = $(this).data('url');

            $('#main-content').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Memuat...</p>
                </div>
            `);

            $.get(url, function(data) {
                $('#main-content').hide().html(data).fadeIn(200);
            }).fail(function() {
                $('#main-content').html(`
                    <div class="alert alert-danger m-3">
                        Gagal memuat konten. Coba lagi nanti.
                    </div>
                `);
            });
        });
    });
</script>
