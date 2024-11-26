const $document = $(document);
const modal = $(".modal");
const main = $("main");
const menuUser = $(".menu-user");
const loading = $("#loading");
const startLoading = () => loading.fadeIn();
const stopLoading = () => loading.fadeOut();
// startLoading();
// stopLoading();
$document.ready(function () {
    handleCountCart();
});
$document.ajaxStart(() => startLoading());
$document.ajaxStop(() => stopLoading());
function formatCurrency(price) {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(price);
}

$document.on("click", "#btn-cart", function () {
    window.location.href = "/gio-hang";
});

$document.on("click", ".box-avatar-nav", function () {
    menuUser.toggleClass("show");
});

$document.on("click", function (event) {
    if (
        !$(event.target).closest(".menu-user").length &&
        !$(event.target).closest(".box-avatar-nav").length
    ) {
        menuUser.removeClass("show");
    }
});

function Toast({ message = "", type = "info", duration = 5000 }) {
    const notifications = document.querySelector(".notifications");
    if (notifications) {
        let newToast = document.createElement("div");
        const icons = {
            success: "fas fa-check-circle",
            info: "fas fa-exclamation-circle",
            warning: "fas fa-exclamation-triangle",
            error: "fas fa-times-circle",
        };
        const icon = icons[type];
        const delay = (duration / 1000).toFixed(2);
        newToast.style.animation = `show 0.5s ease 1 forwards, hide 0.5s ease 1 forwards ${delay}s`;

        newToast.innerHTML = `
        <div class="toast ${type} show">
        <i class="${icon}"></i>
        <div class="content">
        <span>${message}</span>
        </div>
        <i class="fas fa-times" onclick="(this.parentElement).remove()"></i>
        </div>`;
        notifications.appendChild(newToast);
        newToast.timeOut = setTimeout(() => newToast.remove(), duration + 500);
    }
}
const handleCountCart = () => {
    $.get("/carts/count", function (response, status) {
        if (status === "success") {
            let count = response ?? 0;
            $("#count-cart").text(count > 99 ? "99+" : count);
        }
    });
};

function openModal({
    title = "",
    body = "",
    ok = "",
    cancel = "",
    size = "modal-lg",
    footer = true,
    icon = true,
}) {
    modal.find(".modal-title").text(title);
    modal.find(".modal-title").addClass("text-uppercase");
    modal.find(".modal-title").addClass("text-center");
    modal.find(".modal-title").addClass("w-100");
    modal.find(".modal-body").empty().append(body);
    if (ok === "") {
        modal.find(".btn-primary").addClass("d-none");
    } else {
        modal.find(".btn-primary").text(ok);
    }
    if (cancel === "") {
        modal.find(".btn-secondary").addClass("d-none");
    } else {
        modal.find(".btn-secondary").text(cancel);
    }
    if (footer === false) {
        modal.find(".modal-footer").addClass("d-none");
    }
    if (icon === false) {
        modal.find(".btn-close").addClass("d-none");
    }
    modal.find(".modal-dialog").addClass(size);
    modal.modal("show");
}
const closeModal = () => {
    modal.find(".modal .modal-title").text("");
    modal.find(".modal .modal-body").empty();
    modal.find(".modal .btn-primary").text("");
    modal.find(".modal .btn-secondary").text("");
    modal.modal("hide");
};

$document.on("click", ".modal .btn-dismiss", function () {
    closeModal();
});
$document.on("click", ".modal .btn-close", function () {
    closeModal();
});
