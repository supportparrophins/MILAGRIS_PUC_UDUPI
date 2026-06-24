<?php
header('Content-Type: application/manifest+json');

// Include database connection
require APPPATH . 'views/includes/db.php';

$config = [];
$sql = "SELECT config_key, config_value FROM tbl_configuration";

try {
    $stmt = $con->query($sql);
    if ($stmt !== false) {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $config[$row['config_key']] = $row['config_value'];
        }
    }
} catch (PDOException $e) {}

// Extract values
$title            = $config['TITLE'] ?? 'My App';
$tab_title        = $config['TAB_TITLE'] ?? 'Faculty Login';
$institution_logo = $config['INSTITUTION_LOGO'] ?? 'icons/bjes.png';
$index_path_staff = rtrim($config['INDEX_PATH_STAFF'] ?? '', '/');

// ✅ Full logo path
$full_logo_path = $index_path_staff . '/' . ltrim($institution_logo, '/');

// Output JSON manifest
echo json_encode([
    "name" => $title,
    "short_name" => $tab_title,
    "start_url" => "./login.php",
    "display" => "standalone",
    "background_color" => "#ffffff",
    "theme_color" => "#317EFB",
    "description" => "Faculty login for " . $title,
    "icons" => [
        [
            "src" => $full_logo_path,
            "sizes" => "192x192",
            "type" => "image/png"
        ],
        [
            "src" => $full_logo_path,
            "sizes" => "512x512",
            "type" => "image/png"
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
