<?php
/**
 * Archive Template
 * カテゴリ・タグ・投稿一覧のアーカイブページ
 */

get_header();

// フィルタコンテキスト初期化
$_filter           = stelmah_get_current_articles_filter();
$current_cat_id    = $_filter['cat_id'];
$current_tag_id    = $_filter['tag_id'];
$is_articles_filter = stelmah_is_articles_filter();
?>

<style id="article-styles">
/* Category filter buttons */
.cat-btn{
  display:inline-flex; align-items:center; gap:6px;
  padding:8px 20px; border-radius:999px;
  border:1px solid rgba(255,255,255,0.18);
  background:transparent; color:rgba(255,255,255,0.8);
  font-family:'Space Mono','Courier New',monospace;
  font-size:12px; letter-spacing:0.05em;
  cursor:pointer; transition:all 250ms ease;
  white-space:nowrap; text-decoration:none;
}
.cat-btn:hover{
  border-color:#FF00FF; color:#FF00FF;
}
.cat-btn.active{
  background:#FF00FF; color:#000;
  border-color:#FF00FF; font-weight:700;
}

/* Tag filter buttons */
.tag-btn{
  display:inline-flex; align-items:center; gap:4px;
  padding:5px 14px; border-radius:999px;
  border:1px solid rgba(255,255,255,0.12);
  background:rgba(255,255,255,0.04); color:rgba(255,255,255,0.55);
  font-size:11px; text-decoration:none;
  transition:all 250ms ease;
}
.tag-btn:hover{
  border-color:rgba(255,0,255,0.4); color:rgba(255,255,255,0.8);
}
.tag-btn.active{
  background:rgba(255,0,255,0.15); color:#FF00FF;
  border-color:rgba(255,0,255,0.5);
}

/* Article cards */
.article-card{
  background:#1a1a1a;
  border:1px solid rgba(255,255,255,0.08);
  border-radius:16px; overflow:hidden;
  transition:transform 300ms ease, border-color 300ms ease, box-shadow 300ms ease;
}
.article-card:hover{
  transform:translateY(-6px);
  border-color:rgba(255,0,255,0.4);
  box-shadow:0 16px 40px rgba(255,0,255,0.08);
}
.article-card img{
  width:100%; height:200px; object-fit:cover;
  filter:grayscale(30%);
  transition:filter 400ms ease;
}
.article-card:hover img{
  filter:grayscale(0%);
}
.article-card .card-body{
  padding:20px;
}
.article-card .card-badge{
  display:inline-block;
  padding:3px 10px; border-radius:999px;
  background:rgba(255,0,255,0.12); color:#FF00FF;
  font-family:'Space Mono',monospace;
  font-size:10px; letter-spacing:0.08em;
  margin-bottom:10px; text-decoration:none;
}
.article-card .card-title{
  font-size:16px; font-weight:600; line-height:1.5;
  color:#fff; margin-bottom:8px;
  display:-webkit-box; -webkit-line-clamp:2;
  -webkit-box-orient:vertical; overflow:hidden;
}
.article-card .card-excerpt{
  font-size:13px; line-height:1.7;
  color:rgba(255,255,255,0.55);
  display:-webkit-box; -webkit-line-clamp:2;
  -webkit-box-orient:vertical; overflow:hidden;
  margin-bottom:12px;
}
.article-card .card-tags{
  display:flex; flex-wrap:wrap; gap:6px;
  margin-bottom:14px;
}
.article-card .card-tag{
  font-size:10px; color:rgba(255,255,255,0.4);
  background:rgba(255,255,255,0.05);
  padding:2px 8px; border-radius:999px;
  text-decoration:none;
}
.article-card .card-footer{
  display:flex; justify-content:space-between; align-items:center;
  padding-top:12px; border-top:1px solid rgba(255,255,255,0.06);
}
.article-card .card-date{
  font-family:'Space Mono',monospace;
  font-size:11px; color:rgba(255,255,255,0.35);
}
.article-card .card-link{
  font-family:'Space Mono',monospace;
  font-size:11px; color:#FF00FF;
  letter-spacing:0.1em;
  transition:opacity 200ms;
  text-decoration:none;
}
.article-card .card-link:hover{ opacity:0.7; }

/* Fade-in animation */
@keyframes fadeInUp{
  from{ opacity:0; transform:translateY(18px); }
  to{ opacity:1; transform:translateY(0); }
}
.fade-in-up{
  animation: fadeInUp 400ms ease forwards;
}

/* Pickup Section */
.pickup-hero{
  position:relative; border-radius:20px; overflow:hidden;
  background:#1a1a1a; min-height:420px;
  border:1px solid rgba(255,255,255,0.06);
  transition:border-color 300ms ease;
  display:block; text-decoration:none;
}
.pickup-hero:hover{ border-color:rgba(255,0,255,0.3); }
.pickup-hero img{
  width:100%; height:100%; object-fit:cover;
  position:absolute; inset:0;
  filter:grayscale(20%) brightness(0.65);
  transition:filter 500ms ease, transform 600ms ease;
}
.pickup-hero:hover img{
  filter:grayscale(0%) brightness(0.55);
  transform:scale(1.03);
}
.pickup-hero .pickup-overlay{
  position:absolute; inset:0;
  background:linear-gradient(0deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.15) 50%, transparent 100%);
  display:flex; flex-direction:column; justify-content:flex-end;
  padding:28px;
}
.pickup-hero .pickup-label{
  display:inline-flex; align-items:center; gap:6px;
  background:#FF00FF; color:#000;
  font-family:'Space Mono',monospace;
  font-size:10px; font-weight:700; letter-spacing:0.12em;
  padding:4px 12px; border-radius:999px;
  width:fit-content; margin-bottom:12px;
}
.pickup-hero .pickup-title{
  font-size:22px; font-weight:700; line-height:1.45;
  color:#fff; margin-bottom:8px;
}
.pickup-hero .pickup-excerpt{
  font-size:13px; line-height:1.7;
  color:rgba(255,255,255,0.65);
  display:-webkit-box; -webkit-line-clamp:2;
  -webkit-box-orient:vertical; overflow:hidden;
}
.pickup-hero .pickup-meta{
  display:flex; align-items:center; gap:12px;
  margin-top:12px; font-size:11px;
  font-family:'Space Mono',monospace;
}
.pickup-hero .pickup-meta .meta-date{ color:rgba(255,255,255,0.4); }
.pickup-hero .pickup-meta .meta-link{ color:#FF00FF; letter-spacing:0.08em; }

.pickup-side{
  display:flex; gap:14px;
  background:#1a1a1a; border-radius:16px; overflow:hidden;
  border:1px solid rgba(255,255,255,0.06);
  transition:border-color 300ms ease, transform 300ms ease;
  cursor:pointer; text-decoration:none;
}
.pickup-side:hover{
  border-color:rgba(255,0,255,0.3);
  transform:translateX(4px);
}
.pickup-side img{
  width:160px; min-height:140px; object-fit:cover; flex-shrink:0;
  filter:grayscale(30%);
  transition:filter 400ms ease;
}
.pickup-side:hover img{ filter:grayscale(0%); }
.pickup-side .pickup-side-body{
  padding:16px 16px 16px 0;
  display:flex; flex-direction:column; justify-content:center;
  min-width:0;
}
.pickup-side .pickup-side-badge{
  font-family:'Space Mono',monospace;
  font-size:10px; color:#FF00FF; letter-spacing:0.06em;
  margin-bottom:6px;
}
.pickup-side .pickup-side-title{
  font-size:14px; font-weight:600; line-height:1.5; color:#fff;
  display:-webkit-box; -webkit-line-clamp:2;
  -webkit-box-orient:vertical; overflow:hidden;
  margin-bottom:6px;
}
.pickup-side .pickup-side-date{
  font-family:'Space Mono',monospace;
  font-size:10px; color:rgba(255,255,255,0.35);
}

/* Category x Tag Detail Section */
.cattag-detail{
  background:#1a1a1a;
  border:1px solid rgba(255,255,255,0.08);
  border-radius:20px;
  padding:32px 28px;
}
.cattag-detail h2{
  font-size:1.5rem;
  font-weight:900;
  color:#fff;
  margin-top:2.5rem;
  margin-bottom:1rem;
  padding-left:14px;
  border-left:4px solid #FF00FF;
  line-height:1.4;
}
.cattag-detail h2:first-child{
  margin-top:0;
}
.cattag-detail h3{
  font-size:1.2rem;
  font-weight:700;
  color:rgba(255,255,255,0.9);
  margin-top:2rem;
  margin-bottom:0.75rem;
  padding-bottom:6px;
  border-bottom:1px solid rgba(255,0,255,0.25);
  line-height:1.5;
}
.cattag-detail p{
  color:rgba(255,255,255,0.72);
  line-height:1.85;
  margin-bottom:1rem;
}
.cattag-detail img{
  max-width:100%;
  height:auto;
  border-radius:12px;
  margin:1.5rem 0;
  border:1px solid rgba(255,255,255,0.08);
}
.cattag-detail ul,
.cattag-detail ol{
  color:rgba(255,255,255,0.72);
  padding-left:1.5em;
  margin-bottom:1rem;
  line-height:1.85;
}
.cattag-detail li{
  margin-bottom:0.4rem;
}
.cattag-detail a{
  color:#FF00FF;
  text-decoration:underline;
  text-underline-offset:3px;
}
.cattag-detail a:hover{
  color:#fff;
}

/* Pagination */
.pagination-wrap .nav-links{
  display:flex; align-items:center; justify-content:center; gap:8px;
}
.pagination-wrap .nav-links a,
.pagination-wrap .nav-links span{
  display:inline-flex; align-items:center; justify-content:center;
  min-width:40px; height:40px; padding:0 12px; border-radius:10px;
  border:1px solid rgba(255,255,255,0.12);
  background:transparent; color:rgba(255,255,255,0.6);
  font-family:'Space Mono',monospace; font-size:13px;
  transition:all 200ms ease; text-decoration:none;
}
.pagination-wrap .nav-links a:hover{
  border-color:#FF00FF; color:#FF00FF;
}
.pagination-wrap .nav-links .current{
  background:#FF00FF; color:#000;
  border-color:#FF00FF; font-weight:700;
}

@media (max-width: 768px){
  .pickup-side img{ width:120px; min-height:110px; }
  .pickup-hero{ min-height:320px; }
  .pickup-hero .pickup-title{ font-size:18px; }
  .cattag-detail{ padding:24px 18px; }
}
</style>

<section class="top-hero">
  <div class="max-w-6xl mx-auto px-6 pb-16">
    <div class="grid lg:grid-cols-12 gap-8 items-center">
      <div class="lg:col-span-5 space-y-6">
        <div class="text-7xl md:text-8xl font-black italic tracking-tighter text-white">R</div>
        <div class="font-mono text-xs tracking-[0.5em] text-neon-pink">CREATIVE SPACE</div>
        <h1 class="text-2xl md:text-3xl font-semibold leading-tight">ACRY LABO｜アクリルグッズ専門メディア</h1>
        <p class="text-white/70 leading-relaxed">アクリルグッズ制作サービスの比較・紹介が充実しているので、最適なサービス選びがスムーズに進むメディアサイトです。アクリルキーホルダー／アクリルスタンド／アクリルブロックなど、商品別のおすすめサービスを紹介します。</p>
        <div class="flex flex-wrap gap-3 pt-2">
          <a class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-white text-black text-sm font-medium hover:opacity-90 transition" href="#section-a2">一覧へ</a>
          <a class="inline-flex items-center gap-2 px-5 py-3 rounded-full border border-white/40 text-white text-sm font-medium hover:bg-white hover:text-black transition" href="#contact">相談リクエスト</a>
        </div>
      </div>
      <div class="lg:col-span-7">
        <?php
        $default_slider_images = array(
            array('url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/f232c45305-2c7b155114100a018a1e.png'),
            array('url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/381dba732e-8b14493a404087c5b367.png'),
            array('url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/9c3a384c9c-db5ef922f12055a7a40f.png'),
            array('url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/695ae2f233-049417f5fd4fbd7429d3.png'),
            array('url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/91c7b19543-e548c6d370d1c5553319.png'),
            array('url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/fe2006aea0-4299cec61cd6941064c2.png'),
        );
        $slider_images = stelmah_get_option_repeater('archive_slider_images', $default_slider_images);
        ?>
        <div class="top-slider">
          <div class="top-slider-track">
            <?php foreach ($slider_images as $slide) : ?>
            <div class="top-slide"><img alt="" src="<?php echo esc_url($slide['url']); ?>"/></div>
            <?php endforeach; ?>
          </div>
          <div class="top-slider-dots">
            <?php foreach ($slider_images as $index => $slide) : ?>
            <button aria-label="slide <?php echo $index + 1; ?>" class="top-dot" type="button"></button>
            <?php endforeach; ?>
          </div>
          <button aria-label="previous" class="top-arrow top-prev" type="button">&#8249;</button>
          <button aria-label="next" class="top-arrow top-next" type="button">&#8250;</button>
        </div>
      </div>
    </div>
  </div>
</section>

<main class="pb-20 unified-section">
<div class="max-w-6xl mx-auto px-6">

<?php if ( is_post_type_archive() || is_home() || $is_articles_filter ) : ?>
<!-- Pickup Section -->
<section class="pt-12 pb-10" id="pickupSection">
  <div class="flex items-center gap-4 mb-6">
    <div>
      <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">PICKUP</div>
      <h2 class="text-2xl font-bold mt-1">ピックアップ記事</h2>
    </div>
    <div class="flex-1 h-px bg-white/10 ml-4"></div>
  </div>
  <div class="grid lg:grid-cols-5 gap-5">
    <?php
    // ACF is_pickup フィールドが有効な記事を最大3件取得
    $pickup_args = array(
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
        'meta_query'     => array(
            array(
                'key'     => 'is_pickup',
                'value'   => '1',
                'compare' => '=',
            ),
        ),
    );
    $pickup_query = new WP_Query($pickup_args);

    if ( $pickup_query->have_posts() ) :
        $pickup_index = 0;
        while ( $pickup_query->have_posts() ) : $pickup_query->the_post();
            $cats = get_the_category();
            $cat_name = ! empty($cats) ? esc_html($cats[0]->name) : '';

            if ( $pickup_index === 0 ) : ?>
              <a href="<?php the_permalink(); ?>" class="pickup-hero lg:col-span-3 fade-in-up">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail('large', array('loading' => 'lazy')); ?>
                <?php endif; ?>
                <div class="pickup-overlay">
                  <span class="pickup-label"><i class="fa-solid fa-fire text-[10px]"></i> PICKUP</span>
                  <h3 class="pickup-title"><?php the_title(); ?></h3>
                  <p class="pickup-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                  <div class="pickup-meta">
                    <span class="meta-date"><?php echo get_the_date('Y-m-d'); ?></span>
                    <span class="meta-link">READ MORE &rarr;</span>
                  </div>
                </div>
              </a>
              <?php if ( $pickup_query->post_count > 1 ) : ?>
              <div class="lg:col-span-2 flex flex-col gap-5">
              <?php endif; ?>
            <?php else : ?>
              <a href="<?php the_permalink(); ?>" class="pickup-side fade-in-up" style="animation-delay:<?php echo $pickup_index * 80; ?>ms">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail('medium', array('class' => '', 'loading' => 'lazy')); ?>
                <?php endif; ?>
                <div class="pickup-side-body">
                  <div class="pickup-side-badge"><?php echo $cat_name; ?></div>
                  <h4 class="pickup-side-title"><?php the_title(); ?></h4>
                  <span class="pickup-side-date"><?php echo get_the_date('Y-m-d'); ?></span>
                </div>
              </a>
            <?php endif;

            $pickup_index++;
        endwhile;

        if ( $pickup_query->post_count > 1 ) : ?>
          </div>
        <?php endif;
    endif;
    wp_reset_postdata();
    ?>
  </div>
</section>
<?php endif; ?>

<?php if ( $current_cat_id || $current_tag_id ) : ?>
<!-- Category x Tag Detail Section -->
<?php
$_cattag_post = stelmah_get_cattag_content($current_cat_id, $current_tag_id);
?>
<?php if ( $_cattag_post ) : ?>
<?php
$_detail_cat = $current_cat_id ? get_category($current_cat_id) : null;
$_detail_tag = $current_tag_id ? get_tag($current_tag_id) : null;
$_detail_title = '';
if ( $_detail_cat && $_detail_tag ) {
    $_detail_title = esc_html($_detail_cat->name) . ' × ' . esc_html($_detail_tag->name) . ' の詳細情報';
} elseif ( $_detail_cat ) {
    $_detail_title = esc_html($_detail_cat->name) . 'の詳細情報';
} elseif ( $_detail_tag ) {
    $_detail_title = esc_html($_detail_tag->name) . 'の詳細情報';
}
?>
<section class="pt-12 pb-10 border-t border-white/10" id="cattagDetailSection">
  <div class="flex items-center gap-4 mb-6">
    <div>
      <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">CATEGORY &times; TAG</div>
      <h2 class="text-2xl font-bold mt-1"><?php echo $_detail_title; ?></h2>
    </div>
    <div class="flex-1 h-px bg-white/10 ml-4"></div>
  </div>
  <div class="cattag-detail">
    <?php echo apply_filters('the_content', $_cattag_post->post_content); ?>
  </div>
</section>
<?php endif; ?>
<?php endif; ?>

<!-- Filter Section -->
<section class="pt-12 pb-8 border-t border-white/10" id="section-a2" style="scroll-margin-top:110px;">
  <div class="font-mono text-xs tracking-[0.4em] text-neon-pink mb-2">ARTICLES</div>
  <h2 class="text-3xl font-bold mb-8">
    <?php
    if ( $current_cat_id && $current_tag_id ) {
        $__cat = get_category($current_cat_id);
        $__tag = get_tag($current_tag_id);
        if ($__cat && !is_wp_error($__cat)) echo esc_html($__cat->name);
        if ($__tag && !is_wp_error($__tag)) echo ' × #' . esc_html($__tag->name);
    } elseif ( $current_cat_id ) {
        $__cat = get_category($current_cat_id);
        if ($__cat && !is_wp_error($__cat)) echo esc_html($__cat->name);
    } elseif ( $current_tag_id ) {
        $__tag = get_tag($current_tag_id);
        if ($__tag && !is_wp_error($__tag)) echo '#' . esc_html($__tag->name);
    } elseif ( is_category() ) {
        single_cat_title();
    } elseif ( is_tag() ) {
        single_tag_title('#');
    } else {
        echo '記事一覧';
    }
    ?>
  </h2>

  <!-- Category Buttons -->
  <div class="flex flex-wrap gap-2 mb-5">
    <?php $is_all_active = !$current_cat_id && !$current_tag_id && !is_category() && !is_tag(); ?>
    <a href="<?php echo esc_url(home_url('/articles/')); ?>" class="cat-btn <?php echo $is_all_active ? 'active' : ''; ?>">すべて</a>
    <?php
    $categories = get_categories(array('hide_empty' => true));
    foreach ( $categories as $cat ) : ?>
      <a href="<?php echo esc_url(stelmah_articles_url($cat->term_id, $current_tag_id)); ?>" class="cat-btn <?php echo ($current_cat_id === $cat->term_id) ? 'active' : ''; ?>">
        <?php echo esc_html($cat->name); ?>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- Tag Buttons -->
  <div class="flex flex-wrap gap-2 mb-5">
    <?php
    $tags = get_tags(array('hide_empty' => true));
    foreach ( $tags as $tag ) : ?>
      <a href="<?php echo esc_url(stelmah_articles_url($current_cat_id, $tag->term_id)); ?>" class="tag-btn <?php echo ($current_tag_id === $tag->term_id) ? 'active' : ''; ?>">
        #<?php echo esc_html($tag->name); ?>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- Article Grid -->
<?php if ( have_posts() ) : ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
  <?php $i = 0; while ( have_posts() ) : the_post(); ?>
    <article class="article-card fade-in-up" style="animation-delay:<?php echo $i * 60; ?>ms">
      <a href="<?php the_permalink(); ?>">
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail('medium_large', array('loading' => 'lazy')); ?>
        <?php else : ?>
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/no-image.png" alt="" loading="lazy" />
        <?php endif; ?>
      </a>
      <div class="card-body">
        <?php $cats = get_the_category(); if ( ! empty($cats) ) : ?>
          <a href="<?php echo esc_url(stelmah_articles_url($cats[0]->term_id, 0)); ?>" class="card-badge"><?php echo esc_html($cats[0]->name); ?></a>
        <?php endif; ?>
        <h3 class="card-title"><a href="<?php the_permalink(); ?>" class="text-white hover:text-neon-pink transition-colors" style="text-decoration:none;"><?php the_title(); ?></a></h3>
        <p class="card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
        <div class="card-tags">
          <?php $post_tags = get_the_tags();
          if ( $post_tags ) :
            foreach ( $post_tags as $tag ) : ?>
              <a href="<?php echo esc_url(stelmah_articles_url(0, $tag->term_id)); ?>" class="card-tag">#<?php echo esc_html($tag->name); ?></a>
            <?php endforeach;
          endif; ?>
        </div>
        <div class="card-footer">
          <span class="card-date"><?php echo get_the_date('Y-m-d'); ?></span>
          <a href="<?php the_permalink(); ?>" class="card-link">READ MORE &rarr;</a>
        </div>
      </div>
    </article>
  <?php $i++; endwhile; ?>
</div>

<!-- Pagination -->
<div class="pagination-wrap flex flex-col items-center gap-4 pt-4 pb-8">
  <?php stelmah_articles_pagination(); ?>
</div>

<?php else : ?>
<div class="text-center py-20">
  <div class="text-5xl mb-4 opacity-30">&#128237;</div>
  <p class="text-white/50 font-mono text-sm">該当する記事が見つかりませんでした</p>
</div>
<?php endif; ?>

<!-- Section A: カテゴリごとのコラム一覧 -->
<?php
$bottom_cats = get_categories(array('hide_empty' => true));
if ( !empty($bottom_cats) ) : ?>
<section class="pt-12 pb-10 border-t border-white/10">
  <div class="flex items-center gap-4 mb-6">
    <div>
      <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">CATEGORIES</div>
      <h2 class="text-2xl font-bold mt-1">カテゴリごとのコラム一覧</h2>
    </div>
    <div class="flex-1 h-px bg-white/10 ml-4"></div>
  </div>
  <div class="flex flex-wrap gap-3">
    <?php foreach ( $bottom_cats as $bcat ) : ?>
      <a href="<?php echo esc_url(stelmah_articles_url($bcat->term_id, $current_tag_id)); ?>" class="cat-btn <?php echo ($current_cat_id === $bcat->term_id) ? 'active' : ''; ?>">
        <?php echo esc_html($bcat->name); ?>
        <span class="text-[10px] opacity-60">(<?php echo $bcat->count; ?>)</span>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- Section B: タグごとのコラム一覧 -->
<?php
$bottom_tags = get_tags(array('hide_empty' => true));
if ( !empty($bottom_tags) ) : ?>
<section class="pt-12 pb-10 border-t border-white/10">
  <div class="flex items-center gap-4 mb-6">
    <div>
      <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">TAGS</div>
      <h2 class="text-2xl font-bold mt-1">タグごとのコラム一覧</h2>
    </div>
    <div class="flex-1 h-px bg-white/10 ml-4"></div>
  </div>
  <div class="flex flex-wrap gap-2">
    <?php foreach ( $bottom_tags as $btag ) : ?>
      <a href="<?php echo esc_url(stelmah_articles_url($current_cat_id, $btag->term_id)); ?>" class="tag-btn <?php echo ($current_tag_id === $btag->term_id) ? 'active' : ''; ?>">
        #<?php echo esc_html($btag->name); ?>
        <span class="text-[10px] opacity-60">(<?php echo $btag->count; ?>)</span>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

</div>
</main>

<?php get_footer(); ?>
