<?php
/**
 * トップページテンプレート
 */
get_header();

$d = stelmah_frontpage_defaults();

// CONCEPT
$concept_label         = esc_html(stelmah_get_option('concept_label', $d['concept_label']));
$concept_heading       = nl2br(esc_html(stelmah_get_option('concept_heading', $d['concept_heading'])));
$concept_text          = esc_html(stelmah_get_option('concept_text', $d['concept_text']));
$concept_image         = esc_url(stelmah_get_option('concept_image', $d['concept_image']));
$concept_features      = stelmah_get_option_repeater('concept_features', $d['concept_features']);
$concept_readmore_text = esc_html(stelmah_get_option('concept_readmore_text', $d['concept_readmore_text']));
$concept_readmore_link = esc_url(stelmah_get_option('concept_readmore_link', home_url('/about/')));

// Service Highlights
$highlights_heading = esc_html(stelmah_get_option('highlights_heading', $d['highlights_heading']));
$highlights_subtext = esc_html(stelmah_get_option('highlights_subtext', $d['highlights_subtext']));
$highlights_count   = intval(stelmah_get_option('highlights_count', 3));

// Tools & Support
$tools_heading  = esc_html(stelmah_get_option('tools_heading', $d['tools_heading']));
$tools_subtext  = esc_html(stelmah_get_option('tools_subtext', $d['tools_subtext']));
$tools_cta_text = esc_html(stelmah_get_option('tools_cta_text', $d['tools_cta_text']));
$tools_cta_link = esc_url(stelmah_get_option('tools_cta_link', '#'));
$tools_items    = stelmah_get_option_repeater('tools_items', $d['tools_items']);

// Comfortable Workflow
$workflow_heading    = nl2br(esc_html(stelmah_get_option('workflow_heading', $d['workflow_heading'])));
$workflow_features   = stelmah_get_option_repeater('workflow_features', $d['workflow_features']);
$workflow_cta_text   = esc_html(stelmah_get_option('workflow_cta_text', $d['workflow_cta_text']));
$workflow_cta_link   = esc_url(stelmah_get_option('workflow_cta_link', home_url('/articles/')));
$workflow_image_main = esc_url(stelmah_get_option('workflow_image_main', $d['workflow_image_main']));
$workflow_image_sub  = esc_url(stelmah_get_option('workflow_image_sub', $d['workflow_image_sub']));

// Where Design Meets
$where_line1   = esc_html(stelmah_get_option('where_heading_line1', $d['where_heading_line1']));
$where_line2   = esc_html(stelmah_get_option('where_heading_line2', $d['where_heading_line2']));
$where_text    = esc_html(stelmah_get_option('where_text', $d['where_text']));
$where_list    = stelmah_get_option_repeater('where_list', $d['where_list']);
$where_image_1 = esc_url(stelmah_get_option('where_image_1', $d['where_image_1']));
$where_image_2 = esc_url(stelmah_get_option('where_image_2', $d['where_image_2']));

// OUR SERVICES
$services_heading    = esc_html(stelmah_get_option('services_heading', $d['services_heading']));
$services_subheading = esc_html(stelmah_get_option('services_subheading', $d['services_subheading']));
$services_items      = stelmah_get_option_repeater('services_items', $d['services_items']);

// FREE DESIGN RESOURCES
$resources_heading  = nl2br(esc_html(stelmah_get_option('resources_heading', $d['resources_heading'])));
$resources_text     = esc_html(stelmah_get_option('resources_text', $d['resources_text']));
$resources_cta_text = esc_html(stelmah_get_option('resources_cta_text', $d['resources_cta_text']));
$resources_cta_link = esc_url(stelmah_get_option('resources_cta_link', '#'));
?>

<!-- ===== CONCEPT ===== -->
<div class="h-10" id="section-a2"></div>
<section class="unified-section py-10"><div class="max-w-6xl mx-auto px-6"><section class="py-24 px-6 bg-white" id="concept">
<div class="max-w-[1440px] mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
<div class="relative h-[600px] w-full rounded-2xl overflow-hidden shadow-2xl fade-in-up" style="animation-delay: 0.2s;">
<img alt="concept" class="w-full h-full object-cover" src="<?php echo $concept_image; ?>"/>
</div>
<div class="space-y-8 fade-in-up" style="animation-delay: 0.4s;">
<div class="inline-block px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold tracking-widest rounded-full"><?php echo $concept_label; ?></div>
<h2 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 leading-tight"><?php echo $concept_heading; ?></h2>
<p class="text-gray-600 leading-relaxed text-lg"><?php echo $concept_text; ?></p>
<div class="grid grid-cols-2 gap-8 pt-4">
<?php foreach ($concept_features as $feature) : ?>
<div>
<h3 class="text-xl font-bold mb-2 flex items-center gap-2">
<i class="<?php echo esc_attr($feature['icon_class']); ?>"></i> <?php echo esc_html($feature['title']); ?>
</h3>
<p class="text-sm text-gray-500"><?php echo esc_html($feature['description']); ?></p>
</div>
<?php endforeach; ?>
</div>
<div class="pt-6">
<a class="text-gray-900 font-bold border-b-2 border-gray-900 pb-1 hover:text-gray-600 hover:border-gray-600 transition-colors" href="<?php echo $concept_readmore_link; ?>">
<?php echo $concept_readmore_text; ?>
</a>
</div>
</div>
</div>

<!-- ===== Service Highlights ===== -->
</section><section class="py-24 px-6 bg-studio-bg" id="spaces">
<div class="max-w-[1440px] mx-auto">
<div class="text-center mb-16 fade-in-up">
<h2 class="text-3xl md:text-4xl font-serif font-bold mb-4"><?php echo $highlights_heading; ?></h2>
<p class="text-gray-500"><?php echo $highlights_subtext; ?></p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<?php
$highlight_categories = get_categories(array(
    'orderby'    => 'name',
    'order'      => 'ASC',
    'number'     => $highlights_count,
    'hide_empty' => true,
));
$highlight_counter = 1;
foreach ($highlight_categories as $cat) :
    $cat_image_id  = get_term_meta($cat->term_id, 'category_image', true);
    $cat_image_url = $cat_image_id ? wp_get_attachment_url($cat_image_id) : '';
    $cat_link      = home_url('/article/cat_' . $cat->term_id . '/');
    $delay         = $highlight_counter * 0.1;
?>
<a href="<?php echo esc_url($cat_link); ?>" class="group cursor-pointer fade-in-up" style="animation-delay: <?php echo esc_attr($delay); ?>s;">
<div class="h-[400px] overflow-hidden rounded-xl mb-6 relative">
<div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 text-xs font-bold rounded-full z-10">HIGHLIGHT <?php echo sprintf('%02d', $highlight_counter); ?></div>
<?php if ($cat_image_url) : ?>
<img alt="<?php echo esc_attr($cat->name); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="<?php echo esc_url($cat_image_url); ?>"/>
<?php else : ?>
<div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400"><i class="fa-solid fa-image text-4xl"></i></div>
<?php endif; ?>
</div>
<h3 class="text-2xl font-serif font-bold mb-2 group-hover:text-gray-600 transition-colors"><?php echo esc_html($cat->name); ?></h3>
<p class="text-gray-500 text-sm leading-relaxed mb-4"><?php echo esc_html($cat->description); ?></p>
<span class="text-xs font-bold tracking-widest border-b border-gray-300 pb-1 group-hover:border-black transition-all">VIEW DETAILS</span>
</a>
<?php
    $highlight_counter++;
endforeach;
?>
</div>
</div>

<!-- ===== NEWS ===== -->
</section><section class="py-24 bg-[#BCC5CE]" id="news">
<div class="max-w-[1440px] mx-auto px-6 md:px-12 flex flex-col md:flex-row gap-12 md:gap-24">
<div class="md:w-1/4 flex flex-col justify-between min-h-[300px]">
<div>
<h2 class="text-5xl md:text-6xl font-bold text-white tracking-wide mb-8">NEWS</h2>
</div>
<div class="mt-auto">
<a class="group inline-flex items-center gap-4 text-white font-bold text-lg hover:opacity-80 transition-opacity" href="<?php echo home_url('/news/'); ?>">
<span class="border-b border-white pb-1">お知らせ一覧</span>
<span class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#BCC5CE] group-hover:scale-110 transition-transform duration-300">
<i class="fa-solid fa-arrow-right text-sm"></i>
</span>
</a>
</div>
</div>
<div class="md:w-3/4 grid grid-cols-1 md:grid-cols-3 gap-8">
<?php
$news_query = new WP_Query(array(
    'post_type'      => 'news',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
if ($news_query->have_posts()) :
    while ($news_query->have_posts()) : $news_query->the_post();
        $news_tags = get_the_terms(get_the_ID(), 'news_tag');
        $first_tag = ($news_tags && !is_wp_error($news_tags)) ? $news_tags[0]->name : '';
?>
<article class="flex flex-col h-full group cursor-pointer">
<a href="<?php the_permalink(); ?>" class="flex flex-col h-full">
<div class="mb-6 overflow-hidden rounded-full w-40 h-40 md:w-48 md:h-48">
<?php if (has_post_thumbnail()) : ?>
<img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>"/>
<?php else : ?>
<div class="w-full h-full bg-white/20 flex items-center justify-center text-white/40"><i class="fa-solid fa-newspaper text-3xl"></i></div>
<?php endif; ?>
</div>
<div class="flex flex-col flex-grow">
<time class="text-white/80 text-sm font-medium mb-2 block"><?php echo get_the_date('Y.m.d'); ?></time>
<h3 class="text-white text-xl md:text-2xl font-bold leading-snug mb-4"><?php the_title(); ?></h3>
<div class="mt-auto pt-4 border-t border-white/30 flex justify-between items-center">
<?php if ($first_tag) : ?>
<span class="text-white/90 text-sm font-medium"># <?php echo esc_html($first_tag); ?></span>
<?php else : ?>
<span class="text-white/90 text-sm font-medium">&nbsp;</span>
<?php endif; ?>
<span class="w-2 h-2 rounded-full bg-brand-blue"></span>
</div>
</div>
</a>
</article>
<?php
    endwhile;
    wp_reset_postdata();
else :
?>
<div class="col-span-3 text-center py-12">
<p class="text-white/70 text-lg">ニュースはまだありません</p>
</div>
<?php endif; ?>
</div>
</div>

<!-- ===== Tools & Support ===== -->
</section><section class="py-24 px-6 bg-white" id="features">
<div class="max-w-[1440px] mx-auto">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 border-b border-gray-100 pb-8">
<div>
<h2 class="text-3xl md:text-4xl font-serif font-bold mb-2"><?php echo $tools_heading; ?></h2>
<p class="text-gray-500"><?php echo $tools_subtext; ?></p>
</div>
<?php if ($tools_cta_text) : ?>
<a class="hidden md:block text-sm font-bold tracking-widest hover:text-gray-600 transition-colors" href="<?php echo $tools_cta_link; ?>"><?php echo $tools_cta_text; ?> <i class="fa-solid fa-download ml-2"></i></a>
<?php endif; ?>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-8">
<?php foreach ($tools_items as $tool) : ?>
<div class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300 group">
<div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-gray-900 shadow-sm mb-6 group-hover:bg-gray-900 group-hover:text-white transition-colors">
<i class="<?php echo esc_attr($tool['icon_class']); ?>"></i>
</div>
<h3 class="font-bold text-lg mb-2"><?php echo esc_html($tool['title']); ?></h3>
<p class="text-sm text-gray-500"><?php echo esc_html($tool['description']); ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section></div></section>

<!-- ===== Topics ===== -->
<div class="h-10" id="section-a3"></div>
<section class="unified-section py-10"><div class="max-w-6xl mx-auto px-6"><section class="py-24 bg-white" id="topics">
<div class="max-w-7xl mx-auto px-6">
<div class="flex justify-between items-end mb-16">
<div class="flex items-baseline gap-4">
<h2 class="text-6xl font-serif font-bold text-black">Topics</h2>
<span class="text-sm font-medium text-gray-500 tracking-wider">トピックス</span>
</div>
<a class="hidden md:flex items-center gap-2 bg-black text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-gray-800 transition" href="<?php echo home_url('/articles/'); ?>">
一覧を見る <i class="fa-solid fa-arrow-right"></i>
</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
<?php
$topics_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
if ($topics_query->have_posts()) :
    $topic_index = 0;
    while ($topics_query->have_posts()) : $topics_query->the_post();
        $topic_cats   = get_the_category();
        $topic_cat    = $topic_cats ? $topic_cats[0]->name : '';
        $topic_index++;

        if ($topic_index === 1) :
?>
<a href="<?php the_permalink(); ?>" class="group cursor-pointer" id="featured-topic">
<div class="h-[400px] w-full bg-gray-100 rounded-2xl overflow-hidden mb-6 relative">
<?php if (has_post_thumbnail()) : ?>
<img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"/>
<?php else : ?>
<div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fa-solid fa-image text-6xl"></i></div>
<?php endif; ?>
</div>
<div class="space-y-4">
<h3 class="text-2xl font-bold leading-snug group-hover:text-gray-600 transition"><?php the_title(); ?></h3>
<div class="flex items-center justify-between border-t border-gray-200 pt-4 mt-4">
<span class="text-sm font-mono text-gray-500"><?php echo get_the_date('Y.m.d'); ?></span>
<?php if ($topic_cat) : ?>
<span class="px-3 py-1 bg-gray-100 text-xs text-gray-600 rounded-md">#<?php echo esc_html($topic_cat); ?></span>
<?php endif; ?>
</div>
</div>
</a>
<?php
        elseif ($topic_index === 2) :
?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-12">
<?php endif; ?>
<?php if ($topic_index >= 2) : ?>
<a href="<?php the_permalink(); ?>" class="group cursor-pointer" id="topic-item-<?php echo ($topic_index - 1); ?>">
<?php if (has_post_thumbnail()) : ?>
<div class="h-48 w-full bg-gray-50 rounded-lg overflow-hidden mb-4 flex items-center justify-center p-8">
<img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-contain" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>"/>
</div>
<?php else : ?>
<div class="gradient-border-card h-48 w-full mb-4 flex flex-col items-center justify-center p-6 text-center">
<?php if ($topic_cat) : ?>
<span class="text-sm font-bold text-gray-400 mb-1"><?php echo esc_html($topic_cat); ?></span>
<?php endif; ?>
<span class="text-xl font-bold"><?php the_title(); ?></span>
</div>
<?php endif; ?>
<h4 class="text-sm font-bold mb-2 leading-relaxed h-10 overflow-hidden"><?php the_title(); ?></h4>
<div class="flex items-center justify-between mt-2">
<span class="text-xs font-mono text-gray-400"><?php echo get_the_date('Y.m.d'); ?></span>
<?php if ($topic_cat) : ?>
<span class="px-2 py-1 bg-gray-50 text-[10px] text-gray-500 rounded">#<?php echo esc_html($topic_cat); ?></span>
<?php endif; ?>
</div>
</a>
<?php endif; ?>
<?php
    endwhile;
    if ($topic_index >= 2) : ?>
</div>
<?php endif;
    wp_reset_postdata();
else :
?>
<div class="col-span-2 text-center py-12">
<p class="text-gray-500 text-lg">まだ記事がありません</p>
</div>
<?php endif; ?>
</div>
<div class="mt-8 md:hidden text-center">
<a class="inline-flex items-center gap-2 bg-black text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-gray-800 transition" href="<?php echo home_url('/articles/'); ?>">
一覧を見る <i class="fa-solid fa-arrow-right"></i>
</a>
</div>
</div>

<!-- ===== Design & Submission Guide ===== -->
</section><section class="py-24 bg-white" id="features">
<div class="max-w-7xl mx-auto px-6">
<div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
<div class="order-2 md:order-1 relative">
<div class="h-[600px] w-full bg-gray-100 rounded-2xl overflow-hidden">
<img alt="" class="w-full h-full object-cover" src="<?php echo $workflow_image_main; ?>"/>
</div>
<div class="absolute -bottom-10 -right-10 w-64 h-64 bg-white p-4 rounded-xl shadow-xl hidden md:block">
<img alt="" class="w-full h-full object-cover rounded-lg" src="<?php echo $workflow_image_sub; ?>"/>
</div>
</div>
<div class="order-1 md:order-2">
<h2 class="text-4xl md:text-5xl font-serif font-bold mb-8"><?php echo $workflow_heading; ?></h2>
<div class="space-y-8">
<?php foreach ($workflow_features as $wf) : ?>
<div class="flex gap-4">
<div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-xl shrink-0"><i class="<?php echo esc_attr($wf['icon_class']); ?>"></i></div>
<div>
<h3 class="text-xl font-bold mb-2"><?php echo esc_html($wf['title']); ?></h3>
<p class="text-gray-500 text-sm leading-relaxed"><?php echo esc_html($wf['description']); ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
<div class="mt-10">
<a class="text-sm font-bold border-b border-black pb-1 hover:text-gray-600 transition" href="<?php echo $workflow_cta_link; ?>"><?php echo $workflow_cta_text; ?></a>
</div>
</div>
</div>
</div>
</section></div></section>

<!-- ===== Where Design Meets / FEATURED CONTENTS / USEFUL LINKS & TOOLS ===== -->
<div class="h-10" id="section-a4"></div>
<section class="unified-section py-10"><div class="max-w-6xl mx-auto px-6">

<!-- Where Design Meets -->
<section class="py-24 bg-studio-black text-white relative overflow-hidden" id="concept">
<div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
<div class="relative">
<div class="absolute -top-10 -left-10 text-[10rem] font-pixel text-white/5 select-none z-0">01</div>
<h2 class="text-4xl md:text-5xl font-bold mb-8 relative z-10 leading-tight"><?php echo $where_line1; ?><br/><span class="text-neon-lime"><?php echo $where_line2; ?></span></h2>
<p class="text-gray-400 text-lg mb-8 leading-relaxed font-light"><?php echo $where_text; ?></p>
<ul class="space-y-4 font-mono text-sm text-gray-300">
<?php foreach ($where_list as $item) : ?>
<li class="flex items-center gap-3"><i class="fa-solid fa-square text-neon-lime text-xs"></i><span><?php echo esc_html($item['text']); ?></span></li>
<?php endforeach; ?>
</ul>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="h-64 overflow-hidden rounded-sm border border-white/10">
<img alt="" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700" src="<?php echo $where_image_1; ?>"/>
</div>
<div class="h-64 overflow-hidden rounded-sm border border-white/10 translate-y-8">
<img alt="" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700" src="<?php echo $where_image_2; ?>"/>
</div>
</div>
</div>
</section>

<!-- FEATURED CONTENTS -->
<section class="py-24 bg-white text-studio-black" id="spaces">
<div class="max-w-[1440px] mx-auto px-6">
<div class="flex justify-between items-end mb-16 border-b-4 border-studio-black pb-4">
<h2 class="text-6xl font-bold font-sans tracking-tighter"><?php echo $services_heading; ?></h2>
<div class="font-mono text-xl"><?php echo $services_subheading; ?></div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<?php
$featured_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
$svc_offset_classes = array('', 'md:mt-16', '');
$svc_i = 0;
if ($featured_query->have_posts()) :
    while ($featured_query->have_posts()) : $featured_query->the_post();
        $offset = isset($svc_offset_classes[$svc_i]) ? $svc_offset_classes[$svc_i] : '';
        $feat_cats = get_the_category();
        $feat_cat_name = $feat_cats ? $feat_cats[0]->name : '';
?>
<div class="group cursor-pointer <?php echo $offset; ?>">
<a href="<?php the_permalink(); ?>">
<div class="h-[500px] overflow-hidden border-2 border-studio-black relative mb-4">
<div class="absolute top-4 left-4 z-10 bg-neon-lime px-3 py-1 font-mono text-xs font-bold border border-black"><?php echo esc_html($feat_cat_name); ?></div>
<?php if (has_post_thumbnail()) : ?>
<img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"/>
<?php else : ?>
<div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400"><i class="fa-solid fa-image text-4xl"></i></div>
<?php endif; ?>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-2xl font-bold mb-1"><?php the_title(); ?></h3>
<p class="font-mono text-sm text-gray-600"><?php echo esc_html(get_the_date('Y.m.d')); ?></p>
</div>
<i class="fa-solid fa-arrow-right -rotate-45 text-2xl group-hover:rotate-0 transition-transform duration-300"></i>
</div>
</a>
</div>
<?php
        $svc_i++;
    endwhile;
    wp_reset_postdata();
endif;
?>
</div>
</div>
</section>

<!-- USEFUL LINKS & TOOLS -->
<section class="py-20 bg-white" id="equipment">
<div class="max-w-[1440px] mx-auto px-6">
<div class="flex flex-col md:flex-row gap-12">
<div class="w-full md:w-1/3">
<h2 class="text-4xl font-bold mb-6 text-studio-black"><?php echo $resources_heading; ?></h2>
<p class="text-gray-600 mb-8"><?php echo $resources_text; ?></p>
<?php if ($resources_cta_text) : ?>
<a class="inline-block border-b-2 border-black pb-1 font-bold hover:text-neon-lime hover:border-neon-lime transition-colors" href="<?php echo $resources_cta_link; ?>"><?php echo $resources_cta_text; ?></a>
<?php endif; ?>
</div>
<div class="w-full md:w-2/3 grid grid-cols-2 md:grid-cols-4 gap-4">
</div></div></section></div></section>

<div class="h-10" id="section-a5"></div>

<?php get_footer(); ?>
