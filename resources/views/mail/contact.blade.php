<body>
    <article>
        <h1>{{ config('app.name')}} - Contatto</h1>
        <div>
            <p>
                {{ $data['message'] }}
            </p>
            <p>&mdash; {{ $data['email'] }} ({{ $data['name'] }})</p>
        </div>
    </article>
</body>