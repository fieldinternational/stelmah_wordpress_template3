<?php
/**
 * メインテンプレート（フォールバック）
 */
get_header(); ?>

<main class="unified-section pt-28 pb-20">
  <div class="max-w-6xl mx-auto px-6">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="mb-12">
        <h2 class="text-3xl font-bold mb-4">
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="text-white/70 leading-relaxed">
          <?php the_excerpt(); ?>
        </div>
      </article>
    <?php endwhile; else : ?>
      <p class="text-white/50">コンテンツが見つかりませんでした。</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
