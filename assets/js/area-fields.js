$(function () {
    const url = new URL(window.location.href);
    
    // check if the request has any url params
    // open correct tab
    const selectedTab = url.searchParams.get("t");
    
    if (selectedTab) {
        $(`.area_field_tab_btn[data-term-id=${selectedTab}]`).trigger("click");
    }
    
    // intercept the tab switching event
    // set correct url params
    $(".area_field_tab_btn").on("shown.bs.tab", function () {
        const termId = $(this).data("term-id");

        url.searchParams.set("t", termId);

        window.history.pushState({}, "", url);
    });
});