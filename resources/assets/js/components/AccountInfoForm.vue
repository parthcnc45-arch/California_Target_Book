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
                <div v-if="display.billing.special_instructions" style="margin-top: 4px; font-size: 11.5px; color: #64748b;">
                  Instructions: {{ display.billing.special_instructions }}
                </div>
              </span>
              <span v-else>1215 K Street, Suite 1150, Sacramento, CA, 95814</span>
            </td>
          </tr>
          <tr v-for="(shipping, index) in display.shippings" :key="shipping.id">
            <td class="info-label">Shipping Address {{ display.shippings.length > 1 ? (index + 1) : '' }}</td>
            <td class="info-value">
              <span v-if="shipping.address && shipping.address.line1">
                {{ shipping.address.line1 }}{{ shipping.address.line2 ? ', ' + shipping.address.line2 : '' }}, {{ shipping.address.city }}, {{ shipping.address.state }} {{ shipping.address.zip_code }}
                <div v-if="shipping.address.special_instructions" style="margin-top: 4px; font-size: 11.5px; color: #64748b;">
                  Instructions: {{ shipping.address.special_instructions }}
                </div>
              </span>
              <span v-else>No shipping address set</span>
            </td>
          </tr>
          <tr v-if="!display.shippings || !display.shippings.length">
            <td class="info-label">Shipping Address</td>
            <td class="info-value">
              <span v-if="display.billing && display.billing.line1">
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
              <label class="edit-label">Address Line 1</label>
              <input class="edit-input" type="text" v-model="form.billing.line1" placeholder="Address Line 1" required />
            </div>
            <div class="edit-row">
              <label class="edit-label">Address Line 2</label>
              <input class="edit-input" type="text" v-model="form.billing.line2" placeholder="Address Line 2" />
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
            <div class="edit-row" style="margin-top: 12px;">
              <label class="edit-label">Special Instructions</label>
              <input class="edit-input" type="text" v-model="form.billing.special_instructions" placeholder="Delivery instructions" />
            </div>
          </div>

          <!-- Shipping Address Block -->
          <div class="address-block">
            <div v-for="(shipping, index) in form.shippings" :key="shipping.id" style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed #e2e8ee;">
              <div class="address-block-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <h3 class="address-block-title">Shipping Address {{ form.shippings.length > 1 ? (index + 1) : '' }}</h3>
                <label class="same-as-billing-checkbox">
                  <input type="checkbox" v-model="shipping.sameAsBilling" @change="toggleSameAsBilling(index)" /> Same as Billing
                </label>
              </div>
              
              <div v-show="!shipping.sameAsBilling">
                <div class="edit-row">
                  <label class="edit-label">Address Line 1</label>
                  <input class="edit-input" type="text" v-model="shipping.line1" placeholder="Address Line 1" :required="!shipping.sameAsBilling" />
                </div>
                <div class="edit-row">
                  <label class="edit-label">Address Line 2</label>
                  <input class="edit-input" type="text" v-model="shipping.line2" placeholder="Address Line 2" />
                </div>
                <div class="address-grid">
                  <div class="grid-col city-col">
                    <label class="edit-label">City</label>
                    <input class="edit-input" type="text" v-model="shipping.city" :required="!shipping.sameAsBilling" />
                  </div>
                  <div class="grid-col state-col">
                    <label class="edit-label">State</label>
                    <select class="edit-input select-state" v-model="shipping.state" :required="!shipping.sameAsBilling">
                      <option v-for="st in statesList" :key="st.value" :value="st.value">{{ st.label }}</option>
                    </select>
                  </div>
                  <div class="grid-col zip-col">
                    <label class="edit-label">Zip</label>
                    <input class="edit-input" type="text" v-model="shipping.zip_code" :required="!shipping.sameAsBilling" />
                  </div>
                </div>
                <div class="edit-row" style="margin-top: 12px; margin-bottom: 0;">
                  <label class="edit-label">Special Instructions</label>
                  <input class="edit-input" type="text" v-model="shipping.special_instructions" placeholder="Delivery instructions" />
                </div>
              </div>
            </div>

            <div v-if="!form.shippings || !form.shippings.length" style="font-size: 13.5px; color: #64748b; font-style: italic; padding: 10px 0;">
              No shipping address associated with your subscription.
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
  { value: 'AL', label: 'Alabama' },
  { value: 'AK', label: 'Alaska' },
  { value: 'AZ', label: 'Arizona' },
  { value: 'AR', label: 'Arkansas' },
  { value: 'CA', label: 'California' },
  { value: 'CO', label: 'Colorado' },
  { value: 'CT', label: 'Connecticut' },
  { value: 'DE', label: 'Delaware' },
  { value: 'DC', label: 'District Of Columbia' },
  { value: 'FL', label: 'Florida' },
  { value: 'GA', label: 'Georgia' },
  { value: 'GU', label: 'Guam' },
  { value: 'HI', label: 'Hawaii' },
  { value: 'ID', label: 'Idaho' },
  { value: 'IL', label: 'Illinois' },
  { value: 'IN', label: 'Indiana' },
  { value: 'IA', label: 'Iowa' },
  { value: 'KS', label: 'Kansas' },
  { value: 'KY', label: 'Kentucky' },
  { value: 'LA', label: 'Louisiana' },
  { value: 'ME', label: 'Maine' },
  { value: 'MD', label: 'Maryland' },
  { value: 'MA', label: 'Massachusetts' },
  { value: 'MI', label: 'Michigan' },
  { value: 'MN', label: 'Minnesota' },
  { value: 'MS', label: 'Mississippi' },
  { value: 'MO', label: 'Missouri' },
  { value: 'MT', label: 'Montana' },
  { value: 'NE', label: 'Nebraska' },
  { value: 'NV', label: 'Nevada' },
  { value: 'NH', label: 'New Hampshire' },
  { value: 'NJ', label: 'New Jersey' },
  { value: 'NM', label: 'New Mexico' },
  { value: 'NY', label: 'New York' },
  { value: 'NC', label: 'North Carolina' },
  { value: 'ND', label: 'North Dakota' },
  { value: 'OH', label: 'Ohio' },
  { value: 'OK', label: 'Oklahoma' },
  { value: 'OR', label: 'Oregon' },
  { value: 'PA', label: 'Pennsylvania' },
  { value: 'RI', label: 'Rhode Island' },
  { value: 'SC', label: 'South Carolina' },
  { value: 'SD', label: 'South Dakota' },
  { value: 'TN', label: 'Tennessee' },
  { value: 'TX', label: 'Texas' },
  { value: 'UT', label: 'Utah' },
  { value: 'VT', label: 'Vermont' },
  { value: 'VA', label: 'Virginia' },
  { value: 'WA', label: 'Washington' },
  { value: 'WV', label: 'West Virginia' },
  { value: 'WI', label: 'Wisconsin' },
  { value: 'WY', label: 'Wyoming' }
];

export default {
  props: {
    initialUser: { type: Object, required: true },
    initialCompany: { type: Object, required: false, default: null },
    initialBillingAddress: { type: Object, required: false, default: null },
    initialShippingAddresses: { type: Array, required: false, default: () => [] },
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
        shippings: this.initialShippingAddresses ? this.initialShippingAddresses.map(s => {
          return {
            id: s.id,
            address_id: s.address_id,
            sameAsBilling: false,
            line1: s.address ? s.address.line1 : '',
            line2: s.address ? s.address.line2 : '',
            city: s.address ? s.address.city : '',
            state: s.address ? s.address.state : 'CA',
            zip_code: s.address ? s.address.zip_code : '',
            special_instructions: s.address ? s.address.special_instructions : '',
          };
        }) : [],
        billing: {
          line1: this.initialBillingAddress ? this.initialBillingAddress.line1 : '',
          line2: this.initialBillingAddress ? this.initialBillingAddress.line2 : '',
          city: this.initialBillingAddress ? this.initialBillingAddress.city : '',
          state: this.initialBillingAddress ? this.initialBillingAddress.state : 'CA',
          zip_code: this.initialBillingAddress ? this.initialBillingAddress.zip_code : '',
          special_instructions: this.initialBillingAddress ? this.initialBillingAddress.special_instructions : '',
        },
      },
      display: {
        fullName: this.initialUser ? `${this.initialUser.first_name} ${this.initialUser.last_name || ''}`.trim() : '',
        email: this.initialUser ? this.initialUser.email : '',
        phone_number: this.initialUser ? this.initialUser.phone_number : '',
        companyName: this.initialCompany ? this.initialCompany.name : '',
        billing: this.initialBillingAddress ? { ...this.initialBillingAddress } : null,
        shippings: this.initialShippingAddresses ? [ ...this.initialShippingAddresses ] : [],
      }
    };
  },
  watch: {
    'form.billing': {
      deep: true,
      handler(newVal) {
        if (this.form.shippings && this.form.shippings.length) {
          this.form.shippings.forEach(shipping => {
            if (shipping.sameAsBilling) {
              shipping.line1 = newVal.line1;
              shipping.line2 = newVal.line2;
              shipping.city = newVal.city;
              shipping.state = newVal.state;
              shipping.zip_code = newVal.zip_code;
              shipping.special_instructions = newVal.special_instructions;
            }
          });
        }
      }
    }
  },
  mounted() {
    // Check sameAsBilling for each shipping address initially
    if (this.initialBillingAddress && this.form.shippings && this.form.shippings.length) {
      const b = this.initialBillingAddress;
      this.form.shippings.forEach(shipping => {
        if (
          b.line1 === shipping.line1 &&
          b.line2 === shipping.line2 &&
          b.city === shipping.city &&
          b.state === shipping.state &&
          b.zip_code === shipping.zip_code
        ) {
          shipping.sameAsBilling = true;
        }
      });
    }
  },
  methods: {
    startEditing() {
      this.errors = [];
      this.isEditing = true;
    },
    toggleSameAsBilling(index) {
      let shipping = this.form.shippings[index];
      if (shipping.sameAsBilling) {
        shipping.line1 = this.form.billing.line1;
        shipping.line2 = this.form.billing.line2;
        shipping.city = this.form.billing.city;
        shipping.state = this.form.billing.state;
        shipping.zip_code = this.form.billing.zip_code;
        shipping.special_instructions = this.form.billing.special_instructions;
      }
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
      if (this.display.shippings) {
        this.form.shippings = this.display.shippings.map(s => {
          const b = this.display.billing;
          const isSame = b && (b.line1 === s.address.line1 && b.line2 === s.address.line2 && b.city === s.address.city && b.state === s.address.state && b.zip_code === s.address.zip_code);
          return {
            id: s.id,
            address_id: s.address_id,
            sameAsBilling: isSame,
            line1: s.address ? s.address.line1 : '',
            line2: s.address ? s.address.line2 : '',
            city: s.address ? s.address.city : '',
            state: s.address ? s.address.state : 'CA',
            zip_code: s.address ? s.address.zip_code : '',
            special_instructions: s.address ? s.address.special_instructions : '',
          };
        });
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
          this.display.shippings = response.data.shippingAddresses;
          
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
