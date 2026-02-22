import "./bootstrap";

// Sidebar toggle (default closed)
document.addEventListener("DOMContentLoaded", function () {
    var toggle = document.getElementById("sidebarToggle");
    var body = document.body;
    if (!toggle) return;
    var iconOpen = document.getElementById("iconOpen");
    var iconClose = document.getElementById("iconClose");
    var sidebarCloseBtn = document.getElementById("sidebarCloseBtn");

    // find or create overlay element (covers page when sidebar open)
    var overlay = document.getElementById("sidebarOverlay");
    if (!overlay) {
        overlay = document.createElement("div");
        overlay.id = "sidebarOverlay";
        overlay.style.position = "fixed";
        overlay.style.inset = "0";
        overlay.style.background = "rgba(0,0,0,0.45)";
        overlay.style.display = "none";
        overlay.style.zIndex = "99990";
        document.body.appendChild(overlay);
    }

    function openSidebar() {
        body.classList.add("sidebar-open");
        toggle.setAttribute("aria-expanded", "true");
        toggle.classList.add("open");
        if (iconOpen) iconOpen.classList.add("hidden");
        if (iconClose) iconClose.classList.remove("hidden");
        overlay.style.display = "block";
    }

    function closeSidebar() {
        body.classList.remove("sidebar-open");
        toggle.setAttribute("aria-expanded", "false");
        toggle.classList.remove("open");
        if (iconOpen) iconOpen.classList.remove("hidden");
        if (iconClose) iconClose.classList.add("hidden");
        overlay.style.display = "none";
    }

    // ensure default closed state
    closeSidebar();

    toggle.addEventListener("click", function () {
        if (body.classList.contains("sidebar-open")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // clicking overlay closes the sidebar
    overlay.addEventListener("click", function () {
        closeSidebar();
    });

    // clicking the close icon/button in the sidebar header closes it
    if (iconClose) iconClose.addEventListener("click", closeSidebar);
    if (sidebarCloseBtn)
        sidebarCloseBtn.addEventListener("click", closeSidebar);

    // close with Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && body.classList.contains("sidebar-open")) {
            closeSidebar();
        }
    });
});

// Handle send SMS / WA buttons on absensi page (non-blocking, AJAX)
document.addEventListener("DOMContentLoaded", function () {
    function postTo(url, data) {
        return fetch(url, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
            body: data,
            credentials: "same-origin",
        });
    }

    function getCsrfToken() {
        var tokenInput = document.querySelector('form input[name="_token"]');
        return tokenInput ? tokenInput.value : null;
    }

    document.querySelectorAll(".send-sms").forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            var id = this.getAttribute("data-id");
            var token = getCsrfToken();
            if (!token) return alert("CSRF token not found");

            var formData = new FormData();
            formData.append("_token", token);

            btn.disabled = true;
            postTo("/petugas/absensi/" + id + "/send-sms", formData)
                .then(function () {
                    window.location.reload();
                })
                .catch(function () {
                    alert("Gagal mengirim SMS");
                    btn.disabled = false;
                });
        });
    });

    document.querySelectorAll(".send-wa").forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            var id = this.getAttribute("data-id");
            var token = getCsrfToken();
            if (!token) return alert("CSRF token not found");

            var formData = new FormData();
            formData.append("_token", token);

            btn.disabled = true;
            postTo("/petugas/absensi/" + id + "/send-wa", formData)
                .then(function () {
                    window.location.reload();
                })
                .catch(function () {
                    alert("Gagal mengirim WhatsApp");
                    btn.disabled = false;
                });
        });
    });
});
