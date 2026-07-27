@extends('layouts.portal')

@section('portal_styles')
<style>
    .addons-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
        margin-top: 24px;
    }
    @media (max-width: 768px) {
        .addons-grid {
            grid-template-columns: 1fr;
        }
    }
    .addon-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .addon-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
    }
    .addon-badge-applied {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #16a34a;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        align-self: flex-start;
    }
    .addon-badge-applied i {
        font-size: 12px;
    }
    .addon-item-title {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin: 14px 0 8px;
    }
    .addon-item-desc {
        font-size: 13.5px;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 20px;
        min-height: 40px;
    }
    .addon-item-price-row {
        display: flex;
        align-items: baseline;
        margin-bottom: 16px;
    }
    .addon-item-price {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
    }
    .addon-item-old-price {
        font-size: 14px;
        text-decoration: line-through;
        color: #94a3b8;
        margin-left: 8px;
        font-weight: 500;
    }
    .btn-addon-add {
        width: 100%;
        height: 40px;
        border-radius: 8px;
        background: var(--primary-color);
        color: #ffffff;
        border: none;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-addon-add:hover {
        background-color: #b91c1c;
        opacity: 0.9;
    }
</style>
@endsection

@section('portal_content')
    <section id="section-manage-addons" class="portal-section active">
        <header class="section-header">
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Manage Add-ons</h1>
                </div>
                <p class="header-subtitle">Purchase and manage seats, books, and additional digital assets.</p>
            </div>
        </header>

        <div class="flex-column-gap-24">

            <!-- Available Add-ons -->
            <div class="portal-card portal-card-p24">
                <div class="addons-grid">
                    <!-- Post-Election Deck -->
                    <div class="addon-item-card">
                        <div>
                            <span class="addon-badge-applied">
                                <i class="bi bi-check-circle-fill"></i> One-time charge
                            </span>
                            <h3 class="addon-item-title">Post-Election Deck Only</h3>
                            <p class="addon-item-desc">Post-election deck presentation file</p>
                        </div>
                        <div>
                            <div class="addon-item-price-row">
                                <span class="addon-item-price">$1,000</span>
                            </div>
                            <a href="{{ route('auth.account.addon_checkout', ['addon' => 'deck']) }}" class="btn-addon-add" style="text-decoration: none;">
                                <i class="bi bi-plus-lg"></i> Add
                            </a>
                        </div>
                    </div>

                    <!-- Post-Election Deck Presentation -->
                    <div class="addon-item-card">
                        <div>
                            <span class="addon-badge-applied">
                                <i class="bi bi-check-circle-fill"></i> One-time charge
                            </span>
                            <h3 class="addon-item-title">Post-Election Deck Presentation</h3>
                            <p class="addon-item-desc">Post-election deck with live or recorded presentation add-on</p>
                        </div>
                        <div>
                            <div class="addon-item-price-row">
                                <span class="addon-item-price">$200</span>
                            </div>
                            <a href="{{ route('auth.account.addon_checkout', ['addon' => 'presentation']) }}" class="btn-addon-add" style="text-decoration: none;">
                                <i class="bi bi-plus-lg"></i> Add
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


