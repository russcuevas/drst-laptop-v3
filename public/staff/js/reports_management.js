// deleting reports
function confirmDelete(url) {
    swal({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }, function (isConfirmed) {
        if (isConfirmed) {
            setTimeout(function () {
                swal({
                    title: 'Deleted!',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function () {
                    window.location.href = url;
                }, 1500);
            }, 500);
        }
    });
}