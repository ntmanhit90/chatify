<?php

namespace Chatify\Http\Controllers;

use Chatify\Models\ChConversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\ChConversation as Conversation;
use App\Models\ChConversationUser as ConversationUser;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use App\Models\Batch;
class ConversationController extends Controller
{
    protected $perPage = 30;

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $rows = ChConversation::where([
            'ch_conversation_users.user_id' => $user_id,
        ])
            ->join('ch_conversation_users', 'ch_conversations.id', '=', 'ch_conversation_users.conversation_id')
            ->orderBy('ch_conversations.last_message_datetime', 'DESC')
            ->paginate($request->per_page ?? $this->perPage);

        if ($rows->count() > 0) {
            $user = Auth::user();
            $contacts = '';
            foreach ($rows->items() as $row) {
                $contacts .= Chatify::getContactItem($user, $row);
            }
        } else {
            $contacts = '<p class="message-hint center-el"><span>The conversation list is empty</span></p>';
        }

        return Response::json([
            'contacts' => $contacts,
            'total' => $rows->total() ?? 0,
            'last_page' => $rows->lastPage() ?? 1,
        ], 200);
    }

    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:ch_conversations',
            'batch_id' => 'required|integer|min:1',
            'tx_id' => 'nullable'
        ], [
            'name.required' => __('Please give a conversation name')
        ]);

        $batch_id = $request->get('batch_id');
        $batch = Batch::find($batch_id);
        if ($batch) {
            // Create Conversation
            $conv = Chatify::newConversation([
                'name' => $request->get('name'),
                'batch_id' => $request->get('batch_id'),
                'tx_id' => $request->get('tx_id'),
            ]);

            $user_id = Auth::user()->id;
            Chatify::newConversationUser([
                'conversation_id' => $conv->id,
                'user_id' => $user_id
            ]);

            if ($batch->created_by != $user_id) {
                Chatify::newConversationUser([
                    'conversation_id' => $conv->id,
                    'user_id' => $batch->created_by
                ]);
            }

            // Check for ADMIN
            if ($user_id != 1) {
                Chatify::newConversationUser([
                    'conversation_id' => $conv->id,
                    'user_id' => 1
                ]);
            }

            // send the response
            return Response::json([
                'status' => '200',
                'conversation' => $conv
            ]);
        }

        // send the response
        return Response::json([
            'status' => '404',
            'message' => __('Batch is not found')
        ]);
    }

    public function view(Request $request, ChConversation $conversation)
    {
        return Response::json([
            'fetch' => true,
            'conversation' => $conversation,
        ]);
    }
}
