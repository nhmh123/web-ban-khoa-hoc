export function displaySuccessToast(message) {
    Toastify({
        text: message,
        duration: 3000,
        destination: "https://github.com/apvarun/toastify-js",
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () {}, // Callback after click
    }).showToast();
}
export function displayErrorAlert(title, detail, redirect = "") {
    Swal.fire({
        icon: "error",
        title: title,
        text: detail,
        footer:
            redirect !== ""
                ? redirect
                : '<a href="#">Why do I have this issue?</a>',
    });
}
function showConfirmDeleteAlert(
    title,
    text,
    confirmText,
    cancelText,
    afterDeletedTitle,
    afterDeletedText,
    onConfirmFunction
) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });
    swalWithBootstrapButtons
        .fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                onConfirmFunction().then(() => {
                    swalWithBootstrapButtons.fire({
                        title: afterDeletedTitle,
                        text: afterDeletedText,
                        icon: "success",
                    });
                });
            }
        });
}

window.showConfirmDeleteAlert = showConfirmDeleteAlert;