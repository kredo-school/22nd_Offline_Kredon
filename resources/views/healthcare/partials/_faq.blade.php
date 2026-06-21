<div class="card hs-faq-card">

    <div class="card-header fs-faq-header">

        <h5 class="fw-bold mb-0">
            よくある状況
        </h5>

    </div>

    <div class="accordion accordion-flush" 
         id="hsSituationAccordion">

         @forelse($faqCategories as $category)

            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed   hs-faq-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#category{{ $category->id }}">
                        <i class="{{ $category->icon_class}} me-2"></i>

                        {{ $category->name }}

                    </button>

                </h2>

                <div id="category{{ $category->id }}" 
                     class="accordion-collapse collapse"
                     data-bs-parent="#hsSituationAccordion">

                <div class="accordion-body">

                    @foreach($category->faqs as $faq)
                        
                        <div class="fs-faq-item">

                            <div class="fs-faq-question">

                                {{ $faq->question }}

                            </div>

                            <div class="fs-faq-answer">

                                {{ $faq->answer }}

                            </div>

                        </div>
                    @endforeach
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