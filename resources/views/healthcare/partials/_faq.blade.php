<div class="card hs-faq-card">

    <div class="card-header hs-faq-header">

        <h5 class="fw-bold mb-0">
            よくある状況
        </h5>

    </div>

    <div class="accordion accordion-flush"
         id="hsSituationAccordion">

        @forelse($faqCategories as $category)

            <div class="accordion-item">

                {{-- カテゴリ --}}
                <h2 class="accordion-header">

                    <button class="accordion-button collapsed hs-faq-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#category{{ $category->id }}"
                            aria-expanded="false"
                            aria-controls="category{{ $category->id }}">

                        <i class="{{ $category->icon_class }} me-2"></i>

                        {{ $category->name }}

                    </button>

                </h2>

                {{-- カテゴリ内容 --}}
                <div id="category{{ $category->id }}"
                     class="accordion-collapse collapse"
                     data-bs-parent="#hsSituationAccordion">

                    <div class="accordion-body p-0">

                        {{-- FAQ一覧 --}}
                        <div class="accordion accordion-flush"
                             id="faqAccordion{{ $category->id }}">

                            @foreach($category->faqs as $faq)

                                <div class="accordion-item border-0 hs-faq-item">

                                    {{-- 質問 --}}
                                    <h2 class="accordion-header">

                                        <button class="accordion-button collapsed hs-faq-question"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#faq{{ $faq->id }}"
                                                aria-expanded="false"
                                                aria-controls="faq{{ $faq->id }}">

                                            {{ $faq->question }}

                                        </button>

                                    </h2>

                                    {{-- 回答 --}}
                                    <div id="faq{{ $faq->id }}"
                                         class="accordion-collapse collapse"
                                         data-bs-parent="#faqAccordion{{ $category->id }}">

                                        <div class="accordion-body hs-faq-answer">

                                            {!! nl2br(e($faq->answer)) !!}

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

                状況データがありません

            </div>

        @endforelse

    </div>

</div>