<?php get_header();

while (have_posts()) :
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('event') ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to Events Home</a> <span class="metabox__main"><?= the_title() ?></span>
            </p>
        </div>
        <div class="generic-content">
            <p><?php the_content() ?></p>
        </div>
        <div>
            <?php if (get_field('related_program')) : ?>
                <hr class="section-break">
                <h2 class="headline headline--medium">Related Programs</h2>
                <ul class="link-list min-list">
                    <?php
                    $relatedPrograms = get_field('related_program');
                    foreach ($relatedPrograms as $program) : ?>
                        <li><a href="<?= get_the_permalink($program) ?>"><?= get_the_title($program) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile;
get_footer();
?>