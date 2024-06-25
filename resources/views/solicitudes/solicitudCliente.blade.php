@extends('layouts/layoutMaster')


<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
  'resources/assets/vendor/libs/select2/select2.js'
])


<div class="bs-stepper wizard-icons wizard-icons-example mt-2">
    <div class="bs-stepper-header">
      <div class="step" data-target="#account-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-icon">
            <svg viewBox="0 0 54 54">
              <use xlink:href='assets/svg/icons/form-wizard-account.svg#wizardAccount'></use>
            </svg>
          </span>
          <span class="bs-stepper-label">Account Details</span>
        </button>
      </div>
      <div class="line">
        <i class="ri-arrow-right-s-line"></i>
      </div>
      <div class="step" data-target="#personal-info-icon">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-icon">
            <svg viewBox="0 0 58 54">
              <use xlink:href='assets/svg/icons/form-wizard-personal.svg#wizardPersonal'></use>
            </svg>
          </span>
          <span class="bs-stepper-label">Personal Info</span>
        </button>
      </div>
      <div class="line">
        <i class="ri-arrow-right-s-line"></i>
      </div>
      <div class="step" data-target="#address">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-icon">
            <svg viewBox="0 0 54 54">
              <use xlink:href='assets/svg/icons/form-wizard-address.svg#wizardAddress'></use>
            </svg>
          </span>
          <span class="bs-stepper-label">Address</span>
        </button>
      </div>
      <div class="line">
        <i class="ri-arrow-right-s-line"></i>
      </div>
      <div class="step" data-target="#social-links">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-icon">
            <svg viewBox="0 0 54 54">
              <use xlink:href='assets/svg/icons/form-wizard-social-link.svg#wizardSocialLink'></use>
            </svg>
          </span>
          <span class="bs-stepper-label">Social Links</span>
        </button>
      </div>
      <div class="line">
        <i class="ri-arrow-right-s-line"></i>
      </div>
      <div class="step" data-target="#review-submit">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-icon">
            <svg viewBox="0 0 54 54">
              <use xlink:href='assets/svg/icons/form-wizard-submit.svg#wizardSubmit'></use>
            </svg>
          </span>
          <span class="bs-stepper-label">Review & Submit</span>
        </button>
      </div>
    </div>
    <div class="bs-stepper-content">
      <form onSubmit="return false">
        <!-- Account Details -->
        <div id="account-details" class="content">
          <div class="content-header mb-4">
            <h6 class="mb-0">Account Details</h6>
            <small>Enter Your Account Details.</small>
          </div>
          <div class="row g-5">
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" id="username" class="form-control" placeholder="johndoe" />
                <label for="username">Username</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="email" id="email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                <label for="email">Email</label>
              </div>
            </div>
            <div class="col-sm-6 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password2" />
                  <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer" id="password2"><i class="ri-eye-off-line"></i></span>
              </div>
            </div>
            <div class="col-sm-6 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="confirm-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirm-password2" />
                  <label for="confirm-password">Confirm Password</label>
                </div>
                <span class="input-group-text cursor-pointer" id="confirm-password2"><i class="ri-eye-off-line"></i></span>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-outline-secondary btn-prev" disabled> <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ri-arrow-right-line"></i></button>
            </div>
          </div>
        </div>
        <!-- Personal Info -->
        <div id="personal-info-icon" class="content">
          <div class="content-header mb-4">
            <h6 class="mb-0">Personal Info</h6>
            <small>Enter Your Personal Info.</small>
          </div>
          <div class="row g-5">
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" id="first-name" class="form-control" placeholder="John" />
                <label for="first-name">First Name</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" id="last-name" class="form-control" placeholder="Doe" />
                <label for="last-name">Last Name</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <select class="select2" id="country">
                  <option label=" "></option>
                  <option>UK</option>
                  <option>USA</option>
                  <option>Spain</option>
                  <option>France</option>
                  <option>Italy</option>
                  <option>Australia</option>
                </select>
                <label for="country">Country</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <select class="selectpicker w-auto" id="language" data-style="btn-transparent"  data-tick-icon="ri-check-line text-white" multiple>
                  <option>English</option>
                  <option>French</option>
                  <option>Spanish</option>
                </select>
                <label for="language">Language</label>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ri-arrow-right-line"></i></button>
            </div>
          </div>
        </div>
        <!-- Address -->
        <div id="address" class="content">
          <div class="content-header mb-4">
            <h6 class="mb-0">Address</h6>
            <small>Enter Your Address.</small>
          </div>
          <div class="row g-5">
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="address-input" placeholder="98  Borough bridge Road, Birmingham">
                <label for="address-input">Address</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="landmark" placeholder="Borough bridge">
                <label for="landmark">Landmark</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="pincode" placeholder="658921">
                <label for="pincode">Pincode</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="city" placeholder="Birmingham">
                <label for="city">City</label>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ri-arrow-right-line"></i></button>
            </div>
          </div>
        </div>
        <!-- Social Links -->
        <div id="social-links" class="content">
          <div class="content-header mb-4">
            <h6 class="mb-0">Social Links</h6>
            <small>Enter Your Social Links.</small>
          </div>
          <div class="row g-5">
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" id="twitter" class="form-control" placeholder="https://twitter.com/abc" />
                <label for="twitter">Twitter</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" id="facebook" class="form-control" placeholder="https://facebook.com/abc" />
                <label for="facebook">Facebook</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" id="google" class="form-control" placeholder="https://plus.google.com/abc" />
                <label for="google">Google+</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating form-floating-outline">
                <input type="text" id="linkedin" class="form-control" placeholder="https://linkedin.com/abc" />
                <label for="linkedin">Linkedin</label>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ri-arrow-right-line"></i></button>
            </div>
          </div>
        </div>
        <!-- Review -->
        <div id="review-submit" class="content">
  
          <p class="fw-medium mb-2">Account</p>
          <ul class="list-unstyled">
            <li>Username</li>
            <li>exampl@email.com</li>
          </ul>
          <hr>
          <p class="fw-medium mb-2">Personal Info</p>
          <ul class="list-unstyled">
            <li>First Name</li>
            <li>Last Name</li>
            <li>Country</li>
            <li>Language</li>
          </ul>
          <hr>
          <p class="fw-medium mb-2">Address</p>
          <ul class="list-unstyled">
            <li>Address</li>
            <li>Landmark</li>
            <li>Pincode</li>
            <li>City</li>
          </ul>
          <hr>
          <p class="fw-medium mb-2">Social Links</p>
          <ul class="list-unstyled">
            <li>https://twitter.com/abc</li>
            <li>https://facebook.com/abc</li>
            <li>https://plus.google.com/abc</li>
            <li>https://linkedin.com/abc</li>
          </ul>
          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary btn-submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>