<x-mail::message>
    # Server Error Occurred

    **Error Message:**
    {{ $errorMessage }}

    **Request Details:**
    - **URL:** {{ $url }}
    - **Method:** {{ $method }}
    - **IP:** {{ $ip }}

    **Stack Trace Snippet:**
    ```text
    {{ $stackTrace }}
    ```

    Thanks,
    {{ config('app.name') }}
</x-mail::message>