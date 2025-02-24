let currentScroll = 0;

document.addEventListener("DOMContentLoaded", (event) => {
    // Get the top navbar element
    const topNavbar = document.querySelector("#top-navbar");

    // Listen for user scrolling
    document.addEventListener("scroll", (event) => {
        // Get the current scrollY of the screen
        const currentY = window.scrollY;
        currentScroll = currentY;

        // If the user is at 100px on the y-axis
        // The top navbar should be hidden
        // Else it's shown regularly
        if (currentY >= 100) {
            topNavbar.style.top = "-80px";
        } else {
            topNavbar.style.top = "0";
        }

        console.log(currentScroll);
    });
});
