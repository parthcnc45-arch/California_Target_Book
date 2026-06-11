<template>
  <div class="portal-card account-info-card">
    <div class="card-header-custom">
      <h2 class="card-title-custom">Account Information</h2>
      <button v-if="!isEditing" class="btn-edit-profile" @click="startEditing">
        <i class="bi bi-pencil"></i> Edit
      </button>
    </div>
    
    <div class="card-body-custom">
      <!-- Static Display Table -->
      <table v-if="!isEditing" class="info-table">
        <tbody>
          <tr>
            <td class="info-label">Full Name</td>
            <td class="info-value">{{ display.fullName }}</td>
          </tr>
          <tr>
            <td class="info-label">Email Address</td>
            <td class="info-value">{{ display.email }}</td>
          </tr>
          <tr>
            <td class="info-label">Password</td>
            <td class="info-value">
              <div class="info-value-flex">
                <span>••••••••</span>
                <a href="javascript:void(0)" @click="openChangePassword" class="btn-change-password">Change Password</a>
              </div>
            </td>
          </tr>
          <tr>
            <td class="info-label">Company Name</td>
            <td class="info-value">{{ display.companyName }}</td>
          </tr>
          <tr>
            <td class="info-label">Phone Number</td>
            <td class="info-value">{{ display.phone_number || '(916) 555-0142' }}</td>
          </tr>
          <tr>
            <td class="info-label">Billing Address</td>
            <td class="info-value">
              <span v-if="display.billing && display.billing.line1">
                {{ display.billing.line1 }}{{ display.billing.line2 ? ', ' + display.billing.line2 : '' }}, {{ display.billing.city }}, {{ display.billing.state }} {{ display.billing.zip_code }}
              </span>
              <span v-else>1215 K Street, Suite 1150, Sacramento, CA, 95814</span>
            </td>
          </tr>
          <tr>
            <td class="info-label">Shipping Address</td>
            <td class="info-value">
              <span v-if="display.shipping && display.shipping.line1">
                {{ display.shipping.line1 }}{{ display.shipping.line2 ? ', ' + display.shipping.line2 : '' }}, {{ display.shipping.city }}, {{ display.shipping.state }} {{ display.shipping.zip_code }}
              </span>
              <span v-else-if="display.billing && display.billing.line1">
                {{ display.billing.line1 }}{{ display.billing.line2 ? ', ' + display.billing.line2 : '' }}, {{ display.billing.city }}, {{ display.billing.state }} {{ display.billing.zip_code }}
              </span>
              <span v-else>1215 K Street, Suite 1150, Sacramento, CA, 95814</span>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Edit Form -->
      <form v-else class="edit-profile-form" @submit.prevent="saveChanges">
        <div class="form-body">
          <div class="edit-row-flex">
            <label class="edit-label">Full Name</label>
            <div class="edit-input-wrapper">
              <input class="edit-input" type="text" v-model="form.fullName" required />
            </div>
          </div>
          <div class="edit-row-flex">
            <label class="edit-label">Email Address</label>
            <div class="edit-input-wrapper">
              <input class="edit-input" type="email" v-model="form.email" required />
            </div>
          </div>
          <div class="edit-row-flex">
            <label class="edit-label">Password</label>
            <div class="edit-input-wrapper">
              <div class="edit-password-flex">
                <span>••••••••</span>
                <a href="javascript:void(0)" @click="openChangePassword" class="btn-change-password">Change Password</a>
              </div>
            </div>
          </div>
          <div class="edit-row-flex">
            <label class="edit-label">Company Name</label>
            <div class="edit-input-wrapper">
              <input class="edit-input" type="text" v-model="form.companyName" required />
            </div>
          </div>
          <div class="edit-row-flex">
            <label class="edit-label">Phone Number</label>
            <div class="edit-input-wrapper">
              <input class="edit-input" type="text" v-model="form.phone_number" placeholder="(916) 555-0142" />
            </div>
          </div>

          <!-- Billing Address Block -->
          <div class="address-block">
            <h3 class="address-block-title">Billing Address</h3>
            <div class="edit-row">
              <label class="edit-label">Street</label>
              <input class="edit-input" type="text" v-model="form.billing.line1" placeholder="Street address" required />
            </div>
            <div class="address-grid">
              <div class="grid-col city-col">
                <label class="edit-label">City</label>
                <input class="edit-input" type="text" v-model="form.billing.city" required />
              </div>
              <div class="grid-col state-col">
                <label class="edit-label">State</label>
                <select class="edit-input select-state" v-model="form.billing.state" required>
                  <option v-for="st in statesList" :key="st.value" :value="st.value">{{ st.label }}</option>
                </select>
              </div>
              <div class="grid-col zip-col">
                <label class="edit-label">Zip</label>
                <input class="edit-input" type="text" v-model="form.billing.zip_code" required />
              </div>
            </div>
          </div>

          <!-- Shipping Address Block -->
          <div class="address-block">
            <div class="address-block-header">
              <h3 class="address-block-title">Shipping Address</h3>
              <label class="same-as-billing-checkbox">
                <input type="checkbox" v-model="form.sameAsBilling" /> Same as Billing
              </label>
            </div>
            <div v-show="!form.sameAsBilling">
              <div class="edit-row">
                <label class="edit-label">Street</label>
                <input class="edit-input" type="text" v-model="form.shipping.line1" placeholder="Street address" :required="!form.sameAsBilling" />
              </div>
              <div class="address-grid">
                <div class="grid-col city-col">
                  <label class="edit-label">City</label>
                  <input class="edit-input" type="text" v-model="form.shipping.city" :required="!form.sameAsBilling" />
                </div>
                <div class="grid-col state-col">
                  <label class="edit-label">State</label>
                  <select class="edit-input select-state" v-model="form.shipping.state" :required="!form.sameAsBilling">
                    <option v-for="st in statesList" :key="st.value" :value="st.value">{{ st.label }}</option>
                  </select>
                </div>
                <div class="grid-col zip-col">
                  <label class="edit-label">Zip</label>
                  <input class="edit-input" type="text" v-model="form.shipping.zip_code" :required="!form.sameAsBilling" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Error Alert -->
        <div class="bg-danger-alert" v-if="errors.length">
          <ul>
            <li v-for="(err, i) in errors" :key="i">{{ err }}</li>
          </ul>
        </div>

        <!-- Actions -->
        <div class="form-actions">
          <button type="button" class="btn btn-cancel" @click="cancelEditing" :disabled="isLoading">
            Cancel
          </button>
          <button type="submit" class="btn btn-save" :disabled="isLoading">
            <span v-if="isLoading">Saving...</span>
            <span v-else>Save Changes</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

const US_STATES = [
  { value: 'AL', label: 'AL' }, { value: 'AK', label: 'AK' }, { value: 'AZ', label: 'AZ' },
  { value: 'AR', label: 'AR' }, { value: 'CA', label: 'CA' }, { value: 'CO', label: 'CO' },
  { value: 'CT', label: 'CT' }, { value: 'DE', label: 'DE' }, { value: 'FL', label: 'FL' },
  { value: 'GA', label: 'GA' }, { value: 'HI', label: 'HI' }, { value: 'ID', label: 'ID' },
  { value: 'IL', label: 'IL' }, { value: 'IN', label: 'IN' }, { value: 'IA', label: 'IA' },
  { value: 'KS', label: 'KS' }, { value: 'KY', label: 'KY' }, { value: 'LA', label: 'LA' },
  { value: 'ME', label: 'ME' }, { value: 'MD', label: 'MD' }, { value: 'MA', label: 'MA' },
  { value: 'MI', label: 'MI' }, { value: 'MN', label: 'MN' }, { value: 'MS', label: 'MS' },
  { value: 'MO', label: 'MO' }, { value: 'MT', label: 'MT' }, { value: 'NE', label: 'NE' },
  { value: 'NV', label: 'NV' }, { value: 'NH', label: 'NH' }, { value: 'NJ', label: 'NJ' },
  { value: 'NM', label: 'NM' }, { value: 'NY', label: 'NY' }, { value: 'NC', label: 'NC' },
  { value: 'ND', label: 'ND' }, { value: 'OH', label: 'OH' }, { value: 'OK', label: 'OK' },
  { value: 'OR', label: 'OR' }, { value: 'PA', label: 'PA' }, { value: 'RI', label: 'RI' },
  { value: 'SC', label: 'SC' }, { value: 'SD', label: 'SD' }, { value: 'TN', label: 'TN' },
  { value: 'TX', label: 'TX' }, { value: 'UT', label: 'UT' }, { value: 'VT', label: 'VT' },
  { value: 'VA', label: 'VA' }, { value: 'WA', label: 'WA' }, { value: 'WV', label: 'WV' },
  { value: 'WI', label: 'WI' }, { value: 'WY', label: 'WY' }
];

export default {
  props: {
    initialUser: { type: Object, required: true },
    initialCompany: { type: Object, required: false, default: null },
    initialBillingAddress: { type: Object, required: false, default: null },
    initialShippingAddress: { type: Object, required: false, default: null },
    hasSubscription: { type: Boolean, required: false, default: false }
  },
  data() {
    return {
      isEditing: false,
      isLoading: false,
      errors: [],
      statesList: US_STATES,
      form: {
        fullName: this.initialUser ? `${this.initialUser.first_name} ${this.initialUser.last_name || ''}`.trim() : '',
        email: this.initialUser ? this.initialUser.email : '',
        phone_number: this.initialUser ? this.initialUser.phone_number : '',
        companyName: this.initialCompany ? this.initialCompany.name : '',
        sameAsBilling: false,
        billing: {
          line1: this.initialBillingAddress ? this.initialBillingAddress.line1 : '',
          line2: this.initialBillingAddress ? this.initialBillingAddress.line2 : '',
          city: this.initialBillingAddress ? this.initialBillingAddress.city : '',
          state: this.initialBillingAddress ? this.initialBillingAddress.state : 'CA',
          zip_code: this.initialBillingAddress ? this.initialBillingAddress.zip_code : '',
        },
        shipping: {
          line1: this.initialShippingAddress ? this.initialShippingAddress.line1 : '',
          line2: this.initialShippingAddress ? this.initialShippingAddress.line2 : '',
          city: this.initialShippingAddress ? this.initialShippingAddress.city : '',
          state: this.initialShippingAddress ? this.initialShippingAddress.state : 'CA',
          zip_code: this.initialShippingAddress ? this.initialShippingAddress.zip_code : '',
        }
      },
      display: {
        fullName: this.initialUser ? `${this.initialUser.first_name} ${this.initialUser.last_name || ''}`.trim() : '',
        email: this.initialUser ? this.initialUser.email : '',
        phone_number: this.initialUser ? this.initialUser.phone_number : '',
        companyName: this.initialCompany ? this.initialCompany.name : '',
        billing: this.initialBillingAddress ? { ...this.initialBillingAddress } : null,
        shipping: this.initialShippingAddress ? { ...this.initialShippingAddress } : null,
      }
    };
  },
  watch: {
    'form.billing': {
      deep: true,
      handler(newVal) {
        if (this.form.sameAsBilling) {
          this.form.shipping = { ...newVal };
        }
      }
    },
    'form.sameAsBilling'(newVal) {
      if (newVal) {
        this.form.shipping = { ...this.form.billing };
      }
    }
  },
  mounted() {
    // Check if shipping matches billing initially
    if (this.initialBillingAddress && this.initialShippingAddress) {
      const b = this.initialBillingAddress;
      const s = this.initialShippingAddress;
      if (b.line1 === s.line1 && b.line2 === s.line2 && b.city === s.city && b.state === s.state && b.zip_code === s.zip_code) {
        this.form.sameAsBilling = true;
      }
    } else if (!this.initialShippingAddress && this.initialBillingAddress) {
      this.form.sameAsBilling = true;
    }
  },
  methods: {
    startEditing() {
      this.errors = [];
      this.isEditing = true;
    },
    cancelEditing() {
      // Restore values from display object
      this.form.fullName = this.display.fullName;
      this.form.email = this.display.email;
      this.form.phone_number = this.display.phone_number;
      this.form.companyName = this.display.companyName;
      if (this.display.billing) {
        this.form.billing = { ...this.display.billing };
      }
      if (this.display.shipping) {
        this.form.shipping = { ...this.display.shipping };
      }
      
      // Recalculate sameAsBilling
      if (this.display.billing && this.display.shipping) {
        const b = this.display.billing;
        const s = this.display.shipping;
        this.form.sameAsBilling = (b.line1 === s.line1 && b.line2 === s.line2 && b.city === s.city && b.state === s.state && b.zip_code === s.zip_code);
      } else if (!this.display.shipping && this.display.billing) {
        this.form.sameAsBilling = true;
      }

      this.isEditing = false;
    },
    async saveChanges() {
      this.isLoading = true;
      this.errors = [];

      try {
        const response = await axios.put('/api/users/me', this.form);
        if (response.data && response.data.success) {
          const u = response.data.user;
          this.display.fullName = `${u.first_name} ${u.last_name || ''}`.trim();
          this.display.email = u.email;
          this.display.phone_number = u.phone_number;
          this.display.companyName = u.company ? u.company.name : '';
          this.display.billing = u.company ? u.company.address : null;
          this.display.shipping = response.data.shippingAddress;
          
          this.isEditing = false;
        } else {
          this.errors = ['An unexpected response was received from the server.'];
        }
      } catch (err) {
        if (err.response && err.response.data && err.response.data.errors) {
          const validationErrors = err.response.data.errors;
          this.errors = Object.keys(validationErrors).reduce((acc, key) => {
            return acc.concat(validationErrors[key]);
          }, []);
        } else {
          this.errors = ['Failed to update account information. Please try again.'];
        }
      } finally {
        this.isLoading = false;
      }
    },
    openChangePassword() {
      this.$root.showChangePasswordModal = true;
    }
  }
};
</script>

<style scoped>
.portal-card {
  background: #ffffff;
  border: 1px solid var(--border-color, #e2e8ee);
  border-radius: 10px;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  margin-top: 16px;
  width: 100%;
  box-sizing: border-box;
}

.card-header-custom {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border-color, #e2e8ee);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.card-title-custom {
  font-size: 14px;
  font-weight: 700;
  color: #0f172a;
  margin: 0;
}

.btn-edit-profile {
  background: none;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  padding: 4px 10px;
  font-size: 12px;
  font-weight: 600;
  color: #475569;
  display: flex;
  align-items: center;
  gap: 4px;
  cursor: pointer;
  transition: all 0.15s;
}

.btn-edit-profile:hover {
  background-color: #f1f5f9;
  color: #0f172a;
}

.card-body-custom {
  padding: 0;
  overflow-x: auto;
}

.info-table {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}

.info-table td {
  padding: 14px 20px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
  box-sizing: border-box;
}

.info-table tr:last-child td {
  border-bottom: none;
}

.info-label {
  width: 35%;
  font-weight: 500;
  color: var(--text-muted, #64748b);
  font-size: 13px;
  box-sizing: border-box;
}

.info-value {
  width: 65%;
  font-weight: 500;
  color: #0f172a;
  font-size: 13px;
  box-sizing: border-box;
  word-break: normal;
  overflow-wrap: normal;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

.info-value-flex {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.btn-change-password {
  color: var(--primary-color, #d93838) !important;
  font-weight: 600;
  font-size: 13px;
  text-decoration: none !important;
  margin-left: 12px;
  transition: color 0.15s;
}

.btn-change-password:hover {
  color: #b91c1c !important;
}

/* Edit form styles */
.edit-profile-form {
  padding: 24px 20px;
  box-sizing: border-box;
}

.form-body {
  text-align: left;
}

.edit-row {
  margin-bottom: 18px;
}

.edit-row-flex {
  display: flex !important;
  align-items: center !important;
  margin-bottom: 18px !important;
  width: 100% !important;
  box-sizing: border-box !important;
}

.edit-row-flex .edit-label {
  width: 35% !important;
  flex-shrink: 0 !important;
  margin-bottom: 0 !important;
  padding-right: 20px !important;
}

.edit-label {
  display: block !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  color: #475569 !important;
  margin-bottom: 6px !important;
  text-align: left !important;
}

.edit-input-wrapper {
  width: 65% !important;
  box-sizing: border-box !important;
}

.edit-input {
  display: block !important;
  width: 100% !important;
  padding: 8px 12px !important;
  font-size: 13.5px !important;
  line-height: 1.5 !important;
  color: #0f172a !important;
  background-color: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  box-sizing: border-box !important;
  transition: border-color 0.15s, box-shadow 0.15s !important;
}

.edit-input:focus {
  border-color: #d93838;
  outline: none;
  box-shadow: 0 0 0 3px rgba(217, 56, 56, 0.15);
}

.edit-password-flex {
  display: flex;
  align-items: center;
  font-size: 13.5px;
}

.select-state {
  height: 38px;
  background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%2364748b' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 8px 10px;
  appearance: none;
  padding-right: 28px;
}

.address-block {
  margin-top: 24px;
  border-top: 1px solid #e2e8ee;
  padding-top: 20px;
}

.address-block-header {
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  margin-bottom: 12px !important;
}

.address-block-title {
  font-size: 14px;
  font-weight: 700;
  color: #0f172a;
  margin: 0;
}

.same-as-billing-checkbox {
  font-size: 13.5px !important;
  font-weight: 600 !important;
  color: #334155 !important;
  display: flex !important;
  align-items: center !important;
  gap: 8px !important;
  cursor: pointer !important;
  margin: 0 !important;
  user-select: none !important;
}

.same-as-billing-checkbox input {
  width: 16px !important;
  height: 16px !important;
  accent-color: #d93838 !important;
  cursor: pointer !important;
  margin: 0 !important;
}

.address-grid {
  display: flex;
  gap: 12px;
}

.city-col {
  flex: 2;
}

.state-col {
  flex: 1;
}

.zip-col {
  flex: 1;
}

.form-actions {
  display: flex !important;
  justify-content: flex-end !important;
  gap: 12px !important;
  margin-top: 24px !important;
  border-top: 1px solid #e2e8ee !important;
  padding-top: 20px !important;
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 8px 18px;
  font-size: 13.5px;
  font-weight: 600;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.15s;
  border: 1px solid transparent;
  outline: none;
}

.btn-cancel {
  background-color: #ffffff;
  border-color: #cbd5e1;
  color: #475569;
}

.btn-cancel:hover {
  background-color: #f8fafc;
  color: #1e293b;
}

.btn-save {
  background-color: #d93838;
  color: #ffffff;
  border-color: #d93838;
}

.btn-save:hover {
  background-color: #b91c1c;
  border-color: #b91c1c;
}

.btn-save:disabled {
  background-color: #fca5a5;
  border-color: #fca5a5;
  cursor: not-allowed;
}

.bg-danger-alert {
  background-color: #fef2f2;
  border: 1px solid #fee2e2;
  border-radius: 6px;
  padding: 12px;
  margin-top: 16px;
  color: #991b1b;
}

.bg-danger-alert ul {
  padding-left: 20px;
  margin: 0;
  text-align: left;
}
</style>
