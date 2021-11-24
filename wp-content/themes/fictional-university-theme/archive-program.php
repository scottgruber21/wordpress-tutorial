<?php
get_header();
pageBanner([
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone'
])
?>
<div class="container container--narrow page-section">
    <ul class="link-list min-list">
        <?php
        while (have_posts()) :
            the_post();
        ?>

            <li><a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a></li>

        <?php endwhile;
        echo paginate_links();
        ?>
    </ul>
</div>
<?php
get_footer(); ?>