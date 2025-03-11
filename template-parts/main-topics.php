<?php
$main_topics_title = $args["main_topics_title"] ?? null;
$main_topics_content = $args["main_topics_content"] ?? null;
$main_topics_link = $args["main_topics_link"] ?? null;
$main_topics = $args["main_topics_main_topics"] ?? null;
$main_topics_content_class =  $args["main_topics_content_class"] ?? null;
?>

<div class="py-5 dark-blue-bg">
    <?php if ($main_topics_title) : ?>
        <div class="container-fluid mb-5">
            <div class="fs-1 fw-bold text-light text-center">
                <?= $main_topics_title; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($main_topics_content) : ?>
        <div class="container-fluid mb-5">
            <div class="text-light text-center <?php echo $main_topics_content_class; ?>">
                <?= $main_topics_content; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($main_topics_link && isset($main_topics_link["text"]) && $main_topics_link["text"] && isset($main_topics_link["url"]) && $main_topics_link["url"]) : ?>
        <div class="container-fluid mb-5">
            <div class="hstack justify-content-center">
                <a 
                    class="btn sq-primary-button" 
                    target="<?= $main_topics_link['target']; ?>" 
                    href=" <?= $main_topics_link['url']; ?>"
                >
                        <?= $main_topics_link['text']; ?>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($main_topics && is_array($main_topics)) : ?>
        <div class="container">
            <div class="row justify-content-center main_topics_wrapper row-gap-4">
                <?php foreach ($main_topics as $e) : ?>
                    <?php
                    $main_topic_title = $e["main_topic_title"] ?? null;
                    $main_topic_link = $e["main_topic_link"] ?? "#";
                    $main_topic_image = $e["main_topic_image"] ?? null;
                    ?>

                    <div class="rs-col-5">
                        <a class="text-decoration-none text-reset vstack p-3 main_topic_card gap-3 justify-content-between" href="<?= $main_topic_link; ?>" target="_blank">
                            <div class="hstack gap-2 align-items-start justify-content-between">
                                <?php if ($main_topic_title) : ?>
                                    <div class="fs-5 fw-semibold rubik">
                                        <?= $main_topic_title; ?>
                                    </div>
                                <?php endif; ?>



                                <?php if ($main_topic_link) : ?>
                                    <img src="<?= get_template_directory_uri() . "/assets/images/yellow-arrow-left.png;" ?>" class="object-fit-cover main_topic_link_icon">
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-center align-items-center">
                                <?php if ($main_topic_image) : ?>
                                    <img src="<?= $main_topic_image; ?>" class="img-fluid" style="height: 140px">
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    $(function() {
        if (window.innerWidth <= 765) {
            $(".main_topics_wrapper").slick({
                slidesToShow: 1.5,
                slidesToScroll: 1,
                infinite: false,
                arrows: false,
                rtl: true
            });
        }
    });
</script>