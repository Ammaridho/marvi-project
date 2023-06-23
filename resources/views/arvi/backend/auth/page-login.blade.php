<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner login">
        <!-- Register -->
        <div class="card m-0 p-0">
            <div class="card-body m-0 p-0">

            <div class="row g-0">
                <!-- left -->
                <div class="col-12 col-sm-12 col-md-6">
                <div class="p-3">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                    <a href="/" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                        <img src="/arvi/backend-assets/img/logo/oobe-logo-horizontal-dt.png" />
                        </span>
                    </a>
                    </div>
                    <!-- /Logo -->

                    <h4 class="mb-2">Welcome to oobe!</h4>
                    <p class="mb-4">Please sign-in to your account</p>

                    <form action="{{secure_url(route('login'))}}" method="POST" id="formAuthentication" class="mb-3" autocomplete="off">
                
                        @csrf

                        @if (session()->has('notActive'))
                            <div class="small my-3 p-3 alert alert-warning">
                                Hello, it's seems your account is inactive. Please contact our customer support for further info.
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                            placeholder="Enter your email or username" autofocus value="email" placeholder="email" autocomplete="email" required/>
                            @if (session()->has('errorEmail'))
                                <div class="mt-2 badge bg-label-danger d-block text-start">Please input correct email.</div>
                            @endif
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="">
                            <label for="password2" class="form-label">Password</label>
                            <a href="{{ secure_url(route('forget-password-dashboard')) }}" class="float-end">Forget password</a>
                            </div>
                            <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password" 
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                            aria-describedby="password" autocomplete="password" placeholder="password" required />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @if (session()->has('errorPassword'))
                                <div class="mt-2 badge bg-label-danger d-block text-start">Your password incorrect.</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember me </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>

                    <!-- btn reg on mobile-->
                    <div class="mt-4 text-center d-block d-sm-block d-md-none">
                    Don't have an account? <a href="javascript:void(0)" class="sign-up">Sign up now</a>
                    </div>
                </div>

                </div>
                <!-- right -->
                <div class="col-12 col-sm-12 col-md-6 bg-secondary rounded-end d-none d-sm-none d-md-block">
                <div class="p-5 text-white">
                    <div class="pt-4 mt-4"><img src="/arvi/backend-assets/img/illustrations/register-proccess.svg" class="img-fluid" /></div>
                    <h1 class="mt-3 h3 text-white">Platform <span class="text-grad">QR Menu</span> For Your Business</h1>
                    <div class="mt-3">Don't have an account?<br /><a href="javascript:void(0)" class="text-white fw-bold sign-up">Sign up now</a></div>
                </div>
                </div>
            </div>
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
<script src="/arvi/backend-assets/vendor/js/menu.js"></script>
<script src="/arvi/backend-assets/js/main.js"></script>
<script>
    $(function(){
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
    });

    $('.sign-up').on('click',function () {
        $.get("{{route('sign-up')}}",function (data) {
            $('body').html(data);
        })
    })
</script>