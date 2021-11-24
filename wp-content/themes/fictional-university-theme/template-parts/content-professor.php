<li class="professor-card__list-item">
    <a class="professor-card" href="<?= get_the_permalink() ?>">
        <img class="professor-card__image" src="<?= the_post_thumbnail_url('professorLandscape') ?>">
        <span class="professor-card__image"><?= get_the_title() ?></span>
    </a>
</li>