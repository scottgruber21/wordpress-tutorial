<?php get_header();

while (have_posts()) :
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?= the_post_thumbnail('professorPortrait') ?>
                </div>
                <div class="two-thirds">
                    <?php
                    $likeCount = new WP_Query([
                        'post_type' => 'like',
                        'meta_query' => [
                            [
                                'key' => 'liked_professor_id',
                                'compare' => '=',
                                'value' => get_the_ID()
                            ]
                        ]
                    ]);

                    $existStatus = 'no';

                    if (is_user_logged_in()) {
                        $existQuery = new WP_Query([
                            'author' => get_current_user_ID(),
                            'post_type' => 'like',
                            'meta_query' => [
                                [
                                    'key' => 'liked_professor_id',
                                    'compare' => '=',
                                    'value' => get_the_ID()
                                ]
                            ]
                        ]);
                        if ($existQuery->found_posts) {
                            $existStatus = 'yes';
                        }
                    }

                    ?>
                    <span class="like-box" data-exists="<?= $existStatus ?>" data-professor="<?= get_the_ID() ?>" data-like="<?= $existQuery->posts[0]->ID; ?>">
                        <i class="far fa-heart"></i>
                        <i class="fas fa-heart"></i>
                        <span class="like-count"><?= $likeCount->found_posts; ?></span>
                    </span>
                    <?php the_content() ?>
                </div>
            </div>

        </div>
        <div>
            <?php if (get_field('related_program')) : ?>
                <hr class="section-break">
                <h2 class="headline headline--medium">Subjects Taught</h2>
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