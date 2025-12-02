<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* Updated CSS will be added here */
    body {
        font-family: "Arial", sans-serif;
        margin: 0;
        padding: 0;
    }

    .header {
        display: flex;
        justify-content: space-between;
        padding: 10px 20px;
        align-items: center;
    }

    .header-left p,
    .header-center p {
        font-size: 12px;
        color: #000;
        margin: 0;
    }

    .header-center {
        text-align: center;
        flex-grow: 1;
    }

    .company-header {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
    }

    .logo img {
        max-width: 80px;
        margin-right: 20px;
    }

    .company-header h1 {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
        display: inline;
    }

    .company-details {
        text-align: center;
        margin-top: 0px;
    }

    .company-details h2 {
        font-size: 16px;
        margin: 5px 0;
    }

    .company-details p {
        font-size: 14px;
        margin: 2px 0;
    }

    .company-details p.current-page {
        margin-top: 4px;
    }

    .italic-text {
        font-style: italic;
    }

    .separator {
        border: none;
        border-top: 1px solid #bbb;
        margin: 20px 0;
    }

    .filter p {
        font-size: 14px;
        padding-left: 20px;
    }
    </style>
</head>

<body>
    <div class="content">
        <div class="company-header">
            <div class="logo">
                <img src="<?php echo h_session('school_logo') ? base_url(h_session('school_logo')) :base_url('assets/img/brand/logo.png'); ?>" alt="Logo">
            </div>
            <h1><?php echo h_session('school_name') ? h_session('school_name') :'' ?></h1>
        </div>
        <div class="company-details">
            <h2><?php echo h_session('branch_name') ? h_session('branch_name') :'' ?></h2>
            <p class="italic-text"><?php echo h_session('physical_address') ? h_session('physical_address') :'' ?></p>
            <p class="current-page"><?php echo h_session('current_page') ? h_session('current_page') :'' ?></p>
        </div>
    </div>

    <hr class="separator">
</body>

</html>