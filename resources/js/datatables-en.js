// Initiate datatables in roles, tables, users page
;(function () {
    'use strict'

    $('#dataTables').DataTable({
        responsive: true,
        pageLength: 20,
        lengthChange: false,
        searching: true,
        ordering: true,
        paging: false,
        info: false
    })
})()
