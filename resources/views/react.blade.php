<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @viteReactRefresh
    @vite(['resources/js/react.tsx', "resources/js/Pages/{$page['component']}.tsx"])
    @inertiaHead
    @routes
    <script>
        // detect dark mode
        if (window.localStorage.getItem('theme') == 'dark') {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

  </head>
  <body>
    @inertia
  </body>
</html>
