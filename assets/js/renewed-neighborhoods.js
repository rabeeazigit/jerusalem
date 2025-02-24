$(() => {
    // handles the filtering logic
    $("#neighborhoods_search").on("change", function (event) {
        const formData = new FormData(event.currentTarget);

        const data = {
            neighborhood: formData.get("neighborhood")?.toString() ?? null,
            projectStatus: formData.get("project_status")?.toString() ?? null,
            query: formData.get("query")?.toString() ?? null,
            action: "get_filtered_projects",
            nonce: ajaxObject.nonce,
        };

        // if the filter is cleared
        if (!data.neighborhood && !data.projectStatus && !data.query) {
            window.location.reload();
            return;
        }

        $.ajax({
            url: ajaxObject.ajaxUrl,
            method: "POST",
            data,
            dataType: "json",
            beforeSend: function () {
                $(this).prop("disabled", true);
            },
            success: function (response) {
                const projects = response.projects ?? null;

                $("#loadMoreProjects").fadeOut(function () {
                    $("#projects-container").html(projects);
                });
            },
            error: function (error) {
                console.error(error);
            },
            complete: function () {
                $(this).prop("disabled", false);
            },
        });
    });

    // Handles the load more functionallity
    $("#loadMoreProjects").on("click", function () {
        const limit = $(this).attr("data-limit");
        const page = $(this).attr("data-page");

        const data = {
            limit,
            page,
            nonce: ajaxObject.nonce,
            action: "load_projects",
        };

        $.ajax({
            url: ajaxObject.ajaxUrl,
            method: "POST",
            data,
            dataType: "json",
            beforeSend: function () {
                $(this).prop("disabled", true);
            },
            success: function (response) {
                const projects = response.projects ?? [];
                const remaining = response.remaining ?? 0;

                $("#projects-container").append(projects);
                $("#loadMoreProjects span").html(`(${remaining})`);

                if (remaining > 0) {
                    $("#loadMoreProjects").attr(
                        "data-page",
                        parseInt(page) + 1
                    );
                } else {
                    $("#loadMoreProjects").fadeOut();
                }
            },
            error: function (error) {
                console.error(error);
            },
            complete: function () {
                $(this).prop("disabled", false);
            },
        });
    });
});
