<footer id="page-footer" class="bg-body-light">
    {{-- modal konfirmasi logout --}}
    <div class="modal fade" id="logoutAlert" tabindex="-1" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="content py-3">
        <div class="row fs-sm">
            <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                <a class="fw-semibold" href="#" target="_blank">SDN LEMAHBANG</a> &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>
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
{{-- <script src="{{ asset('assets/js/plugins/ckeditor5/build/ckeditor5-dll.js') }}"></script> --}}
<script src="{{ asset('assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>

<script>
One.helpersOnLoad(['js-ckeditor5', 'js-flatpickr']);
</script>
</body>

</html>