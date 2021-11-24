<?php get_header();
while (have_posts()) :
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?= the_title() ?></span>
            </p>
        </div>
        <div class="generic-content">
            <p><?= get_the_content();
                $mapLocation = get_field('map_location');
                ?></p>

            <div class="acf-map">

                <div data-lat="<?= $mapLocation['lat'] ?>" data-lgn="<?= $mapLocation['lng'] ?>" class="marker">
                    <h3><?= get_the_title() ?></h3>
                    <?= $mapLocation['address'] ?>
                </div>
            </div>

            <?php
            $relatedPrograms = new WP_Query([
                'posts_per_page' => -1,
                'post_type' => 'program',
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => [
                    [
                        'name' => 'related_campus',
                        'compare' => 'LIKE',
                        'value' => '"' . get_the_ID() . '"'
                    ]
                ]
            ]); ?>

            <?php if ($relatedPrograms->have_posts()) : ?>
                <h2 class="headline headline--medium">Programs available at this campus</h2>
                <ul class="min-list link-list">
                    <?php while ($relatedPrograms->have_posts()) :
                        $relatedPrograms->the_post();
                    ?>
                        <li>

                            <a href="<?= get_the_permalink() ?>">
                                <?= get_the_title() ?>
                            </a>
                        </li>

                    <?php endwhile; ?>
                </ul>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata() ?>

    <?php
    $today = date('Ymd');
    $homepageEvents = new WP_Query([
        'posts_per_page' => 2,
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => [
            [
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            ],
            [
                'name' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
            ]
        ]
    ]); ?>



    <?php if ($homepageEvents->have_posts()) : ?>
        <hr class=" section-break">
        <h2 class="headline headline--medium">Upcoming <?= get_the_title() ?> Events</h2>
        <?php while ($homepageEvents->have_posts()) :
            $homepageEvents->the_post();
            get_template_part('/template-parts/content', 'event')
        ?>

        <?php endwhile; ?>
    </div>
<?php endif; ?>
</div>
<?php endwhile; ?>

<?php
get_footer();
?>