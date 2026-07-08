@extends('layouts.portal')

@section('portal_content')
    <div class="section-header" style="margin-bottom: 32px;">
        <div class="header-title-container">
            <h1 class="header-title">Add Subscriber</h1>
        </div>
    </div>

    <!-- Account Info -->
    <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Account Info</h3>
    <div class="portal-card" style="margin-bottom: 32px;">
        <div class="card-body-custom" style="padding: 0;">
            <div style="display: flex; gap: 24px; margin-bottom: 16px;">
                <div style="flex: 1;">
                    <label class="form-label-style">First Name</label>
                    <input type="text" class="form-input-style">
                </div>
                <div style="flex: 1;">
                    <label class="form-label-style">Last Name</label>
                    <input type="text" class="form-input-style">
                </div>
            </div>
            <div style="display: flex; gap: 24px;">
                <div style="flex: 1;">
                    <label class="form-label-style">Email</label>
                    <input type="email" class="form-input-style">
                </div>
                <div style="flex: 1;">
                    <label class="form-label-style">Phone Number</label>
                    <input type="text" class="form-input-style">
                </div>
            </div>
        </div>
    </div>

    <!-- Organization -->
    <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Organization</h3>
    <div class="portal-card" style="margin-bottom: 32px;">
        <div class="card-body-custom" style="padding: 0;">
            <div style="margin-bottom: 16px; max-width: 50%;">
                <label class="form-label-style">Organization</label>
                <input type="text" class="form-input-style">
            </div>
            <div style="display: flex; gap: 24px; margin-bottom: 16px;">
                <div style="flex: 1;">
                    <label class="form-label-style">Address Line 1</label>
                    <input type="text" class="form-input-style">
                </div>
                <div style="flex: 1;">
                    <label class="form-label-style">Address Line 2</label>
                    <input type="text" class="form-input-style">
                </div>
            </div>
            <div style="display: flex; gap: 24px;">
                <div style="flex: 2;">
                    <label class="form-label-style">City</label>
                    <input type="text" class="form-input-style">
                </div>
                <div style="flex: 1;">
                    <label class="form-label-style">State</label>
                    <select class="form-input-style" style="padding-top: 7px; padding-bottom: 7px;">
                        <option></option>
                    </select>
                </div>
                <div style="flex: 1.5;">
                    <label class="form-label-style">Zip Code</label>
                    <input type="text" class="form-input-style">
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription -->
    <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Subscription</h3>
    <div class="portal-card" style="margin-bottom: 32px;">
        <div class="card-body-custom" style="padding: 0;">
            
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 24px;">
                <div>
                    <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 12px;">Length</div>
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; margin-bottom: 8px;">
                        <input type="radio" name="length"> 12 Month Subscription
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569;">
                        <input type="radio" name="length" checked> 24 Month Subscription
                    </label>
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 16px; font-weight: 500; color: #0f172a;">$</span>
                    <input type="text" class="form-input-style" value="2200" style="width: 150px; text-align: right; font-weight: 600; font-size: 16px;">
                    <span style="font-size: 13px; color: #64748b; width: 120px;">Subscription Cost</span>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 24px;">
                <div>
                    <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 12px;">Hard Copy Subscriptions</div>
                    <div style="display: flex; gap: 8px;">
                        <button style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                        <button style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 16px; font-weight: 500; color: #0f172a;">$</span>
                    <input type="text" class="form-input-style" value="600" style="width: 150px; text-align: right; font-weight: 600; font-size: 16px;">
                    <span style="font-size: 13px; color: #64748b; width: 120px;">Book Cost</span>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 12px;">Addons</div>
                    <div style="display: flex; gap: 8px;">
                        <button style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                        <button style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 16px; font-weight: 500; color: #0f172a;">$</span>
                    <input type="text" class="form-input-style" value="100" style="width: 150px; text-align: right; font-weight: 600; font-size: 16px;">
                    <span style="font-size: 13px; color: #64748b; width: 120px;">Addon Cost</span>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Payment -->
    <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Payment</h3>
    <div class="portal-card" style="margin-bottom: 32px; flex-direction: row; gap: 40px;">
        <div style="flex: 1;">
            <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 16px;">Payment Method</div>
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569;">
                    <input type="radio" name="payment" checked> Paying By Credit Card
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569;">
                    <input type="radio" name="payment"> Paying By Check
                </label>
            </div>
            
            <div style="font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Credit or Debit Card</div>
            <div style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 10px 12px; display: flex; align-items: center; max-width: 320px; background: #ffffff;">
                <i class="bi bi-credit-card" style="margin-right: 12px; color: #94a3b8; font-size: 16px;"></i>
                <span style="color: #94a3b8; font-size: 13.5px; flex: 1;">Card number</span>
                <span style="background: #16a34a; color: white; font-size: 11px; padding: 3px 8px; border-radius: 20px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px;">Autofill <i class="bi bi-chevron-right" style="font-size: 9px;"></i></span>
            </div>
        </div>
        
        <div style="flex: 1;">
            <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 8px;">Paid Up</div>
            <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0 0 16px 0;">Check this box to mark the subscriber as paid. This will make their subscription active. This will not charge them.</p>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; font-weight: 500;">
                    <input type="checkbox"> Is Paid For
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; font-weight: 500;">
                    <input type="checkbox" checked> Email Invoice
                </label>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Summary</h3>
    <div class="portal-card" style="padding: 0;">
        <table class="portal-grid-table">
            <tbody>
                <tr>
                    <td style="font-weight: 500; color: #475569; border-bottom: 1px solid #f1f5f9;">Base Subscription</td>
                    <td style="text-align: right; font-weight: 600; color: #0f172a; width: 100px; border-bottom: 1px solid #f1f5f9;">$0</td>
                </tr>
                <tr>
                    <td style="font-weight: 500; color: #475569; border-bottom: 1px solid #f1f5f9;">Hard Copies</td>
                    <td style="text-align: right; font-weight: 600; color: #0f172a; border-bottom: 1px solid #f1f5f9;">$0</td>
                </tr>
                <tr>
                    <td style="font-weight: 500; color: #475569; border-bottom: 1px solid #f1f5f9;">Addons</td>
                    <td style="text-align: right; font-weight: 600; color: #0f172a; border-bottom: 1px solid #f1f5f9;">$0</td>
                </tr>
                <tr style="background-color: #f8fafc;">
                    <td style="font-weight: 700; color: #0f172a; border-bottom: none;">Total</td>
                    <td style="text-align: right; font-weight: 700; color: #0f172a; font-size: 15px; border-bottom: none;">$0</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div style="display: flex; justify-content: flex-end; margin-top: 24px; padding-bottom: 40px;">
        <button style="background: #cbd5e1; color: #ffffff; padding: 10px 32px; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: not-allowed;">SUBMIT</button>
    </div>
@endsection
