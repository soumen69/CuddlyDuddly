{{-- using Tailwind CSS --}}

<div class="grid grid-cols-2 lg:grid-cols-3 gap-5 animate-pulse">

    @for ($i = 0; $i < 6; $i++)
        <div class="flex flex-col">

            <div class="aspect-square rounded-2xl bg-gray-200"></div>

            <div class="h-4 bg-gray-200 rounded mt-4 w-3/4"></div>

            <div class="h-3 bg-gray-100 rounded mt-2 w-full"></div>

            <div class="h-3 bg-gray-100 rounded mt-2 w-2/3"></div>

            <div class="h-5 bg-gray-200 rounded mt-4 w-1/3"></div>

        </div>
    @endfor

</div>



{{-- using pati CSS --}}



{{-- <style>
    .dot-loader-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        min-height: 200px;
    }

    .dot-loader {
        position: relative;
        width: 60px;
        height: 60px;
    }

    .dot-loader span {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        animation: bounce 1.2s infinite ease-in-out both;
    }

    .dot-loader span:nth-child(1) {
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        background: #ff4d6d;
        animation-delay: -1.1s;
    }

    .dot-loader span:nth-child(2) {
        top: 14%;
        right: 0;
        background: #4361ee;
        animation-delay: -1s;
    }

    .dot-loader span:nth-child(3) {
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        background: #f4a261;
        animation-delay: -0.9s;
    }

    .dot-loader span:nth-child(4) {
        bottom: 14%;
        right: 0;
        background: #2a9d8f;
        animation-delay: -0.8s;
    }

    .dot-loader span:nth-child(5) {
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        background: #9d4edd;
        animation-delay: -0.7s;
    }

    .dot-loader span:nth-child(6) {
        bottom: 14%;
        left: 0;
        background: #e63946;
        animation-delay: -0.6s;
    }

    .dot-loader span:nth-child(7) {
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        background: #00b4d8;
        animation-delay: -0.5s;
    }

    .dot-loader span:nth-child(8) {
        top: 14%;
        left: 0;
        background: #ffbe0b;
        animation-delay: -0.4s;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0.5);
            opacity: 0.5;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<div class="dot-loader-wrapper">
    <div class="dot-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div> --}}
