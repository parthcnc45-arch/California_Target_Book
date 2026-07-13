<script>
    function toggleAdminSettings(show) {
        if (show) {
            document.documentElement.classList.add('admin-settings-open');
            localStorage.setItem('adminSettingsOpen', 'true');
        } else {
            document.documentElement.classList.remove('admin-settings-open');
            localStorage.setItem('adminSettingsOpen', 'false');
        }
    }

    function handleBackToMainMenu(event) {
        event.preventDefault();
        toggleAdminSettings(false);

        if (/^\/ctb-admin\/new\//.test(window.location.pathname)) {
            window.location.href = '/account/account-info';
        }
    }

    function openAdminSettings(event) {
        localStorage.setItem('adminSettingsOpen', 'true');
    }
</script>
