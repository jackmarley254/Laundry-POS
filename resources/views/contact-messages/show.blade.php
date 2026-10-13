{{-- resources/views/contact-messages/show.blade.php --}}
<x-layout>
@section('title', 'Read Customer Message')
@section('content')
<style>
.msg-detail-hero{background:linear-gradient(135deg,#071a33,#0d6efd);color:#fff;border-radius:18px;padding:22px 24px;margin-bottom:20px}
.msg-detail-card{background:#fff;border:1px solid #e5eaf1;border-radius:18px;overflow:hidden;box-shadow:0 8px 24px #0f172a0b}
.msg-detail-head{padding:25px;border-bottom:1px solid #e5eaf1}.msg-meta{background:#f8faff;border:1px solid #e5eaf1;border-radius:13px;padding:15px;height:100%}
.msg-meta-label{font-size:.68rem;text-transform:uppercase;color:#718096;font-weight:800;letter-spacing:.7px;margin-bottom:6px}
.msg-body{padding:28px;white-space:pre-wrap;overflow-wrap:anywhere;line-height:1.85;color:#34445e;min-height:180px}
</style>
<div class="msg-detail-hero d-flex justify-content-between align-items-center flex-wrap gap-3">
 <div><div class="small text-uppercase fw-bold mb-2" style="letter-spacing:1px;color:#bfdbfe">Customer Support Centre</div><h3 class="fw-bold mb-1"><i class="bi bi-envelope-open-fill me-2"></i>Message Details</h3><div class="small text-white-50">Message #{{ $contactMessage->id }}</div></div>
 <a href="{{ route('contact-messages.index') }}" class="btn btn-light fw-semibold"><i class="bi bi-arrow-left me-1"></i> Back to Inbox</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<article class="msg-detail-card">
 <div class="msg-detail-head d-flex justify-content-between align-items-start flex-wrap gap-3">
  <div><div class="small text-uppercase fw-bold text-primary mb-2">Subject</div><h4 class="fw-bold">{{ $contactMessage->subject }}</h4><div class="small text-secondary">Received {{ $contactMessage->created_at?->format('l, d F Y \a\t h:i A') ?? '—' }}</div></div>
  @if(($contactMessage->status ?? 'unread') === 'unread')<span class="badge rounded-pill text-bg-danger px-3 py-2">Unread</span>@else<span class="badge rounded-pill text-bg-success px-3 py-2">Read</span>@endif
 </div>
 <div class="p-4 border-bottom"><div class="row g-3">
  <div class="col-12 col-md-6"><div class="msg-meta"><div class="msg-meta-label">From</div><div class="fw-bold">{{ $contactMessage->name }}</div></div></div>
  <div class="col-12 col-md-6"><div class="msg-meta"><div class="msg-meta-label">Email Address</div><div class="fw-bold"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div></div></div>
 </div></div>
 <div class="msg-body">{{ $contactMessage->message }}</div>
 <div class="p-4 border-top bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
  <a href="mailto:{{ $contactMessage->email }}?subject={{ rawurlencode('Re: '.$contactMessage->subject) }}" class="btn btn-primary"><i class="bi bi-reply-fill me-1"></i> Reply by Email</a>
  <form action="{{ route('contact-messages.destroy',$contactMessage) }}" method="POST" onsubmit="return confirm('Delete this message permanently?');">@csrf @method('DELETE')<button class="btn btn-outline-danger" type="submit"><i class="bi bi-trash3 me-1"></i> Delete Message</button></form>
 </div>
</article>
@endsection
</x-layout>
