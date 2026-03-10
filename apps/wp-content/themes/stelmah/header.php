<?php
$accent_color   = esc_attr(stelmah_get_option('accent_color', '#FF00FF'));
$bg_color       = esc_attr(stelmah_get_option('bg_color', '#111111'));
$card_bg_color  = esc_attr(stelmah_get_option('card_bg_color', '#1a1a1a'));
$grid_line_color = esc_attr(stelmah_get_option('grid_line_color', '#2a2a2a'));
$site_name      = esc_html(stelmah_get_option('site_name', 'ACRY LABO'));
$site_subtitle  = esc_html(stelmah_get_option('site_subtitle', 'ACRYLIC GOODS MEDIA'));
$site_logo      = stelmah_get_option('site_logo', '');
$cta_text       = esc_html(stelmah_get_option('header_cta_text', 'お問い合わせ'));
$cta_link       = esc_attr(stelmah_get_option('header_cta_link', '#contact'));
$cta_show       = stelmah_get_option('header_cta_show', 1);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        'neon-pink': '<?php echo $accent_color; ?>',
        'neon-lime': '<?php echo $accent_color; ?>',
        'dark-bg': '<?php echo $bg_color; ?>',
        'card-bg': '<?php echo $card_bg_color; ?>',
        'grid-line': '<?php echo $grid_line_color; ?>',
      },
      fontFamily: {
        sans: ['Inter','Noto Sans JP','sans-serif'],
        mono: ['Space Mono','Courier New','monospace'],
      }
    }
  }
};
window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
</script>
<style id="unified-style">
:root{
  --accent: <?php echo $accent_color; ?>;
  --bg: <?php echo $bg_color; ?>;
  --card-bg: <?php echo $card_bg_color; ?>;
  --grid-line: <?php echo $grid_line_color; ?>;
}
::-webkit-scrollbar{ width:8px; }
::-webkit-scrollbar-track{ background:#0f0f0f; }
::-webkit-scrollbar-thumb{ background:var(--accent); border-radius:6px; }

html,body{ height:100%; }
body{
  background:var(--bg);
  color:#eee;
  font-family: Inter,'Noto Sans JP',sans-serif;
  overflow-x:hidden;
}

h1,h2,h3,h4{ color:#fff; }
a{ color:#fff; }
a:hover{ color:var(--accent); }

.unified-section{
  background:var(--bg);
  color:#eee;
}
.unified-section .bg-white,
.unified-section .bg-gray-50,
.unified-section .bg-gray-100{
  background:var(--card-bg) !important;
}
.unified-section .text-gray-900,
.unified-section .text-gray-800,
.unified-section .text-gray-700{
  color:#fff !important;
}
.unified-section .text-gray-600,
.unified-section .text-gray-500,
.unified-section .text-gray-400,
.unified-section .text-studio-text,
.unified-section .text-studio-muted{
  color:rgba(255,255,255,0.72) !important;
}
.unified-section .border-gray-100,
.unified-section .border-gray-200,
.unified-section .border-gray-300{
  border-color:rgba(255,255,255,0.12) !important;
}
.unified-section .shadow-lg,
.unified-section .shadow-xl,
.unified-section .shadow-2xl{
  box-shadow: 0 18px 48px rgba(0,0,0,0.45) !important;
}

.unified-section a.bg-studio-accent,
.unified-section button.bg-studio-accent,
.unified-section a.bg-gray-900,
.unified-section a.bg-black,
.unified-section button.bg-black{
  background:var(--accent) !important;
  color:#000 !important;
}
.unified-section a.border-studio-accent,
.unified-section a.border-black,
.unified-section .border-studio-accent{
  border-color:var(--accent) !important;
}
.unified-section a.text-studio-accent,
.unified-section i.text-studio-accent{
  color:var(--accent) !important;
}

.top-hero{ position:relative; padding-top:88px; }
.top-slider{ position:relative; overflow:hidden; border-radius:24px; background:#0b0b0b; }
.top-slider-track{ display:flex; transition:transform 520ms ease; will-change:transform; }
.top-slide{ min-width:100%; }
.top-slide img{ width:100%; height:clamp(320px,44vw,640px); object-fit:cover; display:block; filter:grayscale(100%); transition:filter 400ms ease; }
.top-slider:hover .top-slide img{ filter:grayscale(0%); }
.top-slider-dots{
  position:absolute; left:0; right:0; bottom:14px;
  display:flex; justify-content:center; align-items:center;
  gap:10px; padding:0 12px;
}
.top-dot{
  width:10px; height:10px; border-radius:999px; border:0;
  background:rgba(255,255,255,0.45);
  box-shadow:0 2px 12px rgba(0,0,0,0.18);
  cursor:pointer;
}
.top-dot.is-active{ background:rgba(255,255,255,0.92); transform:scale(1.15); }
.top-arrow{
  position:absolute; top:50%; transform:translateY(-50%);
  width:44px; height:44px; border-radius:999px;
  border:1px solid rgba(255,255,255,0.25);
  background:rgba(0,0,0,0.25);
  color:white; font-size:26px; line-height:40px;
  cursor:pointer; opacity:0;
  transition:opacity 200ms ease, background 200ms ease;
}
.top-prev{ left:14px; }
.top-next{ right:14px; }
.top-slider:hover .top-arrow{ opacity:1; }
.top-arrow:hover{ background:rgba(255,255,255,0.15); }

@media (prefers-reduced-motion: reduce){
  .top-slider-track{ transition:none; }
}
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class('bg-black text-white'); ?>>
<?php wp_body_open(); ?>

<header class="fixed top-0 left-0 w-full z-50 pointer-events-none mix-blend-difference text-white p-6 flex justify-between items-start">
  <div class="font-mono text-sm tracking-widest">
    <a href="<?php echo home_url('/'); ?>" class="block">
      <?php if ($site_logo) : ?>
        <img src="<?php echo esc_url($site_logo); ?>" alt="<?php echo $site_name; ?>" class="h-8 w-auto">
      <?php else : ?>
        <span class="block"><?php echo $site_name; ?></span>
        <span class="block text-xs opacity-70"><?php echo $site_subtitle; ?></span>
      <?php endif; ?>
    </a>
  </div>
  <div class="pointer-events-auto flex items-center gap-3">
    <?php
    if (has_nav_menu('primary')) {
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => 'nav',
            'container_class'=> 'hidden md:flex items-center gap-6 font-mono text-xs tracking-[0.35em] uppercase opacity-90',
            'items_wrap'     => '%3$s',
            'walker'         => new Stelmah_Nav_Walker(),
        ));
    } else {
        stelmah_fallback_menu();
    }
    ?>
    <div class="text-xs opacity-80 font-mono" id="topClock">--:--</div>
    <?php if ($cta_show) : ?>
    <a class="bg-neon-pink text-black hover:bg-white px-4 py-2 font-bold uppercase text-xs tracking-widest transition-colors" href="<?php echo $cta_link; ?>"><?php echo $cta_text; ?></a>
    <?php endif; ?>
  </div>
</header>
