@include('includes.head')
<body>
    <div class="container">
        <aside>
        @include('includes.topbar')
            <!-- end top -->
            @include('includes.sidebar')
        </aside>
        {{ $slot }}
    </div>
@include('includes.script')
</body>

</html>
