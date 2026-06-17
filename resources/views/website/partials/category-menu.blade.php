<div class="relative z-10 block w-full">
    <div class="container max-w-full 2xl:mx-auto">
        <div class="slider w-full p-0 lg:p-2 xl:p-3 lg:border-y lg:border-black/20 bg-white">
            <div class="w-full flex flex-col lg:flex-row justify-between xl:justify-left lg:items-center cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="relative inline-block z-30 bg-white">
                        <button id="category-btn" type="button"
                            class="lg:min-w-[170px] lg:h-[50px] p-0 lg:p-[15px] hidden lg:flex items-center gap-4 lg:border lg:border-black/20 lg:rounded-xxl">All
                            Categories
                            <span>
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.75 7.125L9.5 11.875L14.25 7.125" stroke="black" stroke-width="1.58333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>

                        <div id="category-dropdown"
                            class="z-80 w-3/5 md:w-2/5 lg:w-screen lg:origin-top lg:flex-1 flex lg:flex flex-col lg:flex-row items-start gap-6 lg:opacity-100 bg-white">
                            <div class="w-full h-full lg:h-auto lg:w-screen bg-white">
                                <div class="vertical-tabs" id="vertical-menu-1">

                                    {{-- LEFT MASTER CATEGORY TABS --}}
                                    <ul class="vertical-list" role="tablist">
                                        @foreach ($categoryChain as $master)
                                            <li role="tab" data-tab="{{ $master['slug'] }}">
                                                {{ $master['name'] }}
                                            </li>
                                        @endforeach
                                    </ul>

                                    {{-- RIGHT PANEL CONTENT --}}
                                    <div class="tab-content">
                                        @foreach ($categoryChain as $master)
                                            <div role="tabpanel" data-tab-panel="{{ $master['slug'] }}">
                                                <button class="panel-back">← Back</button>

                                                <ul class="category-title">

                                                    @foreach ($master['sections'] as $section)
                                                        {{-- SECTION TITLE --}}
                                                        <li>
                                                            <h4>{{ $section['name'] }}</h4>
                                                        </li>

                                                        {{-- SECTION CATEGORIES --}}
                                                        @foreach ($section['categories'] as $category)
                                                            <li>
                                                                <a href="{{ route('category.show', [
                                                                    'master' => $master['slug'],
                                                                    'sectionType' => $section['slug'],
                                                                    'category' => $category['slug'],
                                                                ]) }}"
                                                                    class="inline-flex gap-4">
                                                                    <span>{{ $category['name'] }}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endforeach

                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-transparent hidden lg:flex w-full items-center justify-evenly cursor-pointer"
                    id="category-sidebar">
                    {{-- <div class="all-categories">

                        <ul class="category-tabs" role="tablist">
                            @foreach ($categoryChain->take(7) as $master)
                                <li class="{{ $loop->first ? 'megamenu-list' : '' }}" role="tab"
                                    id="{{ $master['slug'] }}-tab" aria-selected="false"
                                    aria-controls="{{ $master['slug'] }}-panel"
                                    tabindex="{{ $loop->first ? '0' : '-1' }}">
                                    {{ $master['name'] }}
                                </li>
                            @endforeach

                            <span class="tab-underline"></span>
                        </ul>

                        <div class="category-content">

                            @foreach ($categoryChain->take(7) as $master)
                                <div role="tabpanel" id="{{ $master['slug'] }}-panel"
                                    aria-labelledby="{{ $master['slug'] }}-tab" hidden>
                                    <ul class="category-title">

                                        @foreach ($master['sections'] as $section)
                                            <li>
                                                <h4>{{ $section['name'] }}</h4>
                                            </li>

                                            @foreach ($section['categories'] as $category)
                                                <li>{{ $category['name'] }}</li>
                                            @endforeach
                                        @endforeach

                                    </ul>
                                </div>
                            @endforeach

                        </div>
                    </div> --}}


                    <div class="all-categories">

                        {{-- MASTER CATEGORY TABS --}}
                        <ul class="category-tabs" role="tablist">
                            @foreach ($categoryChain->take(7) as $master)
                                <li class="{{ $loop->first ? 'megamenu-list' : '' }}" role="tab"
                                    id="{{ $master['slug'] }}-tab" aria-selected="false"
                                    aria-controls="{{ $master['slug'] }}-panel"
                                    tabindex="{{ $loop->first ? '0' : '-1' }}">
                                    {{ $master['name'] }}
                                </li>
                            @endforeach

                            <span class="tab-underline"></span>
                        </ul>

                        {{-- PANELS --}}
                        <div class="category-content">

                            @foreach ($categoryChain->take(7) as $master)
                                <div role="tabpanel" id="{{ $master['slug'] }}-panel"
                                    aria-labelledby="{{ $master['slug'] }}-tab" hidden>

                                    <ul class="category-title">

                                        @foreach ($master['sections'] as $section)
                                            {{-- 🔒 SECTION BLOCK (UNBREAKABLE) --}}
                                            <li>
                                                <h4>{{ $section['name'] }}</h4>
                                            </li>
                                                    @foreach ($section['categories'] as $category)
                                                        <li>
                                                            <a href="{{ route('category.show', [
                                                                'master' => $master['slug'],
                                                                'sectionType' => $section['slug'],
                                                                'category' => $category['slug'],
                                                            ]) }}"
                                                                class="inline-flex gap-4">
                                                                <span>{{ $category['name'] }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
