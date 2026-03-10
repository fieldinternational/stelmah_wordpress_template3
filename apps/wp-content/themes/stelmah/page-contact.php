<?php
/**
 * お問い合わせ ページテンプレート
 * Template Name: Contact
 */
get_header();

$company_email = esc_html(stelmah_get_option('company_email', 'info@acrylabo.jp'));
$company_phone = stelmah_get_option('company_phone', '');
?>

<main class="unified-section pt-28 pb-20">
  <div class="max-w-6xl mx-auto px-6">
    <nav class="text-xs font-mono tracking-[0.4em] text-white/60">
      <a class="hover:text-white" href="<?php echo home_url('/'); ?>">HOME</a> <span class="mx-2">/</span> CONTACT
    </nav>

    <div class="mt-8">
      <div class="font-mono text-xs tracking-[0.5em] text-neon-pink">CONTACT</div>
      <h1 class="text-4xl md:text-5xl font-black tracking-tight mt-3"><?php the_title(); ?></h1>
      <p class="text-white/60 text-sm mt-4 max-w-2xl">お気軽にお問い合わせください。下記フォームまたはメール・お電話でも承っております。</p>
    </div>

    <!-- 連絡先カード -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="rounded-2xl border border-white/10 bg-[#0f0f10] p-6 text-center">
        <div class="w-12 h-12 mx-auto rounded-full border border-neon-pink/30 flex items-center justify-center text-neon-pink">
          <i class="fa-solid fa-envelope text-lg"></i>
        </div>
        <div class="mt-4 font-mono text-xs tracking-widest text-white/50">EMAIL</div>
        <a href="mailto:<?php echo $company_email; ?>" class="mt-2 block text-sm text-white hover:text-neon-pink transition-colors"><?php echo $company_email; ?></a>
      </div>

      <?php if ($company_phone) : ?>
      <div class="rounded-2xl border border-white/10 bg-[#0f0f10] p-6 text-center">
        <div class="w-12 h-12 mx-auto rounded-full border border-neon-pink/30 flex items-center justify-center text-neon-pink">
          <i class="fa-solid fa-phone text-lg"></i>
        </div>
        <div class="mt-4 font-mono text-xs tracking-widest text-white/50">PHONE</div>
        <a href="tel:<?php echo esc_attr($company_phone); ?>" class="mt-2 block text-sm text-white hover:text-neon-pink transition-colors"><?php echo esc_html($company_phone); ?></a>
      </div>
      <?php endif; ?>

      <div class="rounded-2xl border border-white/10 bg-[#0f0f10] p-6 text-center">
        <div class="w-12 h-12 mx-auto rounded-full border border-neon-pink/30 flex items-center justify-center text-neon-pink">
          <i class="fa-solid fa-clock text-lg"></i>
        </div>
        <div class="mt-4 font-mono text-xs tracking-widest text-white/50">HOURS</div>
        <p class="mt-2 text-sm text-white">平日 10:00 – 18:00</p>
      </div>
    </div>

    <!-- フォームセクション -->
    <section class="mt-12 rounded-3xl border border-white/10 bg-[#0f0f10] overflow-hidden">
      <div class="p-8 md:p-10 stelmah-contact-form">
        <?php while (have_posts()) : the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>
      </div>
    </section>

    <div class="mt-12">
      <a class="inline-flex items-center gap-2 bg-neon-pink text-black px-6 py-3 rounded-full font-bold hover:opacity-90 transition" href="<?php echo home_url('/'); ?>">
        HOMEへ戻る <i class="fa-solid fa-house"></i>
      </a>
    </div>
  </div>
</main>

<style>
/* CF7 ダークテーマ統合 */
.stelmah-contact-form .wpcf7-form p {
  color: rgba(255,255,255,0.7);
  font-size: 0.875rem;
  margin-top: 1rem;
}
.stelmah-contact-form .wpcf7-form label {
  color: rgba(255,255,255,0.8);
  font-size: 0.875rem;
  font-weight: 500;
}
.stelmah-contact-form .wpcf7-form input[type="text"],
.stelmah-contact-form .wpcf7-form input[type="email"],
.stelmah-contact-form .wpcf7-form input[type="tel"],
.stelmah-contact-form .wpcf7-form input[type="url"],
.stelmah-contact-form .wpcf7-form textarea,
.stelmah-contact-form .wpcf7-form select {
  width: 100%;
  padding: 0.75rem 1rem;
  margin-top: 0.5rem;
  background: rgba(0,0,0,0.4);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 0.75rem;
  color: #fff;
  font-size: 0.875rem;
  transition: border-color 0.2s, box-shadow 0.2s;
  outline: none;
}
.stelmah-contact-form .wpcf7-form input:focus,
.stelmah-contact-form .wpcf7-form textarea:focus,
.stelmah-contact-form .wpcf7-form select:focus {
  border-color: #FF00FF;
  box-shadow: 0 0 0 3px rgba(255,0,255,0.15);
}
.stelmah-contact-form .wpcf7-form textarea {
  min-height: 160px;
  resize: vertical;
}
.stelmah-contact-form .wpcf7-form input[type="submit"] {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: #FF00FF;
  color: #000;
  padding: 0.75rem 2rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 0.875rem;
  border: none;
  cursor: pointer;
  transition: opacity 0.2s;
  margin-top: 1.5rem;
  width: auto;
}
.stelmah-contact-form .wpcf7-form input[type="submit"]:hover {
  opacity: 0.9;
}
/* バリデーションエラー */
.stelmah-contact-form .wpcf7-not-valid-tip {
  color: #f87171;
  font-size: 0.75rem;
  margin-top: 0.25rem;
}
.stelmah-contact-form .wpcf7-not-valid {
  border-color: #f87171 !important;
}
/* レスポンスメッセージ */
.stelmah-contact-form .wpcf7-response-output {
  margin-top: 1.5rem;
  padding: 1rem;
  border-radius: 0.75rem;
  font-size: 0.875rem;
}
.stelmah-contact-form .wpcf7-mail-sent-ok,
.stelmah-contact-form .wpcf7 form.sent .wpcf7-response-output {
  border: 1px solid #FF00FF;
  color: #FF00FF;
  background: rgba(255,0,255,0.05);
}
.stelmah-contact-form .wpcf7-validation-errors,
.stelmah-contact-form .wpcf7 form.invalid .wpcf7-response-output,
.stelmah-contact-form .wpcf7 form.failed .wpcf7-response-output {
  border: 1px solid #f87171;
  color: #f87171;
  background: rgba(248,113,113,0.05);
}
/* スピナー */
.stelmah-contact-form .wpcf7-spinner {
  margin-left: 1rem;
}
</style>

<?php get_footer(); ?>
