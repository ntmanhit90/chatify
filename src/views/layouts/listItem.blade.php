{{-- -------------------- Conversation list -------------------- --}}
@if($get == 'conv')
        <?php
        if (!empty($lastMessage)) {
            $lastMessageBody = mb_convert_encoding($lastMessage->body, 'UTF-8', 'UTF-8');
            $lastMessageBody = strlen($lastMessageBody) > 30 ? mb_substr($lastMessageBody, 0, 30, 'UTF-8').'..' : $lastMessageBody;
        }
        ?>
    <table class="messenger-list-item" data-contact="{{ $conversation->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td style="position: relative">
            <span class="conv-icon uppercase">
                {{ trim(substr($conversation->name,0,2)) }}
            </span>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ $conversation->id }}" data-type="user">
                    {{ $conversation->name }}
                    @if(!empty($lastMessage))
                        <span class="contact-item-time" data-time="{{$lastMessage->created_at}}">{{ $lastMessage->timeAgo }}</span>
                    @endif
                </p>
                @if(!empty($lastMessage))
                    <span>
                    {{-- Last message body --}}
                        @if($lastMessage->attachment == null)
                            {!!
                                $lastMessageBody
                            !!}
                        @else
                            <span class="fas fa-file"></span> Attachment
                        @endif
                </span>
                @endif
                {{-- New messages counter --}}
                {!! $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : '' !!}
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if($get == 'search_item')
    <table class="messenger-list-item" data-contact="{{ $user->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
                <div class="avatar av-m"
                     style="background-image: url('{{ $user->avatar }}');">
                </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ $user->id }}" data-type="user">
                {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }}
            </td>

        </tr>
    </table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if($get == 'sharedPhoto')
    <div class="shared-photo chat-image" style="background-image: url('{{ $image }}')"></div>
@endif
