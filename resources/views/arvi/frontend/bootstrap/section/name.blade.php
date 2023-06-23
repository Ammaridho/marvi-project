<section class="section" data-anchor="section-name">
    <div class="wrap">
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12 col-md-8">
                    <h4>What's your name?</h4>
                    <div class="mt-3">
                        <input type="text" autocomplete="off" class="inline-form inputName vf-em-el"
                               name="name" id="name"
                               onkeypress="return (event.charCode > 64 && event.charCode < 91)
                               || (event.charCode > 96 && event.charCode < 123)
                               || (event.charCode==32)" placeholder="Enter here">
                    </div>
                    <div class="mt-3">
                        <a id="submitName" class="btn btn-theme-secondary inputData arrowDownSm">Next</a>
                    </div>
                    <div id="alert-name" class="muted text-danger mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>
