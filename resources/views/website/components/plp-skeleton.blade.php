<div class="grid grid-cols-2 lg:grid-cols-3 gap-y-(--margin-sm) gap-3 md:gap-5">

    @for ($i = 1; $i <= 6; $i++)
        <div class="flex flex-col animate-pulse">

            {{-- IMAGE --}}
            <div
                class="relative overflow-hidden rounded-[18px] md:rounded-block border border-slate-100 bg-slate-100 aspect-square">

                <div
                    class="absolute inset-0 -translate-x-full animate-[skeleton_1.8s_infinite] bg-gradient-to-r from-transparent via-white/70 to-transparent">
                </div>

            </div>

            {{-- TITLE --}}
            <div class="mt-4 space-y-2">

                <div class="h-4 rounded-full bg-slate-200 w-[85%] relative overflow-hidden">
                    <div
                        class="absolute inset-0 -translate-x-full animate-[skeleton_1.8s_infinite] bg-gradient-to-r from-transparent via-white/70 to-transparent">
                    </div>
                </div>

                <div class="h-3 rounded-full bg-slate-100 w-full relative overflow-hidden">
                    <div
                        class="absolute inset-0 -translate-x-full animate-[skeleton_1.8s_infinite] bg-gradient-to-r from-transparent via-white/70 to-transparent">
                    </div>
                </div>

                <div class="h-3 rounded-full bg-slate-100 w-[65%] relative overflow-hidden">
                    <div
                        class="absolute inset-0 -translate-x-full animate-[skeleton_1.8s_infinite] bg-gradient-to-r from-transparent via-white/70 to-transparent">
                    </div>
                </div>

            </div>

            {{-- PRICE --}}
            <div class="flex justify-between items-center mt-4">

                <div class="flex gap-2">

                    <div class="h-5 w-20 rounded-full bg-slate-200"></div>

                    <div class="h-4 w-14 rounded-full bg-slate-100"></div>

                </div>

                <div class="h-6 w-12 rounded-full bg-slate-200"></div>

            </div>

            {{-- COLOR SWATCHES --}}
            <div class="flex gap-2 mt-4">

                <div class="w-4 h-4 rounded-full bg-slate-200"></div>
                <div class="w-4 h-4 rounded-full bg-slate-200"></div>
                <div class="w-4 h-4 rounded-full bg-slate-200"></div>
                <div class="w-4 h-4 rounded-full bg-slate-200"></div>

            </div>

            {{-- BUTTON --}}
            <div class="mt-5 h-11 rounded-full bg-slate-200 relative overflow-hidden">

                <div
                    class="absolute inset-0 -translate-x-full animate-[skeleton_1.8s_infinite] bg-gradient-to-r from-transparent via-white/70 to-transparent">
                </div>

            </div>

        </div>
    @endfor

</div>

<style>
    @keyframes skeleton {
        100% {
            transform: translateX(250%);
        }
    }
</style>
