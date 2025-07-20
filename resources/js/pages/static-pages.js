import { showConfirmDeleteAlert } from "../helpers/notifications";
console.log("static-pages.js loaded");

export function deletePage(url, csrf, pageId) {
    return $.ajax({
        type: "DELETE",
        url: url,
        headers: {
            "X-CSRF-TOKEN": csrf,
        },
        data: { page_id: pageId },
        success: function (response) {
            alert("Page deleted successfully");
        },
    });
}
