<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactMessageController extends Controller
{
    /**
     * Store a message submitted through the public contact form.
     */
    public function store(Request $request)
    {
        $key = 'contact-form:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'message' => 'Too many messages have been submitted. Please try again later.',
            ], 429);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'unread',
        ]);

        RateLimiter::hit($key, 60);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully.',
            'id' => $contactMessage->id,
        ], 201);
    }

    /**
     * Display the contact message inbox.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Optional inbox filters.
        if ($request->filled('status') &&
            in_array($request->status, ['read', 'unread'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(15)->withQueryString();

        $totalMessages = ContactMessage::count();

        $unreadCount = ContactMessage::where('status', 'unread')->count();

        $readCount = ContactMessage::where('status', 'read')->count();

        return view('contact-messages.index', compact(
            'messages',
            'totalMessages',
            'unreadCount',
            'readCount'
        ));
    }

    /**
     * Display a single message and mark it as read.
     */
    public function show(ContactMessage $contactMessage)
    {
        if (($contactMessage->status ?? 'unread') !== 'read') {
            $contactMessage->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }

        return view('contact-messages.show', compact('contactMessage'));
    }

    /**
     * Mark a message as read.
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->update([
            'status' => 'read',
            'read_at' => now(),
        ]);

        return back()->with('success', 'Message marked as read.');
    }

    /**
     * Mark a message as unread.
     */
    public function markAsUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update([
            'status' => 'unread',
            'read_at' => null,
        ]);

        return back()->with('success', 'Message marked as unread.');
    }

    /**
     * Delete a contact message.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}