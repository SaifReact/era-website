<!-- ======= Contact Section ======= -->
<section id="contact" class="contact"> {{--FIXME: Hardcoded ID!--}}

    <div class="container" data-aos="fade-up">

        <header class="section-header">
            <p>Contact us</p>
            <!--<h5 style="margin-top:15px;">From banking to NBFI’s, large corporates to government institutes
                we are there to serve you with your software needs</h5>-->
        </header>

        <div class="row gy-4">

            <div class="col-lg-6">
                @if($location)
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="info-box">
                        <img src="http://127.0.0.1:8000/cms_assets/icons/icon_address.png" />
                            <h3>Address</h3>
                            <p><a href="{{ $location->map_location }}" target="_blank">
                                    {{ $location->address }}</a>
                            </p>
                        </div>
                    </div>
                    @endif
                    @if($contact)
                    <div class="col-md-6">
                        <div class="info-box">
                        <img src="http://127.0.0.1:8000/cms_assets/icons/icon_phone.png" />
                            <h3>Call Us</h3>
                            @if($companyInfo->phone)<p>{{ $companyInfo->phone }}</p>@endif
                            <p><a href="tel:{{ $contact->contact_no }}">{{ $contact->contact_no }}</a></p>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="info-box">
                        <img src="http://127.0.0.1:8000/cms_assets/icons/icon_email.png" />
                            <h3>Email Us</h3>
                            <p><a href="mailto:{{ $companyInfo->email }}">{{ $companyInfo->email }}</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                        <img src="http://127.0.0.1:8000/cms_assets/icons/icon_schedule.png" />
                            <h3>Open Hours</h3>
                            <p>{{ $companyInfo->open_days }}<br>{{ $companyInfo->duration }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <form action="{{ route('contact-store') }}" method="post" class="php-email-form">
                    {{ csrf_field() }}
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6 ">
                            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                required></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                            <button type="submit">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section><!-- End Contact Section -->