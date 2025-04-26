<x-layout
    :metaTitle="config('app.description')"
>
    <section class="section is-large">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5 has-text-centered">
                    <hgroup class="block">
                        <h1 class="title is-1">
                            <a href="{{ config('app.url') }}">
                                <img
                                    src="{{ asset('images/logo.png') }}"
                                    width="300"
                                    height="300"
                                    alt=""
                                />

                                <br />

                                {{ config('app.name') }}
                            </a>
                        </h1>

                        <h2>
                            {{ config('app.description') }}
                        </h2>
                    </hgroup>

                    <p class="block">
                        <a href="mailto:{{ $appEmail = config('app.email') }}">
                            {{ $appEmail }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layout>
