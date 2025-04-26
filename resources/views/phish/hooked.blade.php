<x-layout
    :metaTitle="$email->campaign->hooked_title"
>
    <section class="section pt-0 is-inverted">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5 has-text-centered">
                    <img
                        src="{{ asset('images/hooked.png') }}"
                        width="500"
                        height="500"
                        alt=""
                        data-aos="fade-down"
                        data-aos-duration="1000"
                    />

                    @isset($email->campaign->hooked_title)
                        <h1 class="title is-1">
                            {{ $email->campaign->hooked_title }}
                        </h1>
                    @endisset

                    @isset($email->campaign->hooked_body)
                        <div class="block">
                            {!! $email->campaign->hooked_body !!}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </section>

    <footer class="section">
        <div class="content is-size-7 has-text-centered">
            <a href="{{ config('app.url') }}">
                {{ __("This phishing awareness campaign is powered by Rockphish") }}
            </a>
        </div>
    </footer>
</x-layout>
