<?php
/* ── Stat cards ───────────────────────────────────────────── */
$cards = [
    ['label' => 'Projects',      'value' => (int)$totalProjects,            'trend' => 'Total',     'color' => '#C86142'],
    ['label' => 'Team Members',  'value' => (int)$totalTeam,                'trend' => 'Active',    'color' => '#7C9E8A'],
    ['label' => 'Services',      'value' => (int)$totalServices,            'trend' => 'Listed',    'color' => '#8B7EC8'],
    ['label' => 'Technologies',  'value' => (int)$totalSkills,              'trend' => 'In stack',  'color' => '#C8A842'],
    ['label' => 'New Inquiries', 'value' => (int)($stats['new'] ?? 0),      'trend' => 'Unread',    'color' => '#D06060'],
    ['label' => 'All Inquiries', 'value' => (int)($stats['total'] ?? 0),    'trend' => 'All time',  'color' => '#6EA8C8'],
];

/* ── Chart.js colour palette ─────────────────────────────── */
$chartPalette = ['#C86142','#7C9E8A','#8B7EC8','#C8A842','#6EA8C8','#D06060','#7DB8A4','#A87CC8'];

/* ── Encode chart data to JSON safely ───────────────────── */
$donutLabels  = array_keys($inqStatusCounts);
$donutValues  = array_values($inqStatusCounts);
$donutColors  = array_slice($chartPalette, 0, count($donutLabels));

$barTypeLabels  = array_keys($inqByType);
$barTypeValues  = array_values($inqByType);

$projCatLabels  = array_keys($projByCategory);
$projCatValues  = array_values($projByCategory);

$lineLabels = array_keys($inqByMonth);
$lineValues = array_values($inqByMonth);

$polarLabels = array_keys($contentOverview);
$polarValues = array_values($contentOverview);
$polarColors = array_slice($chartPalette, 0, count($polarLabels));
?>

<!-- ═══════════════════ STAT CARDS ═══════════════════ -->
<div class="stats-grid">
    <?php foreach ($cards as $card): ?>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label"><?php echo e($card['label']); ?></span>
            <span class="stat-trend"><?php echo e($card['trend']); ?></span>
        </div>
        <div class="stat-card-body">
            <span class="stat-value"><?php echo $card['value']; ?></span>
            <span class="stat-dot" style="background:<?php echo e($card['color']); ?>"></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- ═══════════════════ CHARTS ROW 1 ═══════════════════ -->
<div class="dash-charts-row">

    <!-- Inquiries over time - line -->
    <div class="dash-chart-card dash-chart-wide">
        <div class="dash-chart-title">Inquiries - Last 6 Months</div>
        <div class="dash-chart-wrap">
            <canvas id="chartLine" aria-label="Inquiries over the last 6 months" role="img"></canvas>
        </div>
    </div>

    <!-- Inquiry status - donut -->
    <div class="dash-chart-card">
        <div class="dash-chart-title">Inquiry Status</div>
        <div class="dash-chart-wrap dash-chart-wrap--sm">
            <canvas id="chartDonut" aria-label="Inquiry status breakdown" role="img"></canvas>
        </div>
    </div>

</div>

<!-- ═══════════════════ CHARTS ROW 2 ═══════════════════ -->
<div class="dash-charts-row">

    <!-- Inquiries by project type - bar -->
    <div class="dash-chart-card">
        <div class="dash-chart-title">Inquiries by Project Type</div>
        <div class="dash-chart-wrap">
            <canvas id="chartBar" aria-label="Inquiries by project type" role="img"></canvas>
        </div>
    </div>

    <!-- Projects by category - horizontal bar -->
    <div class="dash-chart-card">
        <div class="dash-chart-title">Projects by Category</div>
        <div class="dash-chart-wrap">
            <canvas id="chartHBar" aria-label="Projects by category" role="img"></canvas>
        </div>
    </div>

    <!-- Content overview - polar area -->
    <div class="dash-chart-card">
        <div class="dash-chart-title">Content Overview</div>
        <div class="dash-chart-wrap dash-chart-wrap--sm">
            <canvas id="chartPolar" aria-label="Content overview by type" role="img"></canvas>
        </div>
    </div>

</div>

<!-- ═══════════════════ TABLES ═══════════════════ -->
<div class="dashboard-grid">

    <div class="table-container">
        <div class="table-title">Recent Inquiries</div>
        <table>
            <thead>
                <tr><th>Name</th><th>Type</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php $recent = array_slice($recentInquiries, 0, 6); ?>
                <?php if (empty($recent)): ?>
                    <tr><td colspan="4" class="cell-muted">No inquiries yet.</td></tr>
                <?php else: foreach ($recent as $inq): ?>
                <tr>
                    <td>
                        <div><?php echo e($inq['inquiry_name']); ?></div>
                        <div class="cell-muted" style="font-size:11.5px"><?php echo e($inq['inquiry_email']); ?></div>
                    </td>
                    <td><?php echo e($inq['inquiry_project_type']); ?></td>
                    <td><span class="status-badge <?php echo admin_status_class($inq['inquiry_status']); ?>"><?php echo e($inq['inquiry_status']); ?></span></td>
                    <td class="cell-muted"><?php echo e(date('M j, Y', strtotime($inq['inquiry_created_at']))); ?></td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <div class="table-title">Recent Projects</div>
        <table>
            <thead>
                <tr><th>Name</th><th>Category</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php $recentP = array_slice($recentProjects, 0, 6); ?>
                <?php if (empty($recentP)): ?>
                    <tr><td colspan="4" class="cell-muted">No projects yet.</td></tr>
                <?php else: foreach ($recentP as $proj): ?>
                <tr>
                    <td><?php echo e($proj['project_name']); ?></td>
                    <td><?php echo e($proj['project_category']); ?></td>
                    <td><span class="status-badge <?php echo $proj['project_status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $proj['project_status'] ? 'Active' : 'Inactive'; ?></span></td>
                    <td class="cell-muted"><?php echo e(date('M j, Y', strtotime($proj['project_created_at']))); ?></td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- ═══════════════════ AVAILABILITY ═══════════════════ -->
<div class="admin-panel">
    <h3>Availability</h3>
    <p>Current status shown on the homepage hero and contact page.</p>
    <form class="admin-inline-form" method="POST" action="<?php echo BASE_URL; ?>/admin?action=adminAvailabilityUpdate">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="avail_id" value="<?php echo (int)($avail['availability_id'] ?? 0); ?>">
        <input type="hidden" name="back" value="dashboard">
        <label class="visually-hidden" for="dashAvail">Availability status</label>
        <select id="dashAvail" name="availability_status">
            <?php foreach (['Available', 'Limited Availability', 'Currently Busy'] as $opt): ?>
                <option value="<?php echo e($opt); ?>" <?php echo ($avail['availability_status'] ?? '') === $opt ? 'selected' : ''; ?>><?php echo e($opt); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Update</button>
    </form>
</div>

<!-- ═══════════════════ CHART.JS ═══════════════════ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function () {
    /* ── Shared theme ── */
    const font   = 'Plus Jakarta Sans, system-ui, sans-serif';
    const muted  = '#7A756D';
    const border = '#DFD9CE';
    const text   = '#151413';

    Chart.defaults.font.family = font;
    Chart.defaults.color       = muted;

    const gridCfg = {
        color: border,
        drawBorder: false,
    };
    const tickCfg = { color: muted, font: { size: 11 } };

    /* ── Data from PHP ── */
    const lineLabels  = <?php echo json_encode($lineLabels,    JSON_UNESCAPED_UNICODE); ?>;
    const lineValues  = <?php echo json_encode($lineValues,    JSON_UNESCAPED_UNICODE); ?>;
    const donutLabels = <?php echo json_encode($donutLabels,   JSON_UNESCAPED_UNICODE); ?>;
    const donutValues = <?php echo json_encode($donutValues,   JSON_UNESCAPED_UNICODE); ?>;
    const donutColors = <?php echo json_encode($donutColors,   JSON_UNESCAPED_UNICODE); ?>;
    const barLabels   = <?php echo json_encode($barTypeLabels, JSON_UNESCAPED_UNICODE); ?>;
    const barValues   = <?php echo json_encode($barTypeValues, JSON_UNESCAPED_UNICODE); ?>;
    const hbarLabels  = <?php echo json_encode($projCatLabels, JSON_UNESCAPED_UNICODE); ?>;
    const hbarValues  = <?php echo json_encode($projCatValues, JSON_UNESCAPED_UNICODE); ?>;
    const polarLabels = <?php echo json_encode($polarLabels,   JSON_UNESCAPED_UNICODE); ?>;
    const polarValues = <?php echo json_encode($polarValues,   JSON_UNESCAPED_UNICODE); ?>;
    const polarColors = <?php echo json_encode($polarColors,   JSON_UNESCAPED_UNICODE); ?>;

    const palette = <?php echo json_encode($chartPalette, JSON_UNESCAPED_UNICODE); ?>;

    /* ── 1. Line - inquiries over time ── */
    new Chart(document.getElementById('chartLine'), {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: [{
                label: 'Inquiries',
                data: lineValues,
                borderColor: '#C86142',
                backgroundColor: 'rgba(200,97,66,0.10)',
                borderWidth: 2,
                pointBackgroundColor: '#C86142',
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.38,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1D1C1A',
                    titleColor: '#F0EBE3',
                    bodyColor: '#B8B2A6',
                    borderColor: '#2A2724',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 6,
                }
            },
            scales: {
                x: { grid: gridCfg, ticks: tickCfg },
                y: {
                    grid: gridCfg,
                    ticks: { ...tickCfg, stepSize: 1, precision: 0 },
                    beginAtZero: true,
                }
            }
        }
    });

    /* ── 2. Donut - inquiry status ── */
    new Chart(document.getElementById('chartDonut'), {
        type: 'doughnut',
        data: {
            labels: donutLabels.length ? donutLabels : ['No data'],
            datasets: [{
                data: donutValues.length ? donutValues : [1],
                backgroundColor: donutColors.length ? donutColors : ['#DFD9CE'],
                borderWidth: 2,
                borderColor: '#FFFFFF',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '62%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 14,
                        boxWidth: 10,
                        boxHeight: 10,
                        font: { size: 11 },
                        color: muted,
                    }
                },
                tooltip: {
                    backgroundColor: '#1D1C1A',
                    titleColor: '#F0EBE3',
                    bodyColor: '#B8B2A6',
                    borderColor: '#2A2724',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 6,
                }
            }
        }
    });

    /* ── 3. Bar - inquiries by project type ── */
    new Chart(document.getElementById('chartBar'), {
        type: 'bar',
        data: {
            labels: barLabels.length ? barLabels : ['No data'],
            datasets: [{
                label: 'Inquiries',
                data: barValues.length ? barValues : [0],
                backgroundColor: barLabels.map((_, i) => palette[i % palette.length] + 'CC'),
                borderColor:     barLabels.map((_, i) => palette[i % palette.length]),
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1D1C1A',
                    titleColor: '#F0EBE3',
                    bodyColor: '#B8B2A6',
                    borderColor: '#2A2724',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 6,
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { ...tickCfg, maxRotation: 35 } },
                y: {
                    grid: gridCfg,
                    ticks: { ...tickCfg, stepSize: 1, precision: 0 },
                    beginAtZero: true,
                }
            }
        }
    });

    /* ── 4. Horizontal bar - projects by category ── */
    new Chart(document.getElementById('chartHBar'), {
        type: 'bar',
        data: {
            labels: hbarLabels.length ? hbarLabels : ['No data'],
            datasets: [{
                label: 'Projects',
                data: hbarValues.length ? hbarValues : [0],
                backgroundColor: '#8B7EC8CC',
                borderColor: '#8B7EC8',
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1D1C1A',
                    titleColor: '#F0EBE3',
                    bodyColor: '#B8B2A6',
                    borderColor: '#2A2724',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 6,
                }
            },
            scales: {
                x: {
                    grid: gridCfg,
                    ticks: { ...tickCfg, stepSize: 1, precision: 0 },
                    beginAtZero: true,
                },
                y: { grid: { display: false }, ticks: tickCfg }
            }
        }
    });

    /* ── 5. Polar area - content overview ── */
    new Chart(document.getElementById('chartPolar'), {
        type: 'polarArea',
        data: {
            labels: polarLabels,
            datasets: [{
                data: polarValues,
                backgroundColor: polarColors.map(c => c + 'BB'),
                borderColor: polarColors,
                borderWidth: 1.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 14,
                        boxWidth: 10,
                        boxHeight: 10,
                        font: { size: 11 },
                        color: muted,
                    }
                },
                tooltip: {
                    backgroundColor: '#1D1C1A',
                    titleColor: '#F0EBE3',
                    bodyColor: '#B8B2A6',
                    borderColor: '#2A2724',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 6,
                }
            },
            scales: {
                r: {
                    grid: { color: border },
                    ticks: { display: false },
                    pointLabels: { display: false },
                }
            }
        }
    });

})();
</script>
