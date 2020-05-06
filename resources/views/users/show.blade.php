@extends('index')

@section('title', 'user')

@section('content')
    <div class="container user-main">
        <div style="display:flex;">
            <div class="d-flex flex-row">
                <a href="{{ route('users.show', ['id' => $user->id]) }}" class="text-dark">
                    <i class="fas fa-user-circle fa-3x"></i>
                </a>
            </div>
            <h2 class="h4 card-title ml-2 user-name">
                <a href="{{ route('users.show', ['id' => $user->id]) }}" class="text-dark">
                    {{ $user->name }}
                </a>
            </h2>
        </div>

        <div>
            <follow-button class="ml-auto"
           :initial-is-followed-by='@json($user->isFollowedBy(Auth::user()))'
           :authorized='@json(Auth::check())'
           :display-button='@json($display_follow_button)'
           :followings-counts="@json($followingsCounts)"
           :followers-counts="@json($followersCounts)"
           endpoint="{{ route('users.follow', ['id' => $user->id]) }}">
            </follow-button>
        </div>

        <h3 class="want-books-title"><strong>読みたい本</strong></h3>
        <div class="border border-dark">
        <ul class="slider" style="padding-left: 0px !important; z-index: 1050;">
        @foreach($WantToReadBooks as $wantbook)

            <div class="mt-3 new-books-card">
                <div class="d-flex flex-row">
                    <div class="font-weight-lighter">
                        @isset($wantbook->imageLinks)
                            <div>
                                <li><img class="card-img img-size" src="{{ $wantbook->imageLinks }}" /></li>
                                <div data-target="#modal-detail-{{ $wantbook->id }}" data-toggle="modal" data-backdrop="true">
                                    <button type="button" class="btn btn-sm btn-primary">詳細を見る</button>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>

                @include('popup.wantbook_popup')
                <!-- modal -->
                <div id="modal-delete-{{ $wantbook->id }}" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('delete', ['id' => $wantbook->id]) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    {{ $wantbook->title }}を削除します。よろしいですか？
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                                    <button type="submit" class="btn btn-danger">削除する</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- modal -->
            </div>
        @endforeach
        </ul>
        </div>

        <h3 class="read-books-title"><strong>読んだ本</strong></h3>
        <div class="border border-dark">
        <ul class="slider" style="padding-left: 0px !important;">
            @foreach($ReadBooks as $readbook)

                <div class="mt-3 new-books-card">
                    <form action="{{ route('update', ['id' => $readbook->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex flex-row">
                            <div class="font-weight-lighter">
                                @isset($readbook->imageLinks)
                                    <div>
                                        <img class="card-img img-size" src="{{ $readbook->imageLinks }}" />
                                        <button class="btn btn-sm btn-primary">詳細を見る</button>
{{--                                        @include('popup.readbook_popup')--}}
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </ul>
        </div>

    </div>
@endsection
