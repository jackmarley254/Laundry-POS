{{-- resources/views/contact-messages/index.blade.php --}}
<x-layout>
@section('title', 'Customer Messages')
@section('content')
@php
    $unreadCount = $unreadCount ?? \App\Models\ContactMessage::where('status', 'unread')->count();
    $totalMessages = $totalMessages ?? \App\Models\ContactMessage::count();
@endphp
<style>
.messages-hero{background:linear-gradient(135deg,#071a33,#0b3970,#0d6efd);color:#fff;border-radius:20px;padding:26px;margin-bottom:22px}
.messages-hero h2{font-weight:800}.messages-hero p{color:#dbeafe;margin-bottom:0}
.msg-stat,.msg-panel{background:#fff;border:1px solid #e5eaf1;border-radius:16px;box-shadow:0 6px 22px #0f172a08}
.msg-stat{padding:20px}.msg-stat i{font-size:1.3rem;color:#0d6efd}.msg-number{font-size:1.7rem;font-weight:800;margin:10px 0 0}.msg-label{color:#718096;font-size:.8rem}
.msg-panel{overflow:hidden}.msg-panel-head{padding:20px;border-bottom:1px solid #e5eaf1;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}
.msg-table th{background:#f8faff;color:#718096;font-size:.7rem;text-transform:uppercase;letter-spacing:.6px;white-space:nowrap}
.msg-table th,.msg-table td{padding:15px 17px;vertical-align:middle;border-color:#edf1f6}.msg-table tr.unread{background:#f5f9ff}
.msg-subject{font-weight:700;color:#14213d}.msg-preview{color:#718096;font-size:.78rem;margin-top:4px;max-width:420px}
.msg-status{border-radius:30px;padding:6px 10px;font-size:.7rem;font-weight:750}.msg-status.unread{background:#fff0f0;color:#c62828}.msg-status.read{background:#eaf8ef;color:#15803d}
.msg-open{display:inline-flex;width:36px;height:36px;align-items:center;justify-content:center;border-radius:10px;background:#eaf3ff;color:#0d6efd}
.msg-empty{text-align:center;padding:55px 20px;color:#718096}.msg-empty i{font-size:2rem;color:#0d6efd}
@media(max-width:767px){.msg-table thead{display:none}.msg-table,.msg-table tbody,.msg-table tr,.msg-table td{display:block;width:100%}.msg-table tbody tr{padding:10px;border-bottom:1px solid #edf1f6}.msg-table td{padding:7px;border:0}.messages-hero{padding:20px}}
</style>
<div class="messages-hero">
 <div class="small text-uppercase fw-bold mb-2" style="letter-spacing:1px;color:#bfdbfe">Customer Support Centre</div>
 <h2><i class="bi bi-envelope-paper-fill me-2"></i>Customer Messages</h2>
 <p>Read and manage messages submitted through the SmartWash website contact form.</p>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<div class="row g-3 mb-4">
 <div class="col-12 col-sm-6 col-xl-4"><div class="msg-stat"><i class="bi bi-envelope"></i><div class="msg-number">{{ number_format($totalMessages) }}</div><div class="msg-label">All Messages</div></div></div>
 <div class="col-12 col-sm-6 col-xl-4"><div class="msg-stat"><i class="bi bi-envelope-exclamation text-danger"></i><div class="msg-number">{{ number_format($unreadCount) }}</div><div class="msg-label">Unread Messages</div></div></div>
 <div class="col-12 col-sm-6 col-xl-4"><div class="msg-stat"><i class="bi bi-envelope-check text-success"></i><div class="msg-number">{{ number_format(max(0,$totalMessages-$unreadCount)) }}</div><div class="msg-label">Read Messages</div></div></div>
</div>
<div class="msg-panel">
 <div class="msg-panel-head"><div><h5 class="fw-bold mb-1">Inbox</h5><div class="small text-secondary">Select a message to read its full contents.</div></div><span class="badge text-bg-light border align-self-center">{{ method_exists($messages,'total') ? $messages->total() : $messages->count() }} messages</span></div>
 @if($messages->count())
 <div class="table-responsive"><table class="table msg-table mb-0">
 <thead><tr><th>Sender</th><th>Subject / Message</th><th>Received</th><th>Status</th><th class="text-end">Read</th></tr></thead>
 <tbody>@foreach($messages as $message)
 <tr class="{{ ($message->status ?? 'unread') === 'unread' ? 'unread' : '' }}">
 <td><div class="fw-bold">{{ $message->name }}</div><div class="small text-secondary">{{ $message->email }}</div></td>
 <td><a class="msg-subject" href="{{ route('contact-messages.show',$message) }}">{{ $message->subject }}</a><div class="msg-preview">{{ \Illuminate\Support\Str::limit($message->message,100) }}</div></td>
 <td class="small text-secondary text-nowrap">{{ $message->created_at?->format('d M Y') }}<div>{{ $message->created_at?->format('h:i A') }}</div></td>
 <td>@if(($message->status ?? 'unread') === 'unread')<span class="msg-status unread">● Unread</span>@else<span class="msg-status read">✓ Read</span>@endif</td>
 <td class="text-end"><a class="msg-open" href="{{ route('contact-messages.show',$message) }}" aria-label="Read message" title="Read message"><i class="bi bi-arrow-up-right"></i></a></td>
 </tr>
 @endforeach</tbody></table></div>
 @if(method_exists($messages,'links'))<div class="p-3 border-top">{{ $messages->links() }}</div>@endif
 @else
 <div class="msg-empty"><i class="bi bi-envelope-open d-block mb-3"></i><h5 class="fw-bold text-dark">Your inbox is empty</h5><p class="mb-0">Messages submitted through the website contact form will appear here.</p></div>
 @endif
</div>
@endsection
</x-layout>
