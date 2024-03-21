 {{-- MODAL INSERT --}}
 <div class="modal fade" id="modalPeriode" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
     aria-labelledby="modalInsertLabel" aria-hidden="true">
     <div class="modal-dialog modal-md" role="document">
         <div class="modal-content">
             <div class="block block-rounded block-transparent mb-0">
                 <div class="block-header block-header-default">
                     <h3 class="block-title" id="modal-title"></h3>
                     <div class="block-options">
                         <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                             aria-label="Close">
                             <i class="fa fa-fw fa-times"></i>
                         </button>
                     </div>
                 </div>
                 <div class="block-content fs-sm">
                     {{-- FORM --}}
                     <form methos="POST" id="form-periode">
                         @csrf
                         <input type="hidden" name="_method" id="method" value="POST">

                         <input type="text" name="idPeriode" id="idPeriode" hidden>
                         <div class="mb-3">
                             <label class="form-label" for="semester">Semester</label>
                             <select type="text" class="form-select" id="semester" name="semester" required>
                                 <option value="" disabled selected>Pilih Semester</option>
                                 <option value="Ganjil">Ganjil</option>
                                 <option value="Genap">Genap</option>
                             </select>
                         </div>
                         <div class="mb-3">
                             <label class="form-label" for="tanggalMulai">Tanggal Mulai</label>
                             <input type="text" class="form-control" id="tanggalMulai" name="tanggalMulai" placeholder="Masukan Tanggal Mulai" required>
                         </div>
                         <div class="mb-3">
                             <label class="form-label" for="tanggalSelesai">Tanggal Selesai</label>
                             <input type="text" class="form-control" id="tanggalSelesai" name="tanggalSelesai" placeholder="Masukan Tanggal Selesai" required>
                         </div>
                         <div class="mb-4 text-end" id="btn-form">
                         </div>
                     </form>
                 </div>
                 <div class="block-content block-content-full bg-body">
                 </div>
             </div>
         </div>
     </div>
 </div>
