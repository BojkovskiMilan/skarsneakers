<?php

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role_id"] != 1) {
    header("Location: index.php");
    exit;
}

$logFile = "data/logs.txt";
$loginLogFile = "data/login_logs.txt";

$pageStats = [];

if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $parts = explode(" - ", $line);

        if (count($parts) == 2) {
            $page = trim($parts[1]);

            if (!isset($pageStats[$page])) {
                $pageStats[$page] = 0;
            }
            $pageStats[$page]++;
        }
    }
}

$totalPages = array_sum($pageStats);

$loginsToday = 0;

if (file_exists($loginLogFile)) {
    $lines = file($loginLogFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $today = date("Y-m-d");

    foreach ($lines as $line) {
        if (strpos($line, $today) === 0) {
            $loginsToday++;
        }
    }
}

?>

<div class="container py-5">
   <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1">Website Analytics</h2>
            <p class="text-muted mb-0">
                Overview of traffic, logins and page activity
            </p>
        </div>
        <a href="index.php?strana=admin"
        class="btn btn-outline-dark">
            ← Back to Dashboard
        </a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Logins Today</p>
                    <h2 class="mb-0 text-success"><?= $loginsToday ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Tracked Pages</p>
                    <h2 class="mb-0"><?= count($pageStats) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Visits</p>
                    <h2 class="mb-0"><?= $totalPages ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Page Visit Distribution</h5>
            <?php if ($totalPages == 0): ?>
                <p class="text-muted mb-0">No analytics data available yet.</p>
            <?php else: ?>
                <?php foreach ($pageStats as $page => $count): ?>
                    <?php
                        $percent = round(($count / $totalPages) * 100, 2);
                    ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold"><?= htmlspecialchars($page) ?></span>
                            <span class="text-muted"><?= $count ?> visits • <?= $percent ?>%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-dark"
                                 role="progressbar"
                                 style="width: <?= $percent ?>%">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>