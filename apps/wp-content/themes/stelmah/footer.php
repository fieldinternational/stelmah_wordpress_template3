<?php
$footer_label   = esc_html(stelmah_get_option('footer_label', 'ABOUT US'));
$footer_title   = esc_html(stelmah_get_option('footer_title', '運営情報'));
$company_name   = esc_html(stelmah_get_option('company_name', 'ACRY LABO'));
$company_addr   = esc_html(stelmah_get_option('company_address', '〒107-0062 東京都港区南青山5-10-1'));
$company_email  = esc_html(stelmah_get_option('company_email', 'info@acrylabo.jp'));
$company_phone  = stelmah_get_option('company_phone', '');
$copyright      = stelmah_get_option('copyright_text', '');
$sns_twitter    = stelmah_get_option('sns_twitter', '');
$sns_instagram  = stelmah_get_option('sns_instagram', '');
$sns_facebook   = stelmah_get_option('sns_facebook', '');
$sns_youtube    = stelmah_get_option('sns_youtube', '');
$sns_line       = stelmah_get_option('sns_line', '');
$has_sns = $sns_twitter || $sns_instagram || $sns_facebook || $sns_youtube || $sns_line;
?>
<footer class="unified-section py-16 border-t border-white/10" id="contact">
  <div class="max-w-6xl mx-auto px-6">
    <div class="font-mono text-xs tracking-[0.5em] text-neon-pink"><?php echo $footer_label; ?></div>
    <h2 class="text-3xl font-bold mt-3 text-white"><?php echo $footer_title; ?></h2>
    <div class="mt-8 rounded-3xl border border-white/10 bg-[#0f0f10] p-8 max-w-lg">
      <dl class="space-y-4 text-sm text-white/80">
        <div class="flex justify-between gap-4"><dt class="text-white/60">運営会社</dt><dd class="text-right"><?php echo $company_name; ?></dd></div>
        <div class="flex justify-between gap-4"><dt class="text-white/60">所在地</dt><dd class="text-right"><?php echo $company_addr; ?></dd></div>
        <div class="flex justify-between gap-4"><dt class="text-white/60">Email</dt><dd class="text-right"><?php echo $company_email; ?></dd></div>
        <?php if ($company_phone) : ?>
        <div class="flex justify-between gap-4"><dt class="text-white/60">TEL</dt><dd class="text-right"><?php echo esc_html($company_phone); ?></dd></div>
        <?php endif; ?>
      </dl>
    </div>

    <?php if ($has_sns) : ?>
    <div class="mt-8 flex gap-4">
      <?php if ($sns_twitter) : ?><a href="<?php echo esc_url($sns_twitter); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:border-neon-pink hover:text-neon-pink transition-colors"><i class="fa-brands fa-x-twitter"></i></a><?php endif; ?>
      <?php if ($sns_instagram) : ?><a href="<?php echo esc_url($sns_instagram); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:border-neon-pink hover:text-neon-pink transition-colors"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
      <?php if ($sns_facebook) : ?><a href="<?php echo esc_url($sns_facebook); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:border-neon-pink hover:text-neon-pink transition-colors"><i class="fa-brands fa-facebook-f"></i></a><?php endif; ?>
      <?php if ($sns_youtube) : ?><a href="<?php echo esc_url($sns_youtube); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:border-neon-pink hover:text-neon-pink transition-colors"><i class="fa-brands fa-youtube"></i></a><?php endif; ?>
      <?php if ($sns_line) : ?><a href="<?php echo esc_url($sns_line); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:border-neon-pink hover:text-neon-pink transition-colors"><i class="fa-brands fa-line"></i></a><?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="mt-10 flex flex-wrap gap-6 text-xs font-mono tracking-widest opacity-80">
      <a class="hover:text-neon-pink transition-colors" href="<?php echo home_url('/about/'); ?>">ABOUT</a>
      <a class="hover:text-neon-pink transition-colors" href="<?php echo home_url('/contact/'); ?>">CONTACT</a>
      <a class="hover:text-neon-pink transition-colors" href="<?php echo home_url('/privacy/'); ?>">PRIVACY POLICY</a>
    </div>

    <?php if ($copyright) : ?>
    <div class="mt-8 text-xs text-white/40 font-mono"><?php echo esc_html($copyright); ?></div>
    <?php endif; ?>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
  /* Clock */
  const clockEl = document.getElementById('topClock');
  const pad = (n) => String(n).padStart(2,'0');
  const tick = () => {
    const now = new Date();
    if(clockEl) clockEl.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}`;
  };
  tick();
  setInterval(tick, 10000);

  /* Hero Slider */
  const slider = document.querySelector('.top-slider');
  if(!slider) return;
  const track = slider.querySelector('.top-slider-track');
  const slides = Array.from(slider.querySelectorAll('.top-slide'));
  const dots = Array.from(slider.querySelectorAll('.top-dot'));
  const prev = slider.querySelector('.top-prev');
  const next = slider.querySelector('.top-next');

  let idx = 0;
  let timer = null;

  const setActive = (i) => {
    idx = (i + slides.length) % slides.length;
    track.style.transform = `translateX(-${idx * 100}%)`;
    dots.forEach((d, di) => d.classList.toggle('is-active', di === idx));
  };

  const start = () => { stop(); timer = setInterval(() => setActive(idx + 1), 4200); };
  const stop = () => { if(timer) clearInterval(timer); timer = null; };

  dots.forEach((d, i) => d.addEventListener('click', () => { setActive(i); start(); }));
  if(prev) prev.addEventListener('click', () => { setActive(idx - 1); start(); });
  if(next) next.addEventListener('click', () => { setActive(idx + 1); start(); });

  let startX = 0;
  let isDown = false;
  slider.addEventListener('pointerdown', (e) => { isDown = true; startX = e.clientX; stop(); });
  const endSwipe = (clientX) => {
    if(!isDown) return;
    isDown = false;
    const dx = clientX - startX;
    if(Math.abs(dx) > 40) setActive(idx + (dx < 0 ? 1 : -1));
    start();
  };
  slider.addEventListener('pointerup', (e) => endSwipe(e.clientX));
  slider.addEventListener('pointercancel', () => { isDown = false; start(); });
  slider.addEventListener('mouseenter', stop);
  slider.addEventListener('mouseleave', start);

  setActive(0);
  start();
});
</script>

<?php wp_footer(); ?>
</body>
</html>
