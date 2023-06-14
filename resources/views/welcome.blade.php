<x-layout>
    <section class="section">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5 has-text-centered">
                    <h1 class="title is-1">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            width="670"
                            height="400"
                            alt=""
                        />

                        <br />

                        {{ config('app.name') }}
                    </h1>
                </div>
            </div>
        </div>
    </section>
</x-layout>
