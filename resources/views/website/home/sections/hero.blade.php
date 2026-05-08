<div class="relative z-0 w-full pb-0 lg:pb-5 xl:pb-0 overflow-hidden">
    <div class="container max-w-container mx-auto">

        <div class="relative flex flex-col items-center lg:items-start gap-2 mb-lg px-5">
            <h1 class="font-nature font-medium heading leading-tight tracking-1 text-center md:text-left">
                <span class="iconone">{{ $data['heading']['iconone'] }}</span>
                <span class="icontwo"> {{ $data['heading']['icontwo'] }}</span>
                {{ $data['heading']['rest'] }}
            </h1>
            <p
                class="hidden sm:block relative lg:max-w-(--max-w-search) mx-auto md:mx-0 text-block mt-1 xl:mt-2.5 mb-2 xl:mb-3 font-medium text-center md:text-left hero-text">
                {!! nl2br(e($data['subheading'])) !!}
            </p>

            <a href="{{ $data['cta_url'] }}"
                class="hidden sm:inline-flex max-w-max max-h-(--max-h-review) mx-auto md:mx-0 btn-wrapper lg:py-5 cursor-pointer relative z-2">
                <span class="text-block font-medium">
                    {{ $data['cta_text'] }}
                </span>

                <div class="flex justify-center items-center cursor-pointer">
                    @foreach ($data['avatars'] as $index => $avatar)
                        <div class="max-w-24 h-14 {{ $index > 0 ? '-ml-14' : '' }} overflow-hidden rounded-4xl">
                            <img src="{{ asset($avatar) }}" alt="">
                        </div>
                    @endforeach
                </div>
            </a>
        </div>

        <div class="relative pt-[110px] lg:pt-20 hidden md:block">
            <div
                class="top block absolute z-50 top-0 lg:top-[16%] left-1/2 -translate-x-1/2
                       w-[60%] md:w-[80%] lg:w-[60%] h-[3%]">
            </div>
            <div class="relative z-1">
                <div class="absolute w-full flex items-center mx-auto mt-0">
                    <div class="inline-block mx-auto relative" style="animation: pulseZoom 3s linear infinite;">
                        <svg width="650" height="650" viewBox="0 0 650 650" fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-full opacity-full z-10 -mt-[110px] ml-0 lg:-ml-[23px] sm:mt-0 max-[480px]:max-w-72 max-w-[330px] sm:max-w-[550px]"
                            style="animation: pulseGlow 90s linear infinite;">
                            <path
                                d="M303.564 7.5158C315.851 -2.50527 333.491 -2.50527 345.776 7.5158L372.269 29.123C380.607 35.9215 391.708 38.2886 402.09 35.4817L435.004 26.5857C450.289 22.4544 466.372 29.6239 473.519 43.7526L489.071 74.508C493.913 84.079 503.053 90.7426 513.646 92.4207L547.472 97.7795C563.057 100.249 574.789 113.291 575.597 129.052L577.377 163.749C577.924 174.417 583.545 184.18 592.495 190.014L621.435 208.878C634.612 217.469 640.009 234.095 634.385 248.79L621.936 281.326C618.125 291.28 619.297 302.454 625.085 311.402L643.986 340.61C652.525 353.811 650.702 371.18 639.605 382.321L615.126 406.896C607.599 414.453 604.133 425.15 605.803 435.686L611.249 470.079C613.71 485.638 604.964 500.802 590.264 506.466L558.171 518.822C548.183 522.669 540.642 531.068 537.894 541.414L529.008 574.869C524.95 590.15 510.734 600.489 494.948 599.645L460.855 597.821C450.126 597.247 439.776 601.869 433.044 610.241L411.544 636.983C401.613 649.336 384.368 653.006 370.265 645.766L339.922 630.188C330.348 625.275 318.993 625.275 309.42 630.188L279.075 645.766C264.975 653.006 247.729 649.336 237.798 636.983L216.298 610.241C209.566 601.869 199.216 597.247 188.488 597.821L154.394 599.645C138.608 600.489 124.392 590.15 120.334 574.869L111.447 541.414C108.699 531.068 101.16 522.669 91.1712 518.822L59.0784 506.466C44.3763 500.802 35.6305 485.638 38.0943 470.079L43.54 435.686C45.2081 425.15 41.7431 414.453 34.2155 406.896L9.73596 382.321C-1.35962 371.18 -3.18312 353.811 5.35726 340.61L24.2555 311.402C30.0452 302.454 31.2157 291.28 27.4066 281.326L14.9554 248.79C9.33218 234.095 14.7281 217.469 27.9086 208.878L56.8486 190.014C65.7977 184.18 71.4161 174.417 71.9634 163.749L73.7441 129.052C74.5529 113.291 86.2832 100.249 101.87 97.7795L135.695 92.4207C146.288 90.7426 155.43 84.079 160.271 74.508L175.824 43.7526C182.969 29.6239 199.054 22.4544 214.339 26.5857L247.251 35.4817C257.635 38.2886 268.736 35.9215 277.072 29.123L303.564 7.5158Z"
                                fill="#FDF2FC" />
                        </svg>
                    </div>
                </div>

                <div class="relative z-10 mx-auto -mt-[185px] lg:-mt-[292px] xl:-mt-[280px]">

                    <div style="background-image:url('{{ asset($data['throne_image']) }}')"
                        class="bg-no-repeat bg-center w-0 lg:w-full h-[75px] absolute -right-[213px] top-[100px] z-20">
                    </div>

                    <img src="{{ asset($data['hero_image']) }}" alt="mother and child"
                        class="max-w-72 sm:max-w-[410px] md:max-w-[512px] lg:max-w-[520px] xl:max-w-[620px] mx-auto">
                </div>
            </div>


        </div>
        <div class="gradient-block hidden md:block">
            <div
                class="bottom hidden lg:block absolute z-55 -top-[32px] -translate-y-1/2
                       left-1/2 -translate-x-1/2
                       w-[80%] lg:w-[56%] h-[3%] lg:h-[48%]">
            </div>

        </div>
    </div>
    <img src="{{ asset($data['pattern_image']) }}" alt="hero wave img"
        class=" hidden md:block absolute top-[61%] md:top-[50%] right-0 w-full max-h-[230px] opacity-[0.75]">
</div>
