<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner login">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="javascript:void(0);" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="/arvi/backend-assets/img/logo/oobe-logo-horizontal-dt.png" />
              </span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Create your account</h4>
          <p class="mb-4">Already have an account? <a href="{{route('index')}}">Sign in</a></p>

          <form id="formAuthentication" class="mb-3" method="POST">
            @csrf
            <div class="mb-3">
              <label for="uname" class="form-label">Full Name *</label>
              <input type="text" class="form-control" id="uname" name="uname" value="aaaa"
              placeholder="Enter your full name" autofocus autocomplete="off" required/>
              <div id="unameHelp" class="form-text text-danger d-none alert-helps">
                This field is required.
              </div>
            </div>
            <div class="mb-3">
              <label for="bname" class="form-label">Brand Name *</label>
              <input type="text" class="form-control" id="bname" name="bname" value="bbbb"
              placeholder="Enter brand name" autocomplete="off" required/>
              <div id="bnameHelp" class="form-text text-danger d-none alert-helps">
                This field is required.
              </div>
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Company Name *</label>
              <input type="text" class="form-control" id="name" name="name" value="cccssc"
              placeholder="Enter company name" autocomplete="off" required/>
              <div id="cnameHelp" class="form-text text-danger d-none alert-helps">
                This field is required.
              </div>
              <div id="cnameARHelp" class="form-text text-danger d-none alert-helps">
                This company name is already registered.
              </div>
            </div>
            <div class="mb-3 search-box">
              <label for="company_address" class="form-label">Company Address *</label>
              <div class="form-group has-search">
                <input type="text" class="form-control" id="company_address" value="dddd"
                name="company_address" placeholder="Type to search a location" 
                autocomplete="off" required/>
                <span class="fa fa-search form-control-feedback"></span>
              </div>
              <div id="companyAddressHelp" class="form-text text-danger d-none alert-helps">
                This field is required.
              </div>
            </div>
            <div class="mb-3">
              <label for="phone_number" class="form-label">Phone Number *</label>
              <input type="text" class="form-control  noArrow phone_with_ddd" id="phone_number" value="(+12) 3123123"
                  name="phone_number" placeholder="Enter active mobile number" autocomplete="off" required />
              <div id="phoneNumberHelp" class="form-text text-danger d-none alert-helps">
                This field is required.
              </div>
              <div id="phoneNumberARHelp" class="form-text text-danger d-none alert-helps">
                This phone number is already registered.
              </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email *</label>
              <input type="email" class="form-control" id="email" name="email" value="asldfkj@gmail.com"
              placeholder="Enter your active email address" autocomplete="off" required/>
              <div id="emailAccountHelp" class="form-text text-danger d-none alert-helps">
                This field is required.
              </div>
              <div id="emailARAccountHelp" class="form-text text-danger d-none alert-helps">
                This email address is already registered.
              </div>
            </div>
            <div class="form-group mb-3 password-group">
                <label for="password1" class="form-label">Password *</label>
                <input type="password" class="f-inputbox password-box form-control" value="aaa"
                required="required" autocomplete="off" id="password1" name="password" required 
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <a href="#!" class="password-visibility"><i class="bx bx-hide text-light"></i></a>
            </div>
            <div class="form-group mb-3 password-group">
                <label for="password2" class="form-label">Confirm Password *</label>
                <input type="password" class="f-inputbox password-box form-control" 
                autocomplete="off" id="password2" name="password_confirmation"  required value="aaa"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <a href="#!" class="password-visibility"><i class="bx bx-hide text-light"></i></a>
                <div id="password1Help" class="form-text text-danger d-none alert-helps">
                  Submitted password didn’t match.
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="iagree" name="accept">
                <label class="form-check-label" for="iagree">
                I agree to <a href="#">Platforms Terms of Service</a> and <a href="#">Privacy Policy</a>.</label>
            </div>
            
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit" id="btn-register" disabled>Register</button>
            </div>
          </form>

        </div>
      </div>
      <!-- /Register -->
      
      <div class="my-3 small text-center">
        Copyrights &copy; <?=date('Y');?> Oobe Indonesia. <br />
        PT. Mulai Aja Dulu
      </div>
    </div>
  </div>
</div>

<!-- / Content -->

<!-- Core JS -->
<script src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
<script src="/arvi/backend-assets/vendor/libs/popper/popper.js"></script>
<script src="/arvi/backend-assets/vendor/js/bootstrap.js"></script>
<script src="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/autofill/autofill.js"></script>
<script>
    $(function(){
      //num only
      $(".numbers").on("keypress keyup blur",function (event) {
          //this.value = this.value.replace(/[^0-9\.]/g,'');
          $(this).val($(this).val().replace(/[^0-9\.]/g,''));
          if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
              event.preventDefault();
          }
      });
      //eye of the tiger :)
      $('.password-group').find('.password-box').each(function(index, input) {
          let $input = $(input);
          $input.parent().find('.password-visibility').click(function() {
              let change = "";
              if ($(this).find('i').hasClass('bx-hide')) {
                  $(this).find('i').removeClass('bx-hide')
                  $(this).find('i').addClass('bx-show')
                  change = "text";
              } else {
                  $(this).find('i').removeClass('bx-show')
                  $(this).find('i').addClass('bx-hide')
                  change = "password";
              }
              let rep = $("<input type='" + change + "' />")
                  .attr('id', $input.attr('id'))
                  .attr('name', $input.attr('name'))
                  .attr('class', $input.attr('class'))
                  .val($input.val())
                  .insertBefore($input);
              $input.remove();
              $input = rep;
          }).insertAfter($input);
      });

      //masking mobile phone 
      $('.phone_with_ddd').mask('(+00) 0000-0000-0000');

      $("#iagree").click(function() {
          let checked_status = this.checked;
          if (checked_status == true) {
          $("#btn-register").removeAttr("disabled");
          } else {
          $("#btn-register").attr("disabled", "disabled");
          }
      });
    
    });

    // submit form
    $('#formAuthentication').on('submit',function () {
      event.preventDefault();
      $.ajax({
        type: 'POST',
        url: "{{ route('sign-up-check-data') }}",
        data: $(this).serialize(),
        success: function (data) {

          var urlJavascript = "{{ route('otp-register') }}"
          +'?data=' + JSON.stringify($("#formAuthentication").serializeArray());
          window.location.href = urlJavascript;

        },
        error: function (data) {
          var err = JSON.parse(data.responseText).errors;

          $('.alert-helps').addClass('d-none');
          
          if (err != undefined) {
            Object.keys(err).forEach(function(key) {
              if (key == 'password') {
                  $('#password1Help').removeClass('d-none');
              } else if (err[key][0] == 'email required!') {
                $('#emailAccountHelp').removeClass('d-none');
              } else if (err[key][0] == 'email unique!') {
                $('#emailARAccountHelp').removeClass('d-none');
              } else if (key == 'uname') {
                $('#unameHelp').removeClass('d-none');
              } else if (key == 'bname') {
                $('#bnameHelp').removeClass('d-none');
              } else if (err[key][0] == 'name required!') {
                $('#cnameHelp').removeClass('d-none');
              } else if (err[key][0] == 'name unique!') {
                $('#cnameARHelp').removeClass('d-none');
              } else if (key == 'company_address') {
                $('#companyAddressHelp').removeClass('d-none');
              } else if (err[key][0] == 'phone_number required!') {
                $('#phoneNumberHelp').removeClass('d-none');
              } else if (err[key][0] == 'phone_number unique!') {
                $('#phoneNumberARHelp').removeClass('d-none');
              } else{
                  $('#cnameARHelp').removeClass('d-none');
              }
            });
          }else{
            console.log(data.responseText);
          }
        }
      })
    });

</script>
