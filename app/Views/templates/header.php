<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--css-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--css-->
        <link rel="stylesheet" href="/assets/css/style.css">
    <title>User Authentication system</title>
</head>
<body>

    <?php
        $uri = service('uri');
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Auth SYS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if (session()->get('isLoggedIn')): ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
                    <a class="nav-link" href="/dashboard">Dashbaord</a>
                </li>
                <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
                    <a class="nav-link" href="/profile">Profile</a>
                </li>
            </ul>
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        <? else: ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
                        <a class="nav-link" href="/">Login</a>
                    </li>
                    <li class="nav-item <?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </nav>

