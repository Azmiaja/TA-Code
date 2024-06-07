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
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> --}}
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/air-datepicker/dist/air-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/print-this/printThis.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

@if (session('status') === 'success')
    <script>
        var title = `{{ session('title') }}`;
        var msg = `{{ session('message') }}`;
        // alert(title, msg);
        document.addEventListener("DOMContentLoaded", () => {
            Swal.fire({
                icon: 'success',
                title: title,
                text: msg,
                showConfirmButton: false,
                timer: 1500 // Optional: Auto-close after 1.5 seconds
            });
        });
    </script>
@endif

<script>
    $(document).ready(function() {
        $('#logoutBtn').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
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

    // Fungsi Untuk Update/Custom Modal
    function updateModals(md_title, md_button, title, button) {
        md_title.text(title);
        md_button.html(button);
    }

    // Fungsi Show Modal Insert
    function showModalInsert(button1, modal, form, url, fr_method, md_title, md_button, title, button2) {
        button1.click(function(e) {
            e.preventDefault();
            modal.modal('show');
            form.attr('action', url);
            fr_method.val('POST');
            updateModals(md_title, md_button, title, button2);
        });
    }


    // Fungsi Insert dan Update Data
    function insertOrUpdateData(form, options) {
        form.submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: response.status,
                            title: response.title,
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        options();
                    } else {
                        Swal.fire({
                            icon: response.status,
                            title: response.title,
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                },
            });
        });
    }

    // Fungsi Reset Form
    function resetForm(form, options) {
        form.trigger('reset');
        options();
    }

    // Fungsi Select2 Multiple
    function select2Multiple(select, modal) {
        $(select).select2({
            width: "100%",
            dropdownParent: modal,
            theme: "bootstrap-5",
            multiple: true,
        });
    }

    // Fungsi Select2
    function select2(select, modal) {
        $(select).select2({
            width: '100%',
            cache: false,
            dropdownParent: modal,
            theme: "bootstrap-5",
            placeholder: $(this).data('placeholder'),
            allowClear: true,
        });
    }

    function fileExists(url) {
        let http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return http.status !== 404;
    }
    
</script>
</body>

</html>
