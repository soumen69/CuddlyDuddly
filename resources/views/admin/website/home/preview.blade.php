<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Frontend CSS ONLY --}}
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">

    <style>
        body {
            margin: 0;
            background: #ffffff;
        }

        /* Prevent interactions */
        * {
            pointer-events: none;
        }
        html{
            overflow-x: inherit;
        }
    </style>
</head>

<body>

    @include($view, [
        'data' => (array) $section->data,
        'preview' => true,
        'isPreview' => true,
    ])

</body>

</html>
