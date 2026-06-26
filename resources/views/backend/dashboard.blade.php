@extends('backend.layout')

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Lumos CMS Dashboard</h2>
            <p class="admin-subtitle">Welcome back, {{ Auth::user()->name }}. Administrative controls and product/service metrics.</p>
        </div>
    </div>

    <!-- Quick Stats Cards Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="p-4 border rounded-4 text-center" style="background: rgba(255, 255, 255, 0.02); border-color: rgba(59, 130, 246, 0.15); box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <span style="font-size: 11px; color: var(--color-blue); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">Total Products</span>
                <h3 style="font-size: 32px; font-weight: 800; color: #ffffff; margin: 0;">{{ $productsCount }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 border rounded-4 text-center" style="background: rgba(255, 255, 255, 0.02); border-color: rgba(59, 130, 246, 0.15); box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <span style="font-size: 11px; color: var(--color-blue); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">Total Services</span>
                <h3 style="font-size: 32px; font-weight: 800; color: #ffffff; margin: 0;">{{ $servicesCount }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 border rounded-4 text-center" style="background: rgba(255, 255, 255, 0.02); border-color: rgba(59, 130, 246, 0.15); box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <span style="font-size: 11px; color: var(--color-blue); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">Inquiries / Quotes</span>
                <h3 style="font-size: 32px; font-weight: 800; color: #ffffff; margin: 0;">{{ $quotesCount }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 border rounded-4 text-center" style="background: rgba(255, 255, 255, 0.02); border-color: rgba(59, 130, 246, 0.15); box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <span style="font-size: 11px; color: var(--color-blue); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">Active Staff</span>
                <h3 style="font-size: 32px; font-weight: 800; color: #ffffff; margin: 0;">{{ $staffCount }}</h3>
            </div>
        </div>
    </div>

    <!-- Recent Quotes Log -->
    <h3 style="color: #ffffff; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">✦ Recent Quote Inquiries</h3>

    @if(count($recentQuotes) > 0)
        <div class="table-responsive">
            <table class="table table-dark table-hover border-0 align-middle" style="background: rgba(255,255,255,0.01); border-radius: 16px; overflow: hidden;">
                <thead>
                    <tr style="border-bottom: 1.5px solid rgba(59, 130, 246, 0.2); color: var(--color-blue); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th class="py-3 px-4 border-0">Client Name</th>
                        <th class="py-3 border-0">Email</th>
                        <th class="py-3 border-0">Phone</th>
                        <th class="py-3 border-0">Message</th>
                        <th class="py-3 px-4 border-0 text-end">Received Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentQuotes as $quote)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); font-size: 14px;">
                            <td class="py-3 px-4 border-0 font-weight-bold text-white">{{ $quote->name }}</td>
                            <td class="py-3 border-0 text-white-50">{{ $quote->email }}</td>
                            <td class="py-3 border-0">{{ $quote->phone ?? '-' }}</td>
                            <td class="py-3 border-0 text-truncate" style="max-width: 250px;">{{ $quote->message }}</td>
                            <td class="py-3 px-4 border-0 text-end text-white-50">{{ $quote->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5 border rounded-4" style="background: rgba(255, 255, 255, 0.01); border-color: rgba(255, 255, 255, 0.05); color: #94a3b8;">
            <p style="margin: 0; font-size: 15px;">No quote requests recorded yet.</p>
        </div>
    @endif
@endsection
