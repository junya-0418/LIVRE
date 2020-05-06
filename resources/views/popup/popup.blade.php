<span class="popup border p-2">
    <h3 class="h4 newbooks-book-title">
        @isset($book->title)
            <span>{{ $book->title  }}</span>
        @endisset
    </h3>
    <div class="newbooks-book-author">
        @isset($book->author1)
            <div>{{ $book->author1 }}</div>
        @endisset
        @isset($book->author2)
            <div>{{ $book->author2 }}</div>
        @endisset
        @isset($book->author3)
            <div>{{ $book->author3 }}</div>
        @endisset
        @isset($book->author4)
            <div>{{ $book->author4 }}</div>
        @endisset
        @isset($book->author5)
            <div>{{ $book->author5 }}</div>
        @endisset
    </div>
    <div class="card-text">
        @isset($book->description)
            <span>{{ $book->description  }}</span>
        @endisset
    </div>
</span>
