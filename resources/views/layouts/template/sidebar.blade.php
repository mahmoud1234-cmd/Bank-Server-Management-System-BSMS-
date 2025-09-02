<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">BSMS</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('servers.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-server"></i>
                        <p>Serveurs</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <li class="nav-item">
    <a class="nav-link" href="{{ route('clusters.index') }}">
        <i class="fas fa-server"></i> Cluster Management
    </a>
</li>


</aside>
