<?php
$information_options = $args["information_options"] ?? null;
$information_sqaures = $information_options["information_sqaures"] ?? null;
$information_paragraph = $information_options["information_paragraph"] ?? null;
$information_link = $information_options["information_link"] ?? null;
$information_numberical_data = $information_options["information_numberical_data"] ?? null;
$information_banner_background = $information_options["information_banner_background"] ?? "";
$information_banner_paragraph = $information_options["information_banner_paragraph"] ?? null;
$information_banner_link = $information_options["information_banner_link"] ?? null;
?>

<?php if ($information_sqaures && is_array($information_sqaures)) : ?>
    <div class="container-fluid information_square_bg">
        <div class="row justify-content-center information_square_wrapper px-md-5 px-3">
            <?php foreach ($information_sqaures as $i => $e) : ?>
                <div class="col-md-6">
                    <div class="information_square shadow p-4 <?= $i == 1 ? "information_square_second" : ""; ?>">
                        <div class="d-none d-md-block">
                            <div class="row h-100">
                                <div class="col-md-8">
                                    <?php if (isset($e["information_title"])) : ?>
                                        <div class="fs-1 fw-bold mb-2 rubik">
                                            <?= $e["information_title"]; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($e["information_description"])) : ?>
                                        <div class="fs-5">
                                            <?= $e["information_description"]; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="hstack gap-2 mt-5">
                                        <?php if ($e["white_link"]) : ?>
                                            <a href="<?= $e["white_link"]["url"]; ?>" target="<?= $e["white_link"]["target"]; ?>" class="fs-6 text-decoration-none sq-tertiary-button">
                                                <?= $e["white_link"]["title"]; ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($e["yellow_link"]) : ?>
                                            <a href="<?= $e["yellow_link"]["url"]; ?>" target="<?= $e["yellow_link"]["target"]; ?>" class="fs-6 text-decoration-none sq-primary-button">
                                                <?= $e["yellow_link"]["title"]; ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?php if (isset($e["side_image"]) && $e["side_image"]) : ?>
                                        <div class="d-flex h-100 align-items-end justify-content-end">
                                            <img src="<?= $e["side_image"]; ?>" class="information_square_image object-fit-cover">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-block d-md-none">
                            <div class="row h-100">
                                <div class="col-md-12">
                                    <?php if (isset($e["side_image"])) : ?>
                                        <div class="d-flex h-100 align-items-center justify-content-center">
                                            <img src="<?= $e["side_image"]; ?>" class="information_square_image object-fit-cover">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-8">
                                    <?php if (isset($e["information_title"])) : ?>
                                        <div class="fs-1 text-center fw-bold mt-4 mb-2">
                                            <?= $e["information_title"]; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($e["information_description"])) : ?>
                                        <div class="fs-5 text-center">
                                            <?= $e["information_description"]; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="hstack justify-content-center gap-2 mt-5">
                                        <?php if ($e["white_link"]) : ?>
                                            <a href="<?= $e["white_link"]["url"]; ?>" target="<?= $e["white_link"]["target"]; ?>" class="fs-6 text-decoration-none sq-tertiary-button">
                                                <?= $e["white_link"]["title"]; ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($e["yellow_link"]) : ?>
                                            <a href="<?= $e["yellow_link"]["url"]; ?>" target="<?= $e["yellow_link"]["target"]; ?>" class="fs-6 text-decoration-none sq-primary-button">
                                                <?= $e["yellow_link"]["title"]; ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<div class="container my-5">
    <?php if ($information_paragraph) : ?>
        <div class="fs-1 fw-semibold text-center mb-4 gradientText rubik">
            <?= $information_paragraph; ?>
        </div>
    <?php endif; ?>

    <?php if ($information_link) : ?>
        <div class="d-flex justify-content-center">
            <a href="<?= $information_link["url"]; ?>" target="<?= $information_link["target"]; ?>" class="text-decoration-none sq-primary-button">
                <?= $information_link["title"]; ?>
            </a>
        </div>
    <?php endif; ?>

    <?php if ($information_numberical_data && is_array($information_numberical_data)) : ?>
        <div class="d-none d-md-block">
            <div class="hstack gap-5 my-5">
                <?php foreach ($information_numberical_data as $e) : ?>
                    <div class="vstack align-items-center gap-1 mainTopicWrapper" data-count="<?= $e["number"]; ?>">
                        <?php if (isset($e["number"])) : ?>
                            <div class="display-1 fw-normal rubik mainTopicNumber">
                                0
                            </div>
                        <?php endif; ?>

                        <?php if (isset($e["title"])) : ?>
                            <div class="fs-5 fw-semibold">
                                <?= $e["title"]; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="d-block d-md-none">
            <div class="row mt-5 row-gap-4">
                <?php foreach ($information_numberical_data as $e) : ?>
                    <div class="col-6">
                        <div class="vstack align-items-center gap-1">
                            <?php if (isset($e["number"])) : ?>
                                <div class="display-1 fw-medium">
                                    <?= $e["number"]; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($e["title"])) : ?>
                                <div class="fs-5 fw-medium">
                                    <?= $e["title"]; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="d-none d-md-block information_banner_wrapper">
    <div class="container my-5 ">
        <div class="information_banner" style="background-image: url(<?= $information_banner_background; ?>;">
            <div class="d-flex w-100 h-100 align-items-end justify-content-end">
                <div class="rounded-4 p-3 information_banner_card">
                    <div class="vstack h-100 align-items-start">
                        <div class="flex-fill">
                            <?php if ($information_banner_paragraph) : ?>
                                <div class="fs-5 mb-4">
                                    <?= $information_banner_paragraph; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($information_banner_link) : ?>
                            <a href=" <?= $information_banner_link["url"]; ?>" target="<?= $information_banner_link["target"]; ?>" class="text-decoration-none sq-primary-button">
                                <?= $information_banner_link["title"]; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-block d-md-none">
    <div class="container-fluid px-0 my-5">
        <div class="information_banner" style="background-image: url(<?= $information_banner_background; ?>;">
            <div class="d-flex w-100 h-100 align-items-end justify-content-end">
                <div class="rounded-4 p-3 information_banner_card">
                    <div class="vstack h-100 align-items-start">
                        <div class="flex-fill">
                            <?php if ($information_banner_paragraph) : ?>
                                <div class="fs-5 mb-4">
                                    <?= $information_banner_paragraph; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($information_banner_link) : ?>
                            <a href=" <?= $information_banner_link["url"]; ?>" target="<?= $information_banner_link["target"]; ?>" class="text-decoration-none sq-primary-button">
                                <?= $information_banner_link["title"]; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>