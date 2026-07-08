<div class="card hs-faq-card" id="hs-faq-section">

    <div class="card-header hs-faq-header">

        <h5 class="fw-bold mb-0">
            {{ __('healthcare.faq.title') }}
        </h5>

    </div>

    <div class="accordion accordion-flush"
         id="hsSituationAccordion">

        @forelse($faqCategories as $category)

            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button hs-faq-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#category{{ $category->id }}"
                            aria-expanded="false"
                            aria-controls="category{{ $category->id }}">

                        <i class="{{ $category->icon_class }} me-2"></i>

                        {{ $category->displayName() }}

                    </button>

                </h2>

                <div id="category{{ $category->id }}"
                     class="accordion-collapse collapse"
                     data-bs-parent="#hsSituationAccordion">

                    <div class="accordion-body p-0">

                        <div class="accordion accordion-flush"
                             id="faqAccordion{{ $category->id }}">

                            @foreach($category->faqs as $faq)

                                @php
                                    $isEmergencyPhraseFaq = $category->slug === 'emergency' && $faq->sort_order === 1;
                                @endphp

                                <div @class([
                                    'accordion-item border-0 hs-faq-item',
                                    'hs-faq-item--emergency-phrases' => $isEmergencyPhraseFaq,
                                ])
                                     @if($isEmergencyPhraseFaq)
                                         id="hs-emergency-phrases"
                                         data-hs-category-collapse="#category{{ $category->id }}"
                                         data-hs-faq-collapse="#faq{{ $faq->id }}"
                                     @endif
                                >

                                    <h2 class="accordion-header">

                                        <button class="accordion-button hs-faq-question collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#faq{{ $faq->id }}"
                                                aria-expanded="false"
                                                aria-controls="faq{{ $faq->id }}">

                                            {{ $faq->displayQuestion() }}

                                        </button>

                                    </h2>

                                    <div id="faq{{ $faq->id }}"
                                         class="accordion-collapse collapse"
                                         data-bs-parent="#faqAccordion{{ $category->id }}">

                                        <div class="accordion-body hs-faq-answer">

                                            @if($isEmergencyPhraseFaq)
                                                @if(app()->getLocale() === 'en')
                                                    {!! nl2br(e($faq->displayAnswer())) !!}
                                                @else
                                                <div class="hs-emergency-phrases">
                                                    @foreach($faq->emergencyPhraseItems() as $item)
                                                        @if($item['type'] === 'heading')
                                                            <p class="hs-emergency-phrases__heading">{{ $item['text'] }}</p>
                                                        @else
                                                            <div class="hs-emergency-phrase">
                                                                <p class="hs-emergency-phrase__ja">
                                                                    <span class="hs-emergency-phrase__number">{{ $item['number'] }}.</span>{{ $item['ja'] }}
                                                                </p>
                                                                <p class="hs-emergency-phrase__en">{{ $item['en'] }}</p>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @endif
                                            @else
                                                {!! nl2br(e($faq->displayAnswer())) !!}
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="p-3 text-muted">

                {{ __('healthcare.faq.empty') }}

            </div>

        @endforelse

    </div>

</div>
