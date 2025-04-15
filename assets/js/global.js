document.addEventListener("DOMContentLoaded", (event) => {
    // Get the top navbar element
    const topNavbar = document.querySelector("#top-navbar");
    const brandTextLabel = document.querySelector("#desktop_brand_text");
    const mainMenu = document.querySelector("#main-menu");

    // Listen for user scrolling
    document.addEventListener("scroll", (event) => {
        // Get the current scrollY of the screen
        const currentY = window.scrollY;

        // If the user is at 100px on the y-axis
        if (currentY >= 100) {
            // The top navbar and brand text should be hidden
            topNavbar.style.top = "-80px";
            brandTextLabel.style.top = "-160px";

            // Add -42px top to the main menu
            mainMenu.style.top = "-42px";
        }
        // Else they're shown regularly
        else {
            topNavbar.style.top = "0";
            brandTextLabel.style.top = "0";

            // Add 0 top to the main menu
            mainMenu.style.top = "0";
        }
    });

    // Get the elements
    const searchFields = document.querySelectorAll(".site-searchbox");

    searchFields.forEach((searchField) => {
        searchField.addEventListener("input", async (event) => {
            // Get the search field value
            const searchQuery = event.target?.value ?? "";

            // Get modal elements
            const searchModal = new bootstrap.Modal("#search-modal");
            const searchModalContent = document.querySelector(
                "#search-modal .modal-body .target-col"
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

    // Using Framer Motion
    const { inView, animate, scroll } = Motion;
    let mainTopicDelayer = 1;
    const gradientText = document.querySelector(".gradientText");
    let delayer = 0;

    // Animating the main topic numbers
    inView(".mainTopicWrapper", (element) => {
        const dataCount = parseInt(element.target.getAttribute("data-count"));

        // If no number is provided, hide the element
        if (isNaN(dataCount)) {
            animate(element.target, { opacity: 0 });
            return;
        }

        // Animate opacity and movement
        // To revert back to old ways
        // remove the .then
        animate(
            element.target,
            { opacity: 1, bottom: 0 },
            { duration: 0.5, delay: mainTopicDelayer++ * 0.2 }
        ).then(() => {
            // Counter Effect
            let currentCount = 0;
            const increment = Math.max(1, Math.floor(dataCount / 100));

            const updateCounter = () => {
                if (currentCount < dataCount) {
                    currentCount = Math.min(
                        currentCount + increment,
                        dataCount
                    );
                    element.target.querySelector(
                        ".mainTopicNumber"
                    ).textContent = currentCount.toLocaleString();
                    requestAnimationFrame(updateCounter);
                }
            };

            // Start counting after the delay
            setTimeout(updateCounter, 450);
        });
    });

    // Handle the gradientText filling up on scroll
    scroll(
        (progress) => {
            if (gradientText) {
                gradientText.style.backgroundImage = `linear-gradient(to bottom left, #0C263C ${
                    100 - progress * 100
                }%, rgba(0, 0, 0, 0.15) 100%)`;
            }
        },
        { target: document.querySelector(".gradientText") }
    );

    // Stop disabled links from navigating
    document.querySelectorAll("a.disabled").forEach((disabledLink) => {
        disabledLink.addEventListener("click", (event) => {
            event.preventDefault();
        });
    });
});
