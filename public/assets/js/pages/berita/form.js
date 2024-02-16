
document.addEventListener("DOMContentLoaded", () => {

    const modalBerita = $('#modalBerita');
    const formBerita = $('#formBerita');
    const modalTitle = $("#modal-title");
    const btnInsert = $('#insertBerita');
    const btnCek = $('#cekBT');
    var myEditor;

    function resetForm() {
        formBerita.find(':input').val(null);
        myEditor.setData('');
    }
    

    function updateModal(title) {
        modalTitle.text(title);
    }

    // btnInsert.click(() => {
    //     modalBerita.modal('show');
    //     resetForm();
    //     updateModal('Tambah Berita');
    // });


    new AirDatepicker('#waktu', {
        container: '#modalBerita',
        autoClose: true,
        // selectedDates: [new Date()],
        position: 'top left',
    });

    // ClassicEditor
    //     .create(document.querySelector('.clasic-editor'))
    //     .then(editor => {
    //         myEditor = editor;
    //     })
    //     .catch(error => {
    //         console.error(error);
    //     });

});
