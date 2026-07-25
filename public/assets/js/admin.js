"use strict";

/*
|--------------------------------------------------------------------------
| DOM Ready
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {

    initializeTooltips();
    initializePopovers();
    setActiveMenuItem();

});


/*
|--------------------------------------------------------------------------
| Bootstrap Tooltips
|--------------------------------------------------------------------------
*/

function initializeTooltips() {

    const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    );

    [...tooltipTriggerList].map((element) => {

        return new bootstrap.Tooltip(element);

    });

}


/*
|--------------------------------------------------------------------------
| Bootstrap Popovers
|--------------------------------------------------------------------------
*/

function initializePopovers() {

    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );

    [...popoverTriggerList].map((element) => {

        return new bootstrap.Popover(element);

    });

}


/*
|--------------------------------------------------------------------------
| Active Sidebar Item
|--------------------------------------------------------------------------
*/

function setActiveMenuItem() {

    const currentPage = window.location.pathname.split("/").pop();

    const menuLinks = document.querySelectorAll(
        ".sidebar-nav a"
    );

    menuLinks.forEach((link) => {

        const href = link.getAttribute("href");

        if (href === currentPage) {

            link.classList.add("active");

        }

    });

}


/*
|--------------------------------------------------------------------------
| Confirm Delete
|--------------------------------------------------------------------------
*/

function confirmDelete(message = "Biztosan törölni szeretnéd?") {

    return confirm(message);

}


/*
|--------------------------------------------------------------------------
| Toast Notifications
|--------------------------------------------------------------------------
*/

function showToast(message, type = "success") {

    console.log(`[${type.toUpperCase()}] ${message}`);

    /*
    -----------------------------------------------------------------------

    Bootstrap Toast implementation will be added here later.

    Possible types:

    success
    danger
    warning
    info

    -----------------------------------------------------------------------
    */

}


/*
|--------------------------------------------------------------------------
| Image Preview
|--------------------------------------------------------------------------
*/

function imagePreview(input, previewElementId) {

    const preview = document.getElementById(
        previewElementId
    );

    if (!preview) {

        return;

    }

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function (event) {

            preview.src = event.target.result;

        };

        reader.readAsDataURL(
            input.files[0]
        );

    }

}


/*
|--------------------------------------------------------------------------
| Copy To Clipboard
|--------------------------------------------------------------------------
*/

function copyToClipboard(text) {

    navigator.clipboard.writeText(text)
        .then(() => {

            showToast(
                "Sikeresen másolva."
            );

        })
        .catch(() => {

            console.error(
                "Clipboard hiba."
            );

        });

}


/*
|--------------------------------------------------------------------------
| Mobile Sidebar Toggle
|--------------------------------------------------------------------------
*/

function toggleSidebar() {

    const sidebar = document.querySelector(
        ".sidebar"
    );

    if (!sidebar) {

        return;

    }

    sidebar.classList.toggle(
        "sidebar-open"
    );

}


/*
|--------------------------------------------------------------------------
| Drag & Drop Placeholder
|--------------------------------------------------------------------------
|
| Future gallery uploader module.
|
*/

function initializeDropzone() {

    // Future implementation.

}


/*
|--------------------------------------------------------------------------
| Loading Overlay Placeholder
|--------------------------------------------------------------------------
*/

function showLoader() {

    console.log(
        "Loading..."
    );

}


function hideLoader() {

    console.log(
        "Finished."
    );

}


/*
|--------------------------------------------------------------------------
| Scroll To Top
|--------------------------------------------------------------------------
*/

function scrollToTop() {

    window.scrollTo({

        top: 0,
        behavior: "smooth"

    });

}


/*
|--------------------------------------------------------------------------
| Utility Functions
|--------------------------------------------------------------------------
*/

function disableButton(button) {

    if (!button) {

        return;

    }

    button.disabled = true;

}


function enableButton(button) {

    if (!button) {

        return;

    }

    button.disabled = false;

}


function redirect(url) {

    window.location.href = url;

}


/*
|--------------------------------------------------------------------------
| Future CMS Features
|--------------------------------------------------------------------------
|

- Drag & Drop image upload
- Lightbox gallery
- Sortable image lists
- AJAX requests
- Settings autosave
- Dark mode
- Toast notifications
- Dashboard charts
- Notifications center
- Lazy loading images
- Search & filtering

|--------------------------------------------------------------------------
*/