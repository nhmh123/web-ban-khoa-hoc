//==============INIT==============//

// AOS init
AOS.init();

// Swiper init
var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//==============FORMAT==============//
function formatCurrency(amount) {
    return parseInt(amount).toLocaleString("vi-VN");
}

//==============API==============//

function handleApiError(
    xhr,
    fallbackMessage = "Đã xảy ra lỗi. Vui lòng thử lại."
) {
    const res = xhr.responseJSON;
    let message = fallbackMessage;

    if (res) {
        if (res.detail) {
            message = res.detail;
        } else if (res.title) {
            message = res.title;
        }

        if (res.code) {
            console.warn("[API ERROR CODE]:", res.code);
        }

        if (res.type) {
            console.info("[API DOC]:", res.type);
        }
    } else {
        switch (xhr.status) {
            case 401:
                message = "Bạn cần đăng nhập để thực hiện thao tác này.";
                break;
            case 403:
                message = "Bạn không có quyền truy cập.";
                break;
            case 404:
                message = "Không tìm thấy tài nguyên yêu cầu.";
                break;
            case 500:
                message = "Lỗi máy chủ. Vui lòng thử lại sau.";
                break;
        }
    }

    alert(message);
}

//==============DISPLAY MESSAGE==============//

function displaySuccessToast(message) {
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

function displayErrorAlert(title, detail, redirect = "") {
    Swal.fire({
        icon: "error",
        title: title,
        text: detail,
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

//==============CART==============//

function getUserCart(url, deleteUrl) {
    $.ajax({
        type: "GET",
        url: url,
        success: function (response) {
            console.log(response.data);
            let items = response.data;
            let html = "";

            items.forEach((item) => {
                let course = item.course;

                html += `
                
                    <div class="card border-0 p-0 my-2">
                        <div class="row g-0">
                            <div class="col-md-1 d-flex align-items-center justify-content-start">
                                <input type="checkbox" name="ids[]" value="${
                                    course.course_id
                                }" checked>
                            </div>
                            <div class="col-md-3">
                                <img src="${
                                    course.thumbnail
                                }" class="rounded-start w-100 h-100"
                                    style="object-fit: cover;" alt="Course Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body py-0 my-0 d-flex flex-column h-100">
                                    <h5 class="card-title fs-6 fw-bold">${
                                        course.name
                                    }</h5>
                                    <p class="card-text small mb-1"></p>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div>
                                            <p class="mb-0 text-end fw-bold">
                                                ${formatCurrency(
                                                    course.original_price
                                                )}đ
                                            </p>
                                        </div>
                                        <form action="{{ route('user.cart.remove', ${course.id}) }}"
                                            method="POST" name="remove-cart-item-form"
                                            data-course-id="${course.id}">
                                            <button type="submit" class="btn btn-sm p-0 outline-none border-none">
                                                <i class="bi bi-trash text-dark fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                `;
            });

            $("#cart-container").html(html);
        },
    });
}

function updateCartTotal(url) {
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (response) {
            const cartElement = $("#user-cart-total");
            // console.log(cartElement, response.cartTotal);
            if (cartElement) {
                const count = response.cartTotal ?? 0;

                if (count > 0) {
                    $("#user-cart-total").text(count).removeClass("d-none");
                } else {
                    $("#user-cart-total").text("").addClass("d-none");
                }
            }
        },
        error: function (xhr) {
            console.error("Lỗi khi cập nhật giỏ hàng:", xhr.responseText);
        },
    });
}

function clearCart(url) {
    $.ajax({
        type: "DELETE",
        url: url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}
