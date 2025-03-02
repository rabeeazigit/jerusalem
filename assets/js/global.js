document.addEventListener("DOMContentLoaded", (event) => {
    // Get the top navbar element
    const topNavbar = document.querySelector("#top-navbar");
    const navbarBrandText = document.querySelector("#main_menu_navbar_brand");

    // Listen for user scrolling
    document.addEventListener("scroll", (event) => {
        // Get the current scrollY of the screen
        const currentY = window.scrollY;

        // If the user is at 100px on the y-axis
        // The top navbar and brand text should be hidden
        // Else they're shown regularly
        if (currentY >= 100) {
            topNavbar.style.top = "-80px";
            navbarBrandText.style.top = "-160px";
        } else {
            topNavbar.style.top = "0";
            navbarBrandText.style.top = "0";
        }

        const gradientTexts = document.querySelectorAll(".gradient-text");

        gradientTexts.forEach((gt) => {
            // Get the current scroll position
            const scrollY = window.scrollY;

            // Calculate the percentage based on the scroll position
            let blackPercentage = Math.min(
                100,
                (scrollY / window.innerHeight) * 10
            ); // Increase by 10% as you scroll

            // Apply the gradient
            gt.style.backgroundImage = `linear-gradient(to bottom left, black ${blackPercentage}%, #e4d8b2 100%)`;
        });
    });

    // Get the elements
    const searchFields = document.querySelectorAll(".site-searchbox");
    const searchBox = document.querySelector(".searchbar_searchbox");

    searchFields.forEach((searchField) => {
        searchField.addEventListener("input", async (event) => {
            // Get the search field value
            const searchQuery = event.target?.value ?? "";

            // Get modal elements
            const searchModal = new bootstrap.Modal("#search-modal");
            const searchModalContent = document.querySelector(
                "#search-modal .modal-body"
            );

            // If the query is less than 3 letters do nothing
            if (searchQuery.length < 3) {
                searchModal.hide();
                searchModalContent.innerHTML = "";
                return;
            }

            const ajaxNonce = wpAjax?.ajaxNonce ?? null;
            const ajaxUrl = wpAjax?.ajaxUrl ?? null;

            if (!ajaxNonce || !ajaxUrl) {
                console.error("AJAX Nonce and AJAX URL are missing!");
                return;
            }

            const payload = new URLSearchParams({
                security: ajaxNonce,
                query: searchQuery,
                action: "sq_site_search",
            });

            try {
                const response = await fetch(ajaxUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: payload,
                });

                const json = await response.json();

                if (!response.ok) {
                    console.error(data);
                    return;
                }

                const { data } = json;

                const list = document.createElement("div");
                list.classList.add(
                    "rounded-4",
                    "sq-site-search",
                    "p-4",
                    "vstack",
                    "gap-3"
                );

                searchModalContent.innerHTML = data;
                searchModal.show();
            } catch (error) {
                console.error(error);
            }
        });
    });
});
