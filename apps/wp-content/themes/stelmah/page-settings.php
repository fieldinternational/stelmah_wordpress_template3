<?php
/**
 * Template Name: サイト設定
 * Description: ACFフィールド用の設定ページ（フロントエンドからはアクセス不可）
 */

// フロントエンドからアクセスされた場合、管理画面の編集ページにリダイレクト
if ( current_user_can( 'edit_posts' ) ) {
    wp_redirect( admin_url( 'post.php?post=' . get_the_ID() . '&action=edit' ) );
} else {
    wp_redirect( home_url( '/' ) );
}
exit;
