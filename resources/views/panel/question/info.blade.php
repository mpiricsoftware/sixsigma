@extends('layouts.layoutMaster')

@section('title', 'OMM-Information')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
@section('page-script')
    @vite(['resources/assets/js/forms-selects.js'])
@endsection


@section('content')
    {{-- <div class="container mt-5"> --}}
    <form id="form-id" method="POST" action="{{ route('details-list.store') }}">
        @csrf

        <div class="card mb-4"
            style="width: 100%; max-width: 2000px; padding: 20px; height: 130%; max-height: 2500px; display: flex; flex-direction: column;">
            <div class="card-header">
                <h5>Assessment Details</h5>
            </div>
            <input type="hidden" id="id" name="id" value="{{ $form->id }}">
            <div class="card-body pt-1"style="height:100%;">
                <div class="row">
                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter First Name" value="{{ $user->name }}">
                            <label for="name">First Name</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" name="lastname" id="lastname"
                                placeholder="Enter Last Name" value="{{ $user->lastname }}">
                            <label for="lastname">Last Name</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" name="company" id="company"
                                placeholder="Enter Company" value="{{ $user->company }}">
                            <label for="company">Company</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-floating form-floating-outline">
                          <input type="text" class="form-control" name="located" id="located"
                              placeholder="Enter Your Located Area">
                          <label for="located">Where is your company located?</label>
                      </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" name="designation" id="designation"
                                placeholder="Enter Your Designation" value="{{ $user->designation }}">
                            <label for="designation">Designation</label>
                        </div>
                    </div>

                    <div class="col-md-5 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter Email" value="{{ $user->email }}">
                            <label for="email">Contact Person Email</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" name="Phone_no" id="Phone_" required
                                pattern="^[0-9]{10}$" title="Please enter a valid 10-digit phone number"
                                placeholder="Enter phone number" value="{{ $user->office_no }}">
                            <label for="Phone_">Contact Person PhoneNo:</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <div class="form-floating form-floating-outline">
                          <div class="select2-info">
                            <select name="tools[]" id="tools" class="select2 form-select" multiple>

                                    <option value="Lean" selected>Lean</option>
                                    <option value="Six Sigma">Six Sigma</option>
                                    <option value="TPM">TPM</option>
                                    <option value="5S">5S</option>
                                    <option value="QC Circle">QC Circle</option>
                                    <option value="Daily Management">Daily Management</option>
                                    <option value="DOE">DOE</option>
                                    <option value="Digital Transformation">Digital Transformation</option>
                                    <option value="Time and Motion Study">Time and Motion Study</option>
                                    <option value="VAVE">VAVE</option>
                                    <option value="7 QC">7 QC</option>
                                    <option value="Kaizen">Kaizen</option>
                                    <option value="JIT">JIT</option>
                                    <option value="VSM">VSM</option>
                                    <option value="Policy Deployment">Policy Deployment</option>
                                    <option value="Other">Other</option>

                            </select>
                          </div>
                            <label for="tools">Which of following Tools / concepts / are your implementing currently in OpEx?</label>

                        </div>
                    </div>

                    <div class="col-md-3 mb-5">
                        <div class="form-floating form-floating-outline">
                            <select name="consultant" id="consultant" class="select2 form-select">
                                <option value="Select consultant">Select consultant</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <label for="consultant">Are you a consultant?</label>
                        </div>
                    </div>
                    <div class="col-md-5 mb-5">
                        <div class="form-floating form-floating-outline">
                            <select name="Primary" id="Primary" class="select2 form-select">
                                <option value="Select Group">Select Group</option>
                                <option value="Aerospace">Aerospace</option>
                                <option value="Automotive">Automotive</option>
                                <option value="Electronics / Electrical">Electronics / Electrical</option>
                                <option value="Energy & Chemical (Downstream)">Energy & Chemical (Downstream)</option>
                                <option value="Food & Beverage">Food & Beverage</option>
                                <option value="General Manufacturing">General Manufacturing</option>
                                <option value="Logistic">Logistic</option>
                                <option value="Oil & Gass (Upstream)">Oil & Gass (Upstream)</option>
                                <option value="Machinery & Equipment">Machinery & Equipment</option>
                                <option value="Medical Technology">Medical Technology</option>
                                <option value="Pharmaceuticals">Pharmaceuticals</option>
                                <option value="Precision Parts">Precision Parts</option>
                                <option value="Semiconductors">Semiconductors</option>
                                <option value="Textile (Clothing, Leather & Footwear)">Textile (Clothing, Leather &
                                    Footwear)</option>
                                <option value="Others">Others</option>

                            </select>
                            <label for="Primary Industry Group">Primary Industry Group</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-6">
                        <div class="form-floating form-floating-outline">
                            <div class="select2-info">
                                <select id="business_goals" name ="business_goals[]" class="select2 form-select"
                                    multiple>
                                    <option value="Asset & Equipment Efficiency" selected>Asset & Equipment Efficiency
                                    </option>
                                    <option value="Inventory Efficiency">Inventory Efficiency</option>
                                    <option value="Materials Efficiency">Materials Efficiency</option>
                                    <option value="Utilities Efficiency">Utilities Efficiency</option>
                                    <option value="Workforce Efficiency">Workforce Efficiency</option>
                                    <option value="Planning & Scheduling Effectiveness">Planning & Scheduling Effectiveness
                                    </option>
                                    <option value="Production Flexibility">Production Flexibility</option>
                                    <option value="Workforce Flexibility">Workforce Flexibility</option>
                                    <option value="Time to Market">Time to Market</option>
                                    <option value="Time to Delivery">Time to Delivery</option>
                                    <option value="Product Quality">Product Quality</option>
                                    <option value="Process Quality">Process Quality</option>
                                    <option value="Safety">Safety</option>
                                    <option value="Security of Data">Security of Data</option>
                                </select>
                            </div>
                            <label for="select2Primary">What are your organization’s current top
                                three Business Goals?</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-6">
                        <div class="form-floating form-floating-outline">
                            <div class="select2-info ">
                                <select id="drivers" name="drivers[]" class="select2 form-select" multiple>
                                    <option value="Raw Materials & Consumables cost" selected>Raw Materials & Consumables
                                        cost</option>
                                    <option value="Labour cost">Labour cost</option>
                                    <option value="Utilities">Utilities</option>
                                    <option value="Selling, General & Administrative Expense (“SG&A”)">Selling, General &
                                        Administrative Expense (“SG&A”)</option>
                                    <option value="Transportation & Distribution">Transportation & Distribution</option>
                                    <option value="Aftermarket Services/Warranty">Aftermarket Services/Warranty</option>
                                    <option value="Depreciation cost">Depreciation cost</option>
                                    <option value="Maintenance & Repair cost">Maintenance & Repair cost</option>
                                    <option value="Rental & Operating Lease cost">Rental & Operating Lease cost</option>
                                    <option value="Research & Development (“R&D”)">Research & Development (“R&D”)</option>
                                </select>

                            </div>
                            <label for="select2Primary">Which are your organization’s top three cost
                                drivers?</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" id="hidden-submit" style="display: none;"></button>
            <div class="text-center mb-5">
                <a href="{{ url('/img', ['slug' => $form->slug]) }}" class="btn btn-dark rounded-0" id="go-to-questions">
                    Go to Assessment
                </a>
            </div>

        </div>
        </div>
    </form>
    <script>
        document.getElementById('go-to-questions').addEventListener('click', function(event) {
            event.preventDefault(); // Stop immediate redirect

            let form = document.getElementById('form-id');

            // Perform validation
            if (!validateForm()) {
                return;
            }

            // Submit the form if validation passes
            form.submit();

            // Wait for form submission and then redirect
            setTimeout(() => {
                window.location.href = "{{ url('/img', ['slug' => $form->slug]) }}";
            }, 1000);
        });

        function validateForm() {
            let isValid = true;

            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(el => el.remove());

            function showError(input, message) {
                let error = document.createElement('small');
                error.classList.add('error-message', 'text-danger');
                error.innerText = message;
                input.parentNode.appendChild(error);
                isValid = false;
            }

            let name = document.getElementById('name');
            let lastname = document.getElementById('lastname');
            let designation = document.getElementById('designation');
            let email = document.getElementById('email');
            let phone = document.getElementById('Phone_');
            let company = document.getElementById('company');
            let located = document.getElementById('located');
            let consultant = document.getElementById('consultant');
            let primary = document.getElementById('Primary');
            let drivers = document.getElementById('drivers');
            let business_goals = document.getElementById('business_goals');
            let tools = document.getElementById('tools');

            // Name validation
            if (name.value.trim() === '') {
                showError(name, "First Name is required.");
            }

            // Last Name validation
            if (lastname.value.trim() === '') {
                showError(lastname, "Last Name is required.");
            }

            if (designation.value.trim() === '') {
                showError(designation, "Designation is required.");
            }

            if (located.value === '') {
                showError(located, "Please Enter Company Location.")
            }
            // Email validation
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                showError(email, "Please enter a valid email address.");
            }

            // Phone validation (10 digits)
            let phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(phone.value)) {
                showError(phone, "Please enter a valid 10-digit phone number.");
            }

            // Company validation
            if (company.value.trim() === '') {
                showError(company, "Company name is required.");
            }

            // Consultant selection validation
            if (consultant.value === "Select consultant") {
                showError(consultant, "Please select whether you are a consultant.");
            }

            // Primary Industry Group validation
            if (primary.value === "Select Group") {
                showError(primary, "Please select a Primary Industry Group.");
            }

            if (business_goals.selectedOptions.length < 3) {
                showError(business_goals, "Please select at least 3 Business Goals.");
            }

            if (drivers.selectedOptions.length < 3) {
                showError(drivers, "Please select at least 3 Cost Drivers.");
            }
            if(tools.value === "")
            {
              showError(tools, "Please Select a Tools & Concept. ");
            }

            return isValid;
        }
    </script>


    {{-- </div> --}}

@endsection
