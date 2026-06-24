<?php
// Include your database connection
require_once('config.php');

// Fetch configuration data
$config = [];
$sql = "SELECT config_key, config_value FROM tbl_configuration";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $config[$row['config_key']] = $row['config_value'];
    }
}

// Set fallback values if not found
$title            = $config['TITLE'] ?? '';
$sub_title        = $config['SUB_TITLE'] ?? '';
$tab_title        = $config['TAB_TITLE'] ?? '';
$institution_logo = $config['INSTITUTION_LOGO'] ?? '';
$index_path_staff       = rtrim($config['INDEX_PATH_STAFF'] ?? '', '/'); // remove trailing slash if any
$index_path_student       = rtrim($config['INDEX_PATH_STUDENT'] ?? '', '/'); // remove trailing slash if any
$address          = $config['ADDRESS'] ?? '';
$current_year     = $config['CURRENT_YEAR'] ?? date('Y');

// ✅ Combine INDEX_PATH + INSTITUTION_LOGO
$full_logo_path = $index_path_staff . '/' . ltrim($institution_logo, '/');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="manifest" href="manifest.webmanifest">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo htmlspecialchars($title); ?>">
    <meta name="author" content="Schoolphins">
    <link rel="icon" href="<?php echo htmlspecialchars($full_logo_path); ?>">

    <title><?php echo htmlspecialchars($tab_title); ?></title>

    <script src="index_.js" defer></script>
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<style>
html,
body {
    height: 100%;
}

body {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
}

.form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}

.background {
    background-size: 100% 100vh;
    background-repeat: no-repeat;
    background-color: #fff;
}
</style>

<body class="text-center background">
    <form class="form-signin">
        <!-- ✅ Display image using full URL -->
        <img class="mb-3" src="<?php echo htmlspecialchars($full_logo_path); ?>" alt="Institute Logo" width="122" height="122">

        <div class="d-flex justify-content-center">
            <h2 class="h3 mb-3 font-weight-bold text-nowrap" style="color:black; white-space:nowrap;"><?php echo htmlspecialchars($title); ?></h2>
        </div>

        <!-- <?php //if (!empty($sub_title)) : ?>
            <p class="text-muted mb-4"><?php //echo htmlspecialchars($sub_title); ?></p>
        <?php //endif; ?> -->

        <?php if (!empty($index_path_staff)) { ?>
            <a href="<?php echo $index_path_staff; ?>" class="btn btn-lg btn-primary btn-block">Staff Login</a>
        <?php } ?>
        <?php if (!empty($index_path_student)) { ?>
        <!-- <a href="<?php  //echo $index_path_student; ?>" class="btn btn-lg btn-primary btn-block">Student Login</a> -->
        <?php } ?>
        <p class="mt-5 mb-3 text-black">© <?php echo htmlspecialchars($current_year); ?></p>
    </form>
</body>

</html>

