<footer id="page-footer" class="bg-body-light">
    <div class="content py-3">
        <div class="row fs-sm">
            <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>
                <a class="fw-semibold" href="{{ route('home') }}" target="_blank">SD NEGERI LEMAHBANG</a>
            </div>
            <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">

            </div>
        </div>
    </div>
</footer>
</div>

@stack('scripts')

<script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/air-datepicker/dist/air-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#logoutBtn').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan logout melalui AJAX
                    $.ajax({
                        url: '{{ route('logout') }}',
                        type: 'POST', // Metode harus POST untuk logout di Laravel
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Redirect atau lakukan sesuai kebutuhan setelah logout berhasil
                            window.location.href = '{{ route('home') }}';
                        }
                    });
                }
            });
        });
    });
</script>
</body>

</html>
