<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Site Under Maintenance</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #eef1f6;
            color: #333;
            font-family: "Inter", Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .wrapper {
            background: #fff;
            width: 100%;
            max-width: 520px;
            border-radius: 12px;
            padding: 45px 35px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .icon {
            font-size: 60px;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #2d2f33;
        }

        .subtitle {
            font-size: 15px;
            color: #6c757d;
            margin-bottom: 22px;
            line-height: 1.55;
        }

        .note {
            font-size: 13px;
            color: #8f9baa;
            margin-top: 25px;
            line-height: 1.45;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="icon">🛠️</div>
        <h1>Maintenance Mode</h1>
        {{-- Admin configurable message --}}
        @if (!empty($message))
            <div class="subtitle">{{ $message }}</div>
        @else
            <div class="subtitle">
                We are performing scheduled upgrades to improve your experience.
                Please check back again soon.
            </div>
        @endif
        <div class="note">
            Thank you for your patience and understanding.<br>
            — Team CuddlyDuddly
        </div>
    </div>
</body>

</html>
