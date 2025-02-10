<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= bloginfo("title"); ?>
    </title>
    <?php wp_head(); ?>
</head>

<body>
    <script>
        // a script to override the default yoast home and seperator breadcrumbs icons
        $(function() {
            $(".sq_breadcrumbs *").each(function() {
                if ($(this).text().trim() === "[home]") {
                    $(this).empty();

                    $(this).html(`
                        <a href="<?= home_url(); ?>">
                            <img src="<?= get_template_directory_uri(); ?>/assets/images/home.png" />
                        </a>
                    `);

                    $(this).addClass("home_breadcrumb");
                }

                if ($(this).text().trim() === "[seperator]") {
                    $(this).empty();
                    $(this).addClass("seperator_breadcrumb");
                }
            });
        });
    </script>