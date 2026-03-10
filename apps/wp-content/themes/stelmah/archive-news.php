<?php
/**
 * News Archive Template
 * ニュース一覧ページ
 */

get_header();
?>

<div class="h-24"></div>

<main class="max-w-6xl mx-auto px-6 py-16">
  <div class="mb-10">
    <p class="font-mono text-xs tracking-widest text-gray-400">NEWS</p>
    <h1 class="text-4xl md:text-5xl font-black tracking-tight mt-3">
      <?php
      if ( is_tax('news_category') ) {
          single_term_title();
      } else {
          echo 'ニュース一覧';
      }
      ?>
    </h1>
    <p class="text-gray-300 mt-4 max-w-2xl">ACRY LABOの最新情報・お知らせを掲載します。新サービスの掲載や特集記事をお届けします。</p>
  </div>

  <section class="rounded-3xl border border-white/10 bg-white/5 p-6 md:p-8 mb-10">
    <div class="flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
      <div class="flex flex-wrap gap-2">
        <?php
        $current_term_id = is_tax('news_category') ? get_queried_object_id() : 0;
        $is_all = ! is_tax('news_category');
        ?>
        <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>" class="px-4 py-2 rounded-full border border-white/10 <?php echo $is_all ? 'bg-white/10' : 'bg-black/30 hover:bg-white/10'; ?> transition text-sm" style="text-decoration:none;">すべて</a>
        <?php
        $news_cats = get_terms(array(
            'taxonomy'   => 'news_category',
            'hide_empty' => true,
        ));
        if ( ! is_wp_error($news_cats) && ! empty($news_cats) ) :
          foreach ( $news_cats as $nc ) : ?>
            <a href="<?php echo esc_url(get_term_link($nc)); ?>" class="px-4 py-2 rounded-full border border-white/10 <?php echo ($current_term_id === $nc->term_id) ? 'bg-white/10' : 'bg-black/30 hover:bg-white/10'; ?> transition text-sm" style="text-decoration:none;">
              <?php echo esc_html($nc->name); ?>
            </a>
          <?php endforeach;
        endif; ?>
      </div>
      <div class="w-full md:w-80">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
          <label class="sr-only" for="news-search">検索</label>
          <input type="hidden" name="post_type" value="news" />
          <input id="news-search" name="s" type="search" placeholder="キーワード検索" value="<?php echo esc_attr(get_search_query()); ?>" class="w-full px-4 py-2 rounded-xl bg-black/40 border border-white/10 focus:outline-none focus:ring-2 focus:ring-white/30" />
        </form>
      </div>
    </div>
  </section>

  <?php if ( have_posts() ) : ?>
  <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php while ( have_posts() ) : the_post(); ?>
      <a href="<?php the_permalink(); ?>" class="group rounded-3xl border border-white/10 bg-white/5 hover:bg-white/10 transition p-6 md:p-7 block" style="text-decoration:none;">
        <div class="flex items-center justify-between gap-4">
          <p class="font-mono text-xs tracking-widest text-gray-400"><?php echo get_the_date('Y-m-d'); ?></p>
          <?php
          $news_terms = get_the_terms(get_the_ID(), 'news_category');
          if ( $news_terms && ! is_wp_error($news_terms) ) : ?>
            <span class="font-mono text-[11px] tracking-widest px-3 py-1 rounded-full border border-white/10 bg-black/30"><?php echo esc_html($news_terms[0]->name); ?></span>
          <?php endif; ?>
        </div>
        <h3 class="text-xl md:text-2xl font-black mt-4 group-hover:underline underline-offset-4"><?php the_title(); ?></h3>
        <?php if ( has_excerpt() ) : ?>
          <p class="text-gray-300 mt-3 leading-relaxed"><?php echo esc_html(get_the_excerpt()); ?></p>
        <?php endif; ?>
        <div class="mt-6 flex items-center gap-2 text-sm font-bold tracking-wide">
          <span>続きを読む</span>
          <span class="inline-block translate-x-0 group-hover:translate-x-1 transition-transform">&rarr;</span>
        </div>
      </a>
    <?php endwhile; ?>
  </section>

  <!-- Pagination -->
  <div class="mt-12 flex items-center justify-center gap-2">
    <?php
    the_posts_pagination(array(
        'mid_size'  => 2,
        'prev_text' => 'Prev',
        'next_text' => 'Next',
        'before_page_number' => '',
    ));
    ?>
  </div>
  <style>
  .nav-links{ display:flex; align-items:center; justify-content:center; gap:8px; }
  .nav-links a, .nav-links span{
    padding:8px 16px; border-radius:12px;
    border:1px solid rgba(255,255,255,0.1);
    background:rgba(0,0,0,0.3); font-size:14px;
    transition:background 200ms ease;
    text-decoration:none;
  }
  .nav-links a:hover{ background:rgba(255,255,255,0.1); }
  .nav-links .current{ background:rgba(255,255,255,0.1); }
  </style>

  <?php else : ?>
  <div class="text-center py-20">
    <div class="text-5xl mb-4 opacity-30">&#128237;</div>
    <p class="text-white/50 font-mono text-sm">ニュースが見つかりませんでした</p>
  </div>
  <?php endif; ?>

  <!-- Contact Section -->
  <div class="mt-16 rounded-3xl border border-white/10 bg-white/5 p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
    <div>
      <p class="font-mono text-xs tracking-widest text-gray-400">CONTACT</p>
      <h2 class="text-2xl md:text-3xl font-black mt-3">ご相談・お問い合わせ</h2>
      <p class="text-gray-300 mt-2">記事内容やサービス掲載に関するお問い合わせは、フッターのフォームからどうぞ。</p>
    </div>
    <a href="#contact" class="bg-neon-pink text-black hover:bg-white px-6 py-3 font-bold uppercase text-xs tracking-widest transition-colors rounded-full" style="text-decoration:none;">お問い合わせ</a>
  </div>
</main>

<?php get_footer(); ?>
