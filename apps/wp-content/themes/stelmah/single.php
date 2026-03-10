<?php
/**
 * Single Post Template
 * 投稿記事の詳細ページ
 */

get_header();
?>

<style>
/* Article Detail Styles */
.detail-tag{
  display:inline-flex; align-items:center; gap:4px;
  padding:4px 14px; border-radius:999px;
  border:1px solid rgba(255,255,255,0.12);
  background:rgba(255,255,255,0.04); color:rgba(255,255,255,0.6);
  font-size:12px; transition:all 250ms ease;
  text-decoration:none;
}
.detail-tag:hover{
  border-color:rgba(255,0,255,0.4); color:#FF00FF;
}

/* Related Category Cards (Grid) */
.related-card{
  background:#1a1a1a;
  border:1px solid rgba(255,255,255,0.08);
  border-radius:16px; overflow:hidden;
  transition:transform 300ms ease, border-color 300ms ease, box-shadow 300ms ease;
  text-decoration:none; display:block;
}
.related-card:hover{
  transform:translateY(-6px);
  border-color:rgba(255,0,255,0.4);
  box-shadow:0 16px 40px rgba(255,0,255,0.08);
}
.related-card img{
  width:100%; height:180px; object-fit:cover;
  filter:grayscale(30%);
  transition:filter 400ms ease;
}
.related-card:hover img{ filter:grayscale(0%); }
.related-card .rc-body{ padding:18px; }
.related-card .rc-badge{
  display:inline-block;
  padding:3px 10px; border-radius:999px;
  background:rgba(255,0,255,0.12); color:#FF00FF;
  font-family:'Space Mono',monospace;
  font-size:10px; letter-spacing:0.08em;
  margin-bottom:8px;
}
.related-card .rc-title{
  font-size:14px; font-weight:600; line-height:1.5;
  color:#fff; margin-bottom:6px;
  display:-webkit-box; -webkit-line-clamp:2;
  -webkit-box-orient:vertical; overflow:hidden;
}
.related-card .rc-date{
  font-family:'Space Mono',monospace;
  font-size:11px; color:rgba(255,255,255,0.35);
}

/* Same Tag Items (Horizontal List) */
.tag-item{
  display:flex; gap:16px; align-items:center;
  padding:16px 20px;
  background:#1a1a1a;
  border:1px solid rgba(255,255,255,0.08);
  border-radius:14px;
  transition:border-color 300ms ease, transform 300ms ease, box-shadow 300ms ease;
  text-decoration:none;
}
.tag-item:hover{
  border-color:rgba(255,0,255,0.35);
  transform:translateX(6px);
  box-shadow:0 8px 24px rgba(255,0,255,0.06);
}
.tag-item .ti-num{
  flex-shrink:0;
  width:36px; height:36px;
  display:flex; align-items:center; justify-content:center;
  border-radius:10px;
  background:rgba(255,0,255,0.1);
  color:#FF00FF;
  font-family:'Space Mono',monospace;
  font-size:14px; font-weight:700;
}
.tag-item .ti-img{
  flex-shrink:0;
  width:80px; height:60px;
  border-radius:10px;
  object-fit:cover;
  filter:grayscale(30%);
  transition:filter 400ms ease;
}
.tag-item:hover .ti-img{ filter:grayscale(0%); }
.tag-item .ti-body{ flex:1; min-width:0; }
.tag-item .ti-title{
  font-size:14px; font-weight:600; line-height:1.5;
  color:#fff;
  display:-webkit-box; -webkit-line-clamp:1;
  -webkit-box-orient:vertical; overflow:hidden;
}
.tag-item .ti-meta{
  display:flex; align-items:center; gap:10px;
  margin-top:4px;
}
.tag-item .ti-tag{
  font-size:10px; color:rgba(255,0,255,0.8);
  background:rgba(255,0,255,0.08);
  padding:2px 8px; border-radius:999px;
}
.tag-item .ti-date{
  font-family:'Space Mono',monospace;
  font-size:10px; color:rgba(255,255,255,0.35);
}
.tag-item .ti-arrow{
  flex-shrink:0;
  color:rgba(255,255,255,0.2);
  font-size:14px;
  transition:color 300ms ease, transform 300ms ease;
}
.tag-item:hover .ti-arrow{
  color:#FF00FF;
  transform:translateX(4px);
}

/* CKEditor Article Body Headings */
.article-body h2{
  font-size:1.5rem;
  font-weight:900;
  color:#fff;
  margin-top:2.5rem;
  margin-bottom:1rem;
  padding-left:14px;
  border-left:4px solid #FF00FF;
  line-height:1.4;
}
.article-body h3{
  font-size:1.2rem;
  font-weight:700;
  color:rgba(255,255,255,0.9);
  margin-top:2rem;
  margin-bottom:0.75rem;
  padding-bottom:6px;
  border-bottom:1px solid rgba(255,0,255,0.25);
  line-height:1.5;
}
.article-body p{
  color:rgba(255,255,255,0.72);
  line-height:1.85;
  margin-bottom:1rem;
}
.article-body img{
  max-width:100%;
  height:auto;
  border-radius:12px;
  margin:1.5rem 0;
  border:1px solid rgba(255,255,255,0.08);
}
.article-body ul,
.article-body ol{
  color:rgba(255,255,255,0.72);
  padding-left:1.5em;
  margin-bottom:1rem;
  line-height:1.85;
}
.article-body li{
  margin-bottom:0.4rem;
}
.article-body a{
  color:#FF00FF;
  text-decoration:underline;
  text-underline-offset:3px;
}
.article-body a:hover{
  color:#fff;
}

/* Fade-in animation */
@keyframes fadeInUp{
  from{ opacity:0; transform:translateY(18px); }
  to{ opacity:1; transform:translateY(0); }
}
.fade-in-up{
  animation: fadeInUp 400ms ease forwards;
}
</style>

<div class="h-24"></div>

<main class="max-w-4xl mx-auto px-6 py-16 unified-section">

  <?php while ( have_posts() ) : the_post(); ?>

  <?php $cats = get_the_category(); $first_cat = ! empty($cats) ? $cats[0] : null; ?>

  <!-- Breadcrumb -->
  <nav class="text-sm text-gray-400 font-mono tracking-widest">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white">HOME</a>
    <span class="mx-2">/</span>
    <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/') ); ?>" class="hover:text-white">ARTICLES</a>
    <?php if ( $first_cat ) : ?>
      <span class="mx-2">/</span>
      <a href="<?php echo esc_url(get_category_link($first_cat->term_id)); ?>" class="hover:text-white"><?php echo esc_html($first_cat->name); ?></a>
    <?php endif; ?>
    <span class="mx-2">/</span>
    <span class="text-gray-300"><?php echo esc_html( mb_strimwidth(get_the_title(), 0, 40, '...') ); ?></span>
  </nav>

  <!-- Article Header -->
  <header class="mt-8">
    <div class="flex flex-wrap items-center gap-3 mb-4">
      <span class="font-mono text-xs tracking-widest text-gray-400"><?php echo get_the_date('Y-m-d'); ?></span>
      <?php if ( $first_cat ) : ?>
        <a href="<?php echo esc_url(get_category_link($first_cat->term_id)); ?>" class="font-mono text-[11px] tracking-widest px-4 py-1.5 rounded-full bg-neon-pink/15 text-neon-pink border border-neon-pink/30 hover:bg-neon-pink/25 transition" style="text-decoration:none;">
          <i class="fa-solid fa-folder text-[9px] mr-1"></i><?php echo esc_html($first_cat->name); ?>
        </a>
      <?php endif; ?>
    </div>
    <h1 class="text-3xl md:text-4xl font-black tracking-tight leading-tight"><?php the_title(); ?></h1>
    <?php if ( has_excerpt() ) : ?>
      <p class="text-gray-300 mt-5 leading-relaxed"><?php echo esc_html(get_the_excerpt()); ?></p>
    <?php endif; ?>
    <?php $post_tags = get_the_tags(); if ( $post_tags ) : ?>
      <div class="flex flex-wrap gap-2 mt-5">
        <?php foreach ( $post_tags as $tag ) : ?>
          <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="detail-tag">
            <i class="fa-solid fa-hashtag text-[9px] text-neon-pink/60"></i><?php echo esc_html($tag->name); ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </header>

  <!-- Article Hero Image -->
  <?php if ( has_post_thumbnail() ) : ?>
  <figure class="mt-10 rounded-3xl overflow-hidden border border-white/10 bg-white/5">
    <?php the_post_thumbnail('large', array('class' => 'w-full h-72 md:h-96 object-cover opacity-90')); ?>
  </figure>
  <?php endif; ?>

  <!-- Article Body -->
  <article class="article-body mt-10 rounded-3xl border border-white/10 bg-white/5 p-6 md:p-10 leading-relaxed">
    <div class="text-gray-200 space-y-4">
      <?php the_content(); ?>
    </div>
  </article>

  <!-- Back / CTA -->
  <div class="mt-10 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
    <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/') ); ?>" class="px-5 py-3 rounded-2xl border border-white/10 bg-black/30 hover:bg-white/10 transition text-sm font-bold tracking-wide" style="text-decoration:none;">&larr; 記事一覧へ戻る</a>
    <a href="#contact" class="bg-neon-pink text-black hover:bg-white px-6 py-3 font-bold uppercase text-xs tracking-widest transition-colors rounded-full text-center" style="text-decoration:none;">お問い合わせ</a>
  </div>

  <?php endwhile; ?>

  <!-- Related Category Articles (Card Grid Layout) -->
  <?php if ( $first_cat ) :
    $related_cat_query = new WP_Query(array(
        'category__in'   => array($first_cat->term_id),
        'post__not_in'   => array(get_the_ID()),
        'posts_per_page' => 3,
        'no_found_rows'  => true,
        'post_status'    => 'publish',
    ));
  ?>
  <?php if ( $related_cat_query->have_posts() ) : ?>
  <section class="mt-20">
    <div class="flex items-center gap-4 mb-6">
      <div>
        <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">RELATED CATEGORY</div>
        <h2 class="text-2xl font-bold mt-1"><?php echo esc_html($first_cat->name); ?>の関連コラム</h2>
      </div>
      <div class="flex-1 h-px bg-white/10 ml-4"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <?php $ri = 0; while ( $related_cat_query->have_posts() ) : $related_cat_query->the_post(); ?>
        <a href="<?php the_permalink(); ?>" class="related-card fade-in-up" style="animation-delay:<?php echo $ri * 80; ?>ms">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
          <?php endif; ?>
          <div class="rc-body">
            <?php $rc_cats = get_the_category(); if ( ! empty($rc_cats) ) : ?>
              <span class="rc-badge"><?php echo esc_html($rc_cats[0]->name); ?></span>
            <?php endif; ?>
            <h3 class="rc-title"><?php the_title(); ?></h3>
            <div class="flex items-center justify-between mt-2">
              <span class="rc-date"><?php echo get_the_date('Y-m-d'); ?></span>
              <span class="font-mono text-[11px] text-neon-pink tracking-wider">READ &rarr;</span>
            </div>
          </div>
        </a>
      <?php $ri++; endwhile; ?>
    </div>
  </section>
  <?php endif; wp_reset_postdata(); ?>
  <?php endif; ?>

  <!-- Same Tag Articles (Horizontal List Layout) -->
  <?php
  $current_tags = get_the_tags();
  if ( $current_tags ) :
    $tag_ids = wp_list_pluck($current_tags, 'term_id');
    $tag_display = implode(' ', array_map(function($t) { return '#' . esc_html($t->name); }, $current_tags));

    $related_tag_query = new WP_Query(array(
        'tag__in'        => $tag_ids,
        'post__not_in'   => array(get_the_ID()),
        'posts_per_page' => 3,
        'no_found_rows'  => true,
        'post_status'    => 'publish',
    ));
  ?>
  <?php if ( $related_tag_query->have_posts() ) : ?>
  <section class="mt-20 mb-8">
    <div class="flex items-center gap-4 mb-6">
      <div>
        <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">SAME TAGS</div>
        <h2 class="text-2xl font-bold mt-1">
          <span class="text-white">同じタグ</span>
          <span class="text-neon-pink/60 text-lg ml-2"><?php echo $tag_display; ?></span>
          <span class="text-white"> のコラム</span>
        </h2>
      </div>
      <div class="flex-1 h-px bg-white/10 ml-4"></div>
    </div>
    <div class="flex flex-col gap-4">
      <?php $ti = 0; while ( $related_tag_query->have_posts() ) : $related_tag_query->the_post();
        $shared_tags = array();
        $item_tags = get_the_tags();
        if ( $item_tags ) {
            foreach ( $item_tags as $it ) {
                if ( in_array($it->term_id, $tag_ids) ) {
                    $shared_tags[] = $it;
                }
            }
        }
      ?>
        <a href="<?php the_permalink(); ?>" class="tag-item fade-in-up" style="animation-delay:<?php echo $ti * 100; ?>ms">
          <span class="ti-num"><?php echo str_pad($ti + 1, 2, '0', STR_PAD_LEFT); ?></span>
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail('thumbnail', array('class' => 'ti-img hidden sm:block', 'loading' => 'lazy')); ?>
          <?php endif; ?>
          <div class="ti-body">
            <h3 class="ti-title"><?php the_title(); ?></h3>
            <div class="ti-meta">
              <?php foreach ( $shared_tags as $st ) : ?>
                <span class="ti-tag">#<?php echo esc_html($st->name); ?></span>
              <?php endforeach; ?>
              <span class="ti-date"><?php echo get_the_date('Y-m-d'); ?></span>
            </div>
          </div>
          <i class="fa-solid fa-chevron-right ti-arrow"></i>
        </a>
      <?php $ti++; endwhile; ?>
    </div>
  </section>
  <?php endif; wp_reset_postdata(); ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
