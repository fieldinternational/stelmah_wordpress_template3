<?php
/**
 * Stelmah テーマ functions
 */

// テーマサポート
function stelmah_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'primary' => 'メインナビゲーション',
    ));
}
add_action('after_setup_theme', 'stelmah_setup');

// スタイル・スクリプトの読み込み
function stelmah_enqueue_assets() {
    // Tailwind CSS CDN
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), null, false);

    // Font Awesome
    wp_enqueue_style('font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    wp_enqueue_script('font-awesome-js', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js', array(), '6.4.0', true);

    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Noto+Sans+JP:wght@300;400;500;700;900&family=Space+Mono:wght@400;700&display=swap', array(), null);

    // テーマCSS
    wp_enqueue_style('stelmah-style', get_stylesheet_uri(), array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'stelmah_enqueue_assets');

// ナビゲーションのフォールバック
function stelmah_fallback_menu() {
    ?>
    <nav class="hidden md:flex items-center gap-6 font-mono text-xs tracking-[0.35em] uppercase opacity-90">
        <a href="<?php echo home_url('/'); ?>" class="hover:text-neon-pink transition-colors">TOP</a>
        <a href="<?php echo home_url('/articles/'); ?>" class="hover:text-neon-pink transition-colors">ARTICLES</a>
        <a href="<?php echo home_url('/guide/'); ?>" class="hover:text-neon-pink transition-colors">GUIDE</a>
        <a href="<?php echo home_url('/about/'); ?>" class="hover:text-neon-pink transition-colors">ABOUT</a>
        <a href="<?php echo home_url('/privacy/'); ?>" class="hover:text-neon-pink transition-colors">PRIVACY</a>
        <a href="<?php echo home_url('/news/'); ?>" class="hover:text-neon-pink transition-colors">NEWS</a>
        <a href="<?php echo home_url('/contact/'); ?>" class="hover:text-neon-pink transition-colors">CONTACT</a>
    </nav>
    <?php
}

// wp_nav_menu用カスタムウォーカー（Tailwindクラス付与）
class Stelmah_Nav_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<a href="' . esc_url($item->url) . '" class="hover:text-neon-pink transition-colors">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {
        // no closing tag needed
    }
    function start_lvl(&$output, $depth = 0, $args = null) {
        // no sub-menu wrapper
    }
    function end_lvl(&$output, $depth = 0, $args = null) {
        // no sub-menu wrapper
    }
}

// ========================================
// カスタム投稿タイプ: ニュース
// ========================================
function stelmah_register_news_post_type() {
    register_post_type('news', array(
        'labels' => array(
            'name'               => 'ニュース',
            'singular_name'      => 'ニュース',
            'add_new'            => '新規追加',
            'add_new_item'       => 'ニュースを追加',
            'edit_item'          => 'ニュースを編集',
            'new_item'           => '新しいニュース',
            'view_item'          => 'ニュースを表示',
            'search_items'       => 'ニュースを検索',
            'not_found'          => 'ニュースが見つかりません',
            'not_found_in_trash' => 'ゴミ箱にニュースはありません',
            'menu_name'          => 'ニュース',
        ),
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => array('slug' => 'news'),
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon'    => 'dashicons-megaphone',
        'show_in_rest' => true,
    ));
}
add_action('init', 'stelmah_register_news_post_type');

// ニュース用タクソノミー
function stelmah_register_news_taxonomies() {
    // ニュースカテゴリ（階層あり）
    register_taxonomy('news_category', 'news', array(
        'labels' => array(
            'name'          => 'ニュースカテゴリ',
            'singular_name' => 'ニュースカテゴリ',
            'add_new_item'  => 'ニュースカテゴリを追加',
            'edit_item'     => 'ニュースカテゴリを編集',
            'search_items'  => 'ニュースカテゴリを検索',
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'news-category'),
    ));

    // ニュースタグ（階層なし）
    register_taxonomy('news_tag', 'news', array(
        'labels' => array(
            'name'          => 'ニュースタグ',
            'singular_name' => 'ニュースタグ',
            'add_new_item'  => 'ニュースタグを追加',
            'edit_item'     => 'ニュースタグを編集',
            'search_items'  => 'ニュースタグを検索',
        ),
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'news-tag'),
    ));
}
add_action('init', 'stelmah_register_news_taxonomies');

// ========================================
// カテゴリのサムネイル画像フィールド（ネイティブ実装）
// ========================================

// 管理画面でメディアアップローダーを読み込み
function stelmah_category_admin_scripts($hook) {
    if ($hook === 'edit-tags.php' || $hook === 'term.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'stelmah_category_admin_scripts');

// カテゴリ新規追加画面にフィールド追加
function stelmah_category_add_image_field() {
    ?>
    <div class="form-field">
        <label>カテゴリ画像</label>
        <input type="hidden" name="category_image" id="category_image" value="">
        <div id="category-image-preview" style="margin-bottom: 10px;"></div>
        <button type="button" class="button" id="category-image-upload">画像を選択</button>
        <button type="button" class="button" id="category-image-remove" style="display:none;">画像を削除</button>
        <p class="description">Service Highlightsセクションに表示されるカテゴリ画像です。</p>
    </div>
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#category-image-upload').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'カテゴリ画像を選択', button: { text: '画像を設定' }, multiple: false });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#category_image').val(attachment.id);
                $('#category-image-preview').html('<img src="' + attachment.url + '" style="max-width:200px;height:auto;">');
                $('#category-image-remove').show();
            });
            frame.open();
        });
        $('#category-image-remove').on('click', function(e) {
            e.preventDefault();
            $('#category_image').val('');
            $('#category-image-preview').html('');
            $(this).hide();
        });
        // 新規追加後のフォームリセット
        $(document).ajaxComplete(function(event, xhr, settings) {
            if (settings.data && settings.data.indexOf('action=add-tag') !== -1) {
                $('#category_image').val('');
                $('#category-image-preview').html('');
                $('#category-image-remove').hide();
            }
        });
    });
    </script>
    <?php
}
add_action('category_add_form_fields', 'stelmah_category_add_image_field');

// カテゴリ編集画面にフィールド追加
function stelmah_category_edit_image_field($term) {
    $image_id = get_term_meta($term->term_id, 'category_image', true);
    $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
    ?>
    <tr class="form-field">
        <th scope="row"><label>カテゴリ画像</label></th>
        <td>
            <input type="hidden" name="category_image" id="category_image" value="<?php echo esc_attr($image_id); ?>">
            <div id="category-image-preview" style="margin-bottom: 10px;">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width:200px;height:auto;">
                <?php endif; ?>
            </div>
            <button type="button" class="button" id="category-image-upload">画像を選択</button>
            <button type="button" class="button" id="category-image-remove" style="<?php echo $image_id ? '' : 'display:none;'; ?>">画像を削除</button>
            <p class="description">Service Highlightsセクションに表示されるカテゴリ画像です。</p>
        </td>
    </tr>
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#category-image-upload').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'カテゴリ画像を選択', button: { text: '画像を設定' }, multiple: false });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#category_image').val(attachment.id);
                $('#category-image-preview').html('<img src="' + attachment.url + '" style="max-width:200px;height:auto;">');
                $('#category-image-remove').show();
            });
            frame.open();
        });
        $('#category-image-remove').on('click', function(e) {
            e.preventDefault();
            $('#category_image').val('');
            $('#category-image-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}
add_action('category_edit_form_fields', 'stelmah_category_edit_image_field');

// カテゴリ画像の保存
function stelmah_save_category_image($term_id) {
    if (isset($_POST['category_image'])) {
        update_term_meta($term_id, 'category_image', absint($_POST['category_image']));
    }
}
add_action('created_category', 'stelmah_save_category_image');
add_action('edited_category', 'stelmah_save_category_image');

// ========================================
// アーカイブの表示件数設定
// ========================================
function stelmah_pre_get_posts($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    // ニュースアーカイブ: 6件表示
    if ($query->is_post_type_archive('news') || $query->is_tax('news_category') || $query->is_tax('news_tag')) {
        $query->set('posts_per_page', 6);
    }

    // デフォルト投稿アーカイブ: 15件表示
    if ($query->is_home() || $query->is_category() || $query->is_tag()) {
        $query->set('posts_per_page', 15);
    }

    // カスタム記事フィルタ: /articles/cat_X, /articles/tag_X, /articles/cat_X-tag_X
    $articles_cat = intval(get_query_var('articles_cat'));
    $articles_tag = intval(get_query_var('articles_tag'));
    if ($articles_cat || $articles_tag) {
        $query->set('post_type', 'post');
        $query->set('posts_per_page', 15);
        if ($articles_cat) {
            $query->set('cat', $articles_cat);
        }
        if ($articles_tag) {
            $query->set('tag_id', $articles_tag);
        }
        $query->is_archive = true;
        $query->is_home    = false;
        $query->is_404     = false;
    }

    // ベースURL: /articles/（フィルタなし全投稿一覧）
    if (get_query_var('stelmah_articles_base')) {
        $query->set('post_type', 'post');
        $query->set('posts_per_page', 15);
        $query->is_archive = true;
        $query->is_home    = false;
        $query->is_404     = false;
    }
}
add_action('pre_get_posts', 'stelmah_pre_get_posts');

// ========================================
// 記事フィルタリングシステム（クリーンURL）
// ========================================

// クエリ変数登録
function stelmah_articles_query_vars($vars) {
    $vars[] = 'articles_cat';
    $vars[] = 'articles_tag';
    $vars[] = 'stelmah_articles_base';
    return $vars;
}
add_filter('query_vars', 'stelmah_articles_query_vars');

// リライトルール登録
function stelmah_articles_rewrite_rules() {
    // カテゴリ+タグ（ページ付き）
    add_rewrite_rule(
        'articles/cat_(\d+)-tag_(\d+)/page/(\d+)/?$',
        'index.php?articles_cat=$matches[1]&articles_tag=$matches[2]&paged=$matches[3]',
        'top'
    );
    // カテゴリ+タグ
    add_rewrite_rule(
        'articles/cat_(\d+)-tag_(\d+)/?$',
        'index.php?articles_cat=$matches[1]&articles_tag=$matches[2]',
        'top'
    );
    // カテゴリのみ（ページ付き）
    add_rewrite_rule(
        'articles/cat_(\d+)/page/(\d+)/?$',
        'index.php?articles_cat=$matches[1]&paged=$matches[2]',
        'top'
    );
    // カテゴリのみ
    add_rewrite_rule(
        'articles/cat_(\d+)/?$',
        'index.php?articles_cat=$matches[1]',
        'top'
    );
    // タグのみ（ページ付き）
    add_rewrite_rule(
        'articles/tag_(\d+)/page/(\d+)/?$',
        'index.php?articles_tag=$matches[1]&paged=$matches[2]',
        'top'
    );
    // タグのみ
    add_rewrite_rule(
        'articles/tag_(\d+)/?$',
        'index.php?articles_tag=$matches[1]',
        'top'
    );
    // ベースURL（ページ付き）
    add_rewrite_rule(
        'articles/page/(\d+)/?$',
        'index.php?stelmah_articles_base=1&paged=$matches[1]',
        'top'
    );
    // ベースURL
    add_rewrite_rule(
        'articles/?$',
        'index.php?stelmah_articles_base=1',
        'top'
    );
}
add_action('init', 'stelmah_articles_rewrite_rules');

// ヘルパー: クリーンURL生成
function stelmah_articles_url($cat_id = 0, $tag_id = 0) {
    $cat_id = intval($cat_id);
    $tag_id = intval($tag_id);
    $base   = home_url('/articles/');

    if ($cat_id && $tag_id) {
        return $base . 'cat_' . $cat_id . '-tag_' . $tag_id . '/';
    } elseif ($cat_id) {
        return $base . 'cat_' . $cat_id . '/';
    } elseif ($tag_id) {
        return $base . 'tag_' . $tag_id . '/';
    }
    return $base;
}

// ヘルパー: 現在のフィルタ状態取得（カスタムURL + WPネイティブ両対応）
function stelmah_get_current_articles_filter() {
    $cat_id = intval(get_query_var('articles_cat'));
    $tag_id = intval(get_query_var('articles_tag'));

    // WPネイティブアーカイブからもフォールバック
    if (!$cat_id && is_category()) {
        $cat_id = get_queried_object_id();
    }
    if (!$tag_id && is_tag()) {
        $tag_id = get_queried_object_id();
    }

    return array('cat_id' => $cat_id, 'tag_id' => $tag_id);
}

// ヘルパー: カスタムフィルタページ判定
function stelmah_is_articles_filter() {
    return intval(get_query_var('articles_cat')) > 0 || intval(get_query_var('articles_tag')) > 0;
}

// テンプレート読み込み: カスタムURL時に archive.php を使用
function stelmah_articles_template_include($template) {
    if (stelmah_is_articles_filter() || get_query_var('stelmah_articles_base')) {
        $archive_template = locate_template('archive.php');
        if ($archive_template) {
            return $archive_template;
        }
    }
    return $template;
}
add_filter('template_include', 'stelmah_articles_template_include');

// ドキュメントタイトル: カスタムURL時のタイトル生成
function stelmah_articles_document_title($title) {
    if (!stelmah_is_articles_filter()) {
        return $title;
    }

    $filter  = stelmah_get_current_articles_filter();
    $parts   = array();

    if ($filter['cat_id']) {
        $cat = get_category($filter['cat_id']);
        if ($cat && !is_wp_error($cat)) {
            $parts[] = $cat->name;
        }
    }
    if ($filter['tag_id']) {
        $tag = get_tag($filter['tag_id']);
        if ($tag && !is_wp_error($tag)) {
            $parts[] = '#' . $tag->name;
        }
    }

    if (!empty($parts)) {
        $title['title'] = implode(' × ', $parts) . ' の記事一覧';
    }

    return $title;
}
add_filter('document_title_parts', 'stelmah_articles_document_title');

// ページネーション: カスタムURL対応
function stelmah_articles_pagination() {
    if (stelmah_is_articles_filter()) {
        $filter  = stelmah_get_current_articles_filter();
        $base_url = stelmah_articles_url($filter['cat_id'], $filter['tag_id']);

        echo paginate_links(array(
            'base'      => trailingslashit($base_url) . 'page/%#%/',
            'format'    => '',
            'current'   => max(1, get_query_var('paged')),
            'total'     => $GLOBALS['wp_query']->max_num_pages,
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left text-xs"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right text-xs"></i>',
        ));
    } else {
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left text-xs"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right text-xs"></i>',
        ));
    }
}

// テーマ切り替え時にリライトルールをフラッシュ
function stelmah_flush_rewrite_rules() {
    stelmah_articles_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'stelmah_flush_rewrite_rules');

// ========================================
// Aboutページ用カスタムフィールド
// ========================================

function stelmah_about_defaults() {
    return array(
        'overview' => array(
            array('label' => '運営形態', 'value' => '個人メディア（ONLINE / 全国対応）'),
            array('label' => 'コンテンツ', 'value' => 'テンプレート配布 / サービス比較 / 入稿ガイド'),
            array('label' => '対象ユーザー', 'value' => '同人クリエイター / ハンドメイド作家 / 小規模ショップ'),
            array('label' => 'お問い合わせ', 'value' => 'メールフォームにて受付中'),
        ),
        'values_intro' => 'アクリルグッズ制作サービスは数多くありますが、「どこに頼めばいいのか」「入稿データはどう作るのか」といった情報は意外とまとまっていません。ACRY LABOは、そうした情報の"わかりにくさ"を解消する紹介メディアとして、3つの軸で情報を届けています。',
        'values' => array(
            array('title' => 'わかりやすく比較する', 'description' => '各制作サービスの価格・納期・最低ロット・対応商品などを同じ基準で整理し、比較しやすい形で紹介しています。サービス選びに必要な情報を一箇所にまとめることで、自分に合ったサービスが見つけやすくなります。'),
            array('title' => '入稿の不安を解消する', 'description' => '解像度・カラーモード・塗り足し・白版など、入稿データ作成でつまずきやすいポイントをガイド記事で紹介。各サービスの入稿ルールの違いも整理し、初めての方でもスムーズに入稿できるよう情報を発信しています。'),
            array('title' => '中立な情報を届ける', 'description' => 'ACRY LABOはグッズ制作の受注は行っていません。特定のサービスに偏らない第三者の立場から、実際の利用経験やユーザーの声をもとにした情報を掲載しています。'),
        ),
        'faq' => array(
            array('question' => 'ACRY LABOはグッズ制作サービスですか？', 'answer' => 'いいえ。ACRY LABOはアクリルグッズ制作サービスを比較・紹介する情報メディアです。グッズの制作・販売は行っておらず、各サービスの特徴や入稿方法などの情報をまとめて発信しています。'),
            array('question' => 'どんなグッズの情報を扱っていますか？', 'answer' => 'アクリルキーホルダー、アクリルスタンド、ネームプレート、コースターなど、主要なアクリルグッズの制作サービス情報を掲載しています。取り扱いジャンルは順次拡大中です。'),
            array('question' => '掲載サービスの選定基準はありますか？', 'answer' => '実際の利用経験をもとに、価格・品質・納期・サポート体制などを総合的に評価しています。広告掲載料ではなく、ユーザーにとっての有用性を基準に選定しています。'),
            array('question' => 'サイトの利用に料金はかかりますか？', 'answer' => '記事の閲覧・すべてのコンテンツを無料でご利用いただけます。会員登録も不要です。'),
        ),
    );
}

function stelmah_about_add_meta_box() {
    add_meta_box(
        'stelmah_about_settings',
        'Aboutページ設定',
        'stelmah_about_meta_box_render',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'stelmah_about_add_meta_box');

function stelmah_about_meta_box_render($post) {
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-about.php') {
        echo '<p style="color:#666;">このメタボックスは「About」テンプレートが選択されたページでのみ使用されます。</p>';
        return;
    }

    wp_nonce_field('stelmah_about_save', 'stelmah_about_nonce');

    $defaults = stelmah_about_defaults();
    $overview = get_post_meta($post->ID, '_stelmah_about_overview', true);
    $values_intro = get_post_meta($post->ID, '_stelmah_about_values_intro', true);
    $values = get_post_meta($post->ID, '_stelmah_about_values', true);
    $faq = get_post_meta($post->ID, '_stelmah_about_faq', true);

    if (empty($overview)) $overview = $defaults['overview'];
    if (empty($values_intro)) $values_intro = $defaults['values_intro'];
    if (empty($values)) $values = $defaults['values'];
    if (empty($faq)) $faq = $defaults['faq'];
    ?>

    <h3>概要（AT A GLANCE）</h3>
    <table class="widefat striped">
        <thead><tr><th style="width:30%">ラベル</th><th>値</th></tr></thead>
        <tbody>
        <?php for ($i = 0; $i < 4; $i++) : ?>
            <tr>
                <td><input type="text" name="stelmah_overview[<?php echo $i; ?>][label]" value="<?php echo esc_attr($overview[$i]['label'] ?? ''); ?>" class="widefat"></td>
                <td><input type="text" name="stelmah_overview[<?php echo $i; ?>][value]" value="<?php echo esc_attr($overview[$i]['value'] ?? ''); ?>" class="widefat"></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <h3 style="margin-top:20px;">大切にしていること（OUR VALUES）</h3>
    <p><label><strong>セクション説明文</strong></label></p>
    <textarea name="stelmah_values_intro" rows="3" class="widefat"><?php echo esc_textarea($values_intro); ?></textarea>
    <table class="widefat striped" style="margin-top:10px;">
        <thead><tr><th style="width:25%">タイトル</th><th>説明</th></tr></thead>
        <tbody>
        <?php for ($i = 0; $i < 3; $i++) : ?>
            <tr>
                <td><input type="text" name="stelmah_values[<?php echo $i; ?>][title]" value="<?php echo esc_attr($values[$i]['title'] ?? ''); ?>" class="widefat"></td>
                <td><textarea name="stelmah_values[<?php echo $i; ?>][description]" rows="2" class="widefat"><?php echo esc_textarea($values[$i]['description'] ?? ''); ?></textarea></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <h3 style="margin-top:20px;">よくあるご質問（FAQ）</h3>
    <table class="widefat striped">
        <thead><tr><th style="width:30%">質問</th><th>回答</th></tr></thead>
        <tbody>
        <?php for ($i = 0; $i < 4; $i++) : ?>
            <tr>
                <td><input type="text" name="stelmah_faq[<?php echo $i; ?>][question]" value="<?php echo esc_attr($faq[$i]['question'] ?? ''); ?>" class="widefat"></td>
                <td><textarea name="stelmah_faq[<?php echo $i; ?>][answer]" rows="2" class="widefat"><?php echo esc_textarea($faq[$i]['answer'] ?? ''); ?></textarea></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
    <?php
}

function stelmah_about_save_meta($post_id) {
    if (!isset($_POST['stelmah_about_nonce']) || !wp_verify_nonce($_POST['stelmah_about_nonce'], 'stelmah_about_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_page', $post_id)) return;

    if (isset($_POST['stelmah_overview'])) {
        $overview = array_map(function($item) {
            return array(
                'label' => sanitize_text_field($item['label'] ?? ''),
                'value' => sanitize_text_field($item['value'] ?? ''),
            );
        }, $_POST['stelmah_overview']);
        update_post_meta($post_id, '_stelmah_about_overview', $overview);
    }

    if (isset($_POST['stelmah_values_intro'])) {
        update_post_meta($post_id, '_stelmah_about_values_intro', sanitize_textarea_field($_POST['stelmah_values_intro']));
    }

    if (isset($_POST['stelmah_values'])) {
        $values = array_map(function($item) {
            return array(
                'title' => sanitize_text_field($item['title'] ?? ''),
                'description' => sanitize_textarea_field($item['description'] ?? ''),
            );
        }, $_POST['stelmah_values']);
        update_post_meta($post_id, '_stelmah_about_values', $values);
    }

    if (isset($_POST['stelmah_faq'])) {
        $faq = array_map(function($item) {
            return array(
                'question' => sanitize_text_field($item['question'] ?? ''),
                'answer' => sanitize_textarea_field($item['answer'] ?? ''),
            );
        }, $_POST['stelmah_faq']);
        update_post_meta($post_id, '_stelmah_about_faq', $faq);
    }
}
add_action('save_post_page', 'stelmah_about_save_meta');

// ========================================
// ACF Setting（固定ページ方式）
// ========================================

// ヘルパー: 設定用固定ページIDを取得（staticキャッシュ付き）
function stelmah_get_settings_page_id() {
    static $id = null;
    if ($id !== null) {
        return $id;
    }
    $page = get_page_by_path('stelmah-settings');
    $id = $page ? (int) $page->ID : 0;
    return $id;
}

// ヘルパー: ACFオプション取得（デフォルト値付き）
function stelmah_get_option($field, $default = '') {
    if (function_exists('get_field')) {
        $settings_id = stelmah_get_settings_page_id();
        if ($settings_id) {
            $value = get_field($field, $settings_id);
            if ($value !== null && $value !== '' && $value !== false) {
                return $value;
            }
        }
    }
    return $default;
}

// ヘルパー: 番号付きGroupフィールドをリピーター互換配列で取得
function stelmah_get_option_repeater($field, $defaults = array()) {
    if (!function_exists('get_field')) {
        return $defaults;
    }
    $settings_id = stelmah_get_settings_page_id();
    if (!$settings_id) {
        return $defaults;
    }

    // フィールドマッピング: 旧リピーター名 → 番号付きフィールドの設定
    static $config = array(
        'concept_features'  => array('prefix' => 'concept_feature',  'max' => 4, 'sub_fields' => array('icon_class', 'title', 'description')),
        'tools_items'       => array('prefix' => 'tools_item',       'max' => 8, 'sub_fields' => array('icon_class', 'title', 'description')),
        'workflow_features' => array('prefix' => 'workflow_feature',  'max' => 6, 'sub_fields' => array('icon_class', 'title', 'description')),
        'where_list'        => array('prefix' => 'where_list_item',  'max' => 6, 'type' => 'text'),
        'services_items'        => array('prefix' => 'services_item',        'max' => 6, 'sub_fields' => array('label', 'title', 'description', 'image', 'link')),
        'archive_slider_images' => array('prefix' => 'archive_slider_image', 'max' => 6, 'type' => 'image'),
    );

    if (!isset($config[$field])) {
        return $defaults;
    }

    $cfg   = $config[$field];
    $items = array();

    for ($i = 1; $i <= $cfg['max']; $i++) {
        $name = $cfg['prefix'] . '_' . $i;

        if (isset($cfg['type']) && $cfg['type'] === 'image') {
            // 画像フィールド → array('url' => $value) でラップ
            $value = get_field($name, $settings_id);
            if (!empty($value)) {
                $items[] = array('url' => $value);
            }
        } elseif (isset($cfg['type']) && $cfg['type'] === 'text') {
            // テキストフィールド → array('text' => $value) でラップ
            $value = get_field($name, $settings_id);
            if (!empty($value)) {
                $items[] = array('text' => $value);
            }
        } else {
            // Groupフィールド → サブフィールドの値を収集
            $group = get_field($name, $settings_id);
            if (!empty($group) && is_array($group)) {
                $has_value = false;
                foreach ($cfg['sub_fields'] as $sub) {
                    if (!empty($group[$sub])) {
                        $has_value = true;
                        break;
                    }
                }
                if ($has_value) {
                    $items[] = $group;
                }
            }
        }
    }

    return !empty($items) ? $items : $defaults;
}

// テーマ有効化時に設定用固定ページを自動作成
function stelmah_create_settings_page() {
    if (get_page_by_path('stelmah-settings')) {
        return;
    }
    wp_insert_post(array(
        'post_title'    => 'サイト設定',
        'post_name'     => 'stelmah-settings',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'page_template' => 'page-settings.php',
        'post_content'  => '',
    ));
}
add_action('after_switch_theme', 'stelmah_create_settings_page');

// 初回アクセス時にも設定ページが存在しなければ作成（テーマ切替なしの場合のフォールバック）
function stelmah_ensure_settings_page() {
    if (!is_admin()) {
        return;
    }
    if (get_page_by_path('stelmah-settings')) {
        return;
    }
    stelmah_create_settings_page();
}
add_action('admin_init', 'stelmah_ensure_settings_page');

// 管理メニューに設定ページへのショートカットを追加
function stelmah_admin_settings_menu() {
    $page_id = stelmah_get_settings_page_id();
    if (!$page_id) {
        return;
    }
    add_menu_page(
        'サイト設定',
        'Setting',
        'edit_posts',
        'post.php?post=' . $page_id . '&action=edit',
        '',
        'dashicons-admin-generic',
        2
    );
}
add_action('admin_menu', 'stelmah_admin_settings_menu');

// トップページのデフォルト値
function stelmah_frontpage_defaults() {
    return array(
        // CONCEPT
        'concept_label'         => 'CONCEPT',
        'concept_heading'       => "テンプレートで始める、\nアクリルグッズ制作。",
        'concept_text'          => 'ACRY LABOは、アクリルグッズ制作サービスを比較・紹介するメディアサイトです。サービス比較、最新情報、入稿ノウハウ記事を通じて、初心者でも最適なサービスを見つけられるようサポートします。',
        'concept_image'         => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/b7dd9769ea-10a21384b6281b66ef5e.png',
        'concept_readmore_text' => 'READ MORE ABOUT US',
        'concept_features' => array(
            array('icon_class' => 'fa-regular fa-file-lines text-yellow-500', 'title' => 'Templates', 'description' => '各サービスの特徴を比較できる'),
            array('icon_class' => 'fa-solid fa-headset text-gray-700',        'title' => 'Support',   'description' => '入稿ノウハウ＆お役立ち記事が充実'),
        ),
        // Service Highlights
        'highlights_heading' => 'Service Highlights',
        'highlights_subtext' => 'アクリルグッズ制作に役立つ情報をお届け',
        // Tools & Support
        'tools_heading'  => 'Tools & Support',
        'tools_subtext'  => 'アクリルグッズ制作に役立つコンテンツ',
        'tools_cta_text' => 'DOWNLOAD PDF GUIDE',
        'tools_items' => array(
            array('icon_class' => 'fa-solid fa-file-lines', 'title' => 'Free Templates',   'description' => '各サービスが提供するテンプレート情報をまとめています。'),
            array('icon_class' => 'fa-solid fa-list-check', 'title' => '入稿チェックツール', 'description' => '入稿データのセルフチェックリスト。解像度・カラーモード・塗り足しを確認できます。'),
            array('icon_class' => 'fa-solid fa-book-open',  'title' => 'チュートリアル',     'description' => 'Illustrator・Photoshopの操作方法を、初心者向けにステップバイステップで解説。'),
            array('icon_class' => 'fa-solid fa-headset',    'title' => 'まとめ記事',         'description' => '目的別・予算別のサービスまとめ記事を掲載。はじめてのアクリルグッズ制作でも迷わず選べます。'),
        ),
        // Design & Submission Guide
        'workflow_heading'    => "Design &\nSubmission Guide",
        'workflow_cta_text'   => 'サポート記事を見る',
        'workflow_image_main' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/5e8e5dfe9b-6690f30807ef072f5fca.png',
        'workflow_image_sub'  => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/085b63dae8-bd1867293ba3d133f7d9.png',
        'workflow_features' => array(
            array('icon_class' => 'fa-solid fa-pen-ruler',    'title' => 'デザインの基本を学ぶ',     'description' => 'アクリルグッズに適した解像度・カラーモード・レイアウトの基礎知識を記事で解説。はじめての方でも安心です。'),
            array('icon_class' => 'fa-solid fa-file-circle-check', 'title' => '入稿データの作り方を知る', 'description' => '塗り足し・トンボ・白版など、入稿時につまずきやすいポイントをわかりやすくガイドしています。'),
            array('icon_class' => 'fa-solid fa-magnifying-glass-chart', 'title' => 'サービス選びに役立つ比較情報', 'description' => '主要なアクリルグッズ制作サービスの価格・納期・対応商品を比較。あなたの目的に合ったサービスを見つけられます。'),
        ),
        // Where Design Meets
        'where_heading_line1' => 'Where Design',
        'where_heading_line2' => 'Meets Acrylic',
        'where_text'          => 'ACRY LABOは単なる情報サイトではありません。サービス比較・最新情報・入稿ノウハウを通じて、あなたに最適なアクリルグッズ制作サービスを見つけるためのメディアです。同人グッズ、ノベルティ、販促品など、あらゆるシーンに対応します。',
        'where_image_1'       => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/4ff90d1e20-945eacf3a5c9acb03557.png',
        'where_image_2'       => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/6d2955d892-c22e942ac05fea6c8f75.png',
        'where_list' => array(
            array('text' => '入稿ノウハウ＆比較記事'),
            array('text' => '最新サービス情報を毎週更新'),
        ),
        // FEATURED CONTENTS
        'services_heading'    => 'FEATURED CONTENTS',
        'services_subheading' => 'Pick up articles',
        'services_items' => array(
            array('label' => 'COMPARE', 'title' => 'サービス徹底比較',       'description' => '主要サービスの料金・納期・品質を横断比較', 'image' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/f3c52d697e-53b635c3cdce1c97997c.png', 'link' => ''),
            array('label' => 'HOW TO',  'title' => '入稿データの作り方ガイド', 'description' => '塗り足し・白版・カラーモードをやさしく解説', 'image' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/d8a04b60ec-4c78cf0e68585811a782.png', 'link' => ''),
            array('label' => 'PICKUP',  'title' => '目的別おすすめまとめ',     'description' => '同人・ノベルティ・販促など用途別に紹介',   'image' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/ee546a8f2c-d32483130474bc56237e.png', 'link' => ''),
        ),
        // USEFUL LINKS & TOOLS
        'resources_heading'  => "USEFUL\nLINKS &\nTOOLS",
        'resources_text'     => '各アクリルグッズ制作サービスが公開しているテンプレートや入稿ガイドへのリンクをまとめています。外部サイトの公式情報に直接アクセスできます。',
        'resources_cta_text' => 'まとめ記事を見る ->',
    );
}

// ACFフィールドグループ登録（ACF Free互換 — リピーター→番号付きGroup）
function stelmah_acf_register_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $d = stelmah_frontpage_defaults();
    $fields = array();

    // ===== Tab: サイト基本設定 =====
    $fields[] = array('key' => 'field_stelmah_tab_site', 'label' => 'サイト基本設定', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_site_name',     'label' => 'サイト名',     'name' => 'site_name',     'type' => 'text', 'default_value' => 'ACRY LABO', 'instructions' => 'ヘッダーに表示されるサイト名');
    $fields[] = array('key' => 'field_stelmah_site_subtitle',  'label' => 'サブタイトル', 'name' => 'site_subtitle', 'type' => 'text', 'default_value' => 'ACRYLIC GOODS MEDIA');
    $fields[] = array('key' => 'field_stelmah_site_logo',      'label' => 'ロゴ画像',     'name' => 'site_logo',     'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium', 'instructions' => '設定するとテキストロゴの代わりに画像が表示されます');
    $fields[] = array('key' => 'field_stelmah_ogp_image',      'label' => 'OGP画像',      'name' => 'ogp_image',     'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium', 'instructions' => 'SNSシェア時に表示される画像');

    // ===== Tab: デザイン設定 =====
    $fields[] = array('key' => 'field_stelmah_tab_design', 'label' => 'デザイン設定', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_accent_color',    'label' => 'アクセントカラー', 'name' => 'accent_color',    'type' => 'color_picker', 'default_value' => '#FF00FF');
    $fields[] = array('key' => 'field_stelmah_bg_color',        'label' => '背景色',           'name' => 'bg_color',        'type' => 'color_picker', 'default_value' => '#111111');
    $fields[] = array('key' => 'field_stelmah_card_bg_color',   'label' => 'カード背景色',     'name' => 'card_bg_color',   'type' => 'color_picker', 'default_value' => '#1a1a1a');
    $fields[] = array('key' => 'field_stelmah_grid_line_color', 'label' => 'グリッド線色',     'name' => 'grid_line_color', 'type' => 'color_picker', 'default_value' => '#2a2a2a');

    // ===== Tab: 連絡先情報 =====
    $fields[] = array('key' => 'field_stelmah_tab_contact', 'label' => '連絡先情報', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_company_name',    'label' => '会社名 / 運営者名', 'name' => 'company_name',    'type' => 'text',  'default_value' => 'ACRY LABO');
    $fields[] = array('key' => 'field_stelmah_company_address', 'label' => '住所',              'name' => 'company_address', 'type' => 'text',  'default_value' => '〒107-0062 東京都港区南青山5-10-1');
    $fields[] = array('key' => 'field_stelmah_company_email',   'label' => 'メールアドレス',    'name' => 'company_email',   'type' => 'email', 'default_value' => 'info@acrylabo.jp');
    $fields[] = array('key' => 'field_stelmah_company_phone',   'label' => '電話番号',          'name' => 'company_phone',   'type' => 'text',  'instructions' => '空欄の場合は非表示');

    // ===== Tab: SNSリンク =====
    $fields[] = array('key' => 'field_stelmah_tab_sns', 'label' => 'SNSリンク', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_sns_twitter',   'label' => 'Twitter / X', 'name' => 'sns_twitter',   'type' => 'url', 'instructions' => '空欄の場合は非表示');
    $fields[] = array('key' => 'field_stelmah_sns_instagram', 'label' => 'Instagram',   'name' => 'sns_instagram', 'type' => 'url');
    $fields[] = array('key' => 'field_stelmah_sns_facebook',  'label' => 'Facebook',    'name' => 'sns_facebook',  'type' => 'url');
    $fields[] = array('key' => 'field_stelmah_sns_youtube',   'label' => 'YouTube',     'name' => 'sns_youtube',   'type' => 'url');
    $fields[] = array('key' => 'field_stelmah_sns_line',      'label' => 'LINE',        'name' => 'sns_line',      'type' => 'url');

    // ===== Tab: ヘッダー設定 =====
    $fields[] = array('key' => 'field_stelmah_tab_header', 'label' => 'ヘッダー設定', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_header_cta_text', 'label' => 'CTAボタン テキスト', 'name' => 'header_cta_text', 'type' => 'text', 'default_value' => 'お問い合わせ');
    $fields[] = array('key' => 'field_stelmah_header_cta_link', 'label' => 'CTAボタン リンク',   'name' => 'header_cta_link', 'type' => 'text', 'default_value' => '#contact', 'instructions' => 'URLまたはアンカー（例: #contact）');
    $fields[] = array('key' => 'field_stelmah_header_cta_show', 'label' => 'CTAボタンを表示',    'name' => 'header_cta_show', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1);

    // ===== Tab: フッター設定 =====
    $fields[] = array('key' => 'field_stelmah_tab_footer', 'label' => 'フッター設定', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_footer_label',   'label' => 'セクションラベル',     'name' => 'footer_label',   'type' => 'text', 'default_value' => 'ABOUT US');
    $fields[] = array('key' => 'field_stelmah_footer_title',   'label' => 'セクションタイトル',   'name' => 'footer_title',   'type' => 'text', 'default_value' => '運営情報');
    $fields[] = array('key' => 'field_stelmah_copyright_text', 'label' => 'コピーライト',         'name' => 'copyright_text', 'type' => 'text', 'default_value' => '© 2026 ACRY LABO All Rights Reserved.', 'instructions' => '空欄の場合は非表示');

    // ===== Tab: トップ - CONCEPT =====
    $fields[] = array('key' => 'field_stelmah_tab_concept', 'label' => 'トップ - CONCEPT', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_concept_label',   'label' => 'ラベル', 'name' => 'concept_label',   'type' => 'text',     'default_value' => $d['concept_label']);
    $fields[] = array('key' => 'field_stelmah_concept_heading', 'label' => '見出し', 'name' => 'concept_heading', 'type' => 'textarea', 'rows' => 2, 'default_value' => $d['concept_heading'], 'instructions' => '改行は<br>に変換されます');
    $fields[] = array('key' => 'field_stelmah_concept_text',    'label' => '本文',   'name' => 'concept_text',    'type' => 'textarea', 'rows' => 4, 'default_value' => $d['concept_text']);
    $fields[] = array('key' => 'field_stelmah_concept_image',   'label' => '画像',   'name' => 'concept_image',   'type' => 'image',    'return_format' => 'url', 'preview_size' => 'medium');

    // concept_features: 番号付きGroupフィールド（旧リピーター max 4）
    for ($i = 1; $i <= 4; $i++) {
        $fields[] = array(
            'key'        => 'field_stelmah_concept_feature_' . $i,
            'label'      => '特徴 ' . $i,
            'name'       => 'concept_feature_' . $i,
            'type'       => 'group',
            'layout'     => 'block',
            'sub_fields' => array(
                array('key' => 'field_stelmah_cf' . $i . '_icon',  'label' => 'アイコン（FAクラス）', 'name' => 'icon_class',  'type' => 'text', 'instructions' => '例: fa-regular fa-file-lines text-yellow-500'),
                array('key' => 'field_stelmah_cf' . $i . '_title', 'label' => 'タイトル',            'name' => 'title',       'type' => 'text'),
                array('key' => 'field_stelmah_cf' . $i . '_desc',  'label' => '説明',                'name' => 'description', 'type' => 'text'),
            ),
        );
    }

    $fields[] = array('key' => 'field_stelmah_concept_readmore_text', 'label' => 'READ MORE テキスト', 'name' => 'concept_readmore_text', 'type' => 'text', 'default_value' => $d['concept_readmore_text']);
    $fields[] = array('key' => 'field_stelmah_concept_readmore_link', 'label' => 'READ MORE リンク',   'name' => 'concept_readmore_link', 'type' => 'url');

    // ===== Tab: トップ - Service Highlights =====
    $fields[] = array('key' => 'field_stelmah_tab_highlights', 'label' => 'トップ - Highlights', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_msg_highlights',     'label' => '', 'type' => 'message', 'message' => '項目はWordPressのカテゴリから自動取得されます。カテゴリ画像は各カテゴリの編集画面で設定してください。');
    $fields[] = array('key' => 'field_stelmah_highlights_heading', 'label' => '見出し',       'name' => 'highlights_heading', 'type' => 'text',   'default_value' => $d['highlights_heading']);
    $fields[] = array('key' => 'field_stelmah_highlights_subtext', 'label' => 'サブテキスト', 'name' => 'highlights_subtext', 'type' => 'text',   'default_value' => $d['highlights_subtext']);
    $fields[] = array('key' => 'field_stelmah_highlights_count',   'label' => '表示件数',     'name' => 'highlights_count',   'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 6);

    // ===== Tab: トップ - Tools & Support =====
    $fields[] = array('key' => 'field_stelmah_tab_tools', 'label' => 'トップ - Tools', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_tools_heading',  'label' => '見出し',       'name' => 'tools_heading',  'type' => 'text', 'default_value' => $d['tools_heading']);
    $fields[] = array('key' => 'field_stelmah_tools_subtext',  'label' => 'サブテキスト', 'name' => 'tools_subtext',  'type' => 'text', 'default_value' => $d['tools_subtext']);
    $fields[] = array('key' => 'field_stelmah_tools_cta_text', 'label' => 'CTAテキスト',  'name' => 'tools_cta_text', 'type' => 'text', 'default_value' => $d['tools_cta_text']);
    $fields[] = array('key' => 'field_stelmah_tools_cta_link', 'label' => 'CTAリンク',    'name' => 'tools_cta_link', 'type' => 'url');

    // tools_items: 番号付きGroupフィールド（旧リピーター max 8）
    for ($i = 1; $i <= 8; $i++) {
        $fields[] = array(
            'key'        => 'field_stelmah_tools_item_' . $i,
            'label'      => 'ツール項目 ' . $i,
            'name'       => 'tools_item_' . $i,
            'type'       => 'group',
            'layout'     => 'block',
            'sub_fields' => array(
                array('key' => 'field_stelmah_ti' . $i . '_icon',  'label' => 'アイコン（FAクラス）', 'name' => 'icon_class',  'type' => 'text'),
                array('key' => 'field_stelmah_ti' . $i . '_title', 'label' => 'タイトル',            'name' => 'title',       'type' => 'text'),
                array('key' => 'field_stelmah_ti' . $i . '_desc',  'label' => '説明',                'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            ),
        );
    }

    // ===== Tab: トップ - Design & Submission Guide =====
    $fields[] = array('key' => 'field_stelmah_tab_workflow', 'label' => 'トップ - 入稿ガイド', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_workflow_heading', 'label' => '見出し', 'name' => 'workflow_heading', 'type' => 'textarea', 'rows' => 2, 'default_value' => $d['workflow_heading'], 'instructions' => '改行は<br>に変換されます');

    // workflow_features: 番号付きGroupフィールド（旧リピーター max 6）
    for ($i = 1; $i <= 6; $i++) {
        $fields[] = array(
            'key'        => 'field_stelmah_workflow_feature_' . $i,
            'label'      => 'ワークフロー特徴 ' . $i,
            'name'       => 'workflow_feature_' . $i,
            'type'       => 'group',
            'layout'     => 'block',
            'sub_fields' => array(
                array('key' => 'field_stelmah_wf' . $i . '_icon',  'label' => 'アイコン（FAクラス）', 'name' => 'icon_class',  'type' => 'text'),
                array('key' => 'field_stelmah_wf' . $i . '_title', 'label' => 'タイトル',            'name' => 'title',       'type' => 'text'),
                array('key' => 'field_stelmah_wf' . $i . '_desc',  'label' => '説明',                'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            ),
        );
    }

    $fields[] = array('key' => 'field_stelmah_workflow_cta_text',   'label' => 'CTAテキスト', 'name' => 'workflow_cta_text',   'type' => 'text',  'default_value' => $d['workflow_cta_text']);
    $fields[] = array('key' => 'field_stelmah_workflow_cta_link',   'label' => 'CTAリンク',   'name' => 'workflow_cta_link',   'type' => 'url');
    $fields[] = array('key' => 'field_stelmah_workflow_image_main', 'label' => 'メイン画像',  'name' => 'workflow_image_main', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium');
    $fields[] = array('key' => 'field_stelmah_workflow_image_sub',  'label' => 'サブ画像',    'name' => 'workflow_image_sub',  'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium');

    // ===== Tab: トップ - Where Design Meets =====
    $fields[] = array('key' => 'field_stelmah_tab_where', 'label' => 'トップ - Where Design', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_where_heading_line1', 'label' => '見出し 1行目',               'name' => 'where_heading_line1', 'type' => 'text',     'default_value' => $d['where_heading_line1']);
    $fields[] = array('key' => 'field_stelmah_where_heading_line2', 'label' => '見出し 2行目（アクセントカラー）', 'name' => 'where_heading_line2', 'type' => 'text', 'default_value' => $d['where_heading_line2']);
    $fields[] = array('key' => 'field_stelmah_where_text',          'label' => '説明文',                     'name' => 'where_text',          'type' => 'textarea', 'rows' => 4, 'default_value' => $d['where_text']);

    // where_list: 番号付きTextフィールド（旧リピーター max 6）
    for ($i = 1; $i <= 6; $i++) {
        $fields[] = array(
            'key'   => 'field_stelmah_where_list_item_' . $i,
            'label' => 'リスト項目 ' . $i,
            'name'  => 'where_list_item_' . $i,
            'type'  => 'text',
        );
    }

    $fields[] = array('key' => 'field_stelmah_where_image_1', 'label' => '画像 1', 'name' => 'where_image_1', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium');
    $fields[] = array('key' => 'field_stelmah_where_image_2', 'label' => '画像 2', 'name' => 'where_image_2', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium');

    // ===== Tab: トップ - FEATURED CONTENTS =====
    $fields[] = array('key' => 'field_stelmah_tab_services', 'label' => 'トップ - 注目コンテンツ', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_services_heading',    'label' => '見出し',     'name' => 'services_heading',    'type' => 'text', 'default_value' => $d['services_heading']);
    $fields[] = array('key' => 'field_stelmah_services_subheading', 'label' => 'サブ見出し', 'name' => 'services_subheading', 'type' => 'text', 'default_value' => $d['services_subheading']);

    // services_items: 番号付きGroupフィールド（旧リピーター max 6）
    for ($i = 1; $i <= 6; $i++) {
        $fields[] = array(
            'key'        => 'field_stelmah_services_item_' . $i,
            'label'      => 'サービス項目 ' . $i,
            'name'       => 'services_item_' . $i,
            'type'       => 'group',
            'layout'     => 'block',
            'sub_fields' => array(
                array('key' => 'field_stelmah_si' . $i . '_label', 'label' => 'ラベル',   'name' => 'label',       'type' => 'text'),
                array('key' => 'field_stelmah_si' . $i . '_title', 'label' => 'タイトル', 'name' => 'title',       'type' => 'text'),
                array('key' => 'field_stelmah_si' . $i . '_desc',  'label' => '説明',     'name' => 'description', 'type' => 'text'),
                array('key' => 'field_stelmah_si' . $i . '_image', 'label' => '画像',     'name' => 'image',       'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
                array('key' => 'field_stelmah_si' . $i . '_link',  'label' => 'リンク',   'name' => 'link',        'type' => 'url'),
            ),
        );
    }

    // ===== Tab: トップ - USEFUL LINKS & TOOLS =====
    $fields[] = array('key' => 'field_stelmah_tab_resources', 'label' => 'トップ - お役立ちリンク', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_resources_heading',  'label' => '見出し',     'name' => 'resources_heading',  'type' => 'textarea', 'rows' => 2, 'default_value' => $d['resources_heading'], 'instructions' => '改行は<br>に変換されます');
    $fields[] = array('key' => 'field_stelmah_resources_text',     'label' => '説明文',     'name' => 'resources_text',     'type' => 'textarea', 'rows' => 3, 'default_value' => $d['resources_text']);
    $fields[] = array('key' => 'field_stelmah_resources_cta_text', 'label' => 'CTAテキスト', 'name' => 'resources_cta_text', 'type' => 'text', 'default_value' => $d['resources_cta_text']);
    $fields[] = array('key' => 'field_stelmah_resources_cta_link', 'label' => 'CTAリンク',   'name' => 'resources_cta_link', 'type' => 'url');

    // ===== Tab: 記事一覧 - スライダー =====
    $fields[] = array('key' => 'field_stelmah_tab_archive_slider', 'label' => '記事一覧 - スライダー', 'type' => 'tab');
    $fields[] = array('key' => 'field_stelmah_msg_archive_slider', 'label' => '', 'type' => 'message', 'message' => '記事一覧ページ上部のスライダー画像を設定します（最大6枚）。未設定の場合はデフォルト画像が表示されます。');
    for ($i = 1; $i <= 6; $i++) {
        $fields[] = array(
            'key'           => 'field_stelmah_archive_slider_image_' . $i,
            'label'         => 'スライダー画像 ' . $i,
            'name'          => 'archive_slider_image_' . $i,
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
        );
    }

    acf_add_local_field_group(array(
        'key'      => 'group_stelmah_settings',
        'title'    => 'サイト設定',
        'fields'   => $fields,
        'location' => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-settings.php',
                ),
            ),
        ),
        'style'    => 'default',
        'position' => 'normal',
    ));

    // 投稿のピックアップフィールド
    acf_add_local_field_group(array(
        'key'      => 'group_stelmah_pickup',
        'title'    => 'ピックアップ設定',
        'fields'   => array(
            array(
                'key'           => 'field_stelmah_is_pickup',
                'label'         => 'ピックアップ記事に表示する',
                'name'          => 'is_pickup',
                'type'          => 'true_false',
                'instructions'  => 'ONにするとアーカイブページのピックアップセクションに表示されます（最大3件）',
                'default_value' => 0,
                'ui'            => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ),
            ),
        ),
        'style'    => 'default',
        'position' => 'side',
    ));
}
add_action('acf/init', 'stelmah_acf_register_fields');

// カテゴリ・タグ組み合わせ記事 カスタム投稿タイプ
function stelmah_register_cattag_content_post_type() {
    register_post_type('cattag_content', array(
        'labels' => array(
            'name'               => 'カテゴリ×タグ記事',
            'singular_name'      => 'カテゴリ×タグ記事',
            'add_new'            => '新規追加',
            'add_new_item'       => 'カテゴリ×タグ記事を追加',
            'edit_item'          => 'カテゴリ×タグ記事を編集',
            'new_item'           => '新しいカテゴリ×タグ記事',
            'view_item'          => 'カテゴリ×タグ記事を表示',
            'search_items'       => 'カテゴリ×タグ記事を検索',
            'not_found'          => 'カテゴリ×タグ記事が見つかりません',
            'not_found_in_trash' => 'ゴミ箱にカテゴリ×タグ記事はありません',
            'menu_name'          => 'カテゴリ×タグ記事',
        ),
        'public'             => true,
        'has_archive'        => false,
        'publicly_queryable' => false,
        'rewrite'            => false,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_icon'          => 'dashicons-category',
        'show_in_rest'       => true,
    ));
}
add_action('init', 'stelmah_register_cattag_content_post_type');

// カテゴリ×タグ記事 ACFフィールド
function stelmah_acf_register_cattag_fields() {
    if ( ! function_exists('acf_add_local_field_group') ) {
        return;
    }

    acf_add_local_field_group(array(
        'key'      => 'group_stelmah_cattag',
        'title'    => 'カテゴリ・タグ設定',
        'fields'   => array(
            array(
                'key'           => 'field_stelmah_cattag_category',
                'label'         => 'カテゴリ',
                'name'          => 'cattag_category',
                'type'          => 'taxonomy',
                'instructions'  => '対象のカテゴリを選択してください（空=指定なし）',
                'taxonomy'      => 'category',
                'field_type'    => 'select',
                'allow_null'    => 1,
                'return_format' => 'id',
                'add_term'      => 0,
                'save_terms'    => 0,
                'load_terms'    => 0,
            ),
            array(
                'key'           => 'field_stelmah_cattag_tag',
                'label'         => 'タグ',
                'name'          => 'cattag_tag',
                'type'          => 'taxonomy',
                'instructions'  => '対象のタグを選択してください（空=指定なし）',
                'taxonomy'      => 'post_tag',
                'field_type'    => 'select',
                'allow_null'    => 1,
                'return_format' => 'id',
                'add_term'      => 0,
                'save_terms'    => 0,
                'load_terms'    => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'cattag_content',
                ),
            ),
        ),
        'style'    => 'default',
        'position' => 'normal',
    ));
}
add_action('acf/init', 'stelmah_acf_register_cattag_fields');

// カテゴリ×タグ マッチングヘルパー関数
// /cat_x → カテゴリ一致 & タグ未指定の記事
// /tag_y → カテゴリ未指定 & タグ一致の記事
// /cat_x-tag_y → カテゴリ & タグ両方一致の記事
function stelmah_get_cattag_content($cat_id, $tag_id) {
    $cat_id = intval($cat_id);
    $tag_id = intval($tag_id);

    if ( ! $cat_id && ! $tag_id ) {
        return null;
    }

    $meta_query = array('relation' => 'AND');

    // タグ未指定の空値条件
    $empty_value_conditions = function($key) {
        return array(
            'relation' => 'OR',
            array('key' => $key, 'value' => '', 'compare' => '='),
            array('key' => $key, 'compare' => 'NOT EXISTS'),
            array('key' => $key, 'value' => '0', 'compare' => '='),
        );
    };

    if ( $cat_id && $tag_id ) {
        // /cat_x-tag_y: カテゴリとタグが両方一致
        $meta_query[] = array('key' => 'cattag_category', 'value' => $cat_id, 'compare' => '=');
        $meta_query[] = array('key' => 'cattag_tag', 'value' => $tag_id, 'compare' => '=');
    } elseif ( $cat_id ) {
        // /cat_x: カテゴリ一致 & タグ未指定
        $meta_query[] = array('key' => 'cattag_category', 'value' => $cat_id, 'compare' => '=');
        $meta_query[] = $empty_value_conditions('cattag_tag');
    } else {
        // /tag_y: カテゴリ未指定 & タグ一致
        $meta_query[] = $empty_value_conditions('cattag_category');
        $meta_query[] = array('key' => 'cattag_tag', 'value' => $tag_id, 'compare' => '=');
    }

    $query = new WP_Query(array(
        'post_type'      => 'cattag_content',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => $meta_query,
    ));

    if ( $query->have_posts() ) {
        $post = $query->posts[0];
        wp_reset_postdata();
        return $post;
    }
    wp_reset_postdata();

    return null;
}

// カテゴリ×タグ記事 管理画面カラム追加
function stelmah_cattag_admin_columns($columns) {
    $new_columns = array();
    foreach ( $columns as $key => $label ) {
        $new_columns[$key] = $label;
        if ( $key === 'title' ) {
            $new_columns['cattag_category'] = 'カテゴリ';
            $new_columns['cattag_tag']      = 'タグ';
        }
    }
    return $new_columns;
}
add_filter('manage_cattag_content_posts_columns', 'stelmah_cattag_admin_columns');

function stelmah_cattag_admin_column_content($column, $post_id) {
    if ( $column === 'cattag_category' ) {
        $cat_id = get_field('cattag_category', $post_id);
        if ( $cat_id ) {
            $cat = get_category($cat_id);
            echo $cat && ! is_wp_error($cat) ? esc_html($cat->name) : '—';
        } else {
            echo '—';
        }
    }
    if ( $column === 'cattag_tag' ) {
        $tag_id = get_field('cattag_tag', $post_id);
        if ( $tag_id ) {
            $tag = get_tag($tag_id);
            echo $tag && ! is_wp_error($tag) ? esc_html($tag->name) : '—';
        } else {
            echo '—';
        }
    }
}
add_action('manage_cattag_content_posts_custom_column', 'stelmah_cattag_admin_column_content', 10, 2);

