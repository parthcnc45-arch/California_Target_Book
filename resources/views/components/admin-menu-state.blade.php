<script>
(function () {
    try {
        var isAdminRoute = /^\/ctb-admin\/new\//.test(window.location.pathname);
        var adminOpen = isAdminRoute || localStorage.getItem('adminSettingsOpen') === 'true';

        if (adminOpen) {
            document.documentElement.classList.add('admin-settings-open');
            if (isAdminRoute) {
                localStorage.setItem('adminSettingsOpen', 'true');
            }
        }
    } catch (e) {}
})();
</script>
<style>
#admin-settings-menu {
    display: none;
}

html.admin-settings-open #user-nav-menu {
    display: none;
}

html.admin-settings-open #admin-settings-menu {
    display: block;
}

html.admin-settings-open #bottom-actions-menu {
    display: none;
}
</style>
