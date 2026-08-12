<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Http\Resources\ContactMessageResource;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request)
    {
        $contactMessage = ContactMessage::create($request->validated());

        try {
            Mail::to(env('CONTACT_RECEIVER_EMAIL', config('mail.from.address')))
                ->send(new ContactMessageMail($contactMessage));

            $contactMessage->update([
                'status' => 'sent',
                'email_sent_at' => now(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Contact message submitted successfully and email sent.',
                'data' => new ContactMessageResource($contactMessage->refresh()),
            ], 201);
        } catch (Throwable $e) {
            Log::error('Contact email failed to send.', [
                'contact_message_id' => $contactMessage->id,
                'error' => $e->getMessage(),
            ]);

            $contactMessage->update([
                'status' => 'email_failed',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Message saved successfully, but email notification could not be sent at this time.',
                'data' => new ContactMessageResource($contactMessage->refresh()),
            ], 202);
        }
    }

    public function index()
    {
        $messages = ContactMessage::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Contact messages fetched successfully.',
            'data' => ContactMessageResource::collection($messages),
        ]);
    }

    public function show(ContactMessage $contactMessage)
    {
        return response()->json([
            'status' => true,
            'message' => 'Contact message fetched successfully.',
            'data' => new ContactMessageResource($contactMessage),
        ]);
    }
}
