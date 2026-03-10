<?php
/**
 * Single News Template
 * ニュース記事の詳細ページ
 */

get_header();
?>

<style>
/* Article Body Styles for News */
.news-body h2{
  font-size:1.5rem;
  font-weight:900;
  color:#fff;
  margin-top:2.5rem;
  margin-bottom:1rem;
  padding-left:14px;
  border-left:4px solid #FF00FF;
  line-height:1.4;
}
.news-body h3{
  font-size:1.2rem;
  font-weight:700;
  color:rgba(255,255,255,0.9);
  margin-top:2rem;
  margin-bottom:0.75rem;
  padding-bottom:6px;
  border-bottom:1px solid rgba(255,0,255,0.25);
  line-height:1.5;
}
.news-body p{
  color:rgba(255,255,255,0.72);
  line-height:1.85;
  margin-bottom:1rem;
}
.news-body img{
  max-width:100%;
  height:auto;
  border-radius:12px;
  margin:1.5rem 0;
  border:1px solid rgba(255,255,255,0.08);
}
.news-body ul,
.news-body ol{
  color:rgba(255,255,255,0.72);
  padding-left:1.5em;
  margin-bottom:1rem;
  line-height:1.85;
}
.news-body li{
  margin-bottom:0.4rem;
}
.news-body a{
  color:#FF00FF;
  text-decoration:underline;
  text-underline-offset:3px;
}
.news-body a:hover{
  color:#fff;
}
</style>

<div class="h-24"></div>

<main class="max-w-4xl mx-auto px-6 py-16">

  <?php while ( have_posts() ) : the_post(); ?>

  <!-- Breadcrumb -->
  <nav class="text-sm text-gray-400 font-mono tracking-widest">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white">HOME</a>
    <span class="mx-2">/</span>
    <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>" class="hover:text-white">NEWS</a>
    <span class="mx-2">/</span>
    <span class="text-gray-300"><?php echo esc_html( mb_strimwidth(get_the_title(), 0, 40, '...') ); ?></span>
  </nav>

  <!-- Article Header -->
  <header class="mt-8">
    <div class="flex items-center gap-3">
      <p class="font-mono text-xs tracking-widest text-gray-400"><?php echo get_the_date('Y-m-d'); ?></p>
      <?php
      $news_terms = get_the_terms(get_the_ID(), 'news_category');
      if ( $news_terms && ! is_wp_error($news_terms) ) : ?>
        <span class="font-mono text-[11px] tracking-widest px-3 py-1 rounded-full border border-white/10 bg-black/30"><?php echo esc_html($news_terms[0]->name); ?></span>
      <?php endif; ?>
    </div>
    <h1 class="text-4xl md:text-5xl font-black tracking-tight mt-4"><?php the_title(); ?></h1>
    <?php if ( has_excerpt() ) : ?>
      <p class="text-gray-300 mt-5 leading-relaxed"><?php echo esc_html(get_the_excerpt()); ?></p>
    <?php endif; ?>
  </header>

  <!-- Hero Image -->
  <?php if ( has_post_thumbnail() ) : ?>
  <figure class="mt-10 rounded-3xl overflow-hidden border border-white/10 bg-white/5">
    <?php the_post_thumbnail('large', array('class' => 'w-full h-72 md:h-96 object-cover opacity-90')); ?>
  </figure>
  <?php endif; ?>

  <!-- Article Body -->
  <article class="news-body mt-10 rounded-3xl border border-white/10 bg-white/5 p-6 md:p-10 leading-relaxed">
    <?php the_content(); ?>
  </article>

  <!-- Back / CTA -->
  <div class="mt-10 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
    <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>" class="px-5 py-3 rounded-2xl border border-white/10 bg-black/30 hover:bg-white/10 transition text-sm font-bold tracking-wide" style="text-decoration:none;">&larr; 一覧へ戻る</a>
    <a href="#contact" class="bg-neon-pink text-black hover:bg-white px-6 py-3 font-bold uppercase text-xs tracking-widest transition-colors rounded-full text-center" style="text-decoration:none;">お問い合わせ</a>
  </div>

  <?php endwhile; ?>

  <!-- Next Article -->
  <?php
  $next_post = get_adjacent_post(false, '', false);
  if ( $next_post ) : ?>
  <section class="mt-14 rounded-3xl border border-white/10 bg-white/5 p-8">
    <p class="font-mono text-xs tracking-widest text-gray-400">NEXT</p>
    <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="block mt-3 group" style="text-decoration:none;">
      <h3 class="text-xl font-black group-hover:underline underline-offset-4"><?php echo esc_html($next_post->post_title); ?></h3>
      <?php if ( $next_post->post_excerpt ) : ?>
        <p class="text-gray-300 mt-2"><?php echo esc_html($next_post->post_excerpt); ?></p>
      <?php endif; ?>
    </a>
  </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
