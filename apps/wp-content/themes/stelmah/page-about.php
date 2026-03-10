<?php
/**
 * About ページテンプレート
 * Template Name: About
 */
get_header();

$defaults = stelmah_about_defaults();
$overview = get_post_meta(get_the_ID(), '_stelmah_about_overview', true);
$values_intro = get_post_meta(get_the_ID(), '_stelmah_about_values_intro', true);
$values = get_post_meta(get_the_ID(), '_stelmah_about_values', true);
$faq = get_post_meta(get_the_ID(), '_stelmah_about_faq', true);

if (empty($overview)) $overview = $defaults['overview'];
if (empty($values_intro)) $values_intro = $defaults['values_intro'];
if (empty($values)) $values = $defaults['values'];
if (empty($faq)) $faq = $defaults['faq'];
?>

<main class="unified-section pt-28 pb-20">
  <div class="max-w-6xl mx-auto px-6">
    <nav class="text-xs font-mono tracking-[0.4em] text-white/60">
      <a class="hover:text-white" href="<?php echo home_url('/'); ?>">HOME</a> <span class="mx-2">/</span> ABOUT
    </nav>

    <div class="mt-8 grid gap-10 lg:grid-cols-12 items-start">
      <div class="lg:col-span-7">
        <div class="font-mono text-xs tracking-[0.5em] text-neon-pink">ABOUT</div>
        <h1 class="text-4xl md:text-5xl font-black tracking-tight mt-3"><?php the_title(); ?></h1>
        <div class="text-white/70 mt-6 leading-relaxed">
          <?php while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
          <?php endwhile; ?>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
          <a class="inline-flex items-center gap-2 bg-neon-pink text-black px-6 py-3 rounded-full font-bold hover:opacity-90 transition" href="<?php echo home_url('/articles/'); ?>">
            記事一覧へ <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a class="inline-flex items-center gap-2 border border-white/25 text-white px-6 py-3 rounded-full font-bold hover:bg-white hover:text-black transition" href="#contact">
            お問い合わせ <i class="fa-regular fa-paper-plane"></i>
          </a>
        </div>
      </div>

      <div class="lg:col-span-5">
        <div class="rounded-3xl overflow-hidden border border-white/10 bg-[#0f0f10]">
          <div class="p-6 border-b border-white/10">
            <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">AT A GLANCE</div>
            <h2 class="text-xl font-bold mt-2">概要</h2>
          </div>
          <dl class="p-6 space-y-3 text-sm text-white/80">
            <?php foreach ($overview as $item) : ?>
              <?php if (!empty($item['label']) && !empty($item['value'])) : ?>
                <div class="flex justify-between gap-4">
                  <dt class="text-white/60"><?php echo esc_html($item['label']); ?></dt>
                  <dd class="text-right"><?php echo esc_html($item['value']); ?></dd>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </dl>
        </div>
      </div>
    </div>

    <section class="mt-16 rounded-3xl border border-white/10 bg-[#0f0f10] overflow-hidden">
      <div class="p-8 md:p-10 border-b border-white/10">
        <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">OUR VALUES</div>
        <h2 class="text-2xl md:text-3xl font-bold mt-2">大切にしていること</h2>
        <p class="text-white/70 mt-4 leading-relaxed"><?php echo esc_html($values_intro); ?></p>
      </div>

      <div class="p-8 md:p-10 grid gap-6 md:grid-cols-3">
        <?php foreach ($values as $value) : ?>
          <?php if (!empty($value['title'])) : ?>
            <div class="rounded-2xl border border-white/10 bg-black p-6">
              <h3 class="font-bold text-lg"><?php echo esc_html($value['title']); ?></h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed"><?php echo esc_html($value['description']); ?></p>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="mt-16">
      <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">FAQ</div>
      <h2 class="text-2xl md:text-3xl font-bold mt-2">よくあるご質問</h2>

      <div class="mt-8 grid gap-6 md:grid-cols-2">
        <?php foreach ($faq as $item) : ?>
          <?php if (!empty($item['question'])) : ?>
            <div class="rounded-3xl border border-white/10 bg-[#0f0f10] p-7">
              <h3 class="font-bold"><?php echo esc_html($item['question']); ?></h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed"><?php echo esc_html($item['answer']); ?></p>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</main>

<?php get_footer(); ?>
