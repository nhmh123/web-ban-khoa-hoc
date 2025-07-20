export function getUserCart(url) {
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
                                        <form onsubmit="return handleDeleteItem(event, ${
                                            course.id
                                        })">
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger">Xóa</button>
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

export function updateCartTotal(url) {
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

export function clearCart(url) {
    $.ajax({
        type: "DELETE",
        url: url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}
