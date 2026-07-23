<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logging out...</title>
    <script>
        try {
            localStorage.clear();
        } catch (e) {
            console.error('Failed to clear localStorage:', e);
        }
        window.location.href = "{{ route('home') }}";
    </script>
</head>
<body>
</body>
</html>
