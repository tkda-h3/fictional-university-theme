<?php

// css, js, メニューなど
require get_theme_file_path('/functions/init.php');
// カスタム投稿タイプ
require get_theme_file_path('/functions/custom-post.php');
// カスタムフィールド
require get_theme_file_path('/functions/custom-field.php');
// クエリの定義、書き換え
require get_theme_file_path('/functions/custom-query.php');
// ログイン関係
require get_theme_file_path('/functions/admin.php');
// WP REST API のフィールドの設定
require get_theme_file_path('/functions/api-field.php');
// 検索用APIの設定
require get_theme_file_path('/functions/search-route.php');
// 教授いいね用APIの設定
require get_theme_file_path('/functions/like-route.php');
