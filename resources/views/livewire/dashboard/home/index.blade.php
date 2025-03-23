<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 my-4">
    <div class="col">
        <div class="overview-card overview-card-blue">
            <div class="flex items-center justify-between">
                <div>
                    <div class="overview-card-title">{{ __('Users') }}</div>
                    <div class="overview-card-number">{{ $usersCount }}</div>
                </div>
                <div>
                    <i class="icon bi-people-fill overview-card-icon"></i>
                </div>
            </div>
        </div>
    </div><!-- col -->
    <div class="col">
        <div class="overview-card overview-card-green">
            <div class="flex items-center justify-between">
                <div>
                    <div class="overview-card-title">{{ __('Views today') }}</div>
                    <div class="overview-card-number">{{ $viewsToday }}</div>
                </div>
                <div>
                    <i class="icon bi-eye overview-card-icon"></i>
                </div>
            </div>
        </div>
    </div><!-- col -->
    <!-- Users -->
    <div class="col">
        <div class="overview-card overview-card-yellow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="overview-card-title">{{ __('Last 30 days') }}</div>
                    <div class="overview-card-number">{{ $viewsMonth }}</div>
                </div>
                <div>
                    <i class="icon bi-calendar overview-card-icon"></i>
                </div>
            </div>
        </div>
    </div><!-- col -->
    <!-- Users -->
    <div class="col">
        <div class="card overview-card overview-card-cyan">
            <div class="flex items-center justify-between">
                <div>
                    <div class="overview-card-title">{{ __('All time') }}</div>
                    <div class="overview-card-number">{{ $viewsAll }}</div>
                </div>
                <div>
                    <i class="icon bi-infinity overview-card-icon"></i>
                </div>
            </div>
        </div>
    </div><!-- col -->
</div>
