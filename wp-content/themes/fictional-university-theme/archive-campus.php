<?php
get_header();
pageBanner([
    'title' => 'Our Campuses',
    'subtitle' => 'We have several convenient locations'
]);
?>
<div class="container container--narrow page-section">
    <?php while (have_posts()) :
        the_post();
    ?>
        <h3><a href="<?= get_the_permalink() ?>"><?= the_title() ?></a></h3>
        <p><?= get_field('map_location')['address'] ?></p>
    <?php endwhile; ?>
</div>
<?php
get_footer(); ?>