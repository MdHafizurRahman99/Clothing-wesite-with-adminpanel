@extends('layouts.frontend.master')
@section('css')
@endsection
@section('content')
    <!-- Contact Start -->
    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Contact
                Us</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form bg-light p-30">
                    <div id="success"></div>
                    <form name="sentMessage" id="contactForm" novalidate="novalidate">
                        <div class="control-group">
                            <input type="text" class="form-control" id="name" placeholder="Your Name"
                                required="required" data-validation-required-message="Please enter your name" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control" id="email" placeholder="Your Email"
                                required="required" data-validation-required-message="Please enter your email" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control" id="phone" placeholder="Your Phone Number"
                                required="required" data-validation-required-message="Please enter your phone number" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <select class="form-control" id="subject" required="required" data-validation-required-message="Please select a subject">
                                {{-- <option value="" disabled selected>Select a subject</option> --}}
                                <option value="general">General Inquiry</option>
                                <option value="order">Order Issue</option>
                                <option value="return">Return/Exchange</option>
                                <option value="shipping">Shipping Question</option>
                                <option value="feedback">Feedback</option>
                            </select>
                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <textarea class="form-control" rows="8" id="message" placeholder="Message" required="required"
                                data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="bg-light p-30 mb-30">
                    <iframe style="width: 100%; height: 250px;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30812395.310645804!2d89.6021919586505!3d-19.486640622600035!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2b2bfd076787c5df%3A0x538267a1955b1352!2sAustralia!5e0!3m2!1sen!2sbd!4v1730701994847!5m2!1sen!2sbd"
                        frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
                <div class="bg-light p-30 mb-3">
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street,Australia</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

@section('js')
    <!-- Contact Javascript File -->
    <script src="{{ asset('frontend') }}/mail/jqBootstrapValidation.min.js"></script>
    {{-- <script src="{{ asset('frontend') }}/mail/contact.js"></script> --}}
    <script>
        $(function () {
            $("#contactForm input, #contactForm textarea").jqBootstrapValidation({
                preventSubmit: true,
                submitError: function ($form, event, errors) {},
                submitSuccess: function ($form, event) {
                    event.preventDefault();
                    var name = $("input#name").val();
                    var email = $("input#email").val();
                    var phone = $("input#phone").val();
                    var subject = $("select#subject").val();
                    var message = $("textarea#message").val();

                    $this = $("#sendMessageButton");
                    $this.prop("disabled", true);

                    $.ajax({
                        url: "{{ route('contact.send') }}", // Now this works
                        type: "POST",
                        data: {
                            name: name,
                            email: email,
                            subject: subject,
                            message: message,
                            phone: phone,
                            _token: '{{ csrf_token() }}' // CSRF token
                        },
                        cache: false,
                        success: function () {
                            $('#success').html("<div class='alert alert-success'>");
                            $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                                    .append("</button>");
                            $('#success > .alert-success')
                                    .append("<strong>Your message has been sent. </strong>");
                            $('#success > .alert-success')
                                    .append('</div>');
                            $('#contactForm').trigger("reset");
                        },
                        error: function () {
                            $('#success').html("<div class='alert alert-danger'>");
                            $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                                    .append("</button>");
                            $('#success > .alert-danger').append($("<strong>").text("Sorry " + name + ", it seems that our mail server is not responding. Please try again later!"));
                            $('#success > .alert-danger').append('</div>');
                            $('#contactForm').trigger("reset");
                        },
                        complete: function () {
                            setTimeout(function () {
                                $this.prop("disabled", false);
                            }, 1000);
                        }
                    });
                },
                filter: function () {
                    return $(this).is(":visible");
                },
            });

            $("a[data-toggle=\"tab\"]").click(function (e) {
                e.preventDefault();
                $(this).tab("show");
            });
        });

        $('#name').focus(function () {
            $('#success').html('');
        });
    </script>

@endsection
