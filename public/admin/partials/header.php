<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Default Page Title
|--------------------------------------------------------------------------
*/

$pageTitle = $pageTitle ?? 'EPKO Mini CMS';

?>

<!DOCTYPE html>
<html lang="hu">

<head>

    <!-- Basic Meta Tags -->

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >

    <meta
        name="robots"
        content="noindex, nofollow"
    >

    <meta
        name="author"
        content="EPKO Mini CMS"
    >

    <!-- Page Title -->

    <title>

        <?= htmlspecialchars(
            $pageTitle,
            ENT_QUOTES,
            'UTF-8'
        ); ?>

        | EPKO Mini CMS

    </title>


    <!-- Favicon -->

    <link
        rel="icon"
        type="image/png"
        href="../assets/images/logo.png"
    >


    <!-- Bootstrap 5 -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >


    <!-- Google Fonts -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Admin Stylesheet -->

    <link
        rel="stylesheet"
        href="../assets/css/admin.css"
    >

</head>

<body>

<div class="admin-wrapper">