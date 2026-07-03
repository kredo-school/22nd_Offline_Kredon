<div class="card hs-faq-card">

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

                    <button class="accordion-button collapsed hs-faq-button"
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

                                <div class="accordion-item border-0 hs-faq-item">

                                    <h2 class="accordion-header">

                                        <button class="accordion-button collapsed hs-faq-question"
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

                                            {!! nl2br(e($faq->displayAnswer())) !!}

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
