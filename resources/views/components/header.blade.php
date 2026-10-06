<header class="context-subheader">
    <div class="container-fluid px-4">
        <div class="row align-items-center gy-2">
            <!-- Left: Title & Subtitle + System Health -->
            <div class="col-12 col-md-7 col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h1 class="dashboard-title m-0">Executive Monitoring Dashboard</h1>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2">
                        <i class="bi bi-shield-check me-1"></i> Official Simulation
                    </span>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3 text-muted" style="font-size: 0.78rem;">
                    <span id="headerSubtext">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i><strong>AOI:</strong> Merauke Cluster 3 — Spatial Policy, Environmental Risk & Carbon Intelligence
                    </span>
                    <span class="d-none d-sm-inline">•</span>
                    <span class="d-flex align-items-center gap-1">
                        <span class="status-dot bg-success"></span> Satellite Feed: Active
                    </span>
                    <span class="d-none d-sm-inline">•</span>
                    <span><i class="bi bi-clock-history me-1"></i>Last Sync: 12 Aug 2026, 14:35 WIB</span>
                </div>
            </div>

            <!-- Right: Quick Filters & Actions -->
            <div class="col-12 col-md-5 col-lg-4">
                <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                    <!-- AOI Selector -->
                    <div class="input-group input-group-sm" style="width: 175px;">
                        <label class="input-group-text bg-light text-muted border-end-0" for="aoiSelect">
                            <i class="bi bi-crosshair"></i>
                        </label>
                        <select class="form-select border-start-0 ps-0" id="aoiSelect" aria-label="Select Area of Interest">
                            <option value="cluster-3" selected>Merauke Cluster 3</option>
                            <option value="cluster-1">Merauke Cluster 1 (North)</option>
                            <option value="cluster-2">Merauke Cluster 2 (Mappi)</option>
                            <option value="cluster-all">All Merauke Clusters</option>
                        </select>
                    </div>

                    <!-- Period Selector -->
                    <div class="input-group input-group-sm" style="width: 135px;">
                        <label class="input-group-text bg-light text-muted border-end-0" for="periodSelect">
                            <i class="bi bi-calendar3"></i>
                        </label>
                        <select class="form-select border-start-0 ps-0" id="periodSelect" aria-label="Select Period">
                            <option value="2023-2026" selected>2023 – 2026</option>
                            <option value="2020-2023">2020 – 2023</option>
                            <option value="2023-2035">2023 – 2035 (Proj)</option>
                        </select>
                    </div>

                    <!-- Export Button -->
                    <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 px-2.5" id="btnExportReport" title="Export Analytical Briefing Report">
                        <i class="bi bi-download"></i>
                        <span>Export Report</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
