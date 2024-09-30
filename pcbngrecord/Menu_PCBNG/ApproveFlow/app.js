$('#first').select2({
    theme: "bootstrap-5",
    width: "700px",
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false,
});
$('#second').select2({
    theme: "bootstrap-5",
    width: "700px",
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false,
});
$('#third').select2({
    theme: "bootstrap-5",
    width: "700px",
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false,
});
$('#fourth').select2({
    theme: "bootstrap-5",
    width: "700px",
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false,
});

$(document).ready(function() {
    $('#approve').dataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        scrollX: true,
        scrollY: "65vh",
        scrollCollapse: true,

    })

})