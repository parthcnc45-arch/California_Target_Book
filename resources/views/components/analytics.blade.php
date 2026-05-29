
@if (env('APP_ENV') !== 'production')
    <script>window['ga-disable-UA-56541916-3'] = true;</script>
@endif

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56541916-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-56541916-3', {
    'user_id': String({{ Auth::id() }}),
    custom_map: {
      'dimension1': 'company',
      'dimension2': 'book_category',
      'dimension3': 'is_admin',
      'dimension4': 'user',
    },
  });

  @if ( Auth::id() )
  gtag('set', {
    'user': String({{ Auth::id() }}),
    'company': String({{ Auth::user()->company_id }}),
    'is_admin': Boolean({{ Auth::user()->isAdmin() }}),
  });
  @endif

</script>

