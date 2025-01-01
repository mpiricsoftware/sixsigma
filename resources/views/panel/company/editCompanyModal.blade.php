<!-- Edit Permission Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Add Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editCompanyForm" class="pt-0">
        <div class="modal-body">
          <div class="row g-4">
            <div class="col mb-2">
              <div class="form-floating form-floating-outline">
                <input type="hidden" id="companyID" name="id" value="">
                <input type="hidden" id="user_id" name="user_id" value="">
                <input type="text" id="company_name" name="company_name" class="form-control company_name" placeholder="Enter Name">
                <label for="company_name">Name</label>
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-floating form-floating-outline">
                <input type="email" id="email" name="email" class="form-control email" placeholder="Enter Email">
                <label for="email">Email</label>
              </div>
            </div>
          </div>
          <div class="row g-4">
            <div class="col mb-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="phone" name="phone" class="form-control phone" placeholder="Enter Phone No.">
                <label for="phone">Phone</label>
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="gst" name="gst" class="form-control gst" placeholder="Enter GST No">
                <label for="gst">GST</label>
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="cin_no" name="cin_no" class="form-control cin_no" placeholder="Enter CIN No">
                <label for="cin_no">CIN No</label>
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="billing_zipcode" name="billing_zipcode" class="form-control billing_zipcode" placeholder="Enter Billing Zipcode">
                <label for="billing_zipcode">Billing Zipcode</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="billing_address"  name="billing_address" class="form-control billing_address" placeholder="Enter Billing Address">
                <label for="billing_address">Billing Address</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mt-2">
              <div class="form-floating form-floating-outline">
                <select id="billing_country" name="billing_country" class="form-control billing_country">
                  <option value="">Select Country</option>
                  @foreach($countries as $country)
                      <option value="{{ $country->id }}">{{ $country->name }}</option>
                  @endforeach
                </select>
                <label for="billing_country">Country</label>
              </div>
            </div>
            <div class="col mt-2">
              <div class="form-floating form-floating-outline">
                <select id="billing_state" name="billing_state" class="form-control billing_state">
                  <option value="">Select State</option>
                  @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                  @endforeach
                </select>
                <label for="billing_state">State</label>
              </div>
            </div>
            <div class="col mt-2">
              <div class="form-floating form-floating-outline">
                <select id="billing_city" name="billing_city" class="form-control billing_city">
                  <option value="">Select City</option>
                  @foreach($cities as $city)
                      <option value="{{ $city->id }}">{{ $city->name }}</option>
                  @endforeach
                </select>
                <label for="billing_city">City</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
          <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--/ Edit Permission Modal -->
