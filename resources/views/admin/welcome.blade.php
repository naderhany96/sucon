<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="favicon.ico">
  <title>Sucon</title>
  <meta content="" name="description" />
</head>
<body>
  <noscript>
    <strong>We're sorry but website doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
  </noscript>
  <div id="app"></div>
  <!-- built files will be auto injected -->
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
