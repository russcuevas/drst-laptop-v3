// deleting cart ajax query
document.addEventListener('DOMContentLoaded', function () {
    var deleteIcons = document.querySelectorAll('.icon_close');

    deleteIcons.forEach(function (icon) {
        icon.addEventListener('click', function () {
            var cart_id = icon.getAttribute('data-cart-id');

            fetch('/delete-cart/' + cart_id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    localStorage.setItem('successMessage', data.message);
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
        });
    });
    var successMessage = localStorage.getItem('successMessage');
    if (successMessage) {
        var alertDiv = document.querySelector('.alert.alert-success');
        if (alertDiv) {
            alertDiv.textContent = successMessage;
            alertDiv.style.display = 'block';
            localStorage.removeItem('successMessage');
        }
    }
});


// delete all-cart ajax query
$(document).ready(function () {
    $('.cart-btn-right').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'GET',
            url: '/delete-all-cart',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // for debugging
                console.log(data);
                localStorage.setItem('successMessage', data.message);
                window.location.reload();
            },
            error: function (error) {
                console.error(error);
                var errorMessage = error.responseJSON.message;
                localStorage.setItem('errorMessage', errorMessage);
                window.location.reload();
            }
        });
    });
    var successMessage = localStorage.getItem('successMessage');
    var errorMessage = localStorage.getItem('errorMessage');

    if (successMessage) {
        var alertDiv = document.querySelector('.alert.alert-success');
        if (alertDiv) {
            alertDiv.textContent = successMessage;
            alertDiv.style.display = 'block';
            localStorage.removeItem('successMessage');
        }
    } else if (errorMessage) {
        var alertDiv = document.querySelector('.alert.alert-danger');
        if (alertDiv) {
            alertDiv.textContent = errorMessage;
            alertDiv.style.display = 'block';
            localStorage.removeItem('errorMessage');
        }
    }
});
