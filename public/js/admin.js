
$(document).ready(function() {
    $('#hostTable').DataTable({
        serverSide: true,
        draw: 1,
        "createdRow": function (row, data, dataIndex) {
            var ipCell = $(row).find('td:eq(2)'); 
            var locationCell = $(row).find('td:eq(3)');
            var typeCell = $(row).find('td:eq(4)'); 
            ipCell.addClass('rowDisplay');
            locationCell.addClass('rowDisplay');
            typeCell.addClass('rowDisplay');
        },
        "columnDefs": [
            {
                "targets": [5, 6],
                "searchable": false
            }
        ],
        
        "order": [],
        "dom": 'frtp',
        "pagingType": 'simple',
        "responsive": true,
        "ajax": {
            url: '/hostData',
            type: 'GET',
        },
        "columns": [
            { "data": "name" },
            { "data": "provider_name" },
            { "data": "ip" },
            { "data": "location" },
            { "data": "type" },
            { "data": "edit", "orderable": false },
            { "data": "delete", "orderable": false }
        ]
    });


    $('#providerTable').dataTable({
        serverSide: true,
        draw: 1,
        "order": [],
        "columnDefs": [
            {
                "targets": [1],
                "searchable": false
            }
        ],
        "dom": 'frtp',
        "pagingType": 'simple',
        "responsive": "true",

        "ajax": {
            url: '/providerData',
            type: 'GET',
        },
        "columns": [
            { "data": "name" },
            { "data": "delete", "orderable": false }
        ]
    });
});

function message(id) {
    Swal.fire({
        background: '#2D333F',
        title: 'Are you sure?',
        color: 'white',
        icon: 'warning',
        iconColor: 'red',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/host/delete/' + id;
        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: "Deletion Canceled",
            })
        }
    })
}

function message1(id1) {
    Swal.fire({
        background: '#2D333F',
        title: 'Are you sure?',
        color: 'white',
        text: "Deleting a provider will also delete all connected hosts",
        icon: 'warning',
        iconColor: 'red',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/provider/delete/' + id1;
        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                title: "Deletion Canceled",
            })
        }
    })
}