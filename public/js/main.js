$(document).ready(function() {
    var dataTable = $('#table').DataTable({
        "scrollY": "245px",
        "scrollX": "100%",
        "scrollCollapse": true,
        "dom": '<"top">ct<"top"p><"clear">'

    });
    $('#actived').click(function() {
        $('#sidenav').toggleClass('active')
    })
    $("#filterbox").keyup(function() {
        dataTable.search(this.value).draw();
    });
    $('body').click(function() {
        console.log("width", window.innerWidth)
        console.log("height", window.innerHeight)
    })
});