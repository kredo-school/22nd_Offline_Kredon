@extends('layouts.admin')
 
@section('title', 'Admin Dashboard')
 
@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Kredon Admin | Dashboard</title>
 
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<!-- Tabler Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />
 
<style>
  :root {
    --sidebar-bg: #111827;
    --sidebar-border: rgba(255,255,255,0.07);
    --sidebar-active-bg: rgba(59,130,246,0.15);
    --sidebar-active-text: #93C5FD;
    --sidebar-text: rgba(255,255,255,0.6);
    --blue:   #3B82F6;
    --green:  #10B981;
    --amber:  #F59E0B;
    --indigo: #8B5CF6;
    --purple:   #bf24ea;
    --red:    #EF4444;
  }
 
  body {
    font-family: 'DM Sans', sans-serif;
    background: #fff;
    color: #111827;
    font-size: 14px;
    -webkit-font-smoothing: antialiased;
  }

  /* ── Main column ── */
  .main-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #fff;
  }
 
  /* ── Canvas ── */
  .canvas {
    flex: 1;
    overflow-y: auto;
    padding: 28px 28px 40px;
    background: #fff;
  }
 
  /* ── Avatar circle ── */
  .av {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: var(--blue);
    color: #fff;
    font-size: 13px; font-weight: 600;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .av-sm { width: 28px; height: 28px; font-size: 11px; }
  .av-xs { width: 30px; height: 30px; font-size: 12px; }
 
  /* ── Metric cards ── */
  .metric-icon-wrap {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 10px;
  }
  .metric-icon-wrap i { font-size: 16px; }
  .mi-blue   { background: #EFF6FF; } .mi-blue i   { color: var(--blue); }
  .mi-green  { background: #F0FDF4; } .mi-green i  { color: var(--green); }
  .mi-amber  { background: #FFFBEB; } .mi-amber i  { color: var(--amber); }
  .mi-red    { background: #FEF2F2; } .mi-red i    { color: var(--red); }
  .mi-purple   { background: #f8effc; } .mi-purple i   { color: var(--purple); }
  .mi-indigo { background: #F5F3FF; } .mi-indigo i { color: var(--indigo); }
 
  .metric-value {
    font-size: 22px; font-weight: 600;
    color: #111827; line-height: 1.1;
    letter-spacing: -0.5px;
  }
  .chg { display: inline-flex; align-items: center; gap: 2px; font-size: 11px; font-weight: 500; }
  .chg i { font-size: 12px; }
  .chg.up   { color: #15803D; }
  .chg.down { color: #B91C1C; }
  .chg-label { font-size: 10px; color: #9CA3AF; }
 
  /* ── Card overrides ── */
  .card { border: 1px solid #E5E7EB; border-radius: 10px; }
  .card-title-sm { font-size: 13px; font-weight: 600; color: #111827; }
  .card-tag {
    font-size: 11px; color: #6B7280;
    background: #F9FAFB;
    padding: 3px 9px; border-radius: 20px;
    border: 1px solid #E5E7EB;
  }
 
  /* ── Chart ── */
  .chart-wrap { height: 120px; }
  svg.line-chart { width: 100%; height: 100%; overflow: visible; }
  .legend-dot { width: 16px; height: 2px; border-radius: 2px; display: inline-block; }
 
  /* ── Category bars ── */
  .cat-bar-bg {
    height: 5px; background: #F3F4F6;
    border-radius: 4px; overflow: hidden;
  }
  .cat-bar-fill { height: 100%; border-radius: 4px; }
 
  /* ── Queue items ── */
  .queue-item {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #F3F4F6;
  }
  .queue-item:last-child { border-bottom: none; }
  .q-av {
    width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 600; color: #fff; flex-shrink: 0;
  }
  .q-name { font-size: 12px; font-weight: 500; color: #111827; }
  .q-sub  { font-size: 11px; color: #6B7280; }
 
  /* ── Badges (override Bootstrap) ── */
  .badge-kr-red    { background: #FEF2F2 !important; color: #B91C1C !important; }
  .badge-kr-green  { background: #F0FDF4 !important; color: #166534 !important; }
  .badge-kr-amber  { background: #FFFBEB !important; color: #92400E !important; }
 
  /* ── Activity feed ── */
  .feed-item {
    display: flex; gap: 10px; align-items: flex-start;
    padding: 8px 0;
    border-bottom: 1px solid #F3F4F6;
  }
  .feed-item:last-child { border-bottom: none; }
  .feed-dot {
    width: 8px; height: 8px; border-radius: 50%;
    margin-top: 4px; flex-shrink: 0;
  }
  .feed-text { font-size: 12px; color: #111827; line-height: 1.45; }
  .feed-time { font-size: 11px; color: #9CA3AF; margin-top: 2px; }
</style>
</head>
<body> 
  <!-- ── Main column ── -->
  <div class="main-col">
 
    <!-- Canvas -->
    <main class="canvas">
 
      <!-- Page title -->
      <div class="mb-4">
        <h1 class="fs-4 fw-semibold text-dark mb-1">Dashboard overview</h1>
        <p class="text-secondary mb-0" style="font-size:13px;">Viewing data from the last 7 days</p>
      </div>
 
      <!-- Metric cards — 6 columns -->
      <div class="row g-3 mb-4">
 
        <div class="col">
          <div class="card h-100 p-3 border" style="border-color: #3B82F6 !important;">
            <div class="metric-icon-wrap mi-blue"><i class="ti ti-users" aria-hidden="true"></i></div>
            <div class="text-secondary mb-1" style="font-size:11px;">Total users</div>
            <div class="metric-value">45,210</div>
            <div class="d-flex align-items-center gap-1 mt-1">
              <span class="chg up"><i class="ti ti-arrow-up"></i>+5%</span>
              <span class="chg-label">vs last week</span>
            </div>
          </div>
        </div>
 
        <div class="col">
          <div class="card h-100 p-3 border" style="border-color:#10B981 !important;">
            <div class="metric-icon-wrap mi-green"><i class="ti ti-file-plus" aria-hidden="true"></i></div>
            <div class="text-secondary mb-1" style="font-size:11px;">New posts</div>
            <div class="metric-value">2,510</div>
            <div class="d-flex align-items-center gap-1 mt-1">
              <span class="chg up"><i class="ti ti-arrow-up"></i>+12%</span>
              <span class="chg-label">vs last week</span>
            </div>
          </div>
        </div>
 
        <div class="col">
          <div class="card h-100 p-3 border" style="border-color: #F59E0B !important;">
            <div class="metric-icon-wrap mi-amber"><i class="ti ti-calendar-event" aria-hidden="true"></i></div>
            <div class="text-secondary mb-1" style="font-size:11px;">Active events</div>
            <div class="metric-value">18</div>
            <div class="d-flex align-items-center gap-1 mt-1">
              <span class="chg up"><i class="ti ti-arrow-up"></i>+2</span>
              <span class="chg-label">vs last week</span>
            </div>
          </div>
        </div>
 
        <div class="col">
          <div class="card h-100 p-3 border" style="border-color: #EF4444 !important;">
            <div class="metric-icon-wrap mi-red"><i class="ti ti-message-report" aria-hidden="true"></i></div>
            <div class="text-secondary mb-1" style="font-size:11px;">New comments</div>
            <div class="metric-value">12,385</div>
            <div class="d-flex align-items-center gap-1 mt-1">
              <span class="chg down"><i class="ti ti-arrow-down"></i>-3%</span>
              <span class="chg-label">vs last week</span>
            </div>
          </div>
        </div>
 
        <div class="col">
          <div class="card h-100 p-3 border" style="border-color: #bf24ea !important;">
            <div class="metric-icon-wrap mi-purple"><i class="ti ti-map-pin" aria-hidden="true"></i></div>
            <div class="text-secondary mb-1" style="font-size:11px;">Total locations</div>
            <div class="metric-value">3,125</div>
            <div class="d-flex align-items-center gap-1 mt-1">
              <span class="chg up"><i class="ti ti-arrow-up"></i>+8</span>
              <span class="chg-label">vs last week</span>
            </div>
          </div>
        </div>
 
        <div class="col">
          <div class="card h-100 p-3 border" style="border-color: #8B5CF6 !important;">
            <div class="metric-icon-wrap mi-indigo"><i class="ti ti-crown" aria-hidden="true"></i></div>
            <div class="text-secondary mb-1" style="font-size:11px;">Premium members</div>
            <div class="metric-value">6,780</div>
            <div class="d-flex align-items-center gap-1 mt-1">
              <span class="chg up"><i class="ti ti-arrow-up"></i>+21%</span>
              <span class="chg-label">vs last week</span>
            </div>
          </div>
        </div>
 
      </div><!-- /metrics row -->
 
      <!-- Charts row -->
      <div class="row g-3 mb-3">
 
        <!-- Engagement chart -->
        <div class="col-8">
          <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="card-title-sm">Engagement &amp; content volume</span>
              <span class="card-tag">Last 30 days</span>
            </div>
            <div class="chart-wrap">
              <svg class="line-chart" viewBox="0 0 400 120" preserveAspectRatio="none">
                <line x1="0" y1="110" x2="400" y2="110" stroke="#E5E7EB" stroke-width="0.5"/>
                <line x1="0" y1="78"  x2="400" y2="78"  stroke="#E5E7EB" stroke-width="0.5" stroke-dasharray="4,4"/>
                <line x1="0" y1="46"  x2="400" y2="46"  stroke="#E5E7EB" stroke-width="0.5" stroke-dasharray="4,4"/>
                <line x1="0" y1="14"  x2="400" y2="14"  stroke="#E5E7EB" stroke-width="0.5" stroke-dasharray="4,4"/>
                <text x="0"   y="118" font-size="9" fill="#9CA3AF">1</text>
                <text x="88"  y="118" font-size="9" fill="#9CA3AF">8</text>
                <text x="178" y="118" font-size="9" fill="#9CA3AF">15</text>
                <text x="268" y="118" font-size="9" fill="#9CA3AF">22</text>
                <text x="355" y="118" font-size="9" fill="#9CA3AF">29</text>
                <polyline points="0,82 44,66 89,72 133,50 178,55 222,40 267,44 311,33 356,50 400,38"
                  fill="none" stroke="#3B82F6" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                <polyline points="0,92 44,88 89,98 133,82 178,88 222,70 267,76 311,65 356,77 400,60"
                  fill="none" stroke="#10B981" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke-dasharray="6,3"/>
              </svg>
            </div>
            <div class="d-flex gap-3 mt-2">
              <span class="d-flex align-items-center gap-2 text-secondary" style="font-size:11px;">
                <span class="legend-dot" style="background:#3B82F6;"></span> Daily posts
              </span>
              <span class="d-flex align-items-center gap-2 text-secondary" style="font-size:11px;">
                <span class="legend-dot" style="background:#10B981;"></span> User logins
              </span>
            </div>
          </div>
        </div>
 
        <!-- Top categories -->
        <div class="col-4">
          <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="card-title-sm">Top categories</span>
              <span class="card-tag">This week</span>
            </div>
            <div class="d-flex flex-column gap-2">
 
              <div>
                <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                  <span>Local eats</span><span class="text-secondary">38%</span>
                </div>
                <div class="cat-bar-bg"><div class="cat-bar-fill" style="width:38%;background:#3B82F6;"></div></div>
              </div>
 
              <div>
                <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                  <span>Hidden gems</span><span class="text-secondary">27%</span>
                </div>
                <div class="cat-bar-bg"><div class="cat-bar-fill" style="width:27%;background:#8B5CF6;"></div></div>
              </div>
 
              <div>
                <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                  <span>Weekend hikes</span><span class="text-secondary">19%</span>
                </div>
                <div class="cat-bar-bg"><div class="cat-bar-fill" style="width:19%;background:#10B981;"></div></div>
              </div>
 
              <div>
                <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                  <span>Markets</span><span class="text-secondary">10%</span>
                </div>
                <div class="cat-bar-bg"><div class="cat-bar-fill" style="width:10%;background:#F59E0B;"></div></div>
              </div>
 
              <div>
                <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                  <span>Events</span><span class="text-secondary">6%</span>
                </div>
                <div class="cat-bar-bg"><div class="cat-bar-fill" style="width:6%;background:#EF4444;"></div></div>
              </div>
 
            </div>
          </div>
        </div>
 
      </div><!-- /charts row -->
 
      <!-- Bottom row -->
      <div class="row g-3">
 
        <!-- Moderation queue -->
        <div class="col-6">
          <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="card-title-sm">Moderation queue</span>
              <span class="card-tag">3 pending</span>
            </div>
 
            <div class="queue-item">
              <div class="q-av" style="background:#3B82F6;">U</div>
              <div class="flex-grow-1">
                <div class="q-name">User action</div>
                <div class="q-sub">Banned on an event</div>
              </div>
              <span class="badge rounded-pill badge-kr-red">Banned</span>
            </div>
 
            <div class="queue-item">
              <div class="q-av" style="background:#8B5CF6;">L</div>
              <div class="flex-grow-1">
                <div class="q-name">Location review</div>
                <div class="q-sub">New location submitted</div>
              </div>
              <span class="badge rounded-pill badge-kr-amber">Flagged</span>
            </div>
 
            <div class="queue-item">
              <div class="q-av" style="background:#10B981;">P</div>
              <div class="flex-grow-1">
                <div class="q-name">Post approved</div>
                <div class="q-sub">User @GlenaK</div>
              </div>
              <span class="badge rounded-pill badge-kr-green">Approved</span>
            </div>
 
          </div>
        </div>
 
        <!-- Recent activity -->
        <div class="col-6">
          <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="card-title-sm">Recent activity</span>
              <span class="card-tag">Live</span>
            </div>
 
            <div class="feed-item">
              <div class="feed-dot" style="background:#3B82F6;"></div>
              <div>
                <div class="feed-text">New category "ビーガンセブ" created</div>
                <div class="feed-time">2 min ago</div>
              </div>
            </div>
 
            <div class="feed-item">
              <div class="feed-dot" style="background:#EF4444;"></div>
              <div>
                <div class="feed-text">Report: User @MikeN post hidden</div>
                <div class="feed-time">11 min ago</div>
              </div>
            </div>
 
            <div class="feed-item">
              <div class="feed-dot" style="background:#10B981;"></div>
              <div>
                <div class="feed-text">Premium subscriber: User @GlenaK</div>
                <div class="feed-time">34 min ago</div>
              </div>
            </div>
 
            <div class="feed-item">
              <div class="feed-dot" style="background:#F59E0B;"></div>
              <div>
                <div class="feed-text">New event posted in Cebu City</div>
                <div class="feed-time">1 hr ago</div>
              </div>
            </div>
 
          </div>
        </div>
      </div><!-- /bottom row -->
    </main>
  </div><!-- /main-col -->
  
</body>
</html>
@endsection
 
 